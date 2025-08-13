<?php
 

namespace App\Observers;

use App\Models\Contrato;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ContratoObserver
{
    public function updated(Contrato $contrato)
    {
        $cambios = [];

        foreach ($contrato->getChanges() as $campo => $nuevo) {
            if ($campo === 'updated_at') continue;

            $original = $contrato->getOriginal($campo);

            // Personalizar los cambios de estado
            if (in_array($campo, ['Estado', 'Estado_interno', 'Estado_rpc'])) {
                $cambios[] = "Cambio en $campo: '$original' → '$nuevo'";
            } else {
                $cambios[] = "$campo: '$original' → '$nuevo'";
            }
        }

        if ($cambios) {
                    
            $estadoInternoNuevo = $contrato->getChanges()['Estado_interno'] ?? $contrato->Estado_interno;


            Bitacora::create([
                'id_usuario'     => Auth::id(),
                'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
                'accion'         => 'Actualizó contrato',
                'modulo'         => 'Contratos',
                'Estado_interno' => $estadoInternoNuevo,
                'detalles'       => implode(', ', $cambios),
                'idContrato'     => $contrato->Id ?? null,
                'idCuota'        => 1,
                'id_dp'          => Auth::user()->id_dp ?? null,
                'ip'             => Request::ip(),
                'user_agent'     => Request::userAgent(),
                'ruta'           => Request::path(),
                'metodo'         => Request::method(),
            ]);
        }
    }

    public function created(Contrato $contrato)
    {
 
    }

    public function deleted(Contrato $contrato)
    {
        Bitacora::create([
            'id_usuario'     => Auth::id(),
            'nombre_usuario' => Auth::user()->name ?? 'Desconocido',
            'accion'         => 'Eliminó contrato',
            'modulo'         => 'Contratos',
            'Estado_interno' => $contrato->Estado_interno,
            'detalles'       => 'Contrato eliminado con ID ' . $contrato->id,
            'idContrato'     => $contrato->Id ?? null,
            'idCuota'        => 1,
            'id_dp'          => Auth::user()->id_dp ?? null,
            'ip'             => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'ruta'           => Request::path(),
            'metodo'         => Request::method(),
        ]);
    }
}