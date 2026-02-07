<?php

use Illuminate\Support\Facades\Route;
use Modules\ClassRecord\Http\Controllers\ClassRecordController;
use Modules\ClassRecord\Http\Controllers\ReportController;

Route::middleware(['auth', 'verified'])->prefix('class-record')->name('class-record.')->group(function () {
    Route::get('/', [ClassRecordController::class, 'index'])->name('index');
    Route::get('/{classId}/overview', [ClassRecordController::class, 'overview'])->name('overview');
    Route::post('/{classId}/close-cycle', [ClassRecordController::class, 'closeCycle'])->name('close-cycle');
    Route::get('/{classId}/batch-export', [ReportController::class, 'batchExport'])->name('batch-export');
});
