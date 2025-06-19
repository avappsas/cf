<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use DB;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        return view('home');
    }

    public function obtenerMenu()
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Obtener el perfil del usuario autenticado
            $idUsuario = Auth::user()->id; // Ajusta el acceso al perfil del usuario según tu lógica de aplicación
        
            // Obtener los elementos del menú desde la base de datos según el perfil del usuario
            $menu = DB::table('Menu as a')
                    ->select('a.*')
                    ->join('MenuPerfil as b', 'a.id', '=', 'b.idMenu')
                    ->join('UserPerfil as c', 'b.idPerfil', '=', 'c.idPerfil')
                    ->where('c.iduser', $idUsuario)->get();
        
            return $menu;
        } else {
            // Si el usuario no está autenticado, devuelve un valor vacío o nulo
            return null; // O un valor vacío, dependiendo de tus necesidades
        }
    }
}
