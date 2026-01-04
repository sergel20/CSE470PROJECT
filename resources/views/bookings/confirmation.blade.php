<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center px-4 py-8">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-12 text-white">
                <div class="flex items-center justify-center mb-4">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-center">Booking Confirmed!</h1>
                <p class="text-center text-green-100 mt-2">Your booking request has been sent to the host</p>
            </div>

            <!-- Content -->
            <div class="px-8 py-12">
                <!-- Listing Details -->
                <div class="mb-8 pb-8 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $booking->listing->title }}</h2>
                    
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Check-in</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $booking->start_date->format('M d, Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Check-out</p>
                            <p class="text-lg font-semibold text-gray-800">
                                {{ $booking->end_date->format('M d, Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-blue-50 rounded-lg px-4 py-3 text-center">
                        <p class="text-gray-600 text-sm">Number of Nights</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $booking->nights }}</p>
                    </div>
                </div>

                <!-- Price Breakdown -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Price Breakdown</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700">
                            <span>{{ $booking->nights }} night{{ $booking->nights > 1 ? 's' : '' }} × ${{ number_format($booking->nightly_rate, 2) }}</span>
                            <span class="font-semibold">${{ number_format($booking->nightly_rate * $booking->nights, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between text-gray-700">
                            <span>Service Fee (10%)</span>
                            <span class="font-semibold">${{ number_format($booking->service_fee, 2) }}</span>
                        </div>
                        
                        <div class="border-t-2 border-gray-300 pt-3 flex justify-between text-xl">
                            <span class="font-bold text-gray-800">Total Price</span>
                            <span class="font-bold text-green-600">${{ number_format($booking->total_price, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Booking Status -->
                <div class="bg-yellow-50 border-l-4 border-yellow-500 px-4 py-4 mb-8 rounded">
                    <p class="text-yellow-800 font-medium">Status: <span class="capitalize">{{ $booking->status }}</span></p>
                    <p class="text-sm text-yellow-700 mt-1">The host will review your booking request and notify you of their decision.</p>
                </div>

                <!-- Confirmation Details -->
                <div class="bg-gray-50 rounded-lg px-4 py-4 mb-8">
                    <p class="text-sm text-gray-600 mb-2">
                        <span class="font-semibold">Booking Reference:</span> #{{ $booking->id }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">Confirmation sent to:</span> {{ auth()->user()->email }}
                    </p>
                </div>

                <!-- Action Button -->
                <div class="flex gap-4">
                    <a href="{{ route('home') }}" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200">
                        OK, Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
