@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold">Compose Mail</h1>
        <a href="{{ route('email.inbox') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Back</a>
    </div>
    <form action="{{ route('email.send') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        <!-- Recipient Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Recipient Email</label>
            <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="user@email.com">
        </div>

        <!-- Message Body -->
        <div>
            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
            <textarea id="message" name="message" rows="4" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Your Message"></textarea>
        </div>

        <!-- Attachment -->
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Upload file</label>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none :border-gray-600 placeholder-gray-400" id="file_input" type="file" name="file_input">
        </div>

        <!-- Submit Button -->
        <div class="pt-6">
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Send Email</button>
        </div>
    </form>
</div>

@include('components.alert')

@endsection
