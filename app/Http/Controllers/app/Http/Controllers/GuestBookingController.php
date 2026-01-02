<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class GuestBookingController extends Controller
{
    /**
     * Display the guest's booking history (FR‑20).
     * Shows upcoming and past trips separately.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // Upcoming trips: check_in >= today
        $upcoming = Booking::where('guest_id', $userId)
            ->upcoming()
            ->with(['listing', 'listing.user'])
            ->orderBy('check_in', 'asc')
            ->get();

        // Past trips: check_out < today
        $past = Booking::where('guest_id', $userId)
            ->past()
            ->with(['listing', 'listing.user'])
            ->orderBy('check_out', 'desc')
            ->get();

        return view('guest.bookings.index', compact('upcoming', 'past'));
    }
}

