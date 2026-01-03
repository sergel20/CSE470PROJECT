<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\RecentSearch;   // <-- Add this
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'newest');
        $query = Property::query();

        // Apply sorting
        if ($sort === 'price') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'rating') {
            $query->orderBy('rating', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Apply filters (location, dates, guests)
        if ($request->filled('location')) {
            $query->where('city', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('check_in') && $request->filled('check_out')) {
            // Availability logic can go here
        }

        if ($request->filled('guests')) {
            // Guest capacity logic can go here
        }

        // Save recent search (FR‑5)
        if (auth()->check() && ($request->filled('location') || $request->filled('check_in') || $request->filled('guests'))) {
            RecentSearch::create([
                'user_id'   => auth()->id(),
                'location'  => $request->location,
                'check_in'  => $request->check_in,
                'check_out' => $request->check_out,
                'guests'    => $request->guests,
            ]);
        }

        $properties = $query->paginate(10);

        return view('properties.index', compact('properties', 'sort'));
    }
}
