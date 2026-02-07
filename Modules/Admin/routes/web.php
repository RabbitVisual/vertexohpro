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

use Modules\Admin\Http\Controllers\MaterialModerationController;

Route::middleware(['auth', 'verified'])->prefix('admin/moderation')->name('admin.moderation.')->group(function () {
    Route::get('/', [MaterialModerationController::class, 'index'])->name('index');
    Route::post('/{id}/approve', [MaterialModerationController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject', [MaterialModerationController::class, 'reject'])->name('reject');
});

use Modules\Admin\Http\Controllers\PlanManagerController;

Route::middleware(['auth', 'verified'])->prefix('admin/plans')->name('admin.plans.')->group(function () {
    Route::get('/', [PlanManagerController::class, 'index'])->name('index');
    Route::get('/create', [PlanManagerController::class, 'create'])->name('create');
    Route::post('/', [PlanManagerController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PlanManagerController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PlanManagerController::class, 'update'])->name('update');
    Route::delete('/{id}', [PlanManagerController::class, 'destroy'])->name('destroy');
});

use Modules\Admin\Http\Controllers\BulkModerationController;

Route::middleware(['auth', 'verified'])->prefix('admin/moderation/bulk')->name('admin.moderation.bulk')->group(function () {
    Route::get('/', [BulkModerationController::class, 'index']);
    Route::post('/action', [BulkModerationController::class, 'bulkAction'])->name('.action');
});
