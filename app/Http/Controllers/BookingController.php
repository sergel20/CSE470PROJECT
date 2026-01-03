<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Notifications\BookingRequestNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request
        $data = $request->validate([
            'host_id' => ['required', 'integer', 'exists:users,id'],
            'property_id' => ['required', 'integer', 'exists:properties,id'],
            'nights' => ['nullable', 'integer', 'min:1'],
        ]);

        $guestId = auth()->id();
        $host = User::find($data['host_id']);
        $property = Property::find($data['property_id']);

        // Ensure host and property exist
        if (! $host || ! $property) {
            throw ValidationException::withMessages(['property_id' => 'Invalid host or property.']);
        }

        // Prevent booking your own property
        if (($property->user_id ?? null) === $guestId || $host->id === $guestId) {
            return back()->withErrors(['booking' => 'You cannot book your own property.']);
        }

        // Optional authorization: check a policy or gate if defined
        if (Gate::denies('create-booking', [$property])) {
            abort(403);
        }

        // Calculate total price
        $nights = $data['nights'] ?? 1;
        $nightly_rate = $property->price;
        $service_fee = $nightly_rate * 0.10; // 10% service fee
        $total_price = ($nightly_rate * $nights) + $service_fee;

        // Create booking
        $booking = Booking::create([
            'guest_id' => $guestId,
            'host_id' => $host->id,
            'property_id' => $property->id,
            'status' => 'pending',
            'nights' => $nights,
            'nightly_rate' => $nightly_rate,
            'service_fee' => $service_fee,
            'total_price' => $total_price,
        ]);

        // Notify host (if notifiable)
        if ($host) {
            $host->notify(new BookingRequestNotification($booking));
        }

        return back()->with('status', "Booking request sent! Total: \$$total_price");
    }
}
