<?php

namespace App\Http\Controllers;

use App\Models\Ramo;
use Illuminate\Http\Request;

/**
 * Class RamoController
 * @package App\Http\Controllers
 */
class RamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ramos = Ramo::simplePaginate(20);

        return view('ramo.index', compact('ramos'))
            ->with('i', (request()->input('page', 1) - 1) * $ramos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ramo = new Ramo();
        return view('ramo.create', compact('ramo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Ramo::$rules);

        $ramo = Ramo::create($request->all());

        return redirect()->route('ramos.index')
            ->with('success', 'Ramo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ramo = Ramo::find($id);

        return view('ramo.show', compact('ramo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ramo = Ramo::find($id);

        return view('ramo.edit', compact('ramo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Ramo $ramo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ramo $ramo)
    {
        request()->validate(Ramo::$rules);

        $ramo->update($request->all());

        return redirect()->route('ramos.index')
            ->with('success', 'Ramo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $ramo = Ramo::find($id)->delete();

        return redirect()->route('ramos.index')
            ->with('success', 'Ramo deleted successfully');
    }
}
