<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\BlockedDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostAvailabilityController extends Controller
{
    public function store(Request $request, Listing $listing)
    {
        // only listing owner can block dates
        $this->authorize('update', $listing);

        $request->validate([
            'blocked_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $date = $request->input('blocked_date');

        $block = BlockedDate::firstOrCreate([
            'listing_id' => $listing->id,
            'blocked_date' => $date,
        ]);

        return back()->with('status', 'Date blocked');
    }

    public function destroy(Listing $listing, BlockedDate $block)
    {
        $this->authorize('update', $listing);

        if ($block->listing_id !== $listing->id) {
            abort(404);
        }

        $block->delete();

        return back()->with('status', 'Date unblocked');
    }
}
