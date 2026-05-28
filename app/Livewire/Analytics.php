<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Ticket;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Analytics extends Component
{
    public function render()
    {
        $events = Event::withCount([
            'tickets as paid_count' => fn ($q) => $q->where('is_paid', true),
            'tickets as checked_in_count' => fn ($q) => $q->where('is_paid', true)->whereNotNull('checked_in_at'),
        ])->orderBy('date')->get();

        $events->each(function (Event $event) {
            $event->revenue = $event->paid_count * (float) $event->price;
            $event->fill_pct = $event->capacity > 0
                ? min(100, round(($event->paid_count / $event->capacity) * 100))
                : 0;
            $event->checkin_pct = $event->paid_count > 0
                ? round(($event->checked_in_count / $event->paid_count) * 100)
                : 0;
        });

        $totalRevenue = $events->sum('revenue');
        $totalTickets = $events->sum('paid_count');
        $totalCheckedIn = $events->sum('checked_in_count');
        $checkInRate = $totalTickets > 0
            ? round(($totalCheckedIn / $totalTickets) * 100)
            : 0;

        $topEvents = $events->sortByDesc('paid_count')->take(5);

        return view('livewire.analytics', [
            'events' => $events,
            'totalRevenue' => $totalRevenue,
            'totalTickets' => $totalTickets,
            'totalCheckedIn' => $totalCheckedIn,
            'checkInRate' => $checkInRate,
            'eventCount' => $events->count(),
            'topEvents' => $topEvents,
        ]);
    }
}
