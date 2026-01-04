@extends('layouts.app')

@section('content')
<div class="mb-6">
    <form method="get" action="{{ route('home') }}" class="flex gap-2">
        <input name="q" type="search" placeholder="Search properties..." value="{{ request('q') }}" class="border rounded px-3 py-2 w-1/2 text-gray-900 dark:text-gray-100">
        <input name="min_price" type="number" placeholder="Min price" value="{{ request('min_price') }}" class="border rounded px-3 py-2 w-24 text-gray-900 dark:text-gray-100">
        <input name="max_price" type="number" placeholder="Max price" value="{{ request('max_price') }}" class="border rounded px-3 py-2 w-24 text-gray-900 dark:text-gray-100">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
        <a href="{{ route('home') }}" class="ml-2 text-gray-600 dark:text-gray-300 underline">Reset</a>
    </form>
</div>

@if(!empty($hasFilters) && $hasFilters && isset($properties))
    <h2 class="text-xl font-semibold mb-4">Search Results</h2>
    @if($properties->isEmpty())
        <div class="text-gray-600 dark:text-gray-300">No properties found. Try removing filters or <a href="{{ route('home') }}" class="underline">reset</a>.</div>
    @else
        <div class="grid grid-cols-3 gap-4">
            @foreach($properties as $property)
                <div class="border p-4">
                    @php $photo = $property->photo ? asset('storage/' . $property->photo) : 'https://via.placeholder.com/400x300?text=No+Image'; @endphp
                    <img src="{{ $photo }}" alt="{{ $property->title }}" class="w-full h-48 object-cover mb-2">
                    <h2 class="font-semibold">{{ $property->title }}</h2>
                    <p class="text-lg font-bold">${{ $property->price }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Rating: {{ $property->rating ?? '—' }}</p>
                </div>
            @endforeach
        </div>
    @endif
@else
    <h2 class="text-2xl font-semibold mb-4">Featured</h2>
    <div class="grid grid-cols-3 gap-4 mb-8">
        @foreach($featured as $property)
            <a href="{{ route('properties.show', $property) }}" class="block border p-4 hover:shadow">
                @php $photo = $property->photo ? asset('storage/' . $property->photo) : 'https://via.placeholder.com/400x300?text=No+Image'; @endphp
                <img src="{{ $photo }}" alt="{{ $property->title }}" class="w-full h-48 object-cover mb-2">
                <h3 class="font-semibold">{{ $property->title }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">${{ $property->price }}</p>
            </a>
        @endforeach
    </div>

    <h2 class="text-2xl font-semibold mb-4">Popular</h2>
    <div class="grid grid-cols-3 gap-4 mb-8">
        @foreach($popular as $property)
            <a href="{{ route('properties.show', $property) }}" class="block border p-4 hover:shadow">
                @php $photo = $property->photo ? asset('storage/' . $property->photo) : 'https://via.placeholder.com/400x300?text=No+Image'; @endphp
                <img src="{{ $photo }}" alt="{{ $property->title }}" class="w-full h-48 object-cover mb-2">
                <h3 class="font-semibold">{{ $property->title }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">Rating: {{ $property->rating ?? '—' }}</p>
            </a>
        @endforeach
    </div>

    <h2 class="text-2xl font-semibold mb-4">Recent</h2>
    <div class="grid grid-cols-3 gap-4">
        @foreach($recent as $property)
            <a href="{{ route('properties.show', $property) }}" class="block border p-4 hover:shadow">
                @php $photo = $property->photo ? asset('storage/' . $property->photo) : 'https://via.placeholder.com/400x300?text=No+Image'; @endphp
                <img src="{{ $photo }}" alt="{{ $property->title }}" class="w-full h-48 object-cover mb-2">
                <h3 class="font-semibold">{{ $property->title }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">${{ $property->price }}</p>
            </a>
        @endforeach
    </div>
@endif

@endsection
