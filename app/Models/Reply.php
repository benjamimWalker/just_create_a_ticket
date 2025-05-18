<?php

namespace App\Models;

use App\Events\ReplyCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => ReplyCreated::class,
    ];

    protected $fillable = [
        'message',
        'ticket_id'
    ];
}
