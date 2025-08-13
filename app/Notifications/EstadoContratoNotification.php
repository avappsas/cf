<?php

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EstadoContratoNotification extends Notification
{
    protected $mensaje;

    public function __construct($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Actualización de Estado')
            ->line($this->mensaje)
            ->action('Ver detalles', url('/contratos'))
            ->line('Gracias por usar nuestra aplicación.');
    }
}