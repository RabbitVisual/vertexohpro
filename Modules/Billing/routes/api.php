<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\CheckoutController;
use Modules\Billing\Http\Controllers\WebhookController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('checkout/preference', [CheckoutController::class, 'createPreference'])->name('checkout.preference');
});

// Webhook must be public
Route::post('v1/webhook/mercadopago', [WebhookController::class, 'handle'])->name('billing.webhook.mercadopago');
