<?php

namespace App\Observers;

use App\Models\Cuota;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CuotaObserver
{
    public function created(Cuota $cuota)
    {
        Bitacora::create([
            'id_usuario'     => Auth::id(),
            'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
            'accion'         => 'Creó cuota',
            'modulo'         => 'Cuotas',
            'Estado_interno' => 'CREADA', // ✅ AÑADIDO
            'detalles'       => 'Cuota creada con ID ' . $cuota->id,
            'idContrato'     => $cuota->Contrato ?? null,
            'idCuota'        => $cuota->id,
            'id_dp'          => Auth::user()->id_dp ?? null, 
            'fecha'          => now(),
            'ip'             => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'ruta'           => Request::path(),
            'metodo'         => Request::method(),
        ]);
    }

    public function updated(Cuota $cuota)
    {
        $cambios = [];

        foreach ($cuota->getChanges() as $campo => $nuevo) {
            if ($campo === 'updated_at') continue;

            $original = $cuota->getOriginal($campo);
            $cambios[] = "$campo: '$original' → '$nuevo'";
        }

        if ($cambios) {
            Bitacora::create([
                'id_usuario'     => Auth::id(),
                'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
                'accion'         => 'Actualizó cuota',
                'modulo'         => 'Cuotas',
                'Estado_interno' => $cuota->Estado_juridica ?? null, // ✅ AÑADIDO
                'detalles'       => implode(', ', $cambios),
                'idContrato'     => $cuota->Contrato ?? null,
                'idCuota'        => $cuota->id,
                'id_dp'          => Auth::user()->id_dp ?? null,
                'fecha'          => now(),
                'ip'             => Request::ip(),
                'user_agent'     => Request::userAgent(),
                'ruta'           => Request::path(),
                'metodo'         => Request::method(),
            ]);
        }
    }

    public function deleted(Cuota $cuota)
    {
        Bitacora::create([
            'id_usuario'     => Auth::id(),
            'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
            'accion'         => 'Eliminó cuota',
            'modulo'         => 'Cuotas',
            'Estado_interno' => $cuota->Estado_juridica ?? null, // ✅ AÑADIDO
            'detalles'       => 'Cuota eliminada con ID ' . $cuota->id,
            'idContrato'     => $cuota->Contrato ?? null,
            'idCuota'        => $cuota->id,
            'id_dp'          => Auth::user()->id_dp ?? null,
            'fecha'          => now(),
            'ip'             => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'ruta'           => Request::path(),
            'metodo'         => Request::method(),
        ]);
    }
}