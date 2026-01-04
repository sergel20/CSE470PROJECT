<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Listing;

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

        return view('host.dashboard', compact('listings'));
    }
}
