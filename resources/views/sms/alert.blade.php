<!-- Success Alert -->
@if (session('success'))
    <div id="successAlert" class="fixed top-4 left-1/2 transform -translate-x-1/2 w-80 flex items-center p-3 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-md z-50" role="alert">
        <svg class="shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z"/>
        </svg>
        <div class="flex-1">
            <span class="font-medium">Success!</span> {{ session('success') }}
        </div>
    </div>
@endif

<!-- Error Alert -->
@if ($errors->any())
    <div id="errorAlert" class="fixed top-4 left-1/2 transform -translate-x-1/2 w-80 flex items-center p-3 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-md z-50" role="alert">
        <svg class="shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <div class="flex-1">
            <span class="font-medium">Error!</span> {{ $errors->first() }}
        </div>
    </div>
@endif

<script>
    setTimeout(() => {
        document.getElementById('successAlert')?.remove();
        document.getElementById('errorAlert')?.remove();
    }, 4000);
</script>
