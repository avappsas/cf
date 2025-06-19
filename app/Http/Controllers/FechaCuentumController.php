<?php

namespace App\Http\Controllers;

use App\Models\FechaCuentum;
use Illuminate\Http\Request;

/**
 * Class FechaCuentumController
 * @package App\Http\Controllers
 */
class FechaCuentumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fechaCuenta = FechaCuentum::paginate();

        return view('fecha_cuenta.index', compact('fechaCuenta'))
            ->with('i', (request()->input('page', 1) - 1) * $fechaCuenta->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fechaCuentum = new FechaCuentum();
        return view('fecha_cuenta.create', compact('fechaCuentum'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(FechaCuentum::$rules);

        $fechaCuentum = FechaCuentum::create($request->all());

        return redirect()->route('fecha_cuenta')
            ->with('success', 'Fecha de cuenta creada satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fechaCuentum = FechaCuentum::find($id);

        return view('fecha_cuenta.show', compact('fechaCuentum'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fechaCuentum = FechaCuentum::find($id);

        return view('fecha_cuenta.edit', compact('fechaCuentum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  FechaCuentum $fechaCuentum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FechaCuentum $fechaCuentum)
    {
        request()->validate(FechaCuentum::$rules);

        $fechaCuentum->update($request->all());

        return redirect()->route('fecha_cuenta')
            ->with('success', 'Fecha de cuenta actualizada correctamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $fechaCuentum = FechaCuentum::find($id)->delete();

        return redirect()->route('fecha_cuenta')
            ->with('success', 'Fecha de cuenta Eliminada');
    }
}
