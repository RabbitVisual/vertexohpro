<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('library', LibraryController::class)->names('library');
    Route::get('library/{id}/download', [LibraryController::class, 'download'])->name('library.download');
});
