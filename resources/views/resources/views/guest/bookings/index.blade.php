@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">My Trips</h1>

    @if($bookings->isEmpty())
        <div class="alert alert-info">
            You have no bookings yet.
        </div>
    @else
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Property</th>
                    <th>Dates</th>
                    <th>Guests</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $b)
                <tr>
                    <td>{{ $b->listing->title }}</td>
                    <td>{{ $b->check_in->format('M d, Y') }} – {{ $b->check_out->format('M d, Y') }}</td>
                    <td>{{ $b->guests }}</td>
                    <td>${{ number_format($b->total_price, 2) }}</td>
                    <td>
                        <span class="badge 
                            @if($b->status === 'pending') bg-warning 
                            @elseif($b->status === 'approved') bg-success 
                            @elseif($b->status === 'declined') bg-danger 
                            @else bg-secondary @endif">
                            {{ ucfirst($b->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

