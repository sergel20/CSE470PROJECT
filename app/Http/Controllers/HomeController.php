<?php

namespace App\Http\Controllers;

use App\Models\Property;

class HomeController extends Controller
{
    public function index()
    {
        $properties = Property::latest()->take(10)->get();
        return view('home', compact('properties'));
    }
}
