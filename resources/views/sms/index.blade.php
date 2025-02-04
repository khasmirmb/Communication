@extends('layouts.app')

@section('content')

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Inbox</h1>
            <button data-modal-target="composeModal" data-modal-toggle="composeModal"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">
                Compose
            </button>
        </div>

        @if($messages->count())
            <div class="space-y-4">
                @foreach($messages as $message)
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:bg-gray-100 cursor-pointer"
                        onclick="openMessageModal('{{ $message->sender }}', '{{ $message->created_at->format('F d, Y h:i A') }}', `{{ addslashes($message->message) }}`)">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="font-medium text-gray-800">{{ $message->sender }}</h2>
                                <p class="text-sm text-gray-600">{{ $message->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="text-sm text-gray-500">{{ $message->status }}</span>
                        </div>

                        <p class="mt-2 text-gray-700">{{ Str::limit($message->body, 100) }}...</p>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $messages->links() }}
            </div>
        @else
            <p class="text-gray-500">No messages in your inbox.</p>
        @endif
    </div>

    <!-- Message Modal -->
    <div id="messageModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-5">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-lg font-semibold text-gray-900">Message Details</h3>
                <button onclick="closeMessageModal()" class="text-gray-400 hover:text-gray-900">
                    ✖
                </button>
            </div>
            <div class="mt-4">
                <p class="text-sm text-gray-600"><strong>From:</strong> <span id="modalSender"></span></p>
                <p class="text-sm text-gray-600"><strong>Sent:</strong> <span id="modalTime"></span></p>
                <p class="mt-4 text-gray-800" id="modalMessage"></p>
            </div>
        </div>
    </div>

    <script>
        function openMessageModal(sender, time, message) {
            document.getElementById('modalSender').innerText = sender;
            document.getElementById('modalTime').innerText = time;
            document.getElementById('modalMessage').innerText = message;
            document.getElementById('messageModal').classList.remove('hidden');
        }

        function closeMessageModal() {
            document.getElementById('messageModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('messageModal').addEventListener('click', function(event) {
            if (event.target === this) closeMessageModal();
        });
    </script>


    @include('sms.modal')

    @include('sms.alert')

@endsection
