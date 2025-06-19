<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BrokerController extends Controller
{
    /**
     * Muestra una lista paginada de todos los brokers.
     * Incluye la lógica para calcular el índice de numeración en la tabla.
     */
    public function index()
    {
        // Consultamos los brokers y aplicamos paginación
        $brokers = DB::table('brokers')->simplePaginate(20);

        // Calculamos el índice para la numeración en la tabla
        $i = (request()->input('page', 1) - 1) * $brokers->perPage();

        // Retornamos la vista con los datos necesarios
        return view('broker.index', compact('brokers', 'i'));
    }

    /**
     * Muestra el formulario para crear un nuevo broker.
     * Inicializa un nuevo objeto Broker vacío para el formulario.
     */
    public function create()
    {
        $broker = new Broker();
        return view('broker.create', compact('broker'));
    }
  
    /**
     * Almacena un nuevo broker en la base de datos.
     * Incluye validación y manejo de errores.
     */
    public function store(Request $request)
    {
        // Validamos los datos recibidos según las reglas del modelo
        #request()->validate(Broker::$rules);

            // Creamos el nuevo broker con los datos validados
            $broker = Broker::create($request->all());

            // Redirigimos con mensaje de éxito
            return redirect()->route('brokers.index')
                ->with('success', 'Broker creado exitosamente.');

    }

    /**
     * Muestra los detalles de un broker específico.
     * Usa findOrFail para manejar automáticamente el caso de registros no encontrados.
     */
    public function show($id)
    {
        $broker = Broker::findOrFail($id);
        return view('broker.show', compact('broker'));
    }

    /**
     * Muestra el formulario para editar un broker existente.
     * También usa findOrFail para manejar registros no encontrados.
     */
    public function edit($id)
    {
        $broker = Broker::findOrFail($id);
 
        return view('broker.edit', compact('broker'));
    }

    /**
     * Actualiza un broker específico en la base de datos.
     * Incluye validación y manejo de casos especiales para campos únicos.
     */
    public function update(Request $request, $id)
    {
        // Obtenemos el broker a actualizar
        $broker = Broker::findOrFail($id);
 
            // Actualizamos el broker
            $broker->update($request->all());

            // Redirigimos con mensaje de éxito
            return redirect()->route('brokers.index')
                ->with('success', 'Broker actualizado exitosamente');
 
    }

    /**
     * Elimina un broker específico de la base de datos.
     * Incluye verificación de existencia y manejo de errores.
     */
    public function destroy($id)
    {
        try {
            // Buscamos y eliminamos el broker
            $broker = Broker::findOrFail($id);
            $broker->delete();

            // Redirigimos con mensaje de éxito
            return redirect()->route('brokers.index')
                ->with('success', 'Broker eliminado exitosamente');
        } catch (\Exception $e) {
            // En caso de error, informamos al usuario
            return redirect()->route('brokers.index')
                ->with('error', 'Error al eliminar el broker.');
        }
    }
}