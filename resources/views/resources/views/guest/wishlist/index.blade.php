@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Wishlist</h1>

    @if($wishlist->isEmpty())
        <div class="alert alert-info">
            You don’t have any saved listings yet. Browse properties and add them to your wishlist!
        </div>
    @else
        <div class="row">
            @foreach($wishlist as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    {{-- Listing Image --}}
                    <img src="{{ $item->listing->main_image_url ?? asset('images/default-property.png') }}" 
                         class="card-img-top" 
                         alt="Property image">

                    <div class="card-body d-flex flex-column">
                        {{-- Title --}}
                        <h5 class="card-title">{{ $item->listing->title }}</h5>

                        {{-- Price & Location --}}
                        <p class="card-text mb-1">
                            <strong>${{ number_format($item->listing->price_per_night, 2) }}</strong> / night
                        </p>
                        <p class="text-muted">
                            {{ $item->listing->city }}, {{ $item->listing->country }}
                        </p>

                        {{-- Action Buttons --}}
                        <div class="mt-auto">
                            <form method="POST" action="{{ route('wishlist.remove', $item) }}" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Remove</button>
                            </form>
                            <a href="{{ route('listings.show', $item->listing) }}" class="btn btn-primary btn-sm">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

