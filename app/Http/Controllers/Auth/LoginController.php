<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Define el campo que se usará para el login.
     *
     * @return string
     */
    public function username()
    {
        return 'usuario';
    }

    /**
     * Valida el request de login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
 
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'usuario'   => 'required|integer',
            'password'  => 'required|string',
        ], [
            // Mensaje personalizado si no es numérico
            'usuario.integer' => 'El campo Usuario debe ser un número (tu número de documento de identidad).',
        ]);
    }
    /**
     * Personaliza las credenciales para el intento de autenticación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            'usuario' => $request->input('usuario'),
            'password' => $request->input('password'),
            // Puedes añadir aquí más condiciones, por ejemplo:
            // 'activo' => 1,
        ];
    }
}
