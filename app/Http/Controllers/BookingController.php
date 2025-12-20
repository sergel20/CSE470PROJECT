<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\BookingRequestNotification;
use App\Notifications\BookingStatusNotification;

class BookingController extends Controller
{
    /**
     * Store a new booking request from a guest.
     */
    public function store(Request $request)
    {
        $booking = Booking::create([
            'guest_id'   => auth()->id(),
            'host_id'    => $request->host_id,
            'property_id'=> $request->property_id,
            'status'     => 'pending',
        ]);

        // Notify the host of the new booking request
        $host = User::find($request->host_id);
        if ($host) {
            $host->notify(new BookingRequestNotification($booking));
        }

        return back()->with('status', 'Booking request sent!');
    }

    /**
     * Display bookings for the host's listings (FR‑18).
     */
    public function index(Request $request)
    {
        $bookings = Booking::whereHas('listing', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->get();

        return view('host.bookings.index', compact('bookings'));
    }

    /**
     * Approve a booking (FR‑18).
     */
    public function approve(Request $request, Booking $booking)
    {
        $this->authorize('manage', $booking);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking already processed.');
        }

        $booking->status = 'approved';
        $booking->save();

        // Notify the guest of approval
        if ($booking->guest) {
            $booking->guest->notify(new BookingStatusNotification($booking));
        }

        return back()->with('status', 'Booking approved.');
    }

    /**
     * Decline a booking (FR‑18).
     */
    public function decline(Request $request, Booking $booking)
    {
        $this->authorize('manage', $booking);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking already processed.');
        }

        $booking->status = 'declined';
        $booking->save();

        // Notify the guest of decline
        if ($booking->guest) {
            $booking->guest->notify(new BookingStatusNotification($booking));
        }

        return back()->with('status', 'Booking declined.');
    }
}

