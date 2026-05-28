<?php

namespace App\Livewire;

use App\Models\Ticket;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CheckIn extends Component
{
    public string $ticketCode = '';
    public string $message = '';
    public string $messageType = '';

    public function checkIn(): void
    {
        $this->validate([
            'ticketCode' => 'required|uuid',
        ]);

        $ticket = Ticket::where('unique_code', $this->ticketCode)->first();

        if (! $ticket) {
            $this->message = 'Ticket not found.';
            $this->messageType = 'error';
            return;
        }

        if (! $ticket->is_paid) {
            $this->message = 'This ticket has not been paid for.';
            $this->messageType = 'error';
            return;
        }

        if ($ticket->checked_in_at) {
            $this->message = 'This ticket has already been checked in at ' . $ticket->checked_in_at->format('Y-m-d H:i:s') . '.';
            $this->messageType = 'error';
            return;
        }

        if ($ticket->event->date->lt(now()->startOfDay())) {
            $this->message = 'This event has already ended (' . $ticket->event->date->format('M d, Y') . ').';
            $this->messageType = 'error';
            return;
        }

        $ticket->update(['checked_in_at' => now()]);

        $this->message = 'Successfully checked in! Event: ' . $ticket->event->title . ' | Email: ' . $ticket->user_email;
        $this->messageType = 'success';
        $this->ticketCode = '';
    }

    public function render()
    {
        return view('livewire.check-in');
    }
}
