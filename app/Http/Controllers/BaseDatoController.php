<?php

namespace App\Http\Controllers;

use App\Models\BaseDato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


/**
 * Class BaseDatoController
 * @package App\Http\Controllers
 */
class BaseDatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_dp = auth()->user()->id_dp;
        $vig = 'Vigente';

        $baseDatos = DB::table('Base_Datos as b')
        ->select('b.id', 'Tipo_Doc', 'Documento', 'Nombre', 'Celular')
        ->distinct() // Añade distinct() aquí para seleccionar valores únicos
        ->join('contratos as cc', 'b.Documento', '=', 'cc.No_Documento')
        ->where('cc.Id_Dp', $id_dp)
        ->where('cc.Estado', $vig)
        ->simplePaginate(100);

        return view('base-dato.index', compact('baseDatos'))
            ->with('i', (request()->input('page', 1) - 1) * $baseDatos->perPage());
    }

    public function misdatos()
    {        
        $cc = auth()->user()->usuario; 
        $baseDato = BaseDato::where('Documento',$cc)->get();
    //    print_r($baseDato);die();
        $baseDato =  $baseDato[0];

        return view('base-dato.edit', compact('baseDato'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $baseDato = new BaseDato();


        return view('base-dato.create', compact('baseDato'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        $documento = $request->Documento;
        $archivofirma = $request->file('firma');
        // print_r($archivofirma);die();
        // Generar un nombre de archivo único

        request()->validate(BaseDato::$rules);
        $baseDato = BaseDato::create($request->all()); 

        if ($archivofirma != ''){
        $nombreArchivo = $documento .'.' .$archivofirma->getClientOriginalExtension();
        
        // Guardar el archivo en storage/app/doc_cuenta
        $rutaAlmacenamiento = 'public/Firmas';
        $archivofirma->storeAs($rutaAlmacenamiento, $nombreArchivo);

        // Obtener la URL del archivo almacenado
        $rutaCompleta = Storage::path($rutaAlmacenamiento . '/' . $nombreArchivo);

        $idbd = $baseDato->id;
        $updateid = DB::update("update base_datos set firma = '$rutaCompleta' where id= $idbd ");
        }

        return redirect()->route('base-datos.index')
            ->with('success', 'BaseDato created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $baseDato = BaseDato::find($id);

        return view('base-dato.show', compact('baseDato'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $baseDato = BaseDato::find($id);

        return view('base-dato.edit', compact('baseDato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  BaseDato $baseDato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BaseDato $baseDato)
    {
        request()->validate(BaseDato::$rules);

        $baseDato->update($request->all());

        return redirect()->route('base-datos.index')
            ->with('success', 'BaseDato updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $baseDato = BaseDato::find($id)->delete();

        return redirect()->route('base-datos.index')
            ->with('success', 'BaseDato deleted successfully');
    }
}
