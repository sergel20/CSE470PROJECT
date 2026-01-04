<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $listing->title }}
        </h2>
    </x-slot>

<div class="bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg text-green-800 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg text-blue-800 dark:text-blue-200">
                {{ session('info') }}
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
            <div class="flex gap-2">
                @auth
                    @if(auth()->user()->role === 'guest')
                        @php
                            $inWishlist = auth()->user()->wishlist()->where('listing_id', $listing->id)->exists();
                        @endphp
                        @if($inWishlist)
                            <form method="POST" action="{{ route('wishlist.remove', auth()->user()->wishlist()->where('listing_id', $listing->id)->first()) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-50 border border-red-200 text-red-600 rounded-lg hover:bg-red-100 transition flex items-center gap-2" title="Remove from wishlist">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                    </svg>
                                    Saved
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('wishlist.store', $listing) }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition flex items-center gap-2" title="Add to wishlist">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    Save
                                </button>
                            </form>
                        @endif
                    @endif
                @endauth

                @if(auth()->check() && auth()->user()->id === $listing->user_id)
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
                @endif
            </div>
        </div>

        <!-- Property Info Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center border border-gray-200 dark:border-gray-700">
                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $listing->guest_capacity }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Guests</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center border border-gray-200 dark:border-gray-700">
                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $listing->bedrooms }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Bedrooms</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center border border-gray-200 dark:border-gray-700">
                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $listing->bathrooms }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Bathrooms</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center border border-gray-200 dark:border-gray-700">
                <div class="text-lg text-gray-500 dark:text-gray-400 capitalize">{{ str_replace('_', ' ', $listing->property_type) }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Type</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center border border-gray-200 dark:border-gray-700">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">${{ number_format($listing->price_per_night, 2) }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Per Night</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="col-span-3 md:col-span-2">
                <!-- Description -->
                <div class="bg-white dark:bg-gray-800 rounded-lg p-8 mb-8 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">About the property</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $listing->description }}</p>
                </div>

                <!-- Amenities -->
                @if($listing->amenities)
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-8 mb-8 border border-gray-200 dark:border-gray-700">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Amenities</h2>
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
                                <div class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-900 dark:text-gray-100">
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

                    @auth
                        @if(auth()->user()->role === 'guest')
                            <!-- Booking Form -->
                            <form method="POST" action="{{ route('bookings.store') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="host_id" value="{{ $listing->user_id }}">
                                <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                                    <input type="date" name="start_date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900" min="{{ now()->format('Y-m-d') }}">
                                    @error('start_date')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Nights</label>
                                    <input type="number" name="nights" required min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-900" value="1">
                                    @error('nights')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-600">Nightly rate:</span>
                                        <span class="font-medium">${{ number_format($listing->price_per_night, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between mb-3 pb-3 border-b border-gray-200">
                                        <span class="text-gray-600">Service fee (10%):</span>
                                        <span class="font-medium">${{ number_format($listing->price_per_night * 0.10, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between font-bold text-lg">
                                        <span>Total:</span>
                                        <span id="totalPrice">${{ number_format($listing->price_per_night * 1.10, 2) }}</span>
                                    </div>
                                </div>

                                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition">
                                    Book Now
                                </button>

                                @if($errors->has('booking'))
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                        <p class="text-red-600 text-sm">{{ $errors->first('booking') }}</p>
                                    </div>
                                @endif
                            </form>

                            <script>
                                // Update total price when nights change
                                document.querySelector('input[name="nights"]').addEventListener('change', function() {
                                    const nightly = {{ $listing->price_per_night }};
                                    const nights = parseInt(this.value) || 1;
                                    const total = (nightly * nights) + (nightly * 0.10);
                                    document.getElementById('totalPrice').textContent = '$' + total.toFixed(2);
                                });
                            </script>
                        @else
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                                <p class="text-blue-800 font-medium">You are logged in as a host.</p>
                                <p class="text-blue-600 text-sm mt-1">Hosts cannot book listings.</p>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full block text-center bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition">
                            Sign in to Book
                        </a>
                    @endauth

                    <div class="border-t border-gray-200 mt-6 pt-6">
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
