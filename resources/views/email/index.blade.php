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
        @if(isset($emailDetails) && count($emailDetails) > 0)
            @foreach ($emailDetails as $email)
                <div class="border-b py-4">
                    <div class="flex justify-between">
                        <div class="font-semibold">{{ $email['sender'] }}</div>
                        <div class="text-sm text-gray-500">{{ $email['date'] }}</div>
                    </div>
                    <div class="mt-2">
                        <p class="text-lg font-medium">{{ $email['subject'] }}</p>

                        <!-- Render snippet as preview -->
                        @if($email['snippet'])
                            <p class="text-gray-500">{{ $email['snippet'] }}</p>
                        @endif

                        <!-- Render the plain text content if available -->
                        @if($email['plain_text_content'])
                            <p class="text-gray-700">{{ $email['plain_text_content'] }}</p>
                        @endif

                        <!-- Render the email content as HTML -->
                        @if($email['content'])
                            <p class="text-gray-700">{!! $email['content'] !!}</p>
                        @endif

                        <!-- Render attachments -->
                        @if(isset($email['attachments']) && count($email['attachments']) > 0)
                            <div class="mt-4">
                                <p class="font-semibold">Attachments:</p>
                                <ul class="list-disc pl-5">
                                    @foreach ($email['attachments'] as $attachment)
                                        <li>
                                            <a href="{{ route('download.attachment', ['path' => basename($attachment['path'])]) }}" class="text-blue-500 hover:underline">
                                                {{ $attachment['filename'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <p>No emails found or you're not authorized yet.</p>
        @endif
    </div>
</div>

@include('components.alert')

@endsection
