<?php

namespace Modules\Billing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Billing\Services\MercadoPagoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    protected $mpService;

    public function __construct(MercadoPagoService $mpService)
    {
        $this->mpService = $mpService;
    }

    public function handle(Request $request)
    {
        $type = $request->input('type');

        // Handle only payment notifications
        if ($type === 'payment') {
            $dataId = $request->input('data.id'); // payment ID

            try {
                $payment = $this->mpService->getPayment($dataId);

                $status = $payment['status']; // approved, rejected, pending, etc.
                $externalReference = $payment['external_reference']; // our material_purchase_id

                if ($status === 'approved') {
                    // Update purchase status
                    DB::table('material_purchases')
                        ->where('id', $externalReference)
                        ->update(['status' => 'approved', 'updated_at' => now()]);

                    Log::info("Purchase #{$externalReference} approved via webhook.");
                } elseif ($status === 'rejected' || $status === 'cancelled') {
                    DB::table('material_purchases')
                        ->where('id', $externalReference)
                        ->update(['status' => 'rejected', 'updated_at' => now()]);

                    Log::info("Purchase #{$externalReference} rejected via webhook.");
                }

                return response()->json(['status' => 'processed']);

            } catch (\Exception $e) {
                Log::error("Webhook processing failed for payment {$dataId}: " . $e->getMessage());
                return response()->json(['error' => 'Processing failed'], 500);
            }
        }

        return response()->json(['status' => 'ignored']); // Other types like 'merchant_order'
    }
}
