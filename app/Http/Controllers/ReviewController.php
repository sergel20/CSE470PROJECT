<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Listing;

// app/Http/Controllers/ReviewController.php

class ReviewController extends Controller
{
    public function create(Booking $booking)
    {
        // Check if user owns this booking
        if ($booking->guest_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Check if already reviewed
        $existingReview = Review::where('user_id', auth()->id())
            ->where('listing_id', $booking->listing_id)
            ->first();

        if ($existingReview) {
            return back()->with('info', 'You have already reviewed this listing.');
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        // Check if user owns this booking
        if ($booking->guest_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Check if already reviewed
        $existingReview = Review::where('user_id', auth()->id())
            ->where('listing_id', $booking->listing_id)
            ->first();

        if ($existingReview) {
            return back()->with('info', 'You have already reviewed this listing.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'listing_id' => $booking->listing_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('dashboard')->with('success', 'Review submitted successfully.');
    }
}
