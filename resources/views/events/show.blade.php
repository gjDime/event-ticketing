<x-public-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-1">{{ $event->date->format('l, F j, Y \a\t g:i A') }}</p>
                        <p class="text-2xl font-bold text-indigo-600 mb-4">${{ number_format($event->price, 2) }}</p>
                        <p class="text-gray-700 leading-relaxed">{{ $event->description }}</p>
                    </div>

                    @if($userTicket)
                        <div class="border-t pt-6 text-center">
                            <h3 class="text-lg font-semibold mb-4">Your Ticket</h3>
                            <div class="inline-block p-4 bg-white border rounded-lg">
                                {!! QrCode::size(200)->generate($userTicket->unique_code) !!}
                            </div>
                            <p class="text-sm text-gray-500 mt-3">Show this QR code at the entrance</p>
                            <p class="text-xs text-gray-400 mt-1 font-mono">{{ $userTicket->unique_code }}</p>
                        </div>
                    @else
                        <div class="border-t pt-4 mb-6">
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>Capacity: {{ $event->capacity }}</span>
                                <span class="font-semibold {{ $event->availableTickets() > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $event->availableTickets() > 0 ? $event->availableTickets() . ' tickets available' : 'Sold Out' }}
                                </span>
                            </div>
                        </div>

                        @if($event->availableTickets() > 0)
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-semibold mb-4">Purchase Ticket</h3>
                                @auth
                                    <livewire:purchase-ticket :event="$event" />
                                @else
                                    <p class="text-gray-600 mb-3">You need to be logged in to purchase a ticket.</p>
                                    <a href="{{ route('login') }}"
                                       class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                                        Login to Buy Ticket
                                    </a>
                                @endauth
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('events.index') }}" class="text-indigo-600 hover:text-indigo-800">&larr; Back to Events</a>
            </div>
        </div>
    </div>
</x-public-layout>
