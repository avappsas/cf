<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'whatsapp',
        'whatsapp/webhook',
        'whatsa',
        'contactChats',
        'listenBingo',
        'getMessages',
        'sendMessages',
        'sendWS',
        'getCertificado'
    ];
}
