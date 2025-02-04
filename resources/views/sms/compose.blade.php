@extends('layouts.app')

@section('content')

<div class="max-w-lg mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-2xl font-semibold text-gray-700 mb-4">Send SMS</h1>

    @if(session('success'))
        <div class="mb-4 p-3 text-green-800 bg-green-100 border border-white rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 text-red-800 bg-red-100 border border-red-400 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('sms.send') }}" class="space-y-4">
        @csrf
        <div>
            <label for="to" class="block text-sm font-medium text-gray-700">Recipient Phone Number</label>
            <input type="tel" id="to" name="to" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500" required>
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
            <textarea id="message" name="message" rows="3" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500" required></textarea>
        </div>

        <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
            Send SMS
        </button>
    </form>
</div>

@endsection
