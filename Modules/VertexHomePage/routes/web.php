<?php

use Illuminate\Support\Facades\Route;
use Modules\VertexHomePage\Http\Controllers\VertexHomePageController;

Route::get('/terms', [VertexHomePageController::class, 'terms'])->name('terms');
Route::get('/privacy', [VertexHomePageController::class, 'privacy'])->name('privacy');
Route::get('/contact', [VertexHomePageController::class, 'contact'])->name('contact');
Route::get('/about', [VertexHomePageController::class, 'about'])->name('about');
Route::get('/faq', [VertexHomePageController::class, 'faq'])->name('faq');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('vertexhomepages', VertexHomePageController::class)->names('vertexhomepage');
});
