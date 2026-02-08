<?php

namespace Modules\Support\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Support\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketList extends Component
{
    use WithPagination;

    public $statusFilter = '';

    public function render()
    {
        $tickets = Ticket::where('user_id', Auth::id())
            ->when($this->statusFilter, function ($query) {
                return $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('support::livewire.ticket-list', [
            'tickets' => $tickets
        ]);
    }
}
