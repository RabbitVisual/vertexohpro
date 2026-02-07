<?php

use Illuminate\Support\Facades\Route;
use Modules\ClassRecord\Http\Controllers\ClassRecordController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('classrecords', ClassRecordController::class)->names('classrecord');
});
