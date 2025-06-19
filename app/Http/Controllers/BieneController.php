<?php

namespace App\Http\Controllers;

use App\Models\Biene;
use Illuminate\Http\Request;
use App\Models\Objeto;
use App\Models\Tipo_Bienes;
use App\Models\Valoracione;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\CaracteristicasBien; 




class BieneController extends Controller
{
    public function index(Request $request)
    {
        $id_Caso = $request->get('id_caso');
        $ramo = $request->input('ramo');
        $biene = DB::table('ver_bienes')
                    ->where('id_caso', $id_Caso)
                    ->paginate(10);
 
        return view('biene.index', compact('biene', 'id_Caso' , 'ramo'));
    }

    public function create(Request $request)
    {
 
        $id_Caso = $request->input('id_caso'); 
        $ramo = $request->input('ramo');
        
        $biene = new Biene();
        $Objeto = Objeto::where('id_ramo', $ramo)
                ->pluck('descripcion', 'id');
        $TipoB = Tipo_Bienes::pluck('tipo', 'id') ;
        $valoraciones = collect();
        $caracteristicas = collect();
        $imagenes = [];

        return view('biene.create', compact('biene', 'valoraciones', 'id_Caso', 'Objeto', 'TipoB', 'imagenes','caracteristicas'));
    }

    public function edit($id)
    {
        $biene = Biene::with('objetoRelacionado')->findOrFail($id);
        $valoraciones = Valoracione::where('id_bien', $biene->id_bien)->paginate(10);
        $caracteristicas = CaracteristicasBien::where('id_bien', $biene->id_bien)->get();
        $id_Caso = $biene->id_caso;
        $Objeto = Objeto::pluck('descripcion', 'id');
        $TipoB = Tipo_Bienes::pluck('tipo', 'id');
        $imagenes = Image::where('id_bien', $id)->get(); 

        return view('biene.edit', compact('biene', 'valoraciones', 'id_Caso', 'Objeto', 'TipoB', 'imagenes','caracteristicas'));
    }
 

    public function store(Request $request)
    { 
        DB::beginTransaction();
        try {
            /* 1) Crear bien */
            $biene = Biene::create($request->only([
                'id_caso', 'bien_asegurado', 'objeto', 'tipo', 'detalles'
            ]));               

            /* 2) Valoraciones */
            if ($request->filled('valoraciones')) {
                foreach ($request->input('valoraciones') as $v) {
                    if (!empty($v['descripcion'])) {
                        Valoracione::create([
                            'id_bien'        => $biene->id_bien,
                            'descripcion'    => $v['descripcion'],
                            'cant'           => $v['cant']           ?? 0,
                            'valor_cotizado' => $v['valor_cotizado'] ?? 0,
                            'valor_aprobado' => $v['valor_aprobado'] ?? 0,
                        ]);
                    }
                }
            }

            /* 3) Características */
            if ($request->filled('caracteristicas')) {
                foreach ($request->input('caracteristicas') as $c) {
                    // evitar filas vacías
                    if (!empty($c['caracteristica']) || !empty($c['valor'])) {
                        CaracteristicasBien::create([
                            'id_bien'        => $biene->id_bien,
                            'caracteristica' => $c['caracteristica'],
                            'valor'          => $c['valor'] ?? '',
                        ]);
                    }
                }
            }

            \Log::info('Carac:', $request->input('caracteristicas'));
 

            DB::commit();
            return redirect()
                    ->route('bienes.index', ['id_caso' => $biene->id_caso])
                    ->with('success', 'Bien creado con características.');

                    
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Error: ' . $e->getMessage())
                         ->withInput();
        }
    }

    /* =======================================================
     *  UPDATE
     * ======================================================= */
    public function update(Request $request, $id_bien)
    {
        $biene = Biene::findOrFail($id_bien); 

        $id_caso = $biene->id_caso;

        DB::beginTransaction();
        try {
            /* 1) Actualizar datos básicos */
            $biene->update($request->only([
                'bien_asegurado', 'detalles', 'objeto', 'tipo'
            ]));

            /* 2) Valoraciones */
            $keep = [];
            if ($request->filled('valoraciones')) {
                foreach ($request->input('valoraciones') as $key => $v) {
                    if (!empty($v['descripcion'])) {
                        if (is_numeric($key)) {
                            Valoracione::where('id', $key)->update([
                                'descripcion'    => $v['descripcion'],
                                'cant'           => $v['cant'] ?? 0,
                                'valor_cotizado' => $v['valor_cotizado'] ?? 0,
                                'valor_aprobado' => $v['valor_aprobado'] ?? 0,
                            ]);
                            $keep[] = (int) $key;
                        } else {
                            $keep[] = Valoracione::create([
                                'id_bien'        => $biene->id_bien,
                                'descripcion'    => $v['descripcion'],
                                'cant'           => $v['cant'] ?? 0,
                                'valor_cotizado' => $v['valor_cotizado'] ?? 0,
                                'valor_aprobado' => $v['valor_aprobado'] ?? 0,
                            ])->id;
                        }
                    }
                }
            }
            Valoracione::where('id_bien', $biene->id_bien)
                       ->whereNotIn('id', $keep)->delete();

            /* 3) Características */
            CaracteristicasBien::where('id_bien', $biene->id_bien)->delete();
            if ($request->filled('caracteristicas')) {
                foreach ($request->input('caracteristicas') as $c) {
                    if (!empty($c['caracteristica']) || !empty($c['valor'])) {
                        CaracteristicasBien::create([
                            'id_bien'        => $biene->id_bien,
                            'caracteristica' => $c['caracteristica'],
                            'valor'          => $c['valor'] ?? '',
                        ]);
                    }
                }
            }
 

            DB::commit();
            return redirect()
                ->route('bienes.index', ['id_caso' => $id_caso])
                ->with('success', 'Bien actualizado con sus características y valoraciones.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Error: ' . $e->getMessage())
                         ->withInput();
        }
    }

    public function show($id)
    {
        $biene = Biene::find($id);
        $Objeto = Objeto::pluck('descripcion', 'id');
        $TipoB = Tipo_Bienes::pluck('tipo', 'id');

        if (!$biene) {
            return redirect()->route('bienes.index')->with('error', 'Biene no encontrado.');
        }

        return view('biene.show', compact('biene'));
    }

    public function destroy($id)
    {
        Valoracione::where('id_bien', $id)->delete();
        Biene::where('id_bien', $id)->delete();

        return redirect()->back()->with('success', 'Eliminado con éxito.');
    }

    public function storeImages(Request $request, $id_bien)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:2048',
            'description' => 'required|string|max:255',
        ]);

        $path = $request->file('image')->store('images', 'public');

        Image::create([
            'id_bien' => $id_bien,
            'file_path' => $path,
            'description' => $request->description ?? 'Sin descripción',
        ]);

        return back()->with('success', 'Imagen subida correctamente.');
    }

    public function destroyImage($id)
    {
        $imagen = Image::findOrFail($id);
        Storage::disk('public')->delete($imagen->file_path);
        $imagen->delete();

        return back()->with('success', 'Imagen eliminada correctamente.');
    }

    public function subirPdf(Request $request)
    {
        if ($request->hasFile('valoraciones.pdf') && $request->file('valoraciones.pdf')->isValid()) {
            $valoracionId = $request->input('valoraciones.id');
            $file = $request->file('valoraciones.pdf');
            $filename = 'pdf_' . $valoracionId . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('documentos', $filename, 'public');

            return response()->json(['success' => 'PDF subido correctamente', 'path' => $path]);
        }

        return response()->json(['error' => 'No se ha seleccionado un archivo válido'], 400);
    }


    public function getObjeto(Request $request)
    {
        $TipoB = DB::table('tipo_bienes')
            ->where('id_bien', $request->objeto)
            ->select('tipo', 'id')
            ->get();
  
        return response()->json($TipoB);
    }
    

    public function getCaracteristicas(Request $request)
    {
        // Validamos que se haya enviado el parámetro "tipo_id"
        $tipoId = $request->input('tipo_id');
        
        // Buscamos el registro del tipo en la tabla tipo_bienes
        // y obtenemos el campo "caracteristicas"
        $tipo = DB::table('tipo_bienes')
                 ->where('id', $tipoId)
                 ->select('caracteristicas')
                 ->first();
        
        // Si el registro no se encuentra, retornamos un JSON con las características vacías y un código 404
        if (!$tipo) {
            return response()->json(['caracteristicas' => ''], 404);
        }
        
        // Retornamos la característica en formato JSON
        return response()->json(['caracteristicas' => $tipo->caracteristicas]);
    }
    

}
