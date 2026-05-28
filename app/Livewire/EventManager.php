<?php

namespace App\Livewire;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EventManager extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $description = '';
    public string $date = '';
    public string $price = '';
    public string $capacity = '';

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => $this->editingId ? 'required|date' : 'required|date|after:now',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
        ];
    }

    public function openCreate(): void
    {
        $this->ensureAdmin();
        $this->resetForm();
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $this->ensureAdmin();
        $event = Event::findOrFail($id);
        $this->editingId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->date = $event->date->format('Y-m-d\TH:i');
        $this->price = (string) $event->price;
        $this->capacity = (string) $event->capacity;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->ensureAdmin();
        $data = $this->validate();

        if ($this->editingId) {
            Event::findOrFail($this->editingId)->update($data);
        } else {
            Event::create($data);
        }

        $this->showForm = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $this->ensureAdmin();
        Event::findOrFail($id)->delete();
    }

    public function cancel(): void
    {
        $this->showForm = false;
        $this->resetValidation();
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->reset(['editingId', 'title', 'description', 'date', 'price', 'capacity']);
    }

    protected function ensureAdmin(): void
    {
        if (! Auth::check() || ! Auth::user()->is_admin) {
            abort(403);
        }
    }

    public function render()
    {
        $events = Event::withCount([
            'tickets as paid_count' => fn ($q) => $q->where('is_paid', true),
        ])->orderBy('date')->get();

        return view('livewire.event-manager', [
            'events' => $events,
            'isAdmin' => Auth::check() && Auth::user()->is_admin,
        ]);
    }
}
