<?php

use Illuminate\Support\Str;

// Detecta el host y protocolo del APP_URL
$appUrl = env('APP_URL', 'http://localhost');
$host   = parse_url($appUrl, PHP_URL_HOST) ?: 'localhost';

$isLocalHost = in_array($host, ['localhost', '127.0.0.1']);
$isIp        = filter_var($host, FILTER_VALIDATE_IP) !== false;
$isHttps     = Str::startsWith($appUrl, 'https://');

// Dominio de cookie: null en local/IP; .dominio.tld en producción para cubrir subdominios
$autoSessionDomain = ($isLocalHost || $isIp) ? null : ('.' . $host);

// Secure cookie: true si APP_URL es https
$autoSecureCookie   = $isHttps;

return [

    'driver' => env('SESSION_DRIVER', 'file'),

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    'encrypt' => false,

    'files' => storage_path('framework/sessions'),

    'connection' => env('SESSION_CONNECTION', null),

    'table' => 'sessions',

    'store' => env('SESSION_STORE', null),

    'lottery' => [2, 100],

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    'path' => '/',

    // Aquí usamos detección automática
    'domain' => env('SESSION_DOMAIN', $autoSessionDomain),

    'secure' => env('SESSION_SECURE_COOKIE', $autoSecureCookie),

    'http_only' => true,

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

];