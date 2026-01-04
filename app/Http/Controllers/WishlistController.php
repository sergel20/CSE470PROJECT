<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Listing;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist
     */
    public function index()
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->with('listing')
            ->latest()
            ->get();

        return view('guest.wishlist', compact('wishlist'));
    }

    /**
     * Add a listing to wishlist
     */
    public function store(Listing $listing)
    {
        // Check if already in wishlist
        $exists = Wishlist::where('user_id', auth()->id())
            ->where('listing_id', $listing->id)
            ->exists();

        if ($exists) {
            return back()->with('info', 'This listing is already in your wishlist.');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'listing_id' => $listing->id,
        ]);

        return back()->with('success', 'Added to wishlist!');
    }

    /**
     * Remove a listing from wishlist
     */
    public function destroy(Wishlist $wishlist)
    {
        // Ensure the wishlist item belongs to the authenticated user
        if ($wishlist->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $wishlist->delete();

        return back()->with('success', 'Removed from wishlist.');
    }
}
