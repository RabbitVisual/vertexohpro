<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;
use Modules\Library\Http\Controllers\LibraryResourceController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('libraries', LibraryController::class)->names('library');
    Route::resource('library-resources', LibraryResourceController::class);
});
