<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Muestra el formulario de configuración.
     */
    public function index()
    {
        // Ejemplo de opciones; puedes cargarlas desde BD o config.
        $opciones = [
            ['value' => 'op1', 'label' => 'Opción A'],
            ['value' => 'op2', 'label' => 'Opción B'],
            ['value' => 'op3', 'label' => 'Opción C'],
        ];

        return view('configuracion', compact('opciones'));
    }

 
}
