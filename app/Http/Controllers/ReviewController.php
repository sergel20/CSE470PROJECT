<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// app/Http/Controllers/ReviewController.php

class ReviewController extends Controller
{
    public function store(Request $request, $propertyId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        // ensure booking completed
        $hasBooking = Booking::where('user_id', auth()->id())
            ->where('property_id', $propertyId)
            ->where('status', 'completed')
            ->exists();

        if (!$hasBooking) {
            abort(403, 'You can only review after staying.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'property_id' => $propertyId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }
}
