<?php

use Illuminate\Support\Facades\Route;
use Modules\TeacherPanel\Http\Controllers\TeacherPanelController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('teacherpanel/settings', [TeacherPanelController::class, 'updateSettings'])->name('teacherpanel.update_settings');
    Route::resource('teacherpanels', TeacherPanelController::class)->names('teacherpanel');
});
