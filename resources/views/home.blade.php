@extends('layouts.app')

@section('content')
<h1>Featured Properties</h1>
<div class="grid grid-cols-3 gap-4">
    @foreach($properties as $property)
        <div class="border p-4">
            <img src="{{ asset('storage/' . $property->photo) }}" alt="{{ $property->title }}">
            <h2>{{ $property->title }}</h2>
            <p>${{ $property->price }}</p>
            <p>Rating: {{ $property->rating }}</p>
        </div>
    @endforeach
</div>
@endsection
