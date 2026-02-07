<?php

namespace Modules\Library\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Modules\Library\Models\Material;

class MaterialUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $material;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Material $material)
    {
        $this->material = $material;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'material_updated',
            'material_id' => $this->material->id,
            'title' => $this->material->title,
            'message' => 'Uma nova versão do material "' . $this->material->title . '" está disponível.',
            'url' => route('library.show', $this->material->id),
        ];
    }
}
