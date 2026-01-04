<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Property;

class HostDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $properties = Property::where('host_id', $user->id)
            ->with(['bookings', 'blockedDates'])
            ->latest()
            ->get();

        return view('host.dashboard', compact('properties'));
    }
}
