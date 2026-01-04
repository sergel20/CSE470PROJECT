<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Host Dashboard') }}
            </h2>
            <a href="{{ route('listings.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                + Add Property
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-indigo-600">{{ $properties->count() }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Total Properties</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-green-600">{{ $properties->sum(fn($p) => $p->bookings->count()) }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Total Bookings</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-yellow-600">{{ $properties->sum(fn($p) => $p->blockedDates->count()) }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Blocked Dates</div>
                </div>
            </div>

            <!-- My Properties -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">My Properties</h3>

                    @if($properties->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($properties as $property)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition">
                                    <div class="bg-gray-100 dark:bg-gray-700 h-48 flex items-center justify-center">
                                        @if($property->photo)
                                            <img src="{{ asset('storage/' . $property->photo) }}" alt="{{ $property->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="text-gray-400">No Image</div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $property->title }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $property->location }}</p>
                                        <div class="flex justify-between items-center mb-3">
                                            <span class="text-lg font-bold text-green-600">${{ number_format($property->price, 2) }}/night</span>
                                        </div>
                                        <div class="flex gap-2 text-sm">
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">
                                                {{ $property->bookings->count() }} bookings
                                            </span>
                                            <span class="px-2 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded">
                                                {{ $property->blockedDates->count() }} blocked
                                            </span>
                                        </div>
                                        <div class="mt-4 flex gap-2">
                                            <a href="{{ route('properties.show', $property) }}" class="flex-1 text-center px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-sm">
                                                Manage Availability
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No properties</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding a new property.</p>
                            <div class="mt-6">
                                <a href="{{ route('listings.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                    + Add Property
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
