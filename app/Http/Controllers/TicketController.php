<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Ticket::all());
    }

    public function create(TicketRequest $request): JsonResponse
    {
        return response()->json(Ticket::create($request->validated()), Response::HTTP_CREATED);
    }
}
