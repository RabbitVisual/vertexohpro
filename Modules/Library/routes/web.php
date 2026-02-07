<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;
use Modules\Library\Http\Controllers\AuthorController;

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
    Route::get('/author', [AuthorController::class, 'dashboard'])->name('author.dashboard'); // Author Dashboard
    Route::post('/author/withdraw', [AuthorController::class, 'requestWithdrawal'])->name('author.withdraw'); // Withdrawal Request
    Route::get('/{id}', [LibraryController::class, 'show'])->name('show'); // Details
});

// Checkout Success/Failure/Pending Routes (Generic Marketplace)
Route::middleware(['auth', 'verified'])->prefix('marketplace')->name('marketplace.')->group(function () {
    Route::view('/success', 'library::success')->name('success');
    Route::view('/failure', 'library::failure')->name('failure');
    Route::view('/pending', 'library::pending')->name('pending');
use Modules\Library\Http\Controllers\LibraryResourceController;
use Modules\Library\Http\Controllers\AuthorDashboardController;
use Modules\Library\Http\Controllers\DownloadController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('libraries', LibraryController::class)->names('library');
    Route::resource('library-resources', LibraryResourceController::class);

    // Legacy/Alias routes if needed, otherwise just keep the resource
    Route::get('/author/dashboard', [AuthorDashboardController::class, 'index'])->name('author.dashboard');
    Route::get('/library/download/{id}', [DownloadController::class, 'download'])->name('library.download');
    Route::get('/library/stream/{id}', [DownloadController::class, 'stream'])->name('library.stream');
});
