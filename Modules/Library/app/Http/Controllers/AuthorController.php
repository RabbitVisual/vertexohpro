<?php

namespace Modules\Library\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Support\Models\Ticket;
use Modules\Support\Models\TicketMessage;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthorController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // Calculate Total Sales: Sum of price_paid for all approved purchases of materials owned by the user
        $salesQuery = DB::table('material_purchases')
            ->join('materials', 'material_purchases.material_id', '=', 'materials.id')
            ->where('materials.user_id', $user->id)
            ->where('material_purchases.status', 'approved');

        $totalGross = $salesQuery->sum('material_purchases.price_paid');
        $salesCount = $salesQuery->count();

        // Platform Fee 10%
        $platformFee = $totalGross * 0.10;

        // Net Earnings
        $netEarnings = $totalGross - $platformFee;

        // Fetch recent sales history
        $recentSales = $salesQuery
            ->select('material_purchases.*', 'materials.title as material_title')
            ->orderBy('material_purchases.created_at', 'desc')
            ->limit(10)
            ->get();

        // Check for pending withdrawals (Open Tickets with subject 'Solicitação de Saque')
        $hasPendingWithdrawal = Ticket::where('user_id', $user->id)
            ->where('subject', 'like', 'Solicitação de Saque%')
            ->where('status', 'open')
            ->exists();

        return view('library::author.dashboard', compact('totalGross', 'salesCount', 'netEarnings', 'recentSales', 'hasPendingWithdrawal'));
    }

    public function requestWithdrawal(Request $request)
    {
        $user = $request->user();

        // Re-calculate to ensure server-side validation
        $totalGross = DB::table('material_purchases')
            ->join('materials', 'material_purchases.material_id', '=', 'materials.id')
            ->where('materials.user_id', $user->id)
            ->where('material_purchases.status', 'approved')
            ->sum('material_purchases.price_paid');

        $netEarnings = $totalGross * 0.90;

        // Minimum withdrawal threshold
        if ($netEarnings < 50) {
            return back()->with('error', 'O saldo mínimo para saque é R$ 50,00.');
        }

        // Check if already has open request
        $hasPending = Ticket::where('user_id', $user->id)
            ->where('subject', 'like', 'Solicitação de Saque%')
            ->where('status', 'open')
            ->exists();

        if ($hasPending) {
            return back()->with('error', 'Você já possui uma solicitação de saque em aberto. Aguarde o processamento.');
        }

        try {
            DB::transaction(function () use ($user, $netEarnings) {
                // Create Ticket
                $ticket = Ticket::create([
                    'user_id' => $user->id,
                    'subject' => 'Solicitação de Saque - R$ ' . number_format($netEarnings, 2, ',', '.'),
                    'status' => 'open',
                    'last_reply_at' => now(),
                ]);

                // Initial Message
                TicketMessage::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $user->id,
                    'message' => "Solicito o saque dos meus rendimentos acumulados no valor de R$ " . number_format($netEarnings, 2, ',', '.') . ".",
                ]);
            });

            return back()->with('success', 'Solicitação de saque enviada com sucesso! Acompanhe pelo menu de Suporte.');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao processar solicitação: ' . $e->getMessage());
        }
    }
}
