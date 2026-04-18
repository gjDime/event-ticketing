<div>
    @if($message)
        <div class="mb-4 p-3 rounded-md bg-red-50 text-red-700 text-sm">
            {{ $message }}
        </div>
    @endif

    <form wire:submit="purchase">
        <button type="submit"
                class="w-full bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition disabled:opacity-50"
                wire:loading.attr="disabled">
            <span wire:loading.remove>Buy Ticket - ${{ number_format($event->price, 2) }}</span>
            <span wire:loading>Processing...</span>
        </button>
    </form>
</div>
