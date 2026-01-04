<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Write a Review') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Listing Info -->
                    <div class="mb-6 flex gap-4">
                        @if($booking->listing->main_image)
                            <img src="{{ asset('storage/' . $booking->listing->main_image) }}" alt="{{ $booking->listing->title }}" class="w-32 h-32 object-cover rounded-lg">
                        @else
                            <div class="w-32 h-32 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $booking->listing->title }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $booking->listing->city }}, {{ $booking->listing->country }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                Your stay: {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Review Form -->
                    <form method="POST" action="{{ route('reviews.store', $booking) }}">
                        @csrf

                        <!-- Rating -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Rating <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                        <div class="text-4xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-300 transition">
                                            ⭐
                                        </div>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Your Review
                            </label>
                            <textarea 
                                id="comment" 
                                name="comment" 
                                rows="5" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="Share your experience with this listing..."
                            >{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3">
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Submit Review
                            </button>
                            <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
