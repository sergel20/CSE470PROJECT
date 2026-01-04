<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\BlockedDate;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the host's own listings (FR‑4 dashboard).
     */
    public function index(Request $request)
    {
        $listings = Listing::where('user_id', $request->user()->id)->get();

        // Point to the host dashboard view
        return view('host.listings.index', compact('listings'));
    }

    /**
     * Show the form for creating a new listing.
     */
    public function create()
    {
        return view('listings.create');
    }

    /**
     * Store a newly created listing in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'property_type' => 'required|in:apartment,house,villa,condo,townhouse,cottage,penthouse,studio',
            'guest_capacity' => 'required|integer|min:1|max:50',
            'bedrooms' => 'required|integer|min:0|max:20',
            'bathrooms' => 'required|integer|min:1|max:20',
            'title' => 'required|string|min:10|max:255',
            'description' => 'required|string|min:10|max:5000',
            'price_per_night' => 'required|numeric|min:0.01',
            'amenities' => 'array',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'published'; // default new listings to published

        $listing = Listing::create($validated);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Listing created successfully!');
    }

    /**
     * Display the specified listing.
     */
    public function show(Listing $listing)
    {
        return view('listings.show', ['listing' => $listing]);
    }

    /**
     * Show the form for editing the specified listing.
     */
    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);

        return view('listings.edit', ['listing' => $listing]);
    }

    /**
     * Update the specified listing in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $data = $request->validated();

        if ($request->has('amenities') && is_array($request->amenities)) {
            $data['amenities'] = $request->amenities;
        }

        $listing->update($data);

        return redirect()
            ->route('listings.show', $listing)
            ->with('success', 'Listing updated successfully!');
    }

    /**
     * Remove the specified listing from storage.
     */
    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        $listing->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Listing deleted successfully!');
    }

    /**
     * Toggle the active/inactive status of a listing (FR‑4).
     */
    public function toggleActive(Request $request, Listing $listing)
    {
        $this->authorize('toggleActive', $listing);

        $listing->is_active = !$listing->is_active;
        $listing->save();

        return back()->with('status', 'Listing status updated.');
    }

    /**
     * Get property types for dropdown.
     */
    public static function getPropertyTypes()
    {
        return [
            'apartment' => 'Apartment',
            'house' => 'House',
            'villa' => 'Villa',
            'condo' => 'Condo',
            'townhouse' => 'Townhouse',
            'cottage' => 'Cottage',
            'penthouse' => 'Penthouse',
            'studio' => 'Studio',
        ];
    }

    /**
     * Get available amenities.
     */
    public static function getAmenities()
    {
        return self::amenityLabels();
    }

    public function blockDate(Request $request, Listing $listing)
    {
        // Ensure the user is the owner of the listing
        if ($listing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to block dates on this listing.');
        }

        $validated = $request->validate([
            'blocked_date' => 'required|date|after_or_equal:today',
        ]);

        // Check if this date is already blocked
        BlockedDate::firstOrCreate([
            'listing_id' => $listing->id,
            'blocked_date' => $validated['blocked_date'],
        ]);

        return redirect()->route('dashboard')->with('status', 'Date blocked successfully.');
    }

    public function unblockDate(Request $request, Listing $listing, BlockedDate $blockedDate)
    {
        // Ensure the user is the owner of the listing
        if ($listing->user_id !== auth()->id()) {
            abort(403, 'Unauthorized to unblock dates on this listing.');
        }

        // Ensure the blocked date belongs to this listing
        if ($blockedDate->listing_id !== $listing->id) {
            abort(404, 'Blocked date not found for this listing.');
        }

        $blockedDate->delete();

        return redirect()->route('dashboard')->with('status', 'Date unblocked successfully.');
    }

    private static function amenityLabels()
    {
        return [
            'wifi' => 'WiFi',
            'tv' => 'TV',
            'kitchen' => 'Full Kitchen',
            'parking' => 'Parking',
            'pool' => 'Pool',
            'gym' => 'Gym',
            'ac' => 'Air Conditioning',
            'heating' => 'Heating',
            'washer' => 'Washer',
            'dryer' => 'Dryer',
            'elevator' => 'Elevator',
            'balcony' => 'Balcony/Terrace',
            'garden' => 'Garden',
            'hot_tub' => 'Hot Tub',
            'fireplace' => 'Fireplace',
            'alarm' => 'Security System',
            'pets' => 'Pets Allowed',
            'furnished' => 'Furnished',
        ];
    }
}
