<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Ticket;
use App\Services\MockPaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PurchaseTicket extends Component
{
    public Event $event;
    public int $quantity = 1;
    public string $message = '';

    public bool $showPayment = false;

    public string $cardNumber = '';
    public string $cardName = '';
    public string $cardExpiry = '';
    public string $cardCvv = '';

    protected function rules(): array
    {
        return [
            'quantity' => 'required|integer|min:1|max:10',
        ];
    }

    protected function paymentRules(): array
    {
        return [
            'cardNumber' => ['required', 'regex:/^\d{13,19}$/'],
            'cardName' => ['required', 'string', 'min:2', 'max:100'],
            'cardExpiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/'],
            'cardCvv' => ['required', 'regex:/^\d{3,4}$/'],
        ];
    }

    public function mount(Event $event): void
    {
        $this->event = $event;
    }

    public function proceedToPayment(): void
    {
        if (!Auth::check()) {
            $this->redirect(route('login'));
            return;
        }

        $this->validate();

        $available = $this->event->availableTickets();
        if ($available <= 0) {
            $this->message = 'Sorry, this event is sold out.';
            return;
        }

        if ($available < $this->quantity) {
            $this->message = "Only {$available} ticket(s) left.";
            return;
        }

        $this->message = '';
        $this->showPayment = true;
    }

    public function cancelPayment(): void
    {
        $this->showPayment = false;
        $this->resetValidation();
        $this->reset(['cardNumber', 'cardName', 'cardExpiry', 'cardCvv']);
    }

    public function updatedCardNumber($value): void
    {
        $this->cardNumber = preg_replace('/\s+/', '', $value);
    }

    public function pay(MockPaymentService $paymentService): void
    {
        if (!Auth::check()) {
            $this->redirect(route('login'));
            return;
        }

        $this->validate($this->paymentRules());

        $email = Auth::user()->email;
        $total = (float) $this->event->price * $this->quantity;
        $result = $paymentService->charge($email, $total);

        if (! $result['success']) {
            $this->showPayment = false;
            $this->message = 'Payment failed. Please try again.';
            return;
        }

        try {
            DB::transaction(function () use ($email) {
                $locked = Event::lockForUpdate()->findOrFail($this->event->id);
                $paidCount = $locked->tickets()->where('is_paid', true)->count();
                $available = $locked->capacity - $paidCount;

                if ($available < $this->quantity) {
                    throw new \RuntimeException(
                        $available <= 0
                            ? 'Sorry, this event just sold out.'
                            : "Only {$available} ticket(s) left."
                    );
                }

                for ($i = 0; $i < $this->quantity; $i++) {
                    Ticket::create([
                        'event_id' => $locked->id,
                        'user_email' => $email,
                        'is_paid' => true,
                    ]);
                }
            });
        } catch (\RuntimeException $e) {
            $this->showPayment = false;
            $this->message = $e->getMessage();
            return;
        }

        $this->redirect(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.purchase-ticket');
    }
}
