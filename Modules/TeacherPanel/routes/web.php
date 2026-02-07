<?php

use Illuminate\Support\Facades\Route;
use Modules\TeacherPanel\Http\Controllers\TeacherPanelController;
use Modules\TeacherPanel\Http\Controllers\FrequencyWidgetController;
use Modules\TeacherPanel\Http\Controllers\AgendaWidgetController;
use Modules\TeacherPanel\Http\Controllers\BnccWidgetController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('teacherpanel/settings', [TeacherPanelController::class, 'updateSettings'])->name('teacherpanel.update_settings');

    // Widgets
    Route::get('teacherpanel/widgets/frequency', [FrequencyWidgetController::class, 'index'])->name('teacherpanel.widgets.frequency');
    Route::get('teacherpanel/widgets/agenda', [AgendaWidgetController::class, 'index'])->name('teacherpanel.widgets.agenda');
    Route::get('teacherpanel/widgets/bncc', [BnccWidgetController::class, 'search'])->name('teacherpanel.widgets.bncc');

    Route::resource('teacherpanels', TeacherPanelController::class)->names('teacherpanel');
});
