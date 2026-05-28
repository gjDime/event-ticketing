<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'date', 'price', 'capacity'];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'price' => 'decimal:2',
        ];
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function availableTickets(): int
    {
        $paid = $this->paid_count ?? $this->tickets()->where('is_paid', true)->count();

        return max(0, $this->capacity - (int) $paid);
    }
}
