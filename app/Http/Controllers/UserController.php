<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('activacion', 1)->orderBy('name', 'asc')->simplePaginate(100);
        $provincias = DB::table('Provincias')->pluck('Provincia', 'Id');
        return view('usuarios.index', compact('users','provincias'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $provincias = DB::table('Provincias')->pluck('Provincia', 'Id');
        return view('usuarios.create', compact('user', 'provincias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'usuario' => ['required', 'string', 'max:255', 'unique:users'], // Nueva validación para el campo 'usuario'
            'id_provincia' => 'required|exists:Provincias,Id',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telefonos = $request->telefonos;
        $user->usuario = $request->usuario;
        $user->id_provincia = $request->id_provincia;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('usuarios.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $provincias = DB::table('Provincias')->pluck('Provincia', 'Id');
        // print_r($user);die();
        return view('usuarios.edit', compact('user', 'provincias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:6',
            'id_provincia' => 'required|exists:Provincias,Id',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telefonos = $request->telefonos;
        $user->id_provincia = $request->id_provincia;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('casos.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Perform logout and clear session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function perform()
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }




    public function login(Request $request)
    {
        $correo = $request->correo;
        $password = $request->password;
        // print_r($correo);die();
        
        $data = DB::select("SELECT TOP 1 * from users where email = '$correo';");
        // print_r($data);die();

        $hashedPassword = $data[0]->password; 

        if (Hash::check($password, $hashedPassword)) {
            return json_encode($data);
        } else {
            
            return json_encode('Credenciales incorrecta');
        }
    }
}
