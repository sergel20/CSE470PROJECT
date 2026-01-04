<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Notifications\BookingRequestNotification;
use App\Notifications\BookingStatusNotification;

class BookingController extends Controller
{
    /**
     * Store a new booking request from a guest.
     * FR‑12: Host notified of new request.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $data = $request->validate([
            'host_id'    => ['required', 'integer', 'exists:users,id'],
            'listing_id' => ['required', 'integer', 'exists:listings,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'nights'     => ['required', 'integer', 'min:1'],
        ]);

        $guestId = auth()->id();
        $host = User::findOrFail($data['host_id']);
        $listing = Listing::findOrFail($data['listing_id']);

        // Prevent booking your own listing
        if ($listing->user_id === $guestId || $host->id === $guestId) {
            return back()->withErrors(['booking' => 'You cannot book your own listing.']);
        }

        // Optional authorization: check a policy or gate if defined
        if (Gate::has('create-booking') && Gate::denies('create-booking', [$listing])) {
            abort(403, 'Unauthorized to create booking.');
        }

        // Calculate total price and date range
        $nights = $data['nights'];
        $startDate = Carbon::parse($data['start_date'])->startOfDay();
        $endDate = (clone $startDate)->addDays($nights - 1)->startOfDay();

        // Check for blocked dates
        $blockedExists = \App\Models\BlockedDate::where('listing_id', $listing->id)
            ->whereBetween('blocked_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->exists();

        if ($blockedExists) {
            return back()->withErrors(['booking' => 'Selected dates include blocked dates. Please choose another date.']);
        }

        // Check for overlapping bookings
        $overlap = Booking::where('listing_id', $listing->id)
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate->toDateString(), $endDate->toDateString()])
                  ->orWhereBetween('end_date', [$startDate->toDateString(), $endDate->toDateString()])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('start_date', '<=', $startDate->toDateString())
                         ->where('end_date', '>=', $endDate->toDateString());
                  });
            })->exists();

        if ($overlap) {
            return back()->withErrors(['booking' => 'Selected dates overlap an existing booking.']);
        }

        $nightly_rate = $listing->price_per_night;
        $service_fee = $nightly_rate * 0.10; // 10% service fee
        $total_price = ($nightly_rate * $nights) + $service_fee;

        // Create booking
        $booking = Booking::create([
            'guest_id'     => $guestId,
            'host_id'      => $host->id,
            'listing_id'   => $listing->id,
            'status'       => 'pending',
            'nights'       => $nights,
            'start_date'   => $startDate->toDateString(),
            'end_date'     => $endDate->toDateString(),
            'nightly_rate' => $nightly_rate,
            'service_fee'  => $service_fee,
            'total_price'  => $total_price,
        ]);

        // Notify the host of the new booking request (FR‑12 host side)
        $host->notify(new BookingRequestNotification($booking));

        return back()->with('status', "Booking request sent! Total: \$$total_price");
    }

    /**
     * Display bookings for the host's listings (FR‑18).
     */
    public function index(Request $request)
    {
        $bookings = Booking::whereHas('listing', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })
        ->with(['listing', 'guest'])
        ->orderBy('start_date', 'desc')
        ->get();

        return view('host.bookings.index', compact('bookings'));
    }

    /**
     * Approve a booking (FR‑18).
     * FR‑12: Guest notified of approval.
     */
    public function approve(Request $request, Booking $booking)
    {
        $this->authorize('manage', $booking);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking already processed.');
        }

        $booking->update(['status' => 'approved']);

        // Notify the guest of approval
        $booking->guest?->notify(new BookingStatusNotification($booking));

        return back()->with('status', 'Booking approved and guest notified.');
    }

    /**
     * Decline a booking (FR‑18).
     * FR‑12: Guest notified of decline.
     */
    public function decline(Request $request, Booking $booking)
    {
        $this->authorize('manage', $booking);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking already processed.');
        }

        $booking->update(['status' => 'declined']);

        // Notify the guest of decline
        $booking->guest?->notify(new BookingStatusNotification($booking));

        return back()->with('status', 'Booking declined and guest notified.');
    }
}
