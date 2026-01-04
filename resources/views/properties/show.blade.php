@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-3">{{ $property->title }}</h1>

    <div class="mb-4">
        <p class="text-gray-700">{{ $property->description }}</p>
    </div>

    <div class="mb-4">
        <span class="font-medium">Price per night:</span>
        <span>${{ $property->price }}</span>
    </div>

    {{-- Amenities --}}
    @if(!empty($property->amenities))
        <div class="mb-4">
            <h3 class="font-semibold">Amenities</h3>
            <ul class="list-disc list-inside">
                @php
                    $amenities = is_array($property->amenities) ? $property->amenities : json_decode($property->amenities, true) ?? [];
                @endphp
                @foreach($amenities as $amenity)
                    <li>{{ $amenity }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Host info --}}
    @if($property->host)
        <div class="mb-6 flex items-center gap-4">
            <img src="{{ $property->host->photo_url }}" alt="{{ $property->host->name }}" class="w-16 h-16 rounded-full object-cover">
            <div>
                <div class="font-medium">{{ $property->host->name }}</div>
                <div class="text-sm text-gray-600">{{ $property->host->listings()->count() }} properties</div>
                @if($property->host->bio)
                    <div class="text-sm text-gray-600">{{ $property->host->bio }}</div>
                @endif
                <a href="{{ route('profile.show', $property->host) }}" class="text-sm text-blue-600 hover:underline">View Profile</a>
            </div>
        </div>
    @endif

    {{-- Booking button - only guests can see and book --}}
    @if(Auth::check() && Auth::user()->role === 'guest')
        <div class="mb-6">
            <form method="POST" action="{{ route('bookings.store') }}" class="space-y-2">
                @csrf
                <input type="hidden" name="host_id" value="{{ $property->host_id }}">
                <input type="hidden" name="property_id" value="{{ $property->id }}">

                <div>
                    <label class="block text-sm">Check-in</label>
                    <input type="date" name="start_date" class="border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-sm">Nights</label>
                    <input type="number" name="nights" min="1" value="1" class="border rounded px-3 py-2 w-24" required>
                </div>

                <div>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Book Now</button>
                </div>
            </form>
        </div>
    @elseif(!Auth::check())
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded">
            <p class="text-sm"><a href="{{ route('login') }}" class="text-blue-600 underline">Log in</a> as a guest to book this property.</p>
        </div>
    @elseif(Auth::check() && Auth::user()->role === 'host')
        <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded">
            <p class="text-sm text-gray-600">Only guests can book properties.</p>
        </div>
    @endif

    {{-- Edit link for property owner/host only --}}
    @if(Auth::check() && Auth::user()->id === $property->host_id)
        <a href="{{ route('properties.edit', $property) }}" class="text-sm text-blue-600">Edit Property</a>
    @endif

    {{-- Host availability manager (owner only) --}}
    @if(Auth::check() && Auth::user()->id === $property->host_id)
        <div class="mt-8 p-4 bg-white dark:bg-gray-800 border rounded">
            <h3 class="font-semibold mb-2">Manage blocked dates</h3>

            @if(session('status'))
                <div class="mb-2 text-sm text-green-600">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('properties.blocks.store', $property) }}" class="flex items-center gap-2 mb-4">
                @csrf
                <input type="date" name="blocked_date" class="border rounded px-3 py-2" required>
                <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded">Block</button>
            </form>

            <div>
                <h4 class="font-medium mb-2">Currently blocked</h4>
                <div class="space-y-2">
                    @foreach($property->blockedDates()->orderBy('blocked_date')->get() as $block)
                        <div class="flex items-center justify-between border rounded px-3 py-2">
                            <div>{{ $block->blocked_date->toDateString() }}</div>
                            <form method="POST" action="{{ route('properties.blocks.destroy', [$property, $block]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-blue-600">Unblock</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    @if(!Auth::check() || Auth::user()->id !== $property->host_id)
        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded">
            <p class="text-sm text-yellow-800">Only the property owner can block or unblock dates. Sign in as the host account to manage availability.</p>
        </div>
    @endif
</div>
@endsection
