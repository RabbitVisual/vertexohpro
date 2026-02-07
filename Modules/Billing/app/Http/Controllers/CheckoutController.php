<?php

namespace Modules\Billing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Billing\Services\MercadoPagoService;
use Modules\Library\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $mpService;

    public function __construct(MercadoPagoService $mpService)
    {
        $this->mpService = $mpService;
    }

    public function createPreference(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:materials,id',
        ]);

        $user = $request->user();
        $material = Material::findOrFail($request->material_id);

        if ($material->user_id === $user->id) {
            return response()->json(['error' => 'You cannot buy your own material.'], 400);
        }

        // Check if already purchased
        $existingPurchase = DB::table('material_purchases')
            ->where('user_id', $user->id)
            ->where('material_id', $material->id)
            ->where('status', 'approved')
            ->exists();

        if ($existingPurchase) {
            return response()->json(['error' => 'Material already purchased.'], 400);
        }

        try {
            // Create pending purchase record manually to get ID
            $purchaseId = DB::table('material_purchases')->insertGetId([
                'user_id' => $user->id,
                'material_id' => $material->id,
                'price_paid' => $material->price,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Prepare items for MP
            $items = [[
                'id' => (string) $material->id,
                'title' => $material->title,
                'description' => substr($material->description ?? '', 0, 255),
                'quantity' => 1,
                'currency_id' => 'BRL',
                'unit_price' => (float) $material->price,
            ]];

            // Prepare payer
            $payer = [
                'name' => $user->first_name,
                'surname' => $user->last_name,
                'email' => $user->email,
                // Assuming CPF logic elsewhere if needed
            ];

            // Back URLs
            $baseUrl = config('app.url'); // Use app.url instead of hardcoded
            $backUrls = [
                'success' => "{$baseUrl}/marketplace/success",
                'failure' => "{$baseUrl}/marketplace/failure",
                'pending' => "{$baseUrl}/marketplace/pending",
            ];

            $preference = $this->mpService->createPreference(
                $items,
                $payer,
                (string) $purchaseId,
                $backUrls
            );

            return response()->json(['preference_id' => $preference['id']]);

        } catch (\Exception $e) {
            Log::error('Checkout Failed: ' . $e->getMessage());
            // Optionally delete the pending record if preference fails
            if (isset($purchaseId)) {
                DB::table('material_purchases')->where('id', $purchaseId)->delete();
            }
            return response()->json(['error' => 'Could not initiate checkout.'], 500);
        }
    }
}
