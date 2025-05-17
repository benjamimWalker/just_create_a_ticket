<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Models\Reply;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;

class ReplyController extends Controller
{
    public function index(Ticket $ticket): JsonResponse
    {
        return response()->json($ticket->replies()->oldest()->get());
    }

    public function store(ReplyRequest $request): JsonResponse
    {
        return response()->json(Reply::create($request->validated()));
    }
}
