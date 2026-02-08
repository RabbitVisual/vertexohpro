<?php

namespace Modules\Support\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Support\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketChat extends Component
{
    use WithFileUploads;

    public Ticket $ticket;
    public $newMessage;
    public $attachment;

    protected $rules = [
        'newMessage' => 'required_without:attachment|min:1',
        'attachment' => 'nullable|file|max:10240',
    ];

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function sendMessage()
    {
        $this->validate();

        $path = $this->attachment ? $this->attachment->store('support-attachments', 'public') : null;

        $this->ticket->messages()->create([
            'user_id' => Auth::id(),
            'message' => $this->message ?? $this->newMessage, // Fix potential typo if I used message in view
            'attachment_path' => $path,
            'is_admin' => false, // User sending
        ]);

        $this->newMessage = '';
        $this->attachment = null;

        // Touch ticket to update updated_at for sorting
        $this->ticket->touch();
    }

    public function render()
    {
        return view('support::livewire.ticket-chat', [
            'messages' => $this->ticket->messages()->with('user')->orderBy('created_at', 'asc')->get()
        ]);
    }
}
