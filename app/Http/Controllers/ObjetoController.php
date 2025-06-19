<?php

namespace App\Http\Controllers;

use App\Models\Objeto;
use Illuminate\Http\Request;
use App\Models\Ramo;  
/**
 * Class ObjetoController
 * @package App\Http\Controllers
 */
class ObjetoController extends Controller
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
        $query = Objeto::query();
        
        // Solo aplicamos el filtro si se seleccionó un ramo y no está vacío
        if ($request->has('id_ramo') && $request->id_ramo != '') {
            $query->where('id_ramo', $request->id_ramo);
        }
        
        $objetos = $query->simplePaginate(20); 

        return view('objeto.index', compact('objetos', 'ramos'))
            ->with('i', (request()->input('page', 1) - 1) * $objetos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $objeto = new Objeto();
        $ramos = Ramo::pluck('ramo', 'id'); // Obtiene la lista de ramos para el select
        return view('objeto.create', compact('objeto','ramos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    
     public function store(Request $request)

        {
            # request()->validate(Objeto::$rules);

            $objeto = Objeto::create($request->all());

            return redirect()->route('objetos.index')
                ->with('success', 'Objeto created successfully.');
        }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $objeto = Objeto::find($id);

        return view('objeto.show', compact('objeto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $objeto = Objeto::find($id);
        $ramos = Ramo::pluck('ramo', 'id');
        return view('objeto.edit', compact('objeto','ramos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Objeto $objeto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Objeto $objeto)
    {
        request()->validate(Objeto::$rules);

        $objeto->update($request->all());

        return redirect()->route('objetos.index')
            ->with('success', 'Objeto updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $objeto = Objeto::find($id)->delete();

        return redirect()->route('objetos.index')
            ->with('success', 'Objeto deleted successfully');
    }
}
