<?php

use Illuminate\Support\Facades\Route;
use Modules\ClassRecord\Http\Controllers\ClassRecordController;
use Modules\ClassRecord\Http\Controllers\StudentController;
use Modules\ClassRecord\Http\Controllers\GradeController;
use Modules\ClassRecord\Http\Controllers\ReportController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Resource Routes (Index, Create, Store, Show, Edit, Update, Destroy)
    Route::resource('classrecords', ClassRecordController::class);

    // Custom Routes appended to classrecords
    Route::prefix('classrecords')->name('classrecords.')->group(function () {
        Route::get('/{classId}/overview', [ClassRecordController::class, 'overview'])->name('overview');
        Route::post('/{classId}/close-cycle', [ClassRecordController::class, 'closeCycle'])->name('close-cycle');
        Route::get('/{classId}/batch-export', [ReportController::class, 'batchExport'])->name('batch-export');
    });

    // Student Routes
    Route::post('classrecords/{classId}/students', [StudentController::class, 'store'])->name('classrecords.students.store');
    Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Grade Routes
    Route::post('students/{studentId}/grades', [GradeController::class, 'store'])->name('students.grades.store');

    // Report Routes (Individual)
    Route::get('students/{studentId}/report/sign', [ReportController::class, 'showSignaturePage'])->name('classrecords.reports.sign');
    Route::post('students/{studentId}/report/generate', [ReportController::class, 'generate'])->name('classrecords.reports.generate');

    // Livewire Quick Attendance
    Route::get('/classrecords/{classId}/attendance', \Modules\ClassRecord\Livewire\QuickAttendance::class)->name('classrecords.attendance');
});
