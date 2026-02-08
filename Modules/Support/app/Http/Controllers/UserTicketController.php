<?php

namespace Modules\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Support\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class UserTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('support::index');
    }

    /**
     * Show the specified resource.
     */
    public function show($uuid)
    {
        $ticket = Ticket::where('uuid', $uuid)->where('user_id', Auth::id())->firstOrFail();
        return view('support::show', compact('ticket'));
    }
}
