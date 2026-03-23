<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Ticket extends Model
{
    protected $fillable = ['event_id', 'user_email', 'is_paid', 'checked_in_at'];

    protected function casts(): array
    {
        return [
            'is_paid' => 'boolean',
            'checked_in_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Ticket $ticket) {
            $ticket->unique_code = (string) Str::uuid();
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
