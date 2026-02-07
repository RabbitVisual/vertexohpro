<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;
use Modules\Library\Http\Controllers\MaterialController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    // My Library (Purchased Materials)
    Route::get('library', [LibraryController::class, 'index'])->name('library.index');

    // Materials Marketplace
    Route::get('materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('materials/{id}', [MaterialController::class, 'show'])->name('materials.show');
    Route::get('materials/{id}/download-link', [MaterialController::class, 'getDownloadLink'])->name('materials.link');
    Route::post('materials/{id}/rate', [MaterialController::class, 'rate'])->name('materials.rate');
    Route::put('materials/{id}', [MaterialController::class, 'update'])->name('materials.update');
});

// Signed Download Route
Route::prefix('v1')->middleware('signed')->group(function () {
    Route::get('materials/download/{material}/{user}', [MaterialController::class, 'download'])
        ->name('library.materials.download');
});
