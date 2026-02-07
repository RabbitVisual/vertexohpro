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
});
