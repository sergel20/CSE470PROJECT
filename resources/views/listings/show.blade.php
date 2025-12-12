<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $listing->title }}
        </h2>
    </x-slot>

<div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <!-- Header -->
        <div class="mb-8 flex justify-between items-start">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $listing->title }}</h1>
                <div class="flex flex-wrap gap-3 text-gray-600">
                    <span class="flex items-center gap-1">
                        📍 {{ $listing->address }}, {{ $listing->city }}, {{ $listing->state }} {{ $listing->zip_code }}
                    </span>
                </div>
            </div>

            <!-- Actions -->
            @if(auth()->check() && auth()->user()->id === $listing->user_id)
                <div class="flex gap-2">
                    <a href="{{ route('listings.edit', $listing) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('listings.destroy', $listing) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Property Info Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-indigo-600">{{ $listing->guest_capacity }}</div>
                <div class="text-sm text-gray-600">Guests</div>
            </div>
            <div class="bg-white rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-indigo-600">{{ $listing->bedrooms }}</div>
                <div class="text-sm text-gray-600">Bedrooms</div>
            </div>
            <div class="bg-white rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-indigo-600">{{ $listing->bathrooms }}</div>
                <div class="text-sm text-gray-600">Bathrooms</div>
            </div>
            <div class="bg-white rounded-lg p-4 text-center">
                <div class="text-lg text-gray-500 capitalize">{{ str_replace('_', ' ', $listing->property_type) }}</div>
                <div class="text-sm text-gray-600">Type</div>
            </div>
            <div class="bg-white rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-green-600">${{ number_format($listing->price_per_night, 2) }}</div>
                <div class="text-sm text-gray-600">Per Night</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="col-span-3 md:col-span-2">
                <!-- Description -->
                <div class="bg-white rounded-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">About the property</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $listing->description }}</p>
                </div>

                <!-- Amenities -->
                @if($listing->amenities)
                    <div class="bg-white rounded-lg p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Amenities</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @php
                                $amenityLabels = [
                                    'wifi' => '🌐 WiFi',
                                    'tv' => '📺 TV',
                                    'kitchen' => '🍳 Full Kitchen',
                                    'parking' => '🅿️ Parking',
                                    'pool' => '🏊 Pool',
                                    'gym' => '💪 Gym',
                                    'ac' => '❄️ Air Conditioning',
                                    'heating' => '🔥 Heating',
                                    'washer' => '🧺 Washer',
                                    'dryer' => '🧽 Dryer',
                                    'elevator' => '🛗 Elevator',
                                    'balcony' => '🌅 Balcony/Terrace',
                                    'garden' => '🌳 Garden',
                                    'hot_tub' => '🛁 Hot Tub',
                                    'fireplace' => '🔥 Fireplace',
                                    'alarm' => '🔒 Security System',
                                    'pets' => '🐾 Pets Allowed',
                                    'furnished' => '🛋️ Furnished',
                                ];
                            @endphp

                            @foreach($listing->amenities as $amenity)
                                <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                                    <span>{{ $amenityLabels[$amenity] ?? $amenity }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Location -->
                <div class="bg-white rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Location</h2>
                    <p class="text-gray-700 mb-4">
                        {{ $listing->address }}<br>
                        {{ $listing->city }}, {{ $listing->state }} {{ $listing->zip_code }}<br>
                        {{ $listing->country }}
                    </p>
                    @if($listing->latitude && $listing->longitude)
                        <p class="text-sm text-gray-500">
                            Coordinates: {{ $listing->latitude }}, {{ $listing->longitude }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="col-span-3 md:col-span-1">
                <div class="bg-white rounded-lg p-6 sticky top-4">
                    <div class="text-4xl font-bold text-gray-900 mb-1">${{ number_format($listing->price_per_night, 2) }}</div>
                    <div class="text-gray-600 mb-6">per night</div>

                    <button class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition mb-4">
                        Reserve Now
                    </button>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Property Details</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Property Type:</span>
                                <span class="font-medium capitalize">{{ str_replace('_', ' ', $listing->property_type) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Max Guests:</span>
                                <span class="font-medium">{{ $listing->guest_capacity }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Bedrooms:</span>
                                <span class="font-medium">{{ $listing->bedrooms }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Bathrooms:</span>
                                <span class="font-medium">{{ $listing->bathrooms }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium capitalize px-2 py-1 rounded-full text-xs" :class="{
                                    'bg-yellow-100 text-yellow-800': '{{ $listing->status }}' === 'draft',
                                    'bg-green-100 text-green-800': '{{ $listing->status }}' === 'published',
                                    'bg-red-100 text-red-800': '{{ $listing->status }}' === 'inactive',
                                }">
                                    {{ ucfirst($listing->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 mt-6 pt-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Hosted by</h3>
                        <div class="flex items-center gap-3">
                            <img src="{{ $listing->user->photo_url }}" alt="{{ $listing->user->name }}" class="w-12 h-12 rounded-full">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $listing->user->name }}</p>
                                <p class="text-sm text-gray-600">Superhost</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-xs text-gray-500 mt-6 pt-6 border-t border-gray-200">
                        <p>Listed on {{ $listing->created_at->format('M d, Y') }}</p>
                        <p>Last updated {{ $listing->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
