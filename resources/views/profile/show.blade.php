@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="flex items-center gap-4 mb-6">
        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-profile.png') }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover">
        <div>
            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
            <div class="text-sm text-gray-600 dark:text-gray-300">{{ $propertiesCount }} properties</div>
            @if($user->bio)
                <p class="mt-2 text-gray-700 dark:text-gray-200">{{ $user->bio }}</p>
            @endif
        </div>
    </div>

    <div>
        <h2 class="text-xl font-semibold mb-3">Listings</h2>
        <div class="grid grid-cols-3 gap-4">
            @foreach($user->listings()->latest()->take(9)->get() as $listing)
                <a href="{{ route('listings.show', $listing) }}" class="block border p-3 hover:shadow">
                    <h3 class="font-medium">{{ $listing->title }}</h3>
                    <p class="text-sm text-gray-600">${{ $listing->price_per_night ?? $listing->price ?? '—' }}</p>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
