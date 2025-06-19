<?php

namespace App\Http\Controllers;

use App\Models\Causa;
use Illuminate\Http\Request;
use App\Models\Ramo;  

/**
 * Class CausaController
 * @package App\Http\Controllers
 */
class CausaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        // Obtenemos la lista de ramos para el select
        $ramos = Ramo::pluck('ramo', 'id');
            
        // Iniciamos la consulta base
        $query = Causa::query();
        
        // Solo aplicamos el filtro si se seleccionó un ramo y no está vacío
        if ($request->has('id_ramo') && $request->id_ramo != '') {
            $query->where('id_ramo', $request->id_ramo);
        }
        
        $causas = $query->simplePaginate(20);
         
            return view('causa.index', compact('causas','ramos'))
                ->with('i', (request()->input('page', 1) - 1) * $causas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $causa = new Causa();
        $ramos = Ramo::pluck('ramo', 'id');

        return view('causa.create', compact('causa','ramos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
     
        $causa = Causa::create($request->all());
 
        return redirect()->route('causas.index')
            ->with('success', 'Causa created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $causa = Causa::find($id);
        $ramos = Ramo::pluck('ramo', 'id');
        return view('causa.show', compact('causa','ramos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $causa = Causa::findOrFail($id);  // Obtener el objeto 'causa' por su ID
        $ramos = Ramo::pluck('ramo', 'id');
 
        return view('causa.edit', compact('causa','ramos'));  // Pasar 'causa' a la vista
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Causa $causa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Causa $causa)
    {
       

        $causa->update($request->all()); 

        return redirect()->route('causas.index')
            ->with('success', 'Causa updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */


    public function destroy($id)
    {
        $causa = Causa::find($id)->delete();

        return redirect()->route('causas.index')
            ->with('success', 'Causa deleted successfully');
    }
}
