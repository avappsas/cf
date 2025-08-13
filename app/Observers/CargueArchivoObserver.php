<?php

namespace App\Observers;

use App\Models\CargueArchivo;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CargueArchivoObserver
{
    public function created(CargueArchivo $archivo)
    {
        Bitacora::create([
            'id_usuario'     => Auth::id(),
            'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
            'accion'         => 'Subió archivo',
            'modulo'         => 'Cargue_Archivo',
            'detalles'       => "Archivo subido con ID {$archivo->id}, tipo: {$archivo->Tipo_archivo}",
            'idContrato'     => $archivo->Id_contrato ?? null, 
            'idCuota'        => $archivo->idCuota ?? null,
            'id_dp'          => Auth::user()->id_dp ?? null,
            'ip'             => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'ruta'           => Request::path(),
            'metodo'         => Request::method(),
        ]);
    }

    public function updated(CargueArchivo $archivo)
    {
        $cambios = [];

        foreach ($archivo->getChanges() as $campo => $nuevo) {
            if ($campo === 'updated_at') continue;

            $original = $archivo->getOriginal($campo);

            if ($campo === 'Estado') {
                $cambios[] = "Estado: '$original' → '$nuevo'";
            } else {
                $cambios[] = "$campo: '$original' → '$nuevo'";
            }
        }

        if ($cambios) {
            Bitacora::create([
                'id_usuario'     => Auth::id(),
                'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
                'accion'         => 'Actualizó archivo',
                'modulo'         => 'Cargue_Archivo',
                'detalles'       => implode(', ', $cambios),
                'idContrato'     => $archivo->Id_contrato ?? null,
                'idCuota'        => $archivo->idCuota ?? null,
                'id_dp'          => Auth::user()->id_dp ?? null,
                'ip'             => Request::ip(),
                'user_agent'     => Request::userAgent(),
                'ruta'           => Request::path(),
                'metodo'         => Request::method(),
            ]);
        }
    }

    public function deleted(CargueArchivo $archivo)
    {
        Bitacora::create([
            'id_usuario'     => Auth::id(),
            'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
            'accion'         => 'Eliminó archivo',
            'modulo'         => 'Cargue_Archivo',
            'detalles'       => "Archivo eliminado con ID {$archivo->id}",
            'idContrato'     => $archivo->Id_contrato ?? null,
            'idCuota'        => $archivo->idCuota ?? null,
            'id_dp'          => Auth::user()->id_dp ?? null,
            'ip'             => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'ruta'           => Request::path(),
            'metodo'         => Request::method(),
        ]);
    }
}