<?php

use Illuminate\Support\Facades\Route;
use Modules\Planning\Http\Controllers\PlanningController;
use Modules\Planning\Http\Controllers\LessonPlanController;
use Modules\Planning\Http\Controllers\BnccController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('plannings', PlanningController::class)->names('planning');
    Route::apiResource('lesson-plans', LessonPlanController::class);
    Route::get('bncc/search/{code}', [BnccController::class, 'search']);
});
