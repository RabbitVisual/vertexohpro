<?php

use Illuminate\Support\Facades\Route;
use Modules\Planning\Http\Controllers\PlanningController;
use Modules\Planning\Http\Controllers\BnccHabilidadeController;
use Modules\Planning\Http\Controllers\LessonPlanController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('plannings', PlanningController::class)->names('planning');
    Route::resource('bncc-habilidades', BnccHabilidadeController::class);
    Route::resource('lesson-plans', LessonPlanController::class);
});
