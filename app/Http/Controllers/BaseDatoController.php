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
    public function index(Request $request)
    {
        $id_dp = auth()->user()->id_dp;
        $query = $request->input('query');
    
        $baseDatos = collect(); // colección vacía por defecto
    
        if ($query) {
            // 1) Partimos la cadena por espacios (puede haber varios espacios seguidos)
            $terms = preg_split('/\s+/', trim($query));
    
            $baseDatos = DB::table('Base_Datos as b')
                ->select('b.id', 'b.Tipo_Doc', 'b.Documento', 'b.Nombre', 'b.Celular')
                ->leftJoin('contratos as cc', function ($join) use ($id_dp) {
                    $join->on('b.Documento', '=', 'cc.No_Documento')
                         ->where('cc.Id_Dp', $id_dp);
                })
                ->where(function($q) use ($terms) {
                    foreach ($terms as $term) {
                        $q->where(function($sub) use ($term) {
                            $sub->where('b.Nombre', 'like', "%{$term}%")
                                ->orWhere('b.Documento', 'like', "%{$term}%");
                        });
                    }
                })
                ->distinct()
                ->paginate(50);
        }
    
        return view('base-datos.index', compact('baseDatos', 'query'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $baseDato = new BaseDato(); 

        return view('base-datos.create', compact('baseDato'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(BaseDato::$rules + [
            'firma' => 'nullable|file|mimes:jpg,png|max:2048',
        ]);
    
        $baseDato = BaseDato::create($request->all());
    
        if ($request->hasFile('firma')) {
            $documento = $request->Documento;
            $archivoFirma = $request->file('firma');
            $nombreArchivo = $documento . '_' . time() . '.' . $archivoFirma->getClientOriginalExtension();
    
            // Guardar en public/storage/firmas
            $archivoFirma->storeAs('public/firmas', $nombreArchivo);
    
            // Guardar la ruta relativa (sin "public/"), ya que se puede acceder a ella desde la URL pública
            $rutaAlmacenada = 'firmas/' . $nombreArchivo;
            $baseDato->update(['firma' => $rutaAlmacenada]);
        }
    
        return redirect()->route('base-datos.index')
            ->with('success', 'BaseDato creado exitosamente.');
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

        return view('base-datos.show', compact('baseDato'));
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

        return view('base-datos.edit', compact('baseDato'));
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
         $request->validate(BaseDato::$rules + [
             'firma' => 'nullable|file|mimes:jpg,png|max:2048',
         ]);
     
         $data = $request->all();
     
         if ($request->hasFile('firma')) {
             $documento = $request->Documento ?? $baseDato->Documento;
             $archivoFirma = $request->file('firma');
             $nombreArchivo = $documento . '_' . time() . '.' . $archivoFirma->getClientOriginalExtension();
     
             // Eliminar firma anterior si existe
             if ($baseDato->firma && Storage::exists('public/' . $baseDato->firma)) {
                 Storage::delete('public/' . $baseDato->firma);
             }
     
             // Guardar nueva firma en public/storage/firmas
             $archivoFirma->storeAs('public/firmas', $nombreArchivo);
             $data['firma'] = 'firmas/' . $nombreArchivo;
         }
     
         $baseDato->update($data);
     
         return redirect()
             ->route('base-datos.edit', $baseDato->id)
             ->with('success', 'Registro actualizado correctamente.');
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

    public function misdatosRedirect()
    {
        // Número de documento del usuario autenticado
        $documento = auth()->user()->usuario;
    
        // Busca el id en Base_Datos
        $id = DB::table('Base_Datos')
            ->where('Documento', $documento)
            ->value('id'); // Ajusta el nombre de la PK si es distinto
    
        if (! $id) {
            abort(404, 'No se encontraron tus datos para editar.');
        }
    
        return redirect()->route('base-datos.edit', $id);
    }

    public function verFirma($id)
    {
        $registro = BaseDato::findOrFail($id);
    
        if (!$registro->firma || !Storage::exists($registro->firma)) {
            abort(404);
        }
    
        return response()->file(storage_path('app/' . $registro->firma));
    }
}
