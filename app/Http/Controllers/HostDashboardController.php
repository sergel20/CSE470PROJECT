<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Listing;
use App\Models\Booking;

class HostDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get listings created by this host
        $listings = Listing::where('user_id', $user->id)
            ->with(['bookings', 'blockedDates'])
            ->latest()
            ->get();

        // Get pending bookings for host's listings
        $pendingBookings = Booking::whereHas('listing', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('status', 'pending')
        ->with(['listing', 'guest'])
        ->orderBy('created_at', 'desc')
        ->get();

        // Get recent notifications
        $notifications = $user->notifications()->take(5)->get();

        return view('host.dashboard', compact('listings', 'pendingBookings', 'notifications'));
    }
}
