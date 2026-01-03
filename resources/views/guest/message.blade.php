@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="bg-white dark:bg-gray-800 shadow rounded p-6">
        <h2 class="text-lg font-medium mb-2">Notice</h2>
        <p>{{ $message }}</p>
    </div>
</div>
@endsection
