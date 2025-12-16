<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'newest');
        $query = Property::query();

        if ($sort === 'price') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'rating') {
            $query->orderBy('rating', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $properties = $query->paginate(10);
        return view('properties.index', compact('properties', 'sort'));
    }
}
