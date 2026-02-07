<?php

use Illuminate\Support\Facades\Route;
use Modules\Support\Http\Controllers\SupportController;
use Modules\Support\Http\Controllers\TicketController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('supports', SupportController::class)->names('support');
    Route::resource('tickets', TicketController::class);
});
