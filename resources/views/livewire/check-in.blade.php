<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ticket Check-In
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800">&larr; Back to Dashboard</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Scan or Enter Ticket Code</h3>

                    @if($message)
                        <div class="mb-4 p-4 rounded-md {{ $messageType === 'success' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            {{ $message }}
                        </div>
                    @endif

                    <form wire:submit="checkIn">
                        <div class="flex gap-3">
                            <input type="text"
                                   wire:model="ticketCode"
                                   placeholder="Enter ticket UUID"
                                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono"
                                   required>
                            <button type="submit"
                                    class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition disabled:opacity-50"
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove>Check In</span>
                                <span wire:loading>Checking...</span>
                            </button>
                        </div>
                        @error('ticketCode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
