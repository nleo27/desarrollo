<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevaCartaNotification extends Notification
{
    use Queueable;

    private $carta;

    /**
     * Create a new notification instance.
     */
    public function __construct($carta)
    {
        $this->carta = $carta;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'mensaje' => 'Tienes una nueva carta',
            'carta_id' => $this->carta->id,
            'nombre_carta' => $this->carta->nombre_carta,
        ];
    }
}
