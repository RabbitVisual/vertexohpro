<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;
use Modules\Library\Http\Controllers\LibraryResourceController;

<<<<<<< HEAD
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

Route::middleware(['auth', 'verified'])->prefix('library')->name('library.')->group(function () {
    Route::get('/', [LibraryController::class, 'index'])->name('index'); // Marketplace
    Route::get('/my-library', [LibraryController::class, 'myLibrary'])->name('my-library'); // My Library
    Route::get('/{id}', [LibraryController::class, 'show'])->name('show'); // Details
});

// Checkout Success/Failure/Pending Routes (Generic Marketplace)
Route::middleware(['auth', 'verified'])->prefix('marketplace')->name('marketplace.')->group(function () {
    Route::view('/success', 'library::success')->name('success');
    Route::view('/failure', 'library::failure')->name('failure');
    Route::view('/pending', 'library::pending')->name('pending');
=======
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('libraries', LibraryController::class)->names('library');
    Route::resource('library-resources', LibraryResourceController::class);
});

use Modules\Library\Http\Controllers\AuthorDashboardController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/author/dashboard', [AuthorDashboardController::class, 'index'])->name('author.dashboard');
});

use Modules\Library\Http\Controllers\DownloadController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/library/download/{id}', [DownloadController::class, 'download'])->name('library.download');
    Route::get('/library/stream/{id}', [DownloadController::class, 'stream'])->name('library.stream');
>>>>>>> origin/unify-system-layout-2439224578998115045
});
