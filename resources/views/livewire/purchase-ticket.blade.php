<div>
    @if($message)
        <div class="mb-4 p-3 rounded-md bg-red-50 text-red-700 text-sm">
            {{ $message }}
        </div>
    @endif

    <form wire:submit="purchase">
        <div class="flex gap-3">
            <input type="email"
                   wire:model="email"
                   placeholder="Enter your email address"
                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                   required>
            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition disabled:opacity-50"
                    wire:loading.attr="disabled">
                <span wire:loading.remove>Buy Ticket - ${{ number_format($event->price, 2) }}</span>
                <span wire:loading>Processing...</span>
            </button>
        </div>
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </form>
</div>
