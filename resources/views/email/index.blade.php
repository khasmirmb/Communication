@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">
    <!-- Inbox Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold">Inbox</h1>
        <a href="{{ route('email.compose') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Compose</a>
    </div>

    <!-- Inbox List -->
    <div class="mt-6">
        <!-- Example Email Item -->
        <div class="border-b py-4">
            <div class="flex justify-between">
                <div class="font-semibold">Sender Email</div>
                <div class="text-sm text-gray-500">Received at: 12:30 PM</div>
            </div>
            <div class="mt-2">
                <p class="text-lg font-medium">Email Subject</p>
                <p class="text-gray-700">Email preview or message...</p>
            </div>
        </div>
    </div>
</div>

@include('components.alert')

@endsection
