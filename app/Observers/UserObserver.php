<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class UserObserver
{
    public function created(User $user)
    {
        Bitacora::create([
            'id_usuario'     => Auth::id(), // puede ser null si se crea desde registro público
            'nombre_usuario' => Auth::user()->name ?? 'Sistema',
            'accion'         => 'Creó usuario',
            'modulo'         => 'Usuarios',
            'detalles'       => "Usuario creado: {$user->name} ({$user->email})",
            'id_dp'          => Auth::user()->id_dp ?? null,
            'ip'             => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'ruta'           => Request::path(),
            'metodo'         => Request::method(),
        ]);
    }

    public function updated(User $user)
    {
        $cambios = [];

        foreach ($user->getChanges() as $campo => $nuevo) {
            if ($campo === 'updated_at') continue;

            $original = $user->getOriginal($campo);
            $cambios[] = "$campo: '$original' → '$nuevo'";
        }

        if ($cambios) {
            Bitacora::create([
                'id_usuario'     => Auth::id(),
                'nombre_usuario' => Auth::user()->name ?? 'Sistema',
                'accion'         => 'Actualizó usuario',
                'modulo'         => 'Usuarios',
                'detalles'       => implode(', ', $cambios),
                'id_dp'          => Auth::user()->id_dp ?? null,
                'ip'             => Request::ip(),
                'user_agent'     => Request::userAgent(),
                'ruta'           => Request::path(),
                'metodo'         => Request::method(),
            ]);
        }
    }

    public function deleted(User $user)
    {
        Bitacora::create([
            'id_usuario'     => Auth::id(),
            'nombre_usuario' => Auth::user()->name ?? 'Sistema',
            'accion'         => 'Eliminó usuario',
            'modulo'         => 'Usuarios',
            'detalles'       => "Usuario eliminado: {$user->name} ({$user->email})",
            'id_dp'          => Auth::user()->id_dp ?? null,
            'ip'             => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'ruta'           => Request::path(),
            'metodo'         => Request::method(),
        ]);
    }
}