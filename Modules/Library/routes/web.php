<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;
use Modules\Library\Http\Controllers\LibraryResourceController;
use Modules\Library\Http\Controllers\AuthorDashboardController;
use Modules\Library\Http\Controllers\DownloadController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('libraries', LibraryController::class)->names('library');
    Route::resource('library-resources', LibraryResourceController::class);

    // Legacy/Alias routes if needed, otherwise just keep the resource
    Route::get('/author/dashboard', [AuthorDashboardController::class, 'index'])->name('author.dashboard');
    Route::get('/library/download/{id}', [DownloadController::class, 'download'])->name('library.download');
    Route::get('/library/stream/{id}', [DownloadController::class, 'stream'])->name('library.stream');
});
