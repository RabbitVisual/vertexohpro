<?php

use Illuminate\Support\Facades\Route;
use Modules\ClassRecord\Http\Controllers\ClassRecordController;
use Modules\ClassRecord\Http\Controllers\SchoolClassController;
use Modules\ClassRecord\Http\Controllers\StudentController;
use Modules\ClassRecord\Http\Controllers\AttendanceController;
use Modules\ClassRecord\Http\Controllers\GradeController;
use Modules\ClassRecord\Http\Controllers\ReportController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('classrecords', ClassRecordController::class)->names('classrecord');
    Route::resource('school-classes', SchoolClassController::class);
    Route::resource('students', StudentController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('grades', GradeController::class);

    // Student Routes (Jules nested style)
    Route::post('classrecords/{classId}/students', [StudentController::class, 'store'])->name('classrecords.students.store');
    Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Grade Routes (Jules style)
    Route::post('students/{studentId}/grades', [GradeController::class, 'store'])->name('students.grades.store');

    // Livewire Quick Attendance (Jules new feature)
    Route::get('/classrecords/{classId}/attendance', \Modules\ClassRecord\Livewire\QuickAttendance::class)->name('classrecords.attendance');

    // Additional ClassRecord routes (from our side)
    Route::prefix('classrecord')->group(function () {
        Route::get('students', [StudentController::class, 'index'])->name('classrecord.students.index');
        Route::get('students/import', [StudentController::class, 'import'])->name('classrecord.students.import');
        Route::post('students/import', [StudentController::class, 'processImport'])->name('classrecord.students.process-import');

        Route::get('{classId}/overview', [ClassRecordController::class, 'overview'])->name('class-record.overview');
        Route::post('{classId}/close-cycle', [ClassRecordController::class, 'closeCycle'])->name('class-record.close-cycle');
        Route::get('{classId}/batch-export', [ReportController::class, 'batchExport'])->name('class-record.batch-export');
    });

    // Report Routes
    Route::get('students/{studentId}/report/sign', [ReportController::class, 'showSignaturePage'])->name('classrecords.reports.sign');
    Route::post('students/{studentId}/report/generate', [ReportController::class, 'generate'])->name('classrecords.reports.generate');
});
