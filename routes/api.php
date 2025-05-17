<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


Route::apiResource('tickets', TicketController::class)->only(['index', 'store']);


Route::prefix('replies')->group(function () {
});
