<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\BookingRequestNotification;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $booking = Booking::create([
            'guest_id' => auth()->id(),
            'host_id' => $request->host_id,
            'property_id' => $request->property_id,
            'status' => 'pending',
        ]);

        $host = User::find($request->host_id);
        $host->notify(new BookingRequestNotification($booking));

        return back()->with('status', 'Booking request sent!');
    }
}
