<?php

namespace Modules\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Support\Models\Ticket;
use Modules\Support\Models\TicketMessage;
use Illuminate\Support\Facades\Auth;

class AdminSupportController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('support::admin.index', compact('tickets'));
    }

    public function show($uuid)
    {
        $ticket = Ticket::where('uuid', $uuid)->with('user')->firstOrFail();
        return view('support::admin.show', compact('ticket'));
    }
}
