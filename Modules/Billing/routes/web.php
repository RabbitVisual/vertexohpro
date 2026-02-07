<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\BillingController;
use Modules\Billing\Http\Controllers\CouponController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('billing', BillingController::class)->names('billing');
    Route::resource('coupons', CouponController::class)->names('coupons');
});
