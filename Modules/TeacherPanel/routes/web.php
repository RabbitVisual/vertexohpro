<?php

use Illuminate\Support\Facades\Route;
use Modules\TeacherPanel\Http\Controllers\TeacherPanelController;
use Modules\TeacherPanel\Http\Controllers\FrequencyWidgetController;
use Modules\TeacherPanel\Http\Controllers\AgendaWidgetController;
use Modules\TeacherPanel\Http\Controllers\BnccWidgetController;
use Modules\TeacherPanel\Http\Controllers\MarketplaceTrendsWidgetController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('teacherpanel/settings', [TeacherPanelController::class, 'updateSettings'])->name('teacherpanel.update_settings');

    // Widgets
    Route::get('teacherpanel/widgets/frequency', [FrequencyWidgetController::class, 'index'])->name('teacherpanel.widgets.frequency');
    Route::get('teacherpanel/widgets/agenda', [AgendaWidgetController::class, 'index'])->name('teacherpanel.widgets.agenda');
    Route::get('teacherpanel/widgets/bncc', [BnccWidgetController::class, 'search'])->name('teacherpanel.widgets.bncc');
    Route::get('teacherpanel/widgets/marketplace-trends', [MarketplaceTrendsWidgetController::class, 'index'])->name('teacherpanel.widgets.marketplace_trends');

    Route::resource('teacherpanels', TeacherPanelController::class)->names('teacherpanel');
});
use Modules\TeacherPanel\Http\Controllers\StudentsAtRiskWidgetController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('teacherpanel/widgets/students-at-risk', [StudentsAtRiskWidgetController::class, 'index'])->name('teacherpanel.widgets.students_at_risk');
});
use Modules\TeacherPanel\Http\Controllers\NotificationsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('teacherpanel/notifications/check', [NotificationsController::class, 'check'])->name('teacherpanel.notifications.check');
});
