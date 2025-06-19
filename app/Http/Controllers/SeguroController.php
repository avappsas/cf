<?php

namespace App\Http\Controllers;

use App\Models\Seguro;
use Illuminate\Http\Request;

/**
 * Class SeguroController
 * @package App\Http\Controllers
 */
class SeguroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seguros = Seguro::simplePaginate(20);

        return view('seguro.index', compact('seguros'))
            ->with('i', (request()->input('page', 1) - 1) * $seguros->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $seguro = new Seguro();
        return view('seguro.create', compact('seguro'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Seguro::$rules);

        $seguro = Seguro::create($request->all());

        return redirect()->route('seguros.index')
            ->with('success', 'Seguro created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seguro = Seguro::find($id);

        return view('seguro.show', compact('seguro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seguro = Seguro::find($id);

        return view('seguro.edit', compact('seguro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Seguro $seguro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seguro $seguro)
    {
        request()->validate(Seguro::$rules);

        $seguro->update($request->all());

        return redirect()->route('seguros.index')
            ->with('success', 'Seguro updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $seguro = Seguro::find($id)->delete();

        return redirect()->route('seguros.index')
            ->with('success', 'Seguro deleted successfully');
    }
}
