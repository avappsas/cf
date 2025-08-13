<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $token;
    protected $phoneId;

    public function __construct()
    {
        $this->token = config('services.whatsapp.token');
        $this->phoneId = config('services.whatsapp.phone_id');
    }

    public function enviarPlantillaCambioEstado($telefono, $nombre, $detalle, $url)
    {
        $endpoint = "https://graph.facebook.com/v19.0/{$this->phoneId}/messages";

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $telefono,
            'type' => 'template',
            'template' => [
                'name' => 'cambio_estado_cf',
                'language' => ['code' => 'es_ES'],  // ✅ correcto
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [
                            ['type' => 'text', 'text' => $nombre],
                            ['type' => 'text', 'text' => $detalle],
                            ['type' => 'text', 'text' => $url],
                        ],
                    ]
                ]
            ]
        ];

        $response = Http::withToken($this->token)->post($endpoint, $payload);

        return $response->json();
    }

    public function enviarPlantillaGenerica($telefono, $nombrePlantilla, array $parametrosTexto)
    {
        $endpoint = "https://graph.facebook.com/v19.0/{$this->phoneId}/messages";

        $params = [];
        foreach ($parametrosTexto as $text) {
            $params[] = ['type' => 'text', 'text' => $text];
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $telefono,
            'type' => 'template',
            'template' => [
                'name' => $nombrePlantilla,
                'language' => ['code' => 'es_ES'],  // ✅ correcto
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => $params
                    ]
                ]
            ]
        ];

        $response = Http::withToken($this->token)->post($endpoint, $payload);
        return $response->json();
    }




}