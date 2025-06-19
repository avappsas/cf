<?php

namespace App\Http\Controllers;

use App\Models\CaracteristicasBien;
use Illuminate\Http\Request;

/**
 * Class CaracteristicasBienController
 * @package App\Http\Controllers
 */
class CaracteristicasBienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caracteristicasBiens = CaracteristicasBien::paginate();

        return view('caracteristicas-bien.index', compact('caracteristicasBiens'))
            ->with('i', (request()->input('page', 1) - 1) * $caracteristicasBiens->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $caracteristicasBien = new CaracteristicasBien();
        return view('caracteristicas-bien.create', compact('caracteristicasBien'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(CaracteristicasBien::$rules);

        $caracteristicasBien = CaracteristicasBien::create($request->all());

        return redirect()->route('caracteristicas-biens.index')
            ->with('success', 'CaracteristicasBien created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $caracteristicasBien = CaracteristicasBien::find($id);

        return view('caracteristicas-bien.show', compact('caracteristicasBien'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $caracteristicasBien = CaracteristicasBien::find($id);

        return view('caracteristicas-bien.edit', compact('caracteristicasBien'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  CaracteristicasBien $caracteristicasBien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CaracteristicasBien $caracteristicasBien)
    {
        request()->validate(CaracteristicasBien::$rules);

        $caracteristicasBien->update($request->all());

        return redirect()->route('caracteristicas-biens.index')
            ->with('success', 'CaracteristicasBien updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $caracteristicasBien = CaracteristicasBien::find($id)->delete();

        return redirect()->route('caracteristicas-biens.index')
            ->with('success', 'CaracteristicasBien deleted successfully');
    }
}
