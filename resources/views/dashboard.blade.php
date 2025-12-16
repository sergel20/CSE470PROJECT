<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('listings.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                + Create Listing
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-indigo-600">{{ auth()->user()->listings->count() }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Total Listings</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-green-600">{{ auth()->user()->listings->where('status', 'published')->count() }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Published Listings</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-yellow-600">{{ auth()->user()->listings->where('status', 'draft')->count() }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Draft Listings</div>
                </div>
            </div>

            <!-- My Listings -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">My Listings</h3>

                    @if(auth()->user()->listings->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach(auth()->user()->listings as $listing)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition">
                                    <div class="bg-gray-100 dark:bg-gray-700 h-48 flex items-center justify-center">
                                        <div class="text-gray-400">No Image</div>
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $listing->title }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $listing->address }}, {{ $listing->city }}</p>
                                        <div class="flex justify-between items-center mb-3">
                                            <span class="text-lg font-bold text-green-600">${{ number_format($listing->price_per_night, 2) }}/night</span>
                                            <span class="text-xs px-2 py-1 rounded-full capitalize
                                                @if($listing->status === 'draft') bg-yellow-100 text-yellow-800
                                                @elseif($listing->status === 'published') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($listing->status) }}
                                            </span>
                                        </div>
                                        <div class="flex gap-2">
                                            <a href="{{ route('listings.show', $listing) }}" class="flex-1 text-center px-3 py-2 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 rounded hover:bg-indigo-200 dark:hover:bg-indigo-800 transition text-sm">
                                                View
                                            </a>
                                            <a href="{{ route('listings.edit', $listing) }}" class="flex-1 text-center px-3 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded hover:bg-blue-200 dark:hover:bg-blue-800 transition text-sm">
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">📋</div>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">You haven't created any listings yet.</p>
                            <a href="{{ route('listings.create') }}" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Create Your First Listing
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notifications -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Notifications</h3>

                    @if(auth()->user()->notifications->count() > 0)
                        <ul class="space-y-3">
                            @foreach(auth()->user()->notifications as $notification)
                                <li class="border-b pb-2 @if(is_null($notification->read_at)) font-bold @endif">
                                    {{ $notification->data['message'] }}
                                    <span class="text-sm text-gray-500">
                                        (Booking ID: {{ $notification->data['booking_id'] }})
                                    </span>
                                    @if(is_null($notification->read_at))
                                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="ml-2 text-blue-600 text-xs">Mark as read</button>
                                        </form>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">No notifications yet.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
