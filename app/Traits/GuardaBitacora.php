<?php

namespace App\Traits;

use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

trait GuardaBitacora
{
    public function guardarBitacora(array $data = [])
    {
        Bitacora::create([
            'id_usuario'     => Auth::id(),
            'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
            'accion'         => $data['accion'] ?? 'Acción no especificada',
            'modulo'         => $data['modulo'] ?? null,
            'detalles'       => $data['detalles'] ?? null,
            'idContrato'     => $data['idContrato'] ?? null,
            'idCuota'        => $data['idCuota'] ?? null,
            'id_dp'          => Auth::user()->id_dp ?? null,
            'ip'             => request()->ip(),
            'user_agent'     => request()->userAgent(),
            'ruta'           => request()->path(),
            'metodo'         => request()->method()
        ]);
    }
}