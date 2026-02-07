<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\BillingController;
use Modules\Billing\Http\Controllers\SubscriptionController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('billings', BillingController::class)->names('billing');
    Route::resource('subscriptions', SubscriptionController::class);
});
