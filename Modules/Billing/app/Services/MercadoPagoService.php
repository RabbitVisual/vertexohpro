<?php

namespace Modules\Billing\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MercadoPagoService
{
    protected $baseUrl = 'https://api.mercadopago.com';
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = config('billing.mercadopago.access_token') ?? env('MERCADOPAGO_ACCESS_TOKEN');
    }

    public function createPreference(array $items, array $payer, string $externalReference, array $backUrls)
    {
        $response = Http::withToken($this->accessToken)->post("{$this->baseUrl}/checkout/preferences", [
            'items' => $items,
            'payer' => $payer,
            'external_reference' => $externalReference,
            'back_urls' => $backUrls,
            'auto_return' => 'approved',
            'notification_url' => route('billing.webhook.mercadopago'),
            'statement_descriptor' => 'VERTEX OH PRO',
            'binary_mode' => true,
        ]);

        if ($response->failed()) {
            Log::error('MercadoPago Preference Creation Failed', ['error' => $response->body()]);
            throw new \Exception('Failed to create payment preference.');
        }

        return $response->json();
    }

    public function getPayment($paymentId)
    {
        $response = Http::withToken($this->accessToken)->get("{$this->baseUrl}/v1/payments/{$paymentId}");

        if ($response->failed()) {
            Log::error('MercadoPago Payment Fetch Failed', ['id' => $paymentId, 'error' => $response->body()]);
            throw new \Exception('Failed to fetch payment details.');
        }

        return $response->json();
    }
}
