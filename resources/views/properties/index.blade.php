@extends('layouts.app')

@section('content')
<h1>Property Listings</h1>

<form method="GET" action="{{ route('properties.index') }}">
    <select name="sort" onchange="this.form.submit()">
        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
        <option value="price" {{ $sort === 'price' ? 'selected' : '' }}>Price</option>
        <option value="rating" {{ $sort === 'rating' ? 'selected' : '' }}>Rating</option>
    </select>
</form>

<div class="grid grid-cols-3 gap-4">
    @foreach($properties as $property)
        <div class="border p-4">
            <h2>{{ $property->title }}</h2>
            <p>${{ $property->price }}</p>
            <p>Rating: {{ $property->rating }}</p>
        </div>
    @endforeach
</div>

{{ $properties->links() }}
@endsection
