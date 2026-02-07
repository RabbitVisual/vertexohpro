<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;
use Modules\Library\Http\Controllers\MaterialController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('libraries', LibraryController::class)->names('library');

    // Materials Marketplace
    Route::get('materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('materials/{id}/download-link', [MaterialController::class, 'getDownloadLink'])->name('materials.link');
});

// Signed Download Route
Route::prefix('v1')->middleware('signed')->group(function () {
    Route::get('materials/download/{material}/{user}', [MaterialController::class, 'download'])
        ->name('library.materials.download');
});
