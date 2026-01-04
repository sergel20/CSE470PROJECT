<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\BlockedDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostAvailabilityController extends Controller
{
    public function store(Request $request, Property $property)
    {
        // only property owner can block dates
        $this->authorizeForUser(Auth::user(), 'update', $property);

        $request->validate([
            'blocked_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $date = $request->input('blocked_date');

        $block = BlockedDate::firstOrCreate([
            'property_id' => $property->id,
            'blocked_date' => $date,
        ]);

        return back()->with('status', 'Date blocked');
    }

    public function destroy(Property $property, BlockedDate $block)
    {
        $this->authorizeForUser(Auth::user(), 'update', $property);

        if ($block->property_id !== $property->id) {
            abort(404);
        }

        $block->delete();

        return back()->with('status', 'Date unblocked');
    }
}
