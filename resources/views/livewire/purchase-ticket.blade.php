<div>
    @if($message)
        <div class="mb-4 p-3 rounded-md bg-red-50 text-red-700 text-sm">
            {{ $message }}
        </div>
    @endif

    @if($event->availableTickets() > 0)
        <form wire:submit="proceedToPayment" class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                <input type="number" wire:model.live="quantity" min="1" max="{{ max(1, min(10, $event->availableTickets())) }}"
                       class="block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition disabled:opacity-50"
                    wire:loading.attr="disabled">
                Buy {{ $quantity }} {{ $quantity == 1 ? 'Ticket' : 'Tickets' }} -
                ${{ number_format((float) $event->price * max(1, (int) $quantity), 2) }}
            </button>
        </form>
    @else
        <p class="text-red-600 font-medium">This event is sold out.</p>
    @endif

    @if($showPayment)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4" wire:click.self="cancelPayment">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Payment Details</h3>
                        <button wire:click="cancelPayment" class="text-gray-400 hover:text-gray-600" type="button" aria-label="Close">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="bg-indigo-50 rounded-md p-3 mb-4 text-sm">
                        <div class="flex justify-between text-gray-700">
                            <span>{{ $quantity }} × {{ $event->title }}</span>
                            <span class="font-semibold">${{ number_format((float) $event->price * (int) $quantity, 2) }}</span>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-2 mb-4 text-xs text-yellow-800">
                        <strong>Test mode.</strong> Use any values, e.g. <span class="font-mono">4242 4242 4242 4242</span>, exp <span class="font-mono">12/30</span>, CVV <span class="font-mono">123</span>.
                    </div>

                    <form wire:submit="pay" class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                            <input type="text" wire:model.blur="cardNumber" placeholder="1234 5678 9012 3456" inputmode="numeric"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono">
                            @error('cardNumber') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name on Card</label>
                            <input type="text" wire:model="cardName" placeholder="John Doe"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('cardName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expiry (MM/YY)</label>
                                <input type="text" wire:model="cardExpiry" placeholder="12/30" maxlength="5"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono">
                                @error('cardExpiry') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                <input type="text" wire:model="cardCvv" placeholder="123" maxlength="4" inputmode="numeric"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono">
                                @error('cardCvv') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="button" wire:click="cancelPayment"
                                    class="flex-1 px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="flex-1 px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition disabled:opacity-50"
                                    wire:loading.attr="disabled" wire:target="pay">
                                <span wire:loading.remove wire:target="pay">
                                    Pay ${{ number_format((float) $event->price * (int) $quantity, 2) }}
                                </span>
                                <span wire:loading wire:target="pay">Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
