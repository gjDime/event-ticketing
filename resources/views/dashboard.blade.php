<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <section>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">My Tickets</h3>

                @if($ticketsByEvent->count() > 0)
                    <div class="space-y-6">
                        @foreach($ticketsByEvent as $eventId => $tickets)
                            @php $event = $tickets->first()->event; @endphp
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $event->title }}</h4>
                                            <p class="text-sm text-gray-500">{{ $event->date->format('M d, Y \a\t g:i A') }}</p>
                                        </div>
                                        @if($event->date->isPast())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Past</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">Upcoming</span>
                                        @endif
                                    </div>

                                    <p class="text-gray-600 mb-4">
                                        {{ $tickets->count() }} {{ $tickets->count() === 1 ? 'ticket' : 'tickets' }}
                                    </p>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($tickets as $ticket)
                                            <div class="border rounded-lg p-3 text-center bg-gray-50">
                                                <div class="inline-block p-2 bg-white rounded">
                                                    {!! QrCode::size(140)->generate($ticket->unique_code) !!}
                                                </div>
                                                <p class="text-xs text-gray-400 mt-2 font-mono break-all">{{ $ticket->unique_code }}</p>
                                                @if($ticket->checked_in_at)
                                                    <span class="mt-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                        Checked In
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <a href="{{ route('events.show', $event) }}"
                                       class="mt-4 block w-full text-center bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">
                                        View Event
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                        You haven't purchased any tickets yet.
                        <a href="{{ route('events.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Browse events</a>
                    </div>
                @endif
            </section>

            @if($upcomingEvents->count() > 0)
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Upcoming Events</h3>
                        <a href="{{ route('events.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All &rarr;</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($upcomingEvents as $event)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $event->title }}</h4>
                                    <p class="text-sm text-gray-500 mb-3">{{ $event->date->format('M d, Y \a\t g:i A') }}</p>
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $event->description }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-indigo-600">${{ number_format($event->price, 2) }}</span>
                                        <span class="text-sm text-gray-500">{{ $event->availableTickets() }} tickets left</span>
                                    </div>
                                    <a href="{{ route('events.show', $event) }}"
                                       class="mt-4 block w-full text-center bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

        </div>
    </div>
</x-app-layout>
