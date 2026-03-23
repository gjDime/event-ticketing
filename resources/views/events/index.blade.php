<x-public-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upcoming Events
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $event->title }}</h3>
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
                @empty
                    <div class="col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                        No events available at the moment.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-public-layout>
