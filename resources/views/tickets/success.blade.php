<x-public-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ticket Confirmed!
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="mb-6">
                        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-2xl font-bold text-gray-900">Payment Successful!</h3>
                        <p class="mt-2 text-gray-600">Your ticket has been confirmed.</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h4 class="font-semibold text-lg text-gray-900 mb-2">{{ $ticket->event->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $ticket->event->date->format('l, F j, Y \a\t g:i A') }}</p>
                        <p class="text-sm text-gray-500 mt-1">Email: {{ $ticket->user_email }}</p>
                        <p class="text-xs text-gray-400 mt-2 font-mono">Ticket ID: {{ $ticket->unique_code }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-3">Show this QR code at the entrance:</p>
                        <div class="inline-block p-4 bg-white border rounded-lg">
                            {!! QrCode::size(200)->generate($ticket->unique_code) !!}
                        </div>
                    </div>

                    <a href="{{ route('events.index') }}" class="inline-block bg-indigo-600 text-white py-2 px-6 rounded-md hover:bg-indigo-700 transition">
                        Browse More Events
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
