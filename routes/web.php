<?php

use Illuminate\Support\Facades\Route;

Route::get('tickets', function () {
    return view('ticket-list');
});
