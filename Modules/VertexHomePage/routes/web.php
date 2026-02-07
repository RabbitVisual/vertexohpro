<?php

use Illuminate\Support\Facades\Route;
use Modules\VertexHomePage\Http\Controllers\VertexHomePageController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('vertexhomepages', VertexHomePageController::class)->names('vertexhomepage');
});
