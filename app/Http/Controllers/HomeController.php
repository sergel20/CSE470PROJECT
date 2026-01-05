<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

            // Get trending cities based on booking activity
            $trendingCities = $this->getTrendingCities();

            return view('home', compact('featured', 'recent', 'hasFilters', 'trendingCities'));
        }

        // Unauthenticated visitors: show the welcome page
        return view('welcome');
    }

    /**
     * Get trending cities based on booking activity.
     * Returns cities with the most recent bookings in the last 90 days.
     */
    private function getTrendingCities()
    {
        try {
            // Get trending cities from actual bookings linked to listings
            $trendingCities = Listing::select('listings.city', 'listings.country', DB::raw('COUNT(bookings.id) as booking_count'))
                ->join('bookings', 'listings.id', '=', 'bookings.listing_id')
                ->where('listings.status', 'published')
                ->where('bookings.created_at', '>=', now()->subDays(90))
                ->whereNotNull('listings.city')
                ->where('listings.city', '!=', '')
                ->groupBy('listings.city', 'listings.country')
                ->having(DB::raw('COUNT(bookings.id)'), '>', 0)
                ->orderByDesc('booking_count')
                ->take(6)
                ->get();

            if ($trendingCities->isNotEmpty()) {
                return $trendingCities->map(function ($item) {
                    $sampleListing = Listing::where('city', $item->city)
                        ->where('country', $item->country)
                        ->where('status', 'published')
                        ->whereNotNull('main_image')
                        ->first();

                    return [
                        'city' => $item->city,
                        'country' => $item->country,
                        'booking_count' => (int) $item->booking_count,
                        'image' => $sampleListing?->main_image 
                            ? asset('storage/' . $sampleListing->main_image) 
                            : 'https://via.placeholder.com/400x300?text=' . urlencode($item->city),
                        'listings_count' => Listing::where('city', $item->city)
                            ->where('country', $item->country)
                            ->where('status', 'published')
                            ->count()
                    ];
                });
            }

            return $this->getFallbackTrendingCities();
        } catch (\Exception $e) {
            // Fallback if query fails
            return $this->getFallbackTrendingCities();
        }
    }

    /**
     * Fallback: Get trending cities based on most listed properties
     */
    private function getFallbackTrendingCities()
    {
        return Listing::select('city', 'country')
            ->where('status', 'published')
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->groupBy('city', 'country')
            ->orderByRaw('COUNT(*) DESC')
            ->take(6)
            ->get()
            ->map(function ($item) {
                $sampleListing = Listing::where('city', $item->city)
                    ->where('country', $item->country)
                    ->where('status', 'published')
                    ->whereNotNull('main_image')
                    ->first();

                return [
                    'city' => $item->city,
                    'country' => $item->country,
                    'booking_count' => 0,
                    'image' => $sampleListing?->main_image 
                        ? asset('storage/' . $sampleListing->main_image) 
                        : 'https://via.placeholder.com/400x300?text=' . urlencode($item->city),
                    'listings_count' => Listing::where('city', $item->city)
                        ->where('country', $item->country)
                        ->where('status', 'published')
                        ->count()
                ];
            });
    }
}
