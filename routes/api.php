<?php

use App\Http\Controllers\ReplyController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


Route::apiResource('tickets', TicketController::class)->only(['index', 'store', 'update']);
Route::apiResource('tickets.replies', ReplyController::class)->only(['index', 'store']);
