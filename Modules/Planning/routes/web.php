<?php

use Illuminate\Support\Facades\Route;
use Modules\Planning\Http\Controllers\PlanningController;
use Modules\Planning\Http\Controllers\LessonPlanController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('plannings', PlanningController::class)->names('planning');

    // Lesson Plans Web Routes
    Route::get('lesson-plans/{id}/export', [LessonPlanController::class, 'export'])->name('lesson-plans.export');
    Route::post('lesson-plans/{id}/duplicate', [LessonPlanController::class, 'duplicate'])->name('lesson-plans.duplicate');
    Route::resource('lesson-plans', LessonPlanController::class)->names('lesson-plans');
});
