<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('date')->get();

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $userTicket = null;
        if (Auth::check()) {
            $userTicket = Ticket::where('event_id', $event->id)
                ->where('user_email', Auth::user()->email)
                ->where('is_paid', true)
                ->first();
        }

        return view('events.show', compact('event', 'userTicket'));
    }

    public function ticketSuccess(Ticket $ticket)
    {
        $ticket->load('event');

        return view('tickets.success', compact('ticket'));
    }
}
