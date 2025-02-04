<div class="max-w-lg mx-auto rounded-lg shadow-xl p-8 bg-white">
    <!-- Phone Number Display with + sign -->
    <div class="text-5xl text-center tracking-wider text-gray-800 py-6">
        {{$phone_number}}
    </div>

    <!-- Error Alert -->
    @if(session()->has('error'))
        <div class="bg-red-500 text-white text-center py-3 px-6 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Dialpad Grid -->
    <div class="grid grid-cols-3 gap-6">
        <button wire:click="addNumber('1')" class="bg-gray-200 text-3xl px-12 py-5 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">1</button>
        <button wire:click="addNumber('2')" class="bg-gray-200 text-3xl px-12 py-5 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">2</button>
        <button wire:click="addNumber('3')" class="bg-gray-200 text-3xl px-12 py-5 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">3</button>

        <button wire:click="addNumber('4')" class="bg-gray-200 text-3xl px-12 py-5 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">4</button>
        <button wire:click="addNumber('5')" class="bg-gray-200 text-3xl px-12 py-5 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">5</button>
        <button wire:click="addNumber('6')" class="bg-gray-200 text-3xl px-12 py-5 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">6</button>

        <button wire:click="addNumber('7')" class="bg-gray-200 text-3xl px-12 py-5 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">7</button>
        <button wire:click="addNumber('8')" class="bg-gray-200 text-3xl px-12 py-5 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">8</button>
        <button wire:click="addNumber('9')" class="bg-gray-200 text-3xl px-12 py-5 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">9</button>

        <button wire:click="addNumber('0')" class="col-span-3 bg-gray-200 text-3xl px-12 py-5 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">0</button>
    </div>

    <!-- Backspace Button -->
    <button wire:click="removeLastDigit" class="w-full bg-gray-400 py-4 text-3xl text-white uppercase font-bold rounded-lg mt-6 hover:bg-gray-500 transition-all duration-300 focus:outline-none">
        Backspace
    </button>

    <!-- Call Button -->
    <button wire:click="makePhoneCall" class="w-full bg-green-500 py-4 text-3xl text-white uppercase font-bold rounded-lg mt-6 hover:bg-green-600 transition-all duration-300 focus:outline-none">
        {{$call_button_message}}
    </button>
</div>
