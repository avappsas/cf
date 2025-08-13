<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Make sure to import the DB facade
use Illuminate\Support\Facades\Log; // Optional: For logging errors
use Illuminate\Validation\ValidationException; // For handling validation errors specifically
use Carbon\Carbon; // <--- ESTA LÍNEA ES LA IMPORTANTE Y PROBABLEMENTE FALTA O ES INCORRECTA
use App\Models\Bitacora;
use App\Models\Cuota;


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
                $validatedData = $request->validate([
                    'Entrada' => 'required|numeric|min:0',
                ]);

                $affectedRows = DB::table('cuotas')
                    ->where('Id', $id)
                    ->update(['Entrada' => $validatedData['Entrada']]);

                // Si es AJAX/JSON: responder JSON
                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => $affectedRows > 0,
                        'message' => $affectedRows > 0 ? 'Actualizado' : 'Sin cambios'
                    ]);
                }

                // Si no es AJAX, usar redirect tradicional
                return redirect()->back()->with(
                    $affectedRows > 0 ? 'success' : 'info',
                    $affectedRows > 0 ? 'Entrada actualizada correctamente.' : 'No se realizaron cambios en la entrada.'
                );

            } catch (ValidationException $e) {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'errors' => $e->errors()], 422);
                }
                return redirect()->back()->withErrors($e->errors())->withInput();

            } catch (\Exception $e) {
                Log::error('Error al actualizar la entrada para cuota ID ' . $id . ': ' . $e->getMessage());

                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Error interno'], 500);
                }

                return redirect()->back()->with('error', 'Ocurrió un error al actualizar la entrada.');
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
  
    public function actualizarEntrada(Request $request)
    {
        $request->validate([
            'idCuota' => 'required|integer',
            'entrada' => 'nullable|numeric'
        ]);

        $actualizado = DB::table('cuotas')
            ->where('id', $request->idCuota)
            ->update(['Entrada' => $request->entrada]);

        return response()->json(['success' => $actualizado]);
    }

 
    public function aprobarLoteCuotas(Request $request)
    {
        $idLote = $request->input('idLote');
        $idUsuario = auth()->id();

        try {
            // 1. Obtener todas las cuotas del lote
            $cuotas = Cuota::where('FUID', $idLote)->get();

            if ($cuotas->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'No hay cuotas asociadas al lote.']);
            }

            foreach ($cuotas as $cuota) {
                // Obtener siguiente estado desde tabla de cambios
                $idEstadoActual = $cuota->idEstado;
                $nuevoEstado = DB::table('Cambio_estado')->where('id', $idEstadoActual)->value('pos_estado');

                $nuevoEstadoTexto = DB::table('Cambio_estado')->where('id', $nuevoEstado)->value('EstadoInterno');

                if ($nuevoEstadoTexto) {
                    // Actualizar estado_juridica de la cuota
                        $cuota->Estado_juridica = $nuevoEstadoTexto;
                        $cuota->idEstado = $nuevoEstado;
                        $cuota->save();


                if (!$cuota->wasChanged()) {
                    \Log::warning("La cuota {$cuota->Id} no se actualizó. Estado actual: {$cuota->estado_juridica}, idEstado: {$cuota->id_estado}");
                }

                    // Registrar en bitácora
                    Bitacora::create([
                        'id_usuario'     => $idUsuario,
                        'nombre_usuario' => auth()->user()->name ?? 'Desconocido',
                        'accion'         => 'Cambio estado juridica',
                        'modulo'         => 'Cuotas',
                        'Estado_interno' => $nuevoEstadoTexto,
                        'detalles'       => 'Cambio automático por aprobación de lote',
                        'idContrato'     => $cuota->Contrato ?? null,
                        'idCuota'        => $cuota->Id,
                        'id_dp'          => auth()->user()->id_dp ?? null,
                        'fecha'          => now(),
                        'ip'             => request()->ip(),
                        'user_agent'     => request()->userAgent(),
                        'ruta'           => request()->path(),
                        'metodo'         => request()->method(),
                    ]);
                }
            }

            // Obtener estado actual del lote
            $estadoActual = DB::table('lotes')->where('id', $idLote)->value('estado');

            // Determinar nuevo estado
            $nuevoEstado =  'Pendiente Z-Control';

            // Actualizar lote con el nuevo estado
            DB::table('lotes')
                ->where('id', $idLote)
                ->update(['estado' => $nuevoEstado]); 
                
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Error aprobando lote: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error interno.']);
        }
    }
     


}