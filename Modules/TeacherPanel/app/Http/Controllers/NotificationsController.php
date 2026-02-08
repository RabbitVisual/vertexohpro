<?php

namespace Modules\TeacherPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Support\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    /**
     * Check for new notifications.
     */
    public function check(Request $request)
    {
        $lastCheck = $request->input('last_check');

        $notifications = [];

        // Check for answered tickets updated since last check
        if ($lastCheck) {
            $answeredTickets = Ticket::where('user_id', Auth::id())
                ->where('status', 'answered')
                ->where('updated_at', '>', $lastCheck)
                ->get();

            foreach ($answeredTickets as $ticket) {
                $notifications[] = [
                    'id' => 'ticket-' . $ticket->id,
                    'type' => 'support',
                    'title' => 'Suporte Atualizado',
                    'message' => "Seu chamado #{$ticket->id} foi respondido!",
                    'url' => '#', // Link to support module
                    'timestamp' => $ticket->updated_at->timestamp
                ];
            }
        }

        // Mock Marketplace Sale Notification
        // In real app: Check Order model created_at > $lastCheck
        // Randomly simulate a sale every now and then for demo purposes
        // Check if last_check is older than 10 seconds to avoid spamming on init
        if ($lastCheck && (time() - strtotime($lastCheck) > 5) && rand(1, 100) > 80) {
             $notifications[] = [
                'id' => 'sale-' . time() . '-' . uniqid(),
                'type' => 'marketplace',
                'title' => 'Venda Realizada!',
                'message' => "Nova venda: 'Plano de Aula - Sistema Solar'",
                'url' => '#',
                'timestamp' => time()
            ];
        }

        return response()->json([
            'notifications' => $notifications,
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}
