<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if($isAdmin)
            <div class="mb-6 flex justify-end">
                <button wire:click="openCreate" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                    + Create Event
                </button>
            </div>
        @endif

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
                        @if($isAdmin)
                            <div class="mt-2 flex gap-2">
                                <button wire:click="openEdit({{ $event->id }})"
                                        class="flex-1 bg-yellow-500 text-white py-2 px-3 rounded-md hover:bg-yellow-600 transition text-sm">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $event->id }})"
                                        wire:confirm="Delete this event? All its tickets will be removed too."
                                        class="flex-1 bg-red-600 text-white py-2 px-3 rounded-md hover:bg-red-700 transition text-sm">
                                    Delete
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center text-gray-500">
                    No events available at the moment.
                </div>
            @endforelse
        </div>
    </div>

    @if($showForm)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4" wire:click.self="cancel">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    {{ $editingId ? 'Edit Event' : 'Create Event' }}
                </h3>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" wire:model="title"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea wire:model="description" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date &amp; Time</label>
                        <input type="datetime-local" wire:model="date"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Price ($)</label>
                            <input type="number" step="0.01" min="0" wire:model="price"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Capacity</label>
                            <input type="number" min="1" wire:model="capacity"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('capacity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-4 border-t">
                        <button type="button" wire:click="cancel"
                                class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition">
                            {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
