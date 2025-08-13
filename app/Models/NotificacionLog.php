<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionLog extends Model
{
    protected $table = 'notificaciones_log'; // asegúrate que el nombre sea correcto

    protected $fillable = [
        'tipo',
        'destinatario',
        'telefono',
        'correo',
        'mensaje',
        'canal',
        'contrato_id',
    ];
}