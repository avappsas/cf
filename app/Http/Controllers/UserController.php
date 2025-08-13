<?php

namespace App\Http\Controllers;

use App\Models\Lidere;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
 
    public function index(Request $request)
    {
         

        $search = $request->input('search');
    
        $users = User::select(
            'U.id',
            'name',
            'email',
                'usuario',
                'dependencia',
            DB::raw("STUFF((
                SELECT ', ' + P.PERFIL
                FROM perfiles AS P
                INNER JOIN UserPerfil AS UP ON P.id = UP.idPerfil
                WHERE UP.idUser = U.id
                ORDER BY P.PERFIL
                FOR XML PATH(''), TYPE
            ).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS PERFILES")
            )
            ->from('users as U')
            ->when($search, function($q) use ($search) {
                $q->where('U.usuario', 'like', "%{$search}%")
                  ->orWhere('U.name', 'like', "%{$search}%");
            })  
            ->orderBy('U.id', 'asc')
            ->simplePaginate(30);
             
               
        return view('user.index', compact('users', 'search'))
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

        $perfiles = collect();

        $perfilesDisponibles = DB::table('perfiles')
            ->orderBy('PERFIL')
            ->pluck('PERFIL', 'id');

        $perfilesUsuario = []; // No hay perfiles aún porque es un nuevo usuario

        // Opcional: restringe si el usuario autenticado puede asignar perfiles
        $puedeEditarPerfiles = DB::table('UserPerfil')
            ->where('idUser', auth()->id())
            ->where('idPerfil', 1) // solo si tiene perfil ID 1
            ->exists();

        return view('user.create', compact('user', 'perfiles' ,'perfilesDisponibles', 'perfilesUsuario', 'puedeEditarPerfiles'));
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
            'usuario'     => 'required|string|max:50|unique:users,usuario',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',
            'fotoPerfil'  => 'nullable|image|max:2048',
        ]);

        $user = new User();
        $user->usuario  = $request->usuario;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->activacion = $request->activacion ?? 1;
        $user->id_dp      = $request->id_dp ?? 1;
        $user->pro        = $request->pro ?? 1;
        $user->id_buzon   = $request->id_buzon; 

        // Foto de perfil
        if ($request->hasFile('fotoPerfil')) {
            $path = $request->file('fotoPerfil')->storeAs(
                'fotoPerfil',
                $request->usuario . '.' . $request->file('fotoPerfil')->getClientOriginalExtension(),
                'public'
            );
            $user->foto = $path;
        }

        // Primero guardamos el usuario para obtener el ID
        $user->save();

        // Verificar si ya existe en Base_Datos
        $existe = DB::table('Base_Datos')->where('Documento', $user->usuario)->exists();

        if (!$existe) {
            DB::table('Base_Datos')->insert([
                'Documento' => $user->usuario,
                'Nombre'    => $user->name,
                'Correo'    => $user->email,
            ]);
        }

        // Luego insertamos los perfiles (si se seleccionaron)
        if ($request->has('perfiles')) {
            foreach ($request->perfiles as $idPerfil) {
                DB::table('UserPerfil')->insert([
                    'idUser'   => $user->id,
                    'idPerfil' => $idPerfil,
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }


    public function ActualizarFoto(Request $request)
    {
        $idUsuario = auth()->user()->usuario;
        //$request->archivo->getClientOriginalExtension();
        $image = $request->file('fotoPerfil');
        $nombreImagen = $idUsuario .'.'.$image->getClientOriginalExtension();
        $path = $request->file('fotoPerfil')->storeAs(
            'fotoPerfil', $nombreImagen,'public'
        );

        DB::transaction(function () use ($path, $idUsuario) {
            // Update the Lideres table
            DB::update('update Lideres set foto = ? where cedula = ?', [$path, $idUsuario]);

            // Update the Users table
            DB::table('users')
                ->where('usuario', $idUsuario)
                ->update(['foto' => $path]);
        });

        return $path;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function CrearUsuario(Request $request)
    {
        $id = $request->id;
        //print_r($request->id);die();
        $data = DB::update("EXEC [crearUsuario] @CEDULA = N'$id';");

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
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

    $foto = $user->foto ?? 'fotoPerfil/perfilDefault.png';

    $perfiles = DB::table('perfiles AS P')
        ->select('P.id', 'P.PERFIL')
        ->join('UserPerfil AS UP', 'P.id', '=', 'UP.idPerfil')
        ->where('UP.idUser', '=', $id)
        ->orderBy('P.PERFIL')
        ->get();

    $puedeEditarPerfiles = DB::table('UserPerfil')
        ->where('idUser', auth()->id())
        ->where('idPerfil', 1)
        ->exists();

    $perfilesDisponibles = DB::table('perfiles')
        ->orderBy('PERFIL')
        ->pluck('PERFIL', 'id'); // [id => PERFIL]

    $perfilesUsuario = $perfiles->pluck('id')->toArray();

    return view('user.edit', compact(
        'user', 'foto', 'perfiles',
        'puedeEditarPerfiles', 'perfilesDisponibles', 'perfilesUsuario'
    ));
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Users $user
     * @return \Illuminate\Http\Response
     */


public function update(Request $request, $id)
{
    // 1. Validar campos
    $request->validate([
        'name'        => 'required|string|max:255',
        'email'       => 'required|email',
        'password'    => 'nullable|string|min:6',
        'fotoPerfil'  => 'nullable|image|max:2048',
        'perfiles'    => 'nullable|array', // si no hay perfiles no pasa nada
    ]);

    // 2. Buscar usuario
    $user = User::findOrFail($id);

    // 3. Iniciar transacción para asegurar integridad de los datos
    DB::transaction(function() use ($request, $user) {
        // 3.1. Guardar la foto si se subió
        if ($request->hasFile('fotoPerfil')) {
            $file = $request->file('fotoPerfil');
            $filename = $user->usuario . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('storage/fotoPerfil');
            $file->move($destinationPath, $filename);
            $path = 'fotoPerfil/' . $filename;

            // Actualizar foto en tabla users
            DB::table('users')
                ->where('usuario', $user->usuario)
                ->update(['foto' => $path]);

            $user->foto = $path;
        }

        // 3.2. Actualizar campos básicos
        $user->name = $request->name;
        $user->email = $request->email;

        // 3.3. Si se cambió la contraseña
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // 3.4. Guardar cambios
        $user->save();

        // 3.5. Actualizar perfiles si fueron enviados
        if ($request->has('perfiles')) {
            DB::table('UserPerfil')->where('idUser', $user->id)->delete();

            foreach ($request->perfiles as $idPerfil) {
                DB::table('UserPerfil')->insert([
                    'idUser'   => $user->id,
                    'idPerfil' => $idPerfil,
                ]);
            }
        }
    });

    // 4. Redirigir con éxito
    return redirect()->route('usuarios.edit', $user->id)
                     ->with('success', 'Datos actualizados correctamente');
}


    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */

    public function destroy($id)
    {
        $usuario = User::where('id', $id)->value('usuario');
        //$user = User::find($id)->delete();
        $user = User::where('id', $id)->update(array('activacion' => 2,'password' => bcrypt($usuario)));

        return redirect()->back()
            ->with('Completo', 'El usuario fue activado correctamente!');
    }

    public function cerrarSeccion(){
        Auth::logout();
        return redirect('home');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
