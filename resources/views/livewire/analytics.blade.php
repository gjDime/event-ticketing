<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Analytics
        </h2>
    </x-slot>

    <x-admin-nav />

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Total Revenue</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Tickets Sold</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $totalTickets }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Events</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $eventCount }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Check-In Rate</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900">{{ $checkInRate }}%</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $totalCheckedIn }} / {{ $totalTickets }} scanned</p>
                </div>
            </div>

            @if($topEvents->count() > 0 && $totalTickets > 0)
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Selling Events</h3>
                    <div class="space-y-3">
                        @foreach($topEvents as $event)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700">{{ $event->title }}</span>
                                    <span class="text-gray-500">{{ $event->paid_count }} sold &middot; ${{ number_format($event->revenue, 2) }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-indigo-500 h-2 rounded-full"
                                         style="width: {{ $event->fill_pct }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Per-Event Breakdown</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sold / Capacity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Checked In</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($events as $event)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $event->title }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $event->date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 min-w-[180px]">
                                        <div class="flex items-center gap-2">
                                            <span class="whitespace-nowrap">{{ $event->paid_count }} / {{ $event->capacity }}</span>
                                            <div class="flex-1 bg-gray-100 rounded-full h-1.5 min-w-[60px]">
                                                <div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $event->fill_pct }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-400 whitespace-nowrap">{{ $event->fill_pct }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium whitespace-nowrap">${{ number_format($event->revenue, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $event->checked_in_count }} / {{ $event->paid_count }}
                                        <span class="text-xs text-gray-400">({{ $event->checkin_pct }}%)</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No events yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
