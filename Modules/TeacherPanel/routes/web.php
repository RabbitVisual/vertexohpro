<?php

use Illuminate\Support\Facades\Route;
use Modules\TeacherPanel\Http\Controllers\TeacherPanelController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('teacherpanels', TeacherPanelController::class)->names('teacherpanel');
});
