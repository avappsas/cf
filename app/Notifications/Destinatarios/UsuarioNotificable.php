<?php

namespace App\Notifications\Destinatarios;

use Illuminate\Notifications\Notifiable;

class UsuarioNotificable
{
    use Notifiable;

    public $telefono;
    public $name;
    public $email;

    public function __construct($telefono, $name = 'Usuario', $email = null)
    {
        $this->telefono = $telefono;
        $this->name = $name;
        $this->email = $email;
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