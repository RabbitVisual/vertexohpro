<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;
use Modules\Library\Http\Controllers\LibraryResourceController;
use Modules\Library\Http\Controllers\AuthorDashboardController;
use Modules\Library\Http\Controllers\DownloadController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('libraries', LibraryController::class)->names('library');
    Route::resource('library-resources', LibraryResourceController::class);

    Route::get('/author/dashboard', [AuthorDashboardController::class, 'index'])->name('author.dashboard');
    Route::get('/library/my-items', [LibraryController::class, 'myLibrary'])->name('library.my-library');
    Route::get('/library/download/{id}', [LibraryController::class, 'download'])->name('library.download');
    Route::get('/library/stream/{id}', [DownloadController::class, 'stream'])->name('library.stream');
});
