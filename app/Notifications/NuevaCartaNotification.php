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
        return ['database', 'broadcast']; 
    }

   // Notificación en base de datos
   public function toDatabase($notifiable)
   {
       return [
           'nombre_carta' => $this->carta->nombre_carta,
           'fecha_carta' => $this->carta->fecha_carta,
           'mensaje' => "Tienes una nueva carta.",
       ];
   }

    // Notificación a través de broadcast
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'nombre_carta' => $this->carta->nombre_carta,
            'fecha_carta' => $this->carta->fecha_carta,
            'mensaje' => "Tienes una nueva carta.",
        ]);
    }

    // Definir el canal para este broadcast
    public function broadcastOn()
    {
        return new Channel('user.' . $this->carta->dirigido); // Canal privado por usuario
    }
}
