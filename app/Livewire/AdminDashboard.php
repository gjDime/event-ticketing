<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class AdminDashboard extends Component
{
    public function render()
    {
        $events = Event::withCount([
            'tickets as paid_count' => fn ($q) => $q->where('is_paid', true),
        ])->get();

        return view('livewire.admin-dashboard', compact('events'));
    }
}
