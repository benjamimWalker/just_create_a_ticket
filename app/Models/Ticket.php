<?php

namespace App\Models;

use App\Events\TicketCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'priority',
    ];

    protected $dispatchesEvents = [
        'created' => TicketCreated::class
    ];

    protected function casts()
    {
        return [
            'status' => 'boolean'
        ];
    }
}
