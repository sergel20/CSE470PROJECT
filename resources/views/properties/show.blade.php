{{-- resources/views/properties/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- PROPERTY HEADER --}}
    <h1 class="text-3xl font-bold mb-2">{{ $property->title }}</h1>
    <p class="text-gray-600 mb-4">{{ $property->address }}</p>

    {{-- AVERAGE RATING --}}
    <div class="flex items-center gap-2 mb-6">
        @if($property->reviews->count())
            <span class="text-yellow-500 text-lg">
                {{ number_format($property->averageRating(), 1) }} ★
            </span>
            <span class="text-gray-500">
                ({{ $property->reviews->count() }} reviews)
            </span>
        @else
            <span class="text-gray-400">No reviews yet</span>
        @endif
    </div>

    {{-- IMAGE GALLERY --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        @foreach($property->images as $image)
            <img src="{{ asset('storage/'.$image->path) }}"
                 class="rounded-lg object-cover h-60 w-full">
        @endforeach
    </div>

    {{-- PROPERTY DETAILS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- LEFT SECTION --}}
        <div class="md:col-span-2">
            <h2 class="text-xl font-semibold mb-2">Description</h2>
            <p class="text-gray-700 mb-6">{{ $property->description }}</p>

            <h2 class="text-xl font-semibold mb-2">Amenities</h2>
            <ul class="grid grid-cols-2 gap-2 mb-8">
                @foreach($property->amenities as $amenity)
                    <li class="text-gray-700">• {{ $amenity }}</li>
                @endforeach
            </ul>

            {{-- REVIEWS SECTION (FR-11) --}}
            <h2 class="text-2xl font-semibold mb-4">Guest Reviews</h2>

            @forelse($property->reviews as $review)
                <div class="border rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-1">
                        <strong>{{ $review->user->name }}</strong>
                        <span class="text-yellow-500">
                            {{ str_repeat('★', $review->rating) }}
                        </span>
                    </div>
                    <p class="text-gray-700">{{ $review->comment }}</p>
                    <small class="text-gray-400">
                        {{ $review->created_at->format('d M Y') }}
                    </small>
                </div>
            @empty
                <p class="text-gray-500">No reviews yet for this property.</p>
            @endforelse

            {{-- REVIEW FORM --}}
            @auth
                @if($canReview)
                    <div class="mt-6 border-t pt-6">
                        <h3 class="text-lg font-semibold mb-3">Leave a Review</h3>

                        <form method="POST" action="{{ route('reviews.store', $property->id) }}">
                            @csrf

                            <label class="block mb-2">Rating</label>
                            <select name="rating" required
                                class="border rounded p-2 mb-4 w-full">
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>

                            <label class="block mb-2">Comment</label>
                            <textarea name="comment"
                                class="border rounded p-2 w-full mb-4"
                                placeholder="Share your experience..."></textarea>

                            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                                Submit Review
                            </button>
                        </form>
                    </div>
                @endif
            @endauth

        </div>

        {{-- RIGHT SIDEBAR --}}
        <div class="border rounded-lg p-4 h-fit">
            <p class="text-2xl font-bold mb-2">
                ৳{{ $property->price_per_night }} / night
            </p>

            <form method="POST" action="{{ route('bookings.store', $property->id) }}">
                @csrf

                <label class="block mb-1">Check-in</label>
                <input type="date" name="check_in"
                    class="border p-2 w-full mb-3" required>

                <label class="block mb-1">Check-out</label>
                <input type="date" name="check_out"
                    class="border p-2 w-full mb-3" required>

                <label class="block mb-1">Guests</label>
                <input type="number" name="guests"
                    class="border p-2 w-full mb-4" required>

                <button class="bg-green-600 text-white w-full py-2 rounded">
                    Request Booking
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
