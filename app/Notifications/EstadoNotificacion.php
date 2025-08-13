<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Contracts\Queue\ShouldQueue;


class EstadoNotificacion extends Notification  implements ShouldQueue
{
    use Queueable;

    protected $tipo; // contrato, cuota, general
    protected $data;

    public function __construct($tipo, $data)
    {
        $this->tipo = $tipo;
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['mail', 'whatsapp']; // ✅ Coincide con el nombre usado en app()->extend(...)
    }

    public function toMail($notifiable)
    { 

        return (new MailMessage)
            ->subject('Actualización de estado: ' . ucfirst($this->tipo))
            ->greeting('Hola ' . $notifiable->name)
            ->line('Se ha actualizado el estado de su ' . $this->tipo . '.')
            ->line('Nuevo estado: ' . ($this->data['estado'] ?? 'Desconocido'))
            ->action('Ver detalles', url($this->data['url'] ?? '/'))
            ->line('Gracias por usar nuestra plataforma.');
    }

    public function toWhatsApp($notifiable)
    {
        return [
            'to' => $notifiable->telefono,
            'template' => true,
            'template_name' => $this->plantillaSegunTipo(),
            'nombre' => $notifiable->name,
            'detalle' => $this->data['mensaje'] ?? 'Estado actualizado.',
            'url' => url($this->data['url'] ?? '/')
        ];
    }

    protected function plantillaSegunTipo()
    {
        switch ($this->tipo) {
            case 'contrato':
                return 'cambio_estado_cf';
            case 'cuota':
                return 'cuota_actualizada_cf';
            case 'general':
                return 'aviso_general_cf';
            default:
                return 'cambio_estado_cf';
        }
    }
}