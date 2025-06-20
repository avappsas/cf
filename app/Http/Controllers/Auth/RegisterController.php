<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\BaseDato;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        //['name','email','usuario','activacion','perfil','foto']   bcrypt($request->password)
        //print_r(Hash::make($data['password']));die();

        $user =User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'usuario' => $data['usuario'],
            'password' => Hash::make($data['password']),
            'activacion' => '1'
            //Hash::make($data['password']), 
        ]);

        $id_user =$user->id;
        
        DB::update("insert into UserPerfil  select  $id_user as idUser, 2 as idPerfil ");

        BaseDato::firstOrCreate(
            ['Documento' => $user->usuario],           
            [
              'Nombre' => $user->name,
              'Correo' => $user->email, 
            ] ); 
        return $user;

    }
}
