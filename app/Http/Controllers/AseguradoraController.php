<?php

namespace App\Http\Controllers;

use App\Models\Aseguradora;
use Illuminate\Http\Request;
use App\Models\Ramo;  

/**
 * Class AseguradoraController
 * @package App\Http\Controllers
 */
class AseguradoraController extends Controller
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
        $query = Aseguradora::query();
        
        // Solo aplicamos el filtro si se seleccionó un ramo y no está vacío
        if ($request->has('id_ramo') && $request->id_ramo != '') {
            $query->where('id_ramo', $request->id_ramo);
        }
        
        $aseguradoras = $query->simplePaginate(20);

        return view('aseguradora.index', compact('aseguradoras', 'ramos'))
            ->with('i', (request()->input('page', 1) - 1) * $aseguradoras->perPage());
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Aseguradora::$rules);

        $aseguradora = Aseguradora::create($request->all());

        return redirect()->route('aseguradoras.index')
            ->with('success', 'Aseguradora created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aseguradora = Aseguradora::find($id);

        return view('aseguradora.show', compact('aseguradora'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aseguradora = new Aseguradora();
        $ramos = Ramo::pluck('ramo', 'id'); // Obtiene la lista de ramos para el select
        return view('aseguradora.create', compact('aseguradora', 'ramos'));
    }
    
    public function edit($id)
    {
        $aseguradora = Aseguradora::find($id);
        $ramos = Ramo::pluck('ramo', 'id'); // Obtiene la lista de ramos para el select
        return view('aseguradora.edit', compact('aseguradora', 'ramos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Aseguradora $aseguradora
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aseguradora $aseguradora)
    {
        request()->validate(Aseguradora::$rules);

        $aseguradora->update($request->all());

        return redirect()->route('aseguradoras.index')
            ->with('success', 'Aseguradora updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $aseguradora = Aseguradora::find($id)->delete();

        return redirect()->route('aseguradoras.index')
            ->with('success', 'Aseguradora deleted successfully');
    }
}
