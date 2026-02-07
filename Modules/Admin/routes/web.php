<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('admins', AdminController::class)->names('admin');
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
