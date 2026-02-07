<?php

use Illuminate\Support\Facades\Route;
use Modules\ClassRecord\Http\Controllers\ClassRecordController;
use Modules\ClassRecord\Http\Controllers\StudentController;
use Modules\ClassRecord\Http\Controllers\GradeController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('classrecords', ClassRecordController::class);

    // Student Routes
    Route::post('classrecords/{classId}/students', [StudentController::class, 'store'])->name('classrecords.students.store');
    Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Grade Routes
    Route::post('students/{studentId}/grades', [GradeController::class, 'store'])->name('students.grades.store');

    // Livewire Quick Attendance
    Route::get('/classrecords/{classId}/attendance', \Modules\ClassRecord\Livewire\QuickAttendance::class)->name('classrecords.attendance');
});

    // Report Routes
    Route::get('students/{studentId}/report/sign', [\Modules\ClassRecord\Http\Controllers\ReportController::class, 'showSignaturePage'])->name('classrecords.reports.sign');
    Route::post('students/{studentId}/report/generate', [\Modules\ClassRecord\Http\Controllers\ReportController::class, 'generate'])->name('classrecords.reports.generate');
