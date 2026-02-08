<?php

use Illuminate\Support\Facades\Route;
use Modules\Support\Http\Controllers\UserTicketController;
use Modules\Support\Http\Controllers\AdminSupportController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [UserTicketController::class, 'index'])->name('support.index');
    Route::get('/{uuid}', [UserTicketController::class, 'show'])->name('support.show');

    // Admin Routes
    Route::prefix('admin/support')->name('admin.support.')->group(function () {
        Route::get('/', [AdminSupportController::class, 'index'])->name('index');
        Route::get('/{uuid}', [AdminSupportController::class, 'show'])->name('show');
    });
});
