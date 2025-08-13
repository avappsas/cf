<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacora_uso';

    protected $fillable = [
        'id_usuario',
        'nombre_usuario',
        'accion',
        'modulo',
        'detalles',
        'idContrato',
        'idCuota',
        'id_dp',
        'fecha',
        'ip',
        'user_agent',
        'ruta',
        'metodo',
        'Estado_interno', // ✅ este debe estar si usas mass assignment
    ];

    public $timestamps = false; // No usa created_at ni updated_at
}