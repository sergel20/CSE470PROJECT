<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ListingController extends Controller
{
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
        // Validate all fields at once
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

        $listing = Listing::create($validated);

        return redirect()
            ->route('listings.show', $listing)
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
        // Authorize that user owns this listing
        $this->authorize('update', $listing);

        return view('listings.edit', ['listing' => $listing]);
    }

    /**
     * Update the specified listing in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        // Authorize that user owns this listing
        $this->authorize('update', $listing);

        $data = $request->validated();

        // Handle amenities array
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
        // Authorize that user owns this listing
        $this->authorize('delete', $listing);

        $listing->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Listing deleted successfully!');
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
