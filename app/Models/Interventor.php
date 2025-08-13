<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 

class Interventor extends Model
{
    protected $table      = 'Interventores';
    protected $primaryKey = 'Id';
    public    $timestamps = false;

    // Si usas Mass Assignment:
    protected $fillable = [
        'CEDULA',
        'NOMBRE',
        'CARGO',
        'Id_oficina',
        'CORREO',
        'Celular_Supervisor',
        'Firma',
        'Estado',
        'Año',
        'id_dp',
        'whatsapp_notificacion'
    ];
}