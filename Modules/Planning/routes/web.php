<?php

use Illuminate\Support\Facades\Route;
use Modules\Planning\Http\Controllers\PlanningController;
use Modules\Planning\Http\Controllers\BnccController;
use Modules\Planning\Http\Controllers\LessonPlanController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('plannings', PlanningController::class)->names('planning');

    // BNCC Routes
    Route::get('bncc/search', [BnccController::class, 'search'])->name('bncc.search');
    Route::resource('bncc', BnccController::class)->names('bncc');

    // Lesson Plans Web Routes
    Route::get('lesson-plans/{id}/export', [LessonPlanController::class, 'export'])->name('planning.lesson-plans.export');
    Route::post('lesson-plans/{id}/duplicate', [LessonPlanController::class, 'duplicate'])->name('planning.lesson-plans.duplicate');
    Route::post('lesson-plans/export-batch', [LessonPlanController::class, 'exportBatch'])->name('planning.lesson-plans.export-batch');
    Route::post('lesson-plans/{id}/launch', [LessonPlanController::class, 'launchClass'])->name('planning.lesson-plans.launch');
    Route::resource('lesson-plans', LessonPlanController::class)->names('planning.lesson-plans');
});
