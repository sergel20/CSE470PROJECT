<?php

namespace App\Http\Controllers;

use App\Models\Property;
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
                $query = Property::query();

                if ($q = $request->input('q')) {
                    // Search by property title or description
                    $query->where(function ($sub) use ($q) {
                        $sub->where('title', 'like', "%{$q}%")
                            ->orWhere('description', 'like', "%{$q}%");
                    });
                }

                if ($min = $request->input('min_price')) {
                    $query->where('price', '>=', $min);
                }

                if ($max = $request->input('max_price')) {
                    $query->where('price', '<=', $max);
                }

                $properties = $query->latest()->take(50)->get();
                return view('home', compact('properties', 'hasFilters'));
            }

            // No filters: show curated galleries
            $featured = Property::where('featured', true)->latest()->take(6)->get();
            $popular = Property::whereNotNull('rating')->orderByDesc('rating')->take(6)->get();
            $recent = Property::latest()->take(6)->get();

            return view('home', compact('featured', 'popular', 'recent', 'hasFilters'));
        }

        // Unauthenticated visitors: show the welcome page
        return view('welcome');
    }
}
