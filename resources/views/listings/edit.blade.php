<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Listing') }}
        </h2>
    </x-slot>

<div class="min-h-screen bg-gradient-to-br from-indigo-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Edit Listing</h1>
            <p class="text-lg text-gray-600">Update your property information</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('listings.update', $listing) }}" class="bg-white rounded-lg shadow-lg p-8">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Basic Information -->
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Basic Information</h2>
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        maxlength="255"
                        value="{{ old('title', $listing->title) }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('title') border-red-500 @enderror"
                        required
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">Property Type *</label>
                    <select
                        id="property_type"
                        name="property_type"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('property_type') border-red-500 @enderror"
                        required
                    >
                        <option value="">Select a property type</option>
                        <option value="apartment" {{ old('property_type', $listing->property_type) === 'apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="house" {{ old('property_type', $listing->property_type) === 'house' ? 'selected' : '' }}>House</option>
                        <option value="villa" {{ old('property_type', $listing->property_type) === 'villa' ? 'selected' : '' }}>Villa</option>
                        <option value="condo" {{ old('property_type', $listing->property_type) === 'condo' ? 'selected' : '' }}>Condo</option>
                        <option value="townhouse" {{ old('property_type', $listing->property_type) === 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                        <option value="cottage" {{ old('property_type', $listing->property_type) === 'cottage' ? 'selected' : '' }}>Cottage</option>
                        <option value="penthouse" {{ old('property_type', $listing->property_type) === 'penthouse' ? 'selected' : '' }}>Penthouse</option>
                        <option value="studio" {{ old('property_type', $listing->property_type) === 'studio' ? 'selected' : '' }}>Studio</option>
                    </select>
                    @error('property_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="8"
                        maxlength="5000"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('description') border-red-500 @enderror"
                        required
                    >{{ old('description', $listing->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address Section -->
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 mt-8">Address</h2>
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Street Address *</label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        value="{{ old('address', $listing->address) }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('address') border-red-500 @enderror"
                        required
                    >
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                    <input
                        type="text"
                        id="city"
                        name="city"
                        value="{{ old('city', $listing->city) }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('city') border-red-500 @enderror"
                        required
                    >
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State/Province *</label>
                    <input
                        type="text"
                        id="state"
                        name="state"
                        value="{{ old('state', $listing->state) }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('state') border-red-500 @enderror"
                        required
                    >
                    @error('state')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-2">Zip/Postal Code *</label>
                    <input
                        type="text"
                        id="zip_code"
                        name="zip_code"
                        value="{{ old('zip_code', $listing->zip_code) }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('zip_code') border-red-500 @enderror"
                        required
                    >
                    @error('zip_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                    <input
                        type="text"
                        id="country"
                        name="country"
                        value="{{ old('country', $listing->country) }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('country') border-red-500 @enderror"
                        required
                    >
                    @error('country')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capacity Section -->
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 mt-8">Capacity</h2>
                </div>

                <div>
                    <label for="guest_capacity" class="block text-sm font-medium text-gray-700 mb-2">Max Guests *</label>
                    <input
                        type="number"
                        id="guest_capacity"
                        name="guest_capacity"
                        min="1"
                        max="50"
                        value="{{ old('guest_capacity', $listing->guest_capacity) }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('guest_capacity') border-red-500 @enderror"
                        required
                    >
                    @error('guest_capacity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-2">Bedrooms *</label>
                    <input
                        type="number"
                        id="bedrooms"
                        name="bedrooms"
                        min="0"
                        max="20"
                        value="{{ old('bedrooms', $listing->bedrooms) }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('bedrooms') border-red-500 @enderror"
                        required
                    >
                    @error('bedrooms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-2">Bathrooms *</label>
                    <input
                        type="number"
                        id="bathrooms"
                        name="bathrooms"
                        min="1"
                        max="20"
                        value="{{ old('bathrooms', $listing->bathrooms) }}"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('bathrooms') border-red-500 @enderror"
                        required
                    >
                    @error('bathrooms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amenities Section -->
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 mt-8">Amenities</h2>
                </div>

                <div class="md:col-span-2">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @php
                            $allAmenities = [
                                'wifi' => 'WiFi',
                                'tv' => 'TV',
                                'kitchen' => 'Full Kitchen',
                                'parking' => 'Parking',
                                'pool' => 'Pool',
                                'gym' => 'Gym',
                                'ac' => 'Air Conditioning',
                                'heating' => 'Heating',
                                'washer' => 'Washer',
                                'dryer' => 'Dryer',
                                'elevator' => 'Elevator',
                                'balcony' => 'Balcony/Terrace',
                                'garden' => 'Garden',
                                'hot_tub' => 'Hot Tub',
                                'fireplace' => 'Fireplace',
                                'alarm' => 'Security System',
                                'pets' => 'Pets Allowed',
                                'furnished' => 'Furnished',
                            ];
                            $selectedAmenities = old('amenities', $listing->amenities ?? []);
                        @endphp

                        @foreach($allAmenities as $value => $label)
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    id="amenity_{{ $value }}"
                                    name="amenities[]"
                                    value="{{ $value }}"
                                    {{ in_array($value, $selectedAmenities) ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                >
                                <label for="amenity_{{ $value }}" class="ml-3 text-sm font-medium text-gray-700">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('amenities')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pricing Section -->
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 mt-8">Pricing</h2>
                </div>

                <div>
                    <label for="price_per_night" class="block text-sm font-medium text-gray-700 mb-2">Price per Night *</label>
                    <div class="relative">
                        <span class="absolute left-4 top-2 text-2xl text-gray-400">$</span>
                        <input
                            type="number"
                            id="price_per_night"
                            name="price_per_night"
                            min="0.01"
                            step="0.01"
                            max="999999.99"
                            value="{{ old('price_per_night', $listing->price_per_night) }}"
                            class="block w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent @error('price_per_night') border-red-500 @enderror"
                            required
                        >
                    </div>
                    @error('price_per_night')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('listings.show', $listing) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
