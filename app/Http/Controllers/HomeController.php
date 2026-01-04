<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Authenticated hosts: send to dashboard
        if (Auth::check() && Auth::user()->role === 'host') {
            return redirect()->route('dashboard');
        }

        // Authenticated guests see the property gallery (home view)
        if (Auth::check() && Auth::user()->role === 'guest') {
            $hasFilters = $request->filled('q') || $request->filled('min_price') || $request->filled('max_price');

            if ($hasFilters) {
                $query = Listing::where('status', 'published');

                if ($q = $request->input('q')) {
                    // Search by title or description
                    $query->where(function ($sub) use ($q) {
                        $sub->where('title', 'like', "%{$q}%")
                            ->orWhere('description', 'like', "%{$q}%");
                    });
                }

                if ($min = $request->input('min_price')) {
                    $query->where('price_per_night', '>=', $min);
                }

                if ($max = $request->input('max_price')) {
                    $query->where('price_per_night', '<=', $max);
                }

                $listings = $query->latest()->take(50)->get();
                return view('home', compact('listings', 'hasFilters'));
            }

            // No filters: show curated galleries
            $featured = Listing::where('status', 'published')->latest()->take(6)->get();
            $recent = Listing::where('status', 'published')->latest()->take(6)->get();

            return view('home', compact('featured', 'recent', 'hasFilters'));
        }

        // Unauthenticated visitors: show the welcome page
        return view('welcome');
    }
}
