<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\ThemeController;
use Modules\Core\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/theme', [ThemeController::class, 'update'])->name('theme.update');
    Route::get('/command-center/search', [SearchController::class, 'search'])->name('command-center.search');
});
