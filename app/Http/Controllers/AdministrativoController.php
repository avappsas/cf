<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Make sure to import the DB facade
use Illuminate\Support\Facades\Log; // Optional: For logging errors
use Illuminate\Validation\ValidationException; // For handling validation errors specifically
use Carbon\Carbon; // <--- ESTA LÍNEA ES LA IMPORTANTE Y PROBABLEMENTE FALTA O ES INCORRECTA

class AdministrativoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $idUser = auth()->user()->id; // This variable is not used in the query

        // Tip: Consider using Laravel's Query Builder or Eloquent for cleaner and more secure queries.
        $cuotas = DB::select('select ct.Id, Contrato, FUID, consecutivo, No_Documento, Nombre, c.RPC, Entrada, ct.Cuota
                                from cuotas ct
                                inner join Contratos c ON ct.Contrato=c.Id
                                inner join Base_Datos b ON b.Documento=c.No_Documento
                                where Estado_juridica = \'APROBADA\'');

        return view('administrativo.Entrada', compact('cuotas'));
    }

    /**
     * Update the Entrada field for a specific cuota.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id The ID of the cuota to update (from the route parameter)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEntrada(Request $request, $id)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'Entrada' => 'required|numeric|min:0', // Ensures 'Entrada' is present, numeric, and not negative
            ]);

            // Attempt to update the record in the 'cuotas' table
            $affectedRows = DB::table('cuotas')
                ->where('Id', $id)
                ->update(['Entrada' => $validatedData['Entrada']]);

            if ($affectedRows > 0) {
                // If the update was successful (at least one row was changed)
                return redirect()->back()->with('success', 'Entrada actualizada correctamente.');
            } else {
                // If no rows were affected (e.g., cuota not found or data was the same)
                return redirect()->back()->with('info', 'No se realizaron cambios en la entrada. Es posible que el valor sea el mismo o la cuota no se encontró.');
            }
        } catch (ValidationException $e) {
            // If validation fails, redirect back with errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log any other errors that occur
            Log::error('Error al actualizar la entrada para cuota ID ' . $id . ': ' . $e->getMessage());
            // Redirect back with a generic error message
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar la entrada. Por favor, inténtelo de nuevo.');
        }
    }


   public function mostrarValeEntrada($id)
    {
        // 1. Obtener los datos de la cuota específica usando el $id
             $cuota = DB::table('cuotas as ct')
            ->join('Contratos as c', 'ct.Contrato', '=', 'c.Id')
            ->join('Base_Datos as b', 'b.Documento', '=', 'c.No_Documento') // El join usa c.No_Documento
            ->select(
                'ct.Id',
                'ct.Contrato',
                'ct.FUID',
                'ct.Cuota',
                'ct.consecutivo',
                'c.No_Documento', // Cambiado: ahora referencia la columna de la tabla Contratos (c)
                'b.Nombre',       // Nombre de Base_Datos
                'c.RPC',
                'ct.Entrada',
                'ct.Cuota as valor_cuota'
                // Añade aquí otros campos que necesites de estas tablas para el vale
            )
            ->where('ct.Id', $id)
            ->first();

        if (!$cuota) {
            // Si no se encuentra la cuota, puedes retornar un error 404 o redirigir
            abort(404, 'Vale de entrada no encontrado.');
        }

        // 2. Preparar las fechas
        $fechaActualServidor = Carbon::now(); // Obtiene la fecha y hora actual

        // 3. Construir el array $datosParaVale con los datos dinámicos
        $datosParaVale = [
            'titulo_vale' => 'VALE DE ENTRADA DE MERCANCÍAS',
            'fecha_em' => $fechaActualServidor->format('d.m.Y'), // Fecha actual formateada
            'fecha_actual' => $fechaActualServidor->format('d.m.Y'), // Fecha actual formateada
            'numero_vale' => $cuota->Entrada, // Cambiado: USA EL CAMPO 'Entrada' DE LA CUOTA
            'pagina' => '1', // Puedes mantenerlo así o hacerlo dinámico si tienes múltiples páginas

            // Estos datos parecen ser más estáticos o de configuración, ajústalos si es necesario
            'centro_codigo' => 'CONC', // Ejemplo, podría venir de otra parte o ser fijo
            'centro_denominacion' => 'concejo municipal', // Ejemplo

            'proveedor_codigo' => $cuota->No_Documento, // Usando No_Documento como un código de proveedor
            'proveedor_nombre' => $cuota->Nombre, // Cambiado: USA EL CAMPO 'Nombre' (de Base_Datos)

            'pedido' => $cuota->RPC, // Cambiado: USA EL CAMPO 'RPC' DEL CONTRATO

            'texto_cabecera' => 'Pago cuota ' . ($cuota->Cuota ?? 'N/A'), // Ejemplo usando el consecutivo de la cuota
            'grp_compras_codigo' => '071', // Ejemplo, podría ser fijo o dinámico
            'grp_compras_denominacion' => 'Concejo Municipal', // Ejemplo
            'telefono' => '6687200', // Ejemplo, o podría venir de algún dato de contacto

            'items' => [
                [
                    // Estos datos del item probablemente también deberían ser dinámicos
                    // Quizás relacionados con la cuota o el contrato.
                    // Por ahora, los dejo como en tu ejemplo, pero necesitarás adaptarlos.
                    'pos' => '0001',
                    'material' => $cuota->FUID ?? 'N/A', // Ejemplo usando FUID como material
                    'denominacion_l1' => 'Servicio asociado a cuota ' . ($cuota->Cuota ?? ''),
                    'denominacion_l2' => 'Ref. Contrato: ' . ($cuota->Contrato ?? ''),
                    'k_l1' => '', // Si tienes un centro de costo o similar para la cuota
                    'cantidad' => '1 UN' // Asumiendo una unidad por cuota
                ],
                // ... más items si los hubiera, basados en la lógica de negocio
            ],
            'emisor' => 'VALERIA', // Ejemplo, podría ser el usuario actual o un valor de configuración
        ];

        // Asegúrate de que el nombre de la vista 'pdfentrada' coincida
        // con el archivo .blade.php que creaste (ej. resources/views/pdfentrada.blade.php)
        return view('Administrativo.pdfentrada', ['datos' => $datosParaVale]);
    }
  
 

}