<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\HealthController;
use Modules\Admin\Http\Controllers\AuditController;
use Modules\Admin\Http\Middleware\EnsureUserIsAdmin;

Route::middleware(['auth', 'verified', EnsureUserIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Health
    Route::get('/health', [HealthController::class, 'index'])->name('health');
    Route::post('/health/fix', [HealthController::class, 'fix'])->name('health.fix');

    // Audit
    Route::get('/audit', [AuditController::class, 'index'])->name('audit');
    Route::get('/audit/export', [AuditController::class, 'export'])->name('audit.export');
});
