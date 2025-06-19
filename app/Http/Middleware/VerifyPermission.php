<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class VerifyPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = User::find(1); // Reemplaza esto con la lógica para obtener el usuario actual

        if (!$user->hasPermission($permission)) {
            // Redirigir al usuario a una página de acceso denegado o devolver una respuesta apropiada
            return redirect()->route('access_denied');
        }

        return $next($request);
    }
}
