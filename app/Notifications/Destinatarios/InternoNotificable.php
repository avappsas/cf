<?php

namespace App\Notifications\Destinatarios;

use Illuminate\Notifications\Notifiable;

class InternoNotificable
{
    use Notifiable;

    public $telefono;
    public $email;
    public $name;

    public function __construct($telefono, $email = null)
    {
        $this->telefono = $telefono;
        $this->email = $email;
        $this->name = 'Área Interna';
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }

    public function routeNotificationForWhatsApp()
    {
        return $this->telefono;
    }
}