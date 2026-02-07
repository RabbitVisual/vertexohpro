<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;
use Modules\Library\Http\Controllers\LibraryResourceController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('libraries', LibraryController::class)->names('library');
    Route::resource('library-resources', LibraryResourceController::class);
});

use Modules\Library\Http\Controllers\AuthorDashboardController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/author/dashboard', [AuthorDashboardController::class, 'index'])->name('author.dashboard');
});

use Modules\Library\Http\Controllers\DownloadController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/library/download/{id}', [DownloadController::class, 'download'])->name('library.download');
    Route::get('/library/stream/{id}', [DownloadController::class, 'stream'])->name('library.stream');
});
