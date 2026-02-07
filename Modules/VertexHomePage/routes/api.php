<?php

use Illuminate\Support\Facades\Route;
use Modules\VertexHomePage\Http\Controllers\VertexHomePageController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('vertexhomepages', VertexHomePageController::class)->names('vertexhomepage');
});
