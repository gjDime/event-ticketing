<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('date')->get();

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function ticketSuccess(Ticket $ticket)
    {
        $ticket->load('event');

        return view('tickets.success', compact('ticket'));
    }
}
