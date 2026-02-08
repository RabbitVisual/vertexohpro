<?php

namespace Modules\Support\Livewire;

use Livewire\Component;
use Modules\Support\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Livewire\Attributes\On;

class SupportCreateTicket extends Component
{
    public $subject;
    public $message;
    public $priority = 'low';
    public $showModal = false;

    // protected $listeners = ['open-modal' => 'openModal'];

    protected $rules = [
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'priority' => 'required|in:low,medium,high',
    ];

    #[On('open-modal')]
    public function openModal($name)
    {
        if ($name === 'create-ticket') {
            $this->showModal = true;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['subject', 'message', 'priority']);
    }

    public function submit()
    {
        $this->validate();

        Ticket::create([
            'uuid' => Str::upper(Str::random(8)),
            'user_id' => Auth::id(),
            'subject' => $this->subject,
            'message' => $this->message, // Assuming description or message field exists
            'priority' => $this->priority,
            'status' => 'open',
        ]);

        $this->closeModal();
        $this->dispatch('ticket-created'); // To refresh the list if needed
        return redirect()->route('support.index')->with('success', 'Chamado criado com sucesso!');
    }

    public function render()
    {
        return view('support::livewire.support-create-ticket');
    }
}
