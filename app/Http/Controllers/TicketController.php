<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Ticket::latest()->get());
    }

    public function store(TicketRequest $request): JsonResponse
    {
        return response()->json(Ticket::create($request->validated()), Response::HTTP_CREATED);
    }

    public function update(Ticket $ticket, UpdateTicketStatusRequest $request): JsonResponse
    {
        return response()->json($ticket->update(['status' => $request->status]));
    }
}
