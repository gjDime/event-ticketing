<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class VisitorManagement extends Component
{
    public Event $event;

    public function mount(Event $event): void
    {
        $this->event = $event;
    }

    public function render()
    {
        $tickets = $this->event->tickets()->where('is_paid', true)->latest()->get();

        return view('livewire.visitor-management', compact('tickets'));
    }
}
