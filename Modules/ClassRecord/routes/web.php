<?php

use Illuminate\Support\Facades\Route;
use Modules\ClassRecord\Http\Controllers\ClassRecordController;
use Modules\ClassRecord\Http\Controllers\SchoolClassController;
use Modules\ClassRecord\Http\Controllers\StudentController;
use Modules\ClassRecord\Http\Controllers\AttendanceController;
use Modules\ClassRecord\Http\Controllers\GradeController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('classrecords', ClassRecordController::class)->names('classrecord');
    Route::resource('school-classes', SchoolClassController::class);
    Route::resource('students', StudentController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('grades', GradeController::class);

    // Explicit routes for student list to match PWA cache strategy
    Route::prefix('classrecord')->group(function () {
        Route::get('students', [StudentController::class, 'index'])->name('classrecord.students.index');
        Route::get('students/import', [StudentController::class, 'import'])->name('classrecord.students.import');
        Route::post('students/import', [StudentController::class, 'processImport'])->name('classrecord.students.process-import');

        Route::get('classes/{id}/export', [SchoolClassController::class, 'export'])->name('classrecord.classes.export');
        Route::get('classes/{id}', [SchoolClassController::class, 'show'])->name('classrecord.classes.show');
        Route::get('classes', [SchoolClassController::class, 'index'])->name('classrecord.classes.index');
    });
});
