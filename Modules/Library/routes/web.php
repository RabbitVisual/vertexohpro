<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;
use Modules\Library\Http\Controllers\LibraryResourceController;

Route::middleware(['auth', 'verified'])->prefix('library')->name('library.')->group(function () {
    Route::get('/', [LibraryController::class, 'index'])->name('index'); // Marketplace
    Route::get('/my-library', [LibraryController::class, 'myLibrary'])->name('my-library'); // My Library
    Route::get('/{id}', [LibraryController::class, 'show'])->name('show'); // Details
});

// Checkout Success/Failure/Pending Routes (Generic Marketplace)
Route::middleware(['auth', 'verified'])->prefix('marketplace')->name('marketplace.')->group(function () {
    Route::view('/success', 'library::success')->name('success');
    Route::view('/failure', 'library::failure')->name('failure');
    Route::view('/pending', 'library::pending')->name('pending');
});
