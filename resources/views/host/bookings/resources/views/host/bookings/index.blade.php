@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Booking Requests</h1>

    <table class="table table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Listing</th>
                <th>Guest</th>
                <th>Dates</th>
                <th>Guests</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $b)
            <tr>
                <td>{{ $b->listing->title }}</td>
                <td>{{ $b->guest->name }}</td>
                <td>{{ $b->check_in }} – {{ $b->check_out }}</td>
                <td>{{ $b->guests }}</td>
                <td>${{ $b->total_price }}</td>
                <td>
                    <span class="badge 
                        @if($b->status === 'pending') bg-warning 
                        @elseif($b->status === 'approved') bg-success 
                        @else bg-danger @endif">
                        {{ ucfirst($b->status) }}
                    </span>
                </td>
                <td>
                    @if($b->status === 'pending')
                        <form method="POST" action="{{ route('host.bookings.approve', $b) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-success">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('host.bookings.decline', $b) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <button class="btn btn-sm btn-danger">Decline</button>
                        </form>
                    @else
                        <em class="text-muted">No actions</em>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

