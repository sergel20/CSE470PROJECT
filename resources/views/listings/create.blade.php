<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Listing') }}
        </h2>
    </x-slot>

    <div class="bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Create a New Listing</h1>
                <p class="text-lg text-gray-600">Share your property and start earning</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-8 bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm font-semibold text-red-800 mb-2">Please fix the following errors:</p>
                    <ul class="text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('listings.store') }}" class="bg-white rounded-lg shadow-lg p-8 space-y-8">
                @csrf

                <!-- Section 1: Address -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Address Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Street Address *</label>
                            <input
                                type="text"
                                id="address"
                                name="address"
                                value="{{ old('address') }}"
                                class="block w-full px-4 py-2 border {{ $errors->has('address') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                                placeholder="123 Main Street"
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
                                value="{{ old('city') }}"
                                class="block w-full px-4 py-2 border {{ $errors->has('city') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                                placeholder="New York"
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
                                value="{{ old('state') }}"
                                class="block w-full px-4 py-2 border {{ $errors->has('state') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                                placeholder="NY"
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
                                value="{{ old('zip_code') }}"
                                class="block w-full px-4 py-2 border {{ $errors->has('zip_code') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                                placeholder="10001"
                                required
                            >
                            @error('zip_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                            <input
                                type="text"
                                id="country"
                                name="country"
                                value="{{ old('country') }}"
                                class="block w-full px-4 py-2 border {{ $errors->has('country') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                                placeholder="United States"
                                required
                            >
                            @error('country')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Section 2: Property Details -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Property Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">Property Type *</label>
                            <select
                                id="property_type"
                                name="property_type"
                                class="block w-full px-4 py-2 border {{ $errors->has('property_type') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                                required
                            >
                                <option value="">Select a property type</option>
                                <option value="apartment" {{ old('property_type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="house" {{ old('property_type') === 'house' ? 'selected' : '' }}>House</option>
                                <option value="villa" {{ old('property_type') === 'villa' ? 'selected' : '' }}>Villa</option>
                                <option value="condo" {{ old('property_type') === 'condo' ? 'selected' : '' }}>Condo</option>
                                <option value="townhouse" {{ old('property_type') === 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                                <option value="cottage" {{ old('property_type') === 'cottage' ? 'selected' : '' }}>Cottage</option>
                                <option value="penthouse" {{ old('property_type') === 'penthouse' ? 'selected' : '' }}>Penthouse</option>
                                <option value="studio" {{ old('property_type') === 'studio' ? 'selected' : '' }}>Studio</option>
                            </select>
                            @error('property_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="guest_capacity" class="block text-sm font-medium text-gray-700 mb-2">Max Guests *</label>
                            <input
                                type="number"
                                id="guest_capacity"
                                name="guest_capacity"
                                value="{{ old('guest_capacity', 1) }}"
                                min="1"
                                max="50"
                                class="block w-full px-4 py-2 border {{ $errors->has('guest_capacity') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
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
                                value="{{ old('bedrooms', 1) }}"
                                min="0"
                                max="20"
                                class="block w-full px-4 py-2 border {{ $errors->has('bedrooms') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
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
                                value="{{ old('bathrooms', 1) }}"
                                min="1"
                                max="20"
                                class="block w-full px-4 py-2 border {{ $errors->has('bathrooms') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                                required
                            >
                            @error('bathrooms')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Section 3: Title & Description -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Listing Information</h2>
                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                maxlength="255"
                                class="block w-full px-4 py-2 border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                                placeholder="e.g., Beautiful Cozy Apartment in Manhattan"
                                required
                                oninput="updateCharCount('title')"
                            >
                            <p class="mt-1 text-sm text-gray-500"><span id="title-count">{{ strlen(old('title', '')) }}</span>/255</p>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                maxlength="5000"
                                class="block w-full px-4 py-2 border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                                placeholder="Tell guests what makes your property special..."
                                required
                                oninput="updateCharCount('description')"
                            >{{ old('description') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500"><span id="description-count">{{ strlen(old('description', '')) }}</span>/5000 (minimum 10 characters)</p>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Section 4: Amenities -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Amenities</h2>
                    <p class="text-gray-600 mb-6">Choose all the amenities your property offers</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @php
                            $amenities = [
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
                            $selectedAmenities = old('amenities', []);
                        @endphp

                        @foreach($amenities as $value => $label)
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    id="amenity_{{ $value }}"
                                    name="amenities[]"
                                    value="{{ $value }}"
                                    {{ in_array($value, (array) $selectedAmenities) ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                >
                                <label for="amenity_{{ $value }}" class="ml-3 text-sm font-medium text-gray-700">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr class="border-gray-200">

                <!-- Section 5: Pricing -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Pricing</h2>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <p class="text-sm text-blue-800">💡 <strong>Tip:</strong> Research similar properties in your area to set a competitive price.</p>
                    </div>

                    <div class="max-w-md">
                        <label for="price_per_night" class="block text-sm font-medium text-gray-700 mb-2">Price per Night *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2 text-2xl text-gray-400">$</span>
                            <input
                                type="number"
                                id="price_per_night"
                                name="price_per_night"
                                value="{{ old('price_per_night') }}"
                                min="0.01"
                                step="0.01"
                                max="999999.99"
                                class="block w-full pl-8 pr-4 py-2 border {{ $errors->has('price_per_night') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent"
                                placeholder="99.99"
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
                    <a href="{{ route('dashboard') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="ml-auto px-8 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                        Create Listing
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateCharCount(fieldId) {
            const field = document.getElementById(fieldId);
            const countElement = document.getElementById(fieldId + '-count');
            countElement.textContent = field.value.length;
        }
    </script>
</x-app-layout>
