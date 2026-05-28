<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount([
            'tickets as paid_count' => fn ($q) => $q->where('is_paid', true),
        ])->orderBy('date')->get();

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->loadCount([
            'tickets as paid_count' => fn ($q) => $q->where('is_paid', true),
        ]);

        $userTicketCount = 0;
        if (Auth::check()) {
            $userTicketCount = Ticket::where('event_id', $event->id)
                ->where('user_email', Auth::user()->email)
                ->where('is_paid', true)
                ->count();
        }

        return view('events.show', compact('event', 'userTicketCount'));
    }

    public function ticketSuccess(Ticket $ticket)
    {
        $ticket->load('event');

        return view('tickets.success', compact('ticket'));
    }
}
