@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <h3>Status Updates</h3>
    @if(auth()->user()->notifications->isEmpty())
        <div class="alert alert-info">
            No notifications yet. Once your bookings are approved or declined, updates will appear here.
        </div>
    @else
        <ul class="list-group">
            @foreach(auth()->user()->notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $notification->data['listing_title'] }}</strong><br>
                        Status: 
                        <span class="badge 
                            @if($notification->data['status'] === 'approved') bg-success
                            @elseif($notification->data['status'] === 'declined') bg-danger
                            @else bg-warning @endif">
                            {{ ucfirst($notification->data['status']) }}
                        </span><br>
                        <small>
                            Check‑in: {{ \Carbon\Carbon::parse($notification->data['check_in'])->format('M d, Y') }} |
                            Check‑out: {{ \Carbon\Carbon::parse($notification->data['check_out'])->format('M d, Y') }}
                        </small>
                    </div>
                    <div class="text-end">
                        <span class="text-muted d-block mb-2">
                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                        </span>
                        @if(is_null($notification->read_at))
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary">Mark as Read</button>
                            </form>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection


