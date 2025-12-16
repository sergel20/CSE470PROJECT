@extends('layouts.app')

@section('content')
<h1>{{ $property->title }}</h1>
<p>{{ $property->description }}</p>
<p>${{ $property->price }}</p>

<form method="POST" action="{{ route('bookings.store') }}">
    @csrf
    <input type="hidden" name="host_id" value="{{ $property->host_id }}">
    <input type="hidden" name="property_id" value="{{ $property->id }}">
    <button type="submit">Book Now</button>
</form>
@endsection
