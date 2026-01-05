@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Search Bar -->
    <div class="mb-10">
        <form method="get" action="{{ route('home') }}" class="flex gap-3 items-center">
            <input name="q" type="search" placeholder="Search listings..." value="{{ request('q') }}" class="flex-1 border-2 border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition">
            <input name="min_price" type="number" placeholder="Min $" value="{{ request('min_price') }}" class="w-28 border-2 border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition">
            <input name="max_price" type="number" placeholder="Max $" value="{{ request('max_price') }}" class="w-28 border-2 border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition">
            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">Search</button>
            @if($hasFilters)
                <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium underline transition">Reset</a>
            @endif
        </form>
    </div>

    @if(!empty($hasFilters) && $hasFilters)
        <!-- Search Results -->
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">Search Results</h2>
            
            @if($listings->isEmpty())
                <div class="bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-500 p-6 rounded-lg">
                    <p class="text-gray-700 dark:text-gray-300">No listings found. Try removing filters or <a href="{{ route('home') }}" class="text-indigo-600 dark:text-indigo-400 font-semibold underline">reset your search</a>.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($listings as $listing)
                        <a href="{{ route('listings.show', $listing) }}" class="group block bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            @php $photo = $listing->main_image ? asset('storage/' . $listing->main_image) : 'https://via.placeholder.com/400x300?text=No+Image'; @endphp
                            <div class="relative h-52 overflow-hidden">
                                <img src="{{ $photo }}" alt="{{ $listing->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">{{ $listing->title }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $listing->city }}, {{ $listing->country }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($listing->price_per_night, 0) }}<span class="text-sm font-normal text-gray-600 dark:text-gray-400">/night</span></p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $listing->bedrooms }} bed • {{ $listing->bathrooms }} bath</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <!-- Trending Cities Section -->
        @if(!empty($trendingCities) && $trendingCities->isNotEmpty())
        <div class="mb-16">
            <div class="mb-8 text-center">
                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white px-6 py-2 rounded-full text-sm font-semibold mb-4 shadow-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    TRENDING NOW
                </div>
                <h2 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-3">Popular Destinations</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">Discover the hottest cities based on recent booking activity</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($trendingCities as $city)
                    <x-trending-city-card 
                        :city="$city['city']"
                        :country="$city['country']"
                        :bookingCount="$city['booking_count']"
                        :listingsCount="$city['listings_count']"
                        :image="$city['image']"
                    />
                @endforeach
            </div>
        </div>
        @endif

        <!-- Featured Listings -->
        <div class="mb-16">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Featured Listings</h2>
                <p class="text-gray-600 dark:text-gray-400">Handpicked properties just for you</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($featured ?? [] as $listing)
                    <a href="{{ route('listings.show', $listing) }}" class="group block bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        @php $photo = $listing->main_image ? asset('storage/' . $listing->main_image) : 'https://via.placeholder.com/400x300?text=No+Image'; @endphp
                        <div class="relative h-52 overflow-hidden">
                            <img src="{{ $photo }}" alt="{{ $listing->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute top-4 left-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">
                                FEATURED
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">{{ $listing->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $listing->city }}, {{ $listing->country }}
                            </p>
                            <div class="flex items-center justify-between">
                                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($listing->price_per_night, 0) }}<span class="text-sm font-normal text-gray-600 dark:text-gray-400">/night</span></p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $listing->bedrooms }} bed • {{ $listing->bathrooms }} bath</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-gray-600 dark:text-gray-300">No featured listings yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Listings -->
        <div class="mb-8">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Recent Listings</h2>
                <p class="text-gray-600 dark:text-gray-400">Latest properties added to our platform</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($recent ?? [] as $listing)
                    <a href="{{ route('listings.show', $listing) }}" class="group block bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        @php $photo = $listing->main_image ? asset('storage/' . $listing->main_image) : 'https://via.placeholder.com/400x300?text=No+Image'; @endphp
                        <div class="relative h-52 overflow-hidden">
                            <img src="{{ $photo }}" alt="{{ $listing->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">{{ $listing->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $listing->city }}, {{ $listing->country }}
                            </p>
                            <div class="flex items-center justify-between">
                                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($listing->price_per_night, 0) }}<span class="text-sm font-normal text-gray-600 dark:text-gray-400">/night</span></p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $listing->bedrooms }} bed • {{ $listing->bathrooms }} bath</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-gray-600 dark:text-gray-300">No recent listings yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>

@endsection

