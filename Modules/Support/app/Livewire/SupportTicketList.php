<?php

namespace Modules\Support\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Support\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class SupportTicketList extends Component
{
    use WithPagination;

    public function render()
    {
        $tickets = Ticket::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('support::livewire.support-ticket-list', [
            'tickets' => $tickets
        ]);
    }
}
