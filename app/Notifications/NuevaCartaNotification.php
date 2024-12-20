<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Notifications\Messages\BroadcastMessage;

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

   // Notificación en base de datos
   public function toDatabase($notifiable)
   {
        return new DatabaseMessage([
            'mensaje' => 'Tienes una carta nueva.',
        ]);
   }

    
}
