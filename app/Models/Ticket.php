<?php

namespace App\Models;

use App\Events\TicketCreated;
use App\Events\TicketUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'priority',
    ];

    protected $dispatchesEvents = [
        'created' => TicketCreated::class,
        'updated' => TicketUpdated::class,
    ];

    protected function casts()
    {
        return [
            'status' => 'boolean'
        ];
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }
}
