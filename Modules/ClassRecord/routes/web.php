<?php

use Illuminate\Support\Facades\Route;
use Modules\ClassRecord\Http\Controllers\ClassRecordController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('classrecords', ClassRecordController::class)->names('classrecord');
});

use Modules\ClassRecord\Http\Controllers\InsightsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('classrecord/{classId}/insights/difficulty-map', [InsightsController::class, 'difficultyMap'])->name('classrecord.insights.difficulty_map');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('classrecord/students/{student}/email-report', [ClassRecordController::class, 'emailReportCard'])->name('classrecord.email_report');
});
