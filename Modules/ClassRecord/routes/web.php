<?php

use Illuminate\Support\Facades\Route;
use Modules\ClassRecord\Http\Controllers\ClassRecordController;
use Modules\ClassRecord\Http\Controllers\StudentController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('classrecords', ClassRecordController::class)->names('classrecord');

    // Explicit route for student list to match PWA cache strategy
    Route::prefix('classrecord')->group(function () {
        Route::get('students', [StudentController::class, 'index'])->name('classrecord.students.index');
    });
});
