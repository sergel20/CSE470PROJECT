<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Guest Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ auth()->user()->bookings->count() }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Total Bookings</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ auth()->user()->wishlist->count() }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Saved Listings</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ auth()->user()->unreadNotifications->count() }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Notifications</div>
                </div>
            </div>

            <!-- My Bookings -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">My Bookings 📅</h3>

                    @if(auth()->user()->bookings->count() > 0)
                        <div class="space-y-4">
                            @foreach(auth()->user()->bookings->sortByDesc('created_at') as $booking)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-start gap-4">
                                                @if($booking->listing->main_image)
                                                    <img src="{{ asset('storage/' . $booking->listing->main_image) }}" alt="{{ $booking->listing->title }}" class="w-24 h-24 object-cover rounded-lg">
                                                @else
                                                    <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-400">No Image</div>
                                                @endif
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $booking->listing->title }}</h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $booking->listing->city }}, {{ $booking->listing->country }}</p>
                                                    <div class="mt-2 text-sm">
                                                        <p class="text-gray-700 dark:text-gray-300">
                                                            <strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}
                                                        </p>
                                                        <p class="text-gray-700 dark:text-gray-300">
                                                            <strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
                                                        </p>
                                                        <p class="text-gray-700 dark:text-gray-300">
                                                            <strong>Guests:</strong> {{ $booking->number_of_guests }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-2">
                                            <span class="inline-block px-3 py-1 text-sm font-medium rounded-full
                                                @if($booking->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($booking->status === 'declined') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                            <p class="text-xl font-bold text-green-600 dark:text-green-400">${{ number_format($booking->total_price, 2) }}</p>
                                            
                                            @php
                                                $hasReviewed = \App\Models\Review::where('user_id', auth()->id())
                                                    ->where('listing_id', $booking->listing_id)
                                                    ->exists();
                                            @endphp
                                            @if($hasReviewed)
                                                <span class="text-sm text-green-600 dark:text-green-400">✓ Reviewed</span>
                                            @else
                                                <a href="{{ route('reviews.create', $booking) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-sm">
                                                    ⭐ Write Review
                                                </a>
                                            @endif
                                            
                                            <a href="{{ route('listings.show', $booking->listing) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm">
                                                View Listing →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📅</div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">No bookings yet</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 mb-4">Start exploring and book your first stay!</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Browse Listings
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- My Wishlist -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">My Wishlist ❤️</h3>
                        <a href="{{ route('home') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm">
                            Browse More →
                        </a>
                    </div>

                    @if(auth()->user()->wishlist->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach(auth()->user()->wishlist as $item)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition">
                                    <div class="relative">
                                        <div class="bg-gray-100 dark:bg-gray-700 h-48 flex items-center justify-center">
                                            @if($item->listing->main_image)
                                                <img src="{{ asset('storage/' . $item->listing->main_image) }}" alt="{{ $item->listing->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="text-gray-400">No Image</div>
                                            @endif
                                        </div>
                                        <!-- Remove button -->
                                        <form method="POST" action="{{ route('wishlist.remove', $item) }}" class="absolute top-2 right-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-white dark:bg-gray-800 p-2 rounded-full shadow-lg hover:bg-red-50 dark:hover:bg-red-900 transition" title="Remove from wishlist">
                                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 truncate mb-1">{{ $item->listing->title }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $item->listing->city }}, {{ $item->listing->country }}</p>
                                        <div class="flex justify-between items-center mb-3">
                                            <span class="text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($item->listing->price_per_night, 2) }}/night</span>
                                        </div>
                                        <a href="{{ route('listings.show', $item->listing) }}" class="w-full block text-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-sm">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">❤️</div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">No saved listings yet</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 mb-4">Start exploring and save your favorite listings!</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Browse Listings
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notifications -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Notifications</h3>

                    @if(auth()->user()->notifications->isEmpty())
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            No notifications yet. Once your bookings are approved or declined, updates will appear here.
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach(auth()->user()->notifications->take(5) as $notification)
                                <div class="flex items-start justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg {{ is_null($notification->read_at) ? 'bg-blue-50 dark:bg-blue-900' : '' }}">
                                    <div class="flex-1">
                                        <strong class="text-gray-900 dark:text-gray-100">{{ $notification->data['listing_title'] ?? 'Booking Update' }}</strong>
                                        <div class="mt-1">
                                            <span class="inline-block px-2 py-1 text-xs rounded
                                                @if(($notification->data['status'] ?? '') === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif(($notification->data['status'] ?? '') === 'declined') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                                {{ ucfirst($notification->data['status'] ?? 'pending') }}
                                            </span>
                                        </div>
                                        @if(isset($notification->data['check_in']) && isset($notification->data['check_out']))
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                Check-in: {{ \Carbon\Carbon::parse($notification->data['check_in'])->format('M d, Y') }} |
                                                Check-out: {{ \Carbon\Carbon::parse($notification->data['check_out'])->format('M d, Y') }}
                                            </p>
                                        @endif
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                    @if(is_null($notification->read_at))
                                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                            @csrf
                                            <button class="ml-4 px-3 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                                Mark as Read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>


