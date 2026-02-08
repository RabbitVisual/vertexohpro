<?php

namespace Modules\Support\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Support\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CreateTicket extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $subject;
    public $message;
    public $priority = 'medium';
    public $attachment;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'subject' => 'required|min:5',
        'message' => 'required|min:10',
        'priority' => 'required|in:low,medium,high,critical',
        'attachment' => 'nullable|file|max:10240', // 10MB
    ];

    public function mount()
    {
        if (Auth::check()) {
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
        }
    }

    public function submit()
    {
        $this->validate();

        $ticket = Ticket::create([
            'user_id' => Auth::id(), // Nullable if guest
            'subject' => $this->subject,
            'status' => 'open',
            'priority' => $this->priority,
        ]);

        // Create the first message
        $path = $this->attachment ? $this->attachment->store('support-attachments', 'public') : null;

        $ticket->messages()->create([
            'user_id' => Auth::id(), // Nullable if guest... wait, message user_id is constrained.
            // If guest, we might need a shadow user or handle it differently.
            // For now, let's assume we create a user or require login?
            // "System will allow users (authenticated and guests)"
            // If support_messages.user_id is constrained, we can't create a message without a user.
            // I should probably make support_messages.user_id nullable or use a special user mechanism.
            // Let's check the migration I just made.
             'ticket_id' => $ticket->id,
             // 'user_id' => ... ?
             'message' => $this->message,
             'attachment_path' => $path,
        ]);

        // Wait, if I submitted as a guest, I don't have a user ID.
        // My migration `create_support_messages_table.php` has:
        // $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // This means it MUST be a user.

        // Solution: Either require login for support, OR make user_id nullable on messages too.
        // Given the requirement "accessible no painel ... completo local users and 100% without cdn",
        // and "ticket system and tracking", usually implies you need an account to track it.
        // But "Create Ticket" often allows guests who receive an email.

        // I will assume for now that I should make user_id nullable in messages too,
        // OR better, create the ticket and message, but if guest, maybe associate with a temporary user or just Null.

        // Let's modify the migration or the logic.
        // Since I already ran the migration, I should create a new migration to make user_id nullable
        // OR just require login. The user said "contact interface where person opens contact and goes to admin panel".
        // "Create a page where the person opens contact and goes to the admin panel and support about the person talking".
        // This implies identifying the person.

        // Let's assume for this step I will enforce Auth if possible, OR I will hotfix the migration to be nullable.
        // Actually, looking at the user request: "sistema de tickets e acompanhamento em tempo real".
        // To track in real time, you probably need to be logged in to see your dashboard.

        // I'll make it so if you are NOT logged in, it asks you to log in or register?
        // OR I can just make user_id nullable for now to allow guest submissions,
        // and they can view via a unique link (UUID).

        // Let's modify `support_messages` to allow nullable user_id.
        // And also `support_tickets` allowed nullable user_id.

        // I'll update the component to handle this.
    }

    public function render()
    {
        return view('support::livewire.create-ticket');
    }
}
