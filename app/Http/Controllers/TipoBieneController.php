<?php

namespace App\Http\Controllers;

use App\Models\TipoBiene;
use Illuminate\Http\Request;

/**
 * Class TipoBieneController
 * @package App\Http\Controllers
 */
class TipoBieneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoBienes = TipoBiene::paginate();

        return view('tipo_biene.index', compact('tipoBienes'))
            ->with('i', (request()->input('page', 1) - 1) * $tipoBienes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipoBiene = new TipoBiene();
        return view('tipo_biene.create', compact('tipoBiene'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 

        $tipoBiene = TipoBiene::create($request->all());

        return redirect()->route('tipo_bienes.index')
            ->with('success', 'TipoBiene created successfully.');
    } 

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoBiene = TipoBiene::find($id);

        return view('tipo_biene.show', compact('tipoBiene'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoBiene = TipoBiene::find($id);

        return view('tipo_biene.edit', compact('tipoBiene'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  TipoBiene $tipoBiene
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoBiene $tipoBiene)
    {
        request()->validate(TipoBiene::$rules);

        $tipoBiene->update($request->all());

        return redirect()->route('tipo_bienes.index')
            ->with('success', 'TipoBiene updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tipoBiene = TipoBiene::find($id)->delete();

        return redirect()->route('tipo_bienes.index')
            ->with('success', 'TipoBiene deleted successfully');
    }





}
