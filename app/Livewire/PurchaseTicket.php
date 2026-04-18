<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Ticket;
use App\Services\MockPaymentService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PurchaseTicket extends Component
{
    public Event $event;
    public string $message = '';
    public bool $success = false;

    public function mount(Event $event): void
    {
        $this->event = $event;
    }

    public function purchase(MockPaymentService $paymentService): void
    {
        if (!Auth::check()) {
            $this->redirect(route('login'));
            return;
        }

        if ($this->event->availableTickets() <= 0) {
            $this->message = 'Sorry, this event is sold out.';
            return;
        }

        $email = Auth::user()->email;
        $result = $paymentService->charge($email, (float) $this->event->price);

        if ($result['success']) {
            $ticket = Ticket::create([
                'event_id' => $this->event->id,
                'user_email' => $email,
                'is_paid' => true,
            ]);

            $this->redirect(route('tickets.success', $ticket));
        }
    }

    public function render()
    {
        return view('livewire.purchase-ticket');
    }
}
