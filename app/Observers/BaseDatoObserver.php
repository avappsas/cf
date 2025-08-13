<?php

namespace App\Observers;

use App\Models\BaseDato;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class BaseDatoObserver
{
    public function created(BaseDato $baseDato)
    {
        Bitacora::create([
            'id_usuario'     => Auth::id(),
            'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
            'accion'         => 'Creó registro',
            'modulo'         => 'Base_Datos',
            'detalles'       => "Documento: {$baseDato->Documento}, Nombre: {$baseDato->Nombre}",
            'idContrato'     => $baseDato->idContrato ?? null,
            'idCuota'        => $baseDato->idCuota ?? null,
            'id_dp'          => Auth::user()->id_dp ?? null,
            'fecha'          => now(),
            'ip'             => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'ruta'           => Request::path(),
            'metodo'         => Request::method(),
        ]);
    }

    public function updated(BaseDato $baseDato)
    {
        $cambios = [];

        foreach ($baseDato->getChanges() as $campo => $nuevoValor) {
            if ($campo === 'updated_at') continue;
            $cambios[] = "$campo: '{$baseDato->getOriginal($campo)}' → '$nuevoValor'";
        }

        if (!empty($cambios)) {
            Bitacora::create([
                'id_usuario'     => Auth::id(),
                'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
                'accion'         => 'Actualizó registro',
                'modulo'         => 'Base_Datos',
                'detalles'       => implode(', ', $cambios),
                'idContrato'     => $baseDato->idContrato ?? null,
                'idCuota'        => $baseDato->idCuota ?? null,
                'id_dp'          => Auth::user()->id_dp ?? null,
                'fecha'          => now(),
                'ip'             => Request::ip(),
                'user_agent'     => Request::userAgent(),
                'ruta'           => Request::path(),
                'metodo'         => Request::method(),
            ]);
        }
    }

    public function deleted(BaseDato $baseDato)
    {
        Bitacora::create([
            'id_usuario'     => Auth::id(),
            'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
            'accion'         => 'Eliminó registro',
            'modulo'         => 'Base_Datos',
            'detalles'       => "Documento: {$baseDato->Documento}, Nombre: {$baseDato->Nombre}",
            'idContrato'     => $baseDato->idContrato ?? null,
            'idCuota'        => $baseDato->idCuota ?? null,
            'id_dp'          => Auth::user()->id_dp ?? null,
            'fecha'          => now(),
            'ip'             => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'ruta'           => Request::path(),
            'metodo'         => Request::method(),
        ]);
    }
}