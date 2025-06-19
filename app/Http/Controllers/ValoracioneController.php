<?php

namespace App\Http\Controllers;

use App\Models\Valoracione;
use Illuminate\Http\Request;

/**
 * Class ValoracioneController
 * @package App\Http\Controllers
 */
class ValoracioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $valoraciones = Valoracione::paginate();

        return view('valoracione.index', compact('valoraciones'))
            ->with('i', (request()->input('page', 1) - 1) * $valoraciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $valoracione = new  Valoracione ();
         
        return view('valoracione.create', compact('valoracione' ));
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
            'id_bien' => 'required|exists:bienes,id',
            'descripcion' => 'required|string|max:255',
            // Agregar validaciones para otros campos
        ]);
    
        Valoracione::create($request->all());
    
        return redirect()->route('valoraciones.index')
            ->with('success', 'Valoración creada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $valoracione = Valoracione::find($id);

        return view('valoracione.show', compact('valoracione'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $valoracione = Valoracione::find($id);

        return view('valoracione.edit', compact('valoracione'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Valoracione $valoracione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Valoracione $valoracione)
    {
        request()->validate(Valoracione::$rules);

        $valoracione->update($request->all());

        return redirect()->route('valoraciones.index')
            ->with('success', 'Valoracione updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $valoracione = Valoracione::find($id)->delete();

        return redirect()->route('valoraciones.index')
            ->with('success', 'Valoracione deleted successfully');
    }
}
