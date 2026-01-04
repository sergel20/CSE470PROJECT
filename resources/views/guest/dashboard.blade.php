@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <h3>Status Updates</h3>
    @if(auth()->user()->notifications->isEmpty())
        <p class="text-muted">No notifications yet.</p>
    @else
        <ul class="list-group">
            @foreach(auth()->user()->notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $notification->data['listing_title'] }} —
                    <strong>{{ ucfirst($notification->data['status']) }}</strong>
                    <span class="text-muted">
                        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                    </span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection

