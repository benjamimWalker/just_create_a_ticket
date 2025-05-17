<?php

use App\Models\Ticket;
use Illuminate\Support\Facades\Route;

Route::get('tickets', function () {
    return view('ticket-list');
});

Route::get('tickets/{ticket}/replies', function (Ticket $ticket) {
    return view('replies-list', ['ticket' => $ticket]);
});
