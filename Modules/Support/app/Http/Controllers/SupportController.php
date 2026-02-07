<?php

namespace Modules\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Support\Models\Ticket;
use Modules\Support\Models\TicketMessage;

class SupportController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $ticket = Ticket::create([
                'user_id' => auth()->id() ?? 1, // Fallback for dev
                'subject' => $validated['subject'],
                'status' => 'open',
            ]);

            TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => auth()->id() ?? 1,
                'message' => $validated['message'],
            ]);

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Ticket criado com sucesso!', 'ticket_id' => $ticket->id], 201);
            }

            return redirect()->back()->with('success', 'Ticket criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Erro ao criar ticket: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Erro ao criar ticket.');
        }
    }
}
