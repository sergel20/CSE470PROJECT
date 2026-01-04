@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Listings</h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Price/night</th>
                <th>Status</th>
                <th>Toggle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listings as $listing)
            <tr>
                <td>{{ $listing->title }}</td>
                <td>${{ $listing->price_per_night }}</td>
                <td>
                    <span class="badge {{ $listing->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $listing->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <form method="POST" action="{{ route('host.listings.toggle', $listing) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm {{ $listing->is_active ? 'btn-danger' : 'btn-success' }}">
                            {{ $listing->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
