<?php

namespace App\Events;

use App\Models\Reply;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class ReplyCreated implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(public readonly Reply $reply)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('tickets.' . $this->reply->ticket_id);
    }
}
