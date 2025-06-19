<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class CheckRouteAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ruta = $request->route()->getName();
        // print_r($ruta);die();
        $user = Auth::user()->id;
        // Buscar en la base de datos si el usuario tiene acceso a la ruta
        $perfilRuta = DB::table('rutaperfil as a')->select('a.*')
                                ->join('Rutas as c', 'a.idRuta', '=', 'c.id')
                                ->join('userperfil as b', 'a.idperfil', '=', 'b.idperfil')
                                ->where('b.iduser', $user)
                                ->where('c.ruta', $ruta)
                                ->first();
                                // print_r($perfilRuta);die();

        if (!$perfilRuta) {
            // Si el usuario no tiene acceso a la ruta, redirigir o devolver un error según sea necesario
            return redirect()->route('pagina_no_autorizada'); // Cambia 'pagina_no_autorizada' por la ruta de tu elección
        }

        return $next($request);
    }
}
