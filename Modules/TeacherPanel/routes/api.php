<?php

use Illuminate\Support\Facades\Route;
use Modules\TeacherPanel\Http\Controllers\TeacherPanelController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('teacherpanels', TeacherPanelController::class)->names('teacherpanel');
});
