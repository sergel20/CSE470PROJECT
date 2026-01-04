@extends('layouts.app')

@section('content')
<div class="mb-6">
    <form method="get" action="{{ route('home') }}" class="flex gap-2">
        <input name="q" type="search" placeholder="Search listings..." value="{{ request('q') }}" class="border rounded px-3 py-2 w-1/2 text-gray-900 dark:text-gray-100">
        <input name="min_price" type="number" placeholder="Min price" value="{{ request('min_price') }}" class="border rounded px-3 py-2 w-24 text-gray-900 dark:text-gray-100">
        <input name="max_price" type="number" placeholder="Max price" value="{{ request('max_price') }}" class="border rounded px-3 py-2 w-24 text-gray-900 dark:text-gray-100">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
        <a href="{{ route('home') }}" class="ml-2 text-gray-600 dark:text-gray-300 underline">Reset</a>
    </form>
</div>

@if(!empty($hasFilters) && $hasFilters)
    <h2 class="text-xl font-semibold mb-4">Search Results</h2>
    
    @if($listings->isEmpty())
        <div class="text-gray-600 dark:text-gray-300">No listings found. Try removing filters or <a href="{{ route('home') }}" class="underline">reset</a>.</div>
    @else
        <div class="grid grid-cols-3 gap-4">
            @foreach($listings as $listing)
                <a href="{{ route('listings.show', $listing) }}" class="block border p-4 hover:shadow">
                    @php $photo = $listing->main_image ? asset('storage/' . $listing->main_image) : 'https://via.placeholder.com/400x300?text=No+Image'; @endphp
                    <img src="{{ $photo }}" alt="{{ $listing->title }}" class="w-full h-48 object-cover mb-2">
                    <h2 class="font-semibold">{{ $listing->title }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $listing->city }}, {{ $listing->country }}</p>
                    <p class="text-lg font-bold">${{ number_format($listing->price_per_night, 2) }}/night</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $listing->bedrooms }} bed • {{ $listing->bathrooms }} bath</p>
                    @if($listing->reviews->count() > 0)
                        <div class="mt-2 flex items-center gap-1">
                            <span class="text-yellow-500">⭐</span>
                            <span class="font-semibold">{{ number_format($listing->averageRating(), 1) }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">({{ $listing->reviews->count() }} {{ $listing->reviews->count() === 1 ? 'review' : 'reviews' }})</span>
                        </div>
                    @else
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No reviews</p>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
@else
    <h2 class="text-2xl font-semibold mb-4">Featured Listings</h2>
    <div class="grid grid-cols-3 gap-4 mb-8">
        @forelse($featured ?? [] as $listing)
            <a href="{{ route('listings.show', $listing) }}" class="block border p-4 hover:shadow">
                @php $photo = $listing->main_image ? asset('storage/' . $listing->main_image) : 'https://via.placeholder.com/400x300?text=No+Image'; @endphp
                <img src="{{ $photo }}" alt="{{ $listing->title }}" class="w-full h-48 object-cover mb-2">
                <h3 class="font-semibold">{{ $listing->title }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $listing->city }}, {{ $listing->country }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">${{ number_format($listing->price_per_night, 2) }}/night</p>
                @if($listing->reviews->count() > 0)
                    <div class="mt-2 flex items-center gap-1">
                        <span class="text-yellow-500">⭐</span>
                        <span class="font-semibold">{{ number_format($listing->averageRating(), 1) }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">({{ $listing->reviews->count() }})</span>
                    </div>
                @else
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No reviews</p>
                @endif
            </a>
        @empty
            <div class="col-span-3 text-center text-gray-600 dark:text-gray-300">No featured listings yet.</div>
        @endforelse
    </div>

    <h2 class="text-2xl font-semibold mb-4">Recent Listings</h2>
    <div class="grid grid-cols-3 gap-4">
        @forelse($recent ?? [] as $listing)
            <a href="{{ route('listings.show', $listing) }}" class="block border p-4 hover:shadow">
                @php $photo = $listing->main_image ? asset('storage/' . $listing->main_image) : 'https://via.placeholder.com/400x300?text=No+Image'; @endphp
                <img src="{{ $photo }}" alt="{{ $listing->title }}" class="w-full h-48 object-cover mb-2">
                <h3 class="font-semibold">{{ $listing->title }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $listing->city }}, {{ $listing->country }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">${{ number_format($listing->price_per_night, 2) }}/night</p>
                @if($listing->reviews->count() > 0)
                    <div class="mt-2 flex items-center gap-1">
                        <span class="text-yellow-500">⭐</span>
                        <span class="font-semibold">{{ number_format($listing->averageRating(), 1) }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">({{ $listing->reviews->count() }})</span>
                    </div>
                @else
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No reviews</p>
                @endif
            </a>
        @empty
            <div class="col-span-3 text-center text-gray-600 dark:text-gray-300">No recent listings yet.</div>
        @endforelse
    </div>
@endif

@endsection
