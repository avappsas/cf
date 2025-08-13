<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;
 

class WhatsAppChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            Log::warning('📛 La notificación no tiene método toWhatsApp');
            return;
        }

        $data = $notification->toWhatsApp($notifiable);
        $telefono = $data['to'] ?? null;

        Log::info("📤 WhatsAppChannel: intento de envío", [
            'to' => $telefono,
            'tipo_envio' => isset($data['template']) ? 'plantilla' : 'texto',
            'payload' => $data,
        ]);

        try {
            $whatsapp = new WhatsAppService();

            if (!empty($data['template'])) {
                $whatsapp->enviarPlantillaGenerica(
                    $telefono,
                    $data['template_name'],
                    [
                        $data['nombre'] ?? 'Usuario',
                        $data['detalle'] ?? '',
                        $data['url'] ?? ''
                    ]
                );
            } else {
                $whatsapp->enviarMensajeTexto($telefono, $data['message'] ?? '');
            }

            Log::info("✅ WhatsApp enviado a $telefono");

        } catch (\Throwable $e) {
            Log::error("❌ Error en WhatsAppChannel al enviar a $telefono: " . $e->getMessage());
        }
    }
}