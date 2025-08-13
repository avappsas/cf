<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrato;  // Asegúrate de que tu modelo esté aquí
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class InboxController extends Controller
{
    /**
     * Display a listing of contratos con estado "Solicitud CDP".
     */
 
    public function index()
        {
            $id_dp = auth()->user()->id_dp;   
            $idUser = auth()->user()->id;
            $perfil = DB::table('UserPerfil') ->where('idUser', $idUser) ->where('idPerfil', '!=', 2) ->where('idPerfil', '!=', 1) ->orderBy('idPerfil', 'asc') ->pluck('idPerfil') ->toArray();
            $perfiUser = $perfil[0] ?? null;   
            $id_formato = 1;
            $id_formato2 = 1;
                if (is_null($perfiUser)) {
                    return response()->json(['error' => 'No está autorizado para acceder a este recurso.'], 403);
                }

                // Inicializar variables por defecto
                $estado1 = $estado2 = $estado3 = $estadoP = null;

            if ($perfiUser == 4) {   // 4=ADMINISTRATIVO
                $id_formato = 34;
                $id_formato2 = null;
                $estado1 = null;
                $estado2 = ['Solicitud CDP', 'Solicitud CDP-Liberar' ,'Solicitud RPC-A', 'Solicitud CDP-A'];
                $estado3 = ['Solicitud CDP-D', 'Solicitud CDP-PD'];  
                $estadoP  = null;

             }elseif ($perfiUser == 9) {   // 4=EJECUCION ADMINISTRATIVO USER 1 - NIDIA
                $id_formato = 34;
                $id_formato2 = null;
                $estado1 = null; 
                $estado2 = ['Solicitud CDP-Generar', 'Solicitud RPC', 'Solicitud RPC-A1'];
                $estado3 = ['Solicitud CDP-D','Solicitud RPC-D'];  
                $estadoP  = null;

            }elseif ($perfiUser == 13) {   // 4=EJECUCION ADMINISTRATIVO USER 2 - GERALDIN
                $id_formato = 1032;
                $id_formato2 = 1037;
                $estado1 = null; 
                $estado2 = ['Solicitud CDP-Descargar', 'Solicitud RPC', 'Solicitud RPC-A1'];
                $estado3 = null; 
                $estadoP  = ['Subiendo Entrada'];

             }elseif ($perfiUser == 8) {   // 8=PRESIDENCIA
                $id_formato = 1031;
                $id_formato2 = null;
                $estado1 = ['Secop-Presidencia', 'Solicitud RPC-P']; 
                $estado2 = ['Firma Secop-Presidencia', 'Solicitud RPC-P', 'Solicitud CDP-Presidencia', 'Solicitud RPC-PA' ];
                $estado3 = ['Solicitud CDP-D'];  
                $estadoP  = null;

             }elseif ($perfiUser == 10) {   // 10=CONTADURIA
                $id_formato = 1033;
                $id_formato2 = 9;
                $estado1  = null; 
                $estado2  = ['Solicitud RPC-A','Solicitud RPC-P','Solicitud RPC-A1','Solicitud RPC-PA','Solicitud RPC-D','RPC - Aprobado'];
                $estado3  = null; 
                $estadoP  = ['Pendiente Contabilidad'];

             }elseif ($perfiUser == 11) {   // 11=TALENTO HUMANO
                $id_formato = 1034;
                $id_formato2 = null;
                $estado1  = null; 
                $estado2  = ['Solicitud RPC','Solicitud RPC-A','Solicitud RPC-P','Solicitud RPC-A1','Solicitud RPC-PA','Solicitud RPC-D','RPC - Aprobado'];
                $estado3  = null; 
                $estadoP  = null;

             } 

            // SOLICITUDES
            $contratos = Contrato::from('Contratos as c')
                        ->join('Base_Datos as b', 'b.Documento', '=', 'c.No_Documento')
                        ->leftjoin('Oficinas as o', 'c.Oficina', '=', 'o.id')
                        ->leftjoin('Cargue_Archivo as ca', function ($join) use ($id_formato) {
                            $join->on('ca.Id_contrato', '=', 'c.id')
                                 ->where('ca.Id_formato', '=', $id_formato)
                                 ->where('ca.Estado', '!=', 'ANULADO');
                        })
                        ->whereIn('c.Estado_interno', (array)$estado1)
                        ->select('c.*', 'b.Nombre', 'ca.ruta', 'o.Oficina as nombre_oficina')
                        ->paginate(30);
 
            // APROBADOS
            $contratosB = Contrato::from('Contratos as c')
                        ->join('Base_Datos as b', 'b.Documento', '=', 'c.No_Documento') 
                        ->leftjoin('Oficinas as o', 'c.Oficina', '=', 'o.id') 
                        ->leftjoin('Cargue_Archivo as ca', function ($join) use ($id_formato) {
                            $join->on('ca.Id_contrato', '=', 'c.id')
                                 ->where('ca.Id_formato', '=', $id_formato)
                                 ->where('ca.Estado', '!=', 'ANULADO');
                        })
                        ->whereIn('c.Estado_interno', (array)$estado2)
                        ->select('c.*', 'b.Nombre',   'o.Oficina as nombre_oficina', 'ca.Estado')
                        ->paginate(30);

             //DEVUELTOS           
             $contratosC = Contrato::from('Contratos as c')
                        ->join('Base_Datos as b', 'b.Documento', '=', 'c.No_Documento') 
                        ->leftjoin('Oficinas as o', 'c.Oficina', '=', 'o.id')
                        ->join('Cargue_Archivo as ca', function ($join) use ($id_formato) {
                            $join->on('ca.Id_contrato', '=', 'c.id')
                                 ->where('ca.Id_formato', '=', $id_formato)
                                 ->where('ca.Estado', '!=', 'ANULADO'); })
                        ->whereIn('c.Estado_interno', (array)$estado3)
                        ->select('c.*', 'b.Nombre', 'ca.ruta', 'o.Oficina as nombre_oficina')
                        ->paginate(30);    

             //TODOS
             $contratosT = Contrato::from('Contratos as c')
                        ->join('Base_Datos as b', 'b.Documento', '=', 'c.No_Documento') 
                        ->leftjoin('Oficinas as o', 'c.Oficina', '=', 'o.id') 
                        ->whereBetween('c.id_estado', [16, 32])
                        ->select('c.*', 'b.Nombre',  'o.Oficina as nombre_oficina')
                        ->paginate(30);             
             
            //IDENTIFICAR LOTES          
            $cuotasE = DB::table('lotes as a')
            ->select('a.*', 'u.name as nameUser')
            ->leftJoin('users as u', 'a.idUser', '=', 'u.id')  
            ->whereIn('estado', ['PENDIENTE SAP', 'Subiendo Entrada','Pendiente Contabilidad'])
            ->orderBy('a.id', 'desc')
            ->simplePaginate(50);

            //PENDIENTE CONTABLE CUOTAS
            $cuotasP = DB::table('bandeja_cuentas as b')
                ->join('contratos as c', 'b.Contrato', '=', 'c.id')
                ->leftJoin('oficinas as o', 'c.Oficina', '=', 'o.id')
                ->leftJoin('Cargue_Archivo as ca', function ($join) use ($id_formato2) {
                    $join->on('ca.Id_contrato', '=', 'c.id')
                        ->where('ca.Id_formato', '=', $id_formato2)
                        ->where('ca.Estado', '!=', 'ANULADO');
                })
                ->where('b.estado_juridica', $estadoP)
                ->where('b.Id_Dp', $id_dp)
                ->select('b.*', 'ca.estado as estado_cargue' , 'ca.ruta', 'o.Oficina as nombre_oficina')
                ->simplePaginate(150);

 
            return view('inbox.index', compact('contratos','contratosB','contratosC', 'contratosT', 'id_formato', 'perfiUser', 'cuotasE','cuotasP'));

        }

        
    public function verDocBuzon(Request $request)
        {
 
            $idContrato = $request->idContrato;
            $idCuota = $request->idCuota;
            $estadoContrato = DB::table('contratos')->where('id', $idContrato)->value('Estado'); 
            $id_dp = auth()->user()->id_dp;   
            $idUser = auth()->user()->id;
            $perfil = DB::table('UserPerfil') ->where('idUser', $idUser) ->where('idPerfil', '!=', 2) ->where('idPerfil', '!=', 1) ->orderBy('idPerfil', 'asc') ->pluck('idPerfil') ->toArray();
            $perfiUser = $perfil[0] ?? null;
 
            // ✅ Valor por defecto si no entra en ningún if
            $buzon = [0]; // o cualquier buzon vacío seguro
            $inLista = implode(',', $buzon);
            
            if( str_contains($estadoContrato,'Solicitud CDP')){
                $buzon = [1];
                $inLista = implode(',', $buzon); 
            }elseif( str_contains($estadoContrato,'RPC') && $perfiUser == 10 || $perfiUser == 1 ){
                $buzon = [3];
                $inLista = implode(',', $buzon);  
            }elseif( str_contains($estadoContrato,'RPC') && $perfiUser == 11  ){
                $buzon = [4];
                $inLista = implode(',', $buzon); 
            }elseif( str_contains($estadoContrato,'Solicitud RPC') && $perfiUser != 10){
                $buzon = [3,2];
                $inLista = implode(',', $buzon); 
            }elseif( str_contains($estadoContrato,'En Ejecución') && $idCuota > 1 && ($perfiUser == 10  )){
                    $buzon = [7];
                    $inLista = implode(',', $buzon);  
            }elseif( str_contains($estadoContrato,'En Ejecución') && $idCuota > 1 && ($perfiUser == 13  )){
                    $buzon = [8];
                    $inLista = implode(',', $buzon);  
            }
    
                $datos = DB::select("
                    SELECT 
                        f.Id, 
                        ca.Ruta,
                        CASE 
                            WHEN ESTADO IS NULL THEN  
                                CASE 
                                    WHEN f.Opcional = 1 THEN '(SI APLICA)' 
                                    ELSE UPPER(ca.Estado) 
                                END
                            ELSE Estado 
                        END AS Estado,
                        ca.Observacion,
                        UPPER(f.Nombre) AS Nombre,
                        f.tipo,
                        ? AS idContrato,
                        ? AS idCuota
                    FROM Formatos f 
                    LEFT JOIN (
                        SELECT * 
                        FROM Cargue_Archivo ca 
                        WHERE ca.Id_contrato = ?  
                        AND ca.id_cuota = ?
                        AND Estado != 'ANULADO'
                    ) ca ON f.Id = ca.Id_formato
                    INNER JOIN (
                        SELECT a.*, b.Nivel 
                        FROM Formatos a
                        INNER JOIN Contratos b ON a.Id_Dp = b.Id_Dp 
                        WHERE b.Id = ?
                    ) c ON f.Id = c.Id
                    WHERE c.buzon IN ($inLista)
                    ORDER BY f.Id ASC
                ", [
                    $idContrato,  // para SELECT ... AS idContrato
                    $idCuota,     // para SELECT ... AS idCuota
                    $idContrato,  // para WHERE ca.Id_contrato
                    $idCuota,     // para SELECT ... AS idCuota
                    $idContrato   // para subquery WHERE b.Id
                ]);
            
            
 
    $contrato = DB::table('contratos')
                  ->select('No_Documento','CDP','Fecha_CDP as fecha_cdp','Fecha_Venc_CDP as fecha_venc_cdp', 'RPC','Fecha_Suscripcion', 'Fecha_Venc_RPC','Nivel')
                  ->where('id',$idContrato)
                  ->first();

    $nombreContratista = DB::table('Base_Datos')
                  ->select('Nombre')
                  ->where('Documento',$contrato->No_Documento)
                  ->first();       
                  
 
      
  
    $htmlTabla = view('inbox.tablaCargueBuzon', [
    'datos' => $datos,
    'nombreContratista' => $nombreContratista->Nombre ?? '',
    ])->render();

    return response()->json([
      'html'                => $htmlTabla,
      'cdp'                 => $contrato->CDP,
      'fecha_cdp'           => $contrato->fecha_cdp,
      'fecha_venc_cdp'      => $contrato->fecha_venc_cdp,
      'nivel'               => $contrato->Nivel ?? null,
      'rpc'                 => $contrato->RPC,
      'fecha_rpc'           => $contrato->Fecha_Suscripcion,
      'fecha_venc_rpc'      => $contrato->Fecha_Venc_RPC,
      'estadoContrato'      => $estadoContrato, 
      'userPerfil'          => $perfiUser,
      'docs'                => $datos,    
    ]);
            
    }

 
public function ver_bitacora($id)
{
    $datos = DB::table('bitacora_uso')
        ->select('nombre_usuario', 'accion', 'idContrato', 'fecha', 'Estado_interno')
        ->where('idContrato', $id)
        ->orderBy('fecha', 'asc')
        ->get();

    $datosProcesados = [];
    $anterior = null;
    $ultimo = null;

    foreach ($datos as $fila) {
        $actual = Carbon::parse($fila->fecha);

        $diferencia = $anterior
            ? $actual->diff($anterior)->format('%h horas, %i minutos')
            : '—';

        $resaltado = $anterior && $actual->diffInHours($anterior) >= 24;

        $datosProcesados[] = [
            'nombre_usuario' => $fila->nombre_usuario,
            'accion'         => $fila->accion,
            'estado_interno' => $fila->Estado_interno,
            'fecha'          => $actual->format('Y-m-d H:i'),
            'diferencia'     => $diferencia,
            'alerta'         => $resaltado,
        ];

        $anterior = $actual;
        $ultimo = $actual;
    }

    // Tiempo desde el último evento hasta ahora
    $diffUltimo = $ultimo ? $ultimo->diff(Carbon::now()) : null;

    $tiempoDesdeUltimo = $diffUltimo
        ? $diffUltimo->format('%h horas, %i minutos')
        : '—';

    $resaltarUltimo = $diffUltimo && $ultimo->diffInHours(Carbon::now()) >= 24;

    return view('inbox.bitacoraContrato', compact(
        'datosProcesados',
        'tiempoDesdeUltimo',
        'resaltarUltimo'
    ));
}


public function cambioEstadoBuzon(Request $request)
{
    $opcion     = $request->estado;
    $idCuota    = $request->idCuota;
    $idContrato = $request->idContrato;
    $estadoContrato     = DB::table('contratos')->where('id', $idContrato)->value('Estado_interno');
    $idestadoContrato   = DB::table('contratos')->where('id', $idContrato)->value('id_estado');
    $updated = false;
    $perfiUser = auth()->user()->id_buzon;

    if ($opcion == 0) { // DEVOLUCIÓN
        $estadoAnteriorId = DB::table('Cambio_estado')->where('id', $idestadoContrato)->value('pre_estado');
        $idnuevoestado = DB::table('Cambio_estado')->where('id', $estadoAnteriorId)->first();

        if ($idnuevoestado) {
            $contrato = \App\Models\Contrato::find($idContrato);
            if ($contrato) {
                $contrato->Estado         = $idnuevoestado->EstadoUsuario;
                $contrato->Estado_interno = $idnuevoestado->EstadoInterno;
                $contrato->id_estado      = $idnuevoestado->id;
                $updated = $contrato->save(); // dispara observer y guarda en bitácora
            }
        }

    } elseif ($opcion == 1 || $opcion == 2) { // APROBADO

        if (str_contains($estadoContrato, 'Solicitud CDP')) {
            $buzon = [1];
        } else {
            $buzon = [2];
        }

       
        $oficina =  DB::table('contratos')->where('id', $idContrato)->value('Oficina'); 
            
            if ((int)$oficina === 15) { // si es UTL COJE EL SIGUIENTE ID DE UTL 
                     $estadoSiguienteId = DB::table('Cambio_estado')->where('id', $idestadoContrato)->value('utl');
                }else {
                     $estadoSiguienteId = DB::table('Cambio_estado')->where('id', $idestadoContrato)->value('pos_estado');
                } 


        $idnuevoestado = DB::table('Cambio_estado')->where('id', $estadoSiguienteId)->first();

        if ($idnuevoestado) {
            $contrato = \App\Models\Contrato::find($idContrato);
            if ($contrato) {
                $contrato->Estado         = $idnuevoestado->EstadoUsuario;
                $contrato->Estado_interno = $idnuevoestado->EstadoInterno;
                $contrato->id_estado      = $idnuevoestado->id;
                $updated = $contrato->save(); // 🔥 dispara observer y bitácora
            }

            $estadoContratoLimpio = strtoupper(trim($estadoContrato));

            $estadosCargado = [
                'SOLICITUD CDP',
                'SOLICITUD RPC-PA',
                'SOLICITUD CDP-PRESIDENCIA'
            ];

            $nuevoEstado = in_array($estadoContratoLimpio, $estadosCargado) ? 'CARGADO' : 'PENDIENTE';

                DB::table('Cargue_Archivo as ca')
                    ->leftJoin('Formatos as f', 'ca.Id_formato', '=', 'f.Id')
                    ->where('ca.Id_contrato', $idContrato)
                    ->whereIn('ca.Estado', ['CARGADO', 'APROBADA','FIRMADO'])
                    ->whereIn('f.buzon', $buzon)
                    ->whereNotIn('f.Id', [1031])
                    ->update([
                        'ca.Estado'              => $nuevoEstado,
                        'ca.Fecha_actualizacion' => now(),
                        'ca.id_user'             => auth()->id(),
                    ]);
        }
    }

    return response()->json([
        'success' => $updated,
        'estado'  => $estado ?? null
    ]);
}

 

public function actualizarCDP(Request $request)
{
    $data = $request->validate([
        'idContrato'       => 'required|integer|exists:contratos,id',
        'cdp'              => 'required|string',
        'fecha_cdp'        => 'required|date',
        'fecha_venc_cdp'   => 'required|date', 
        'nivel'            => 'required|string',
    ]);
 
    $contrato = \App\Models\Contrato::find($data['idContrato']);

    if ($contrato) {
        $contrato->CDP            = $data['cdp'];
        $contrato->Fecha_CDP      = $data['fecha_cdp'];
        $contrato->Fecha_Venc_CDP = $data['fecha_venc_cdp'];
        $contrato->Nivel          = $data['nivel'];
        $contrato->save(); // ✅ Dispara el observer y guarda en la bitácora
    }

    return response()->json(['success' => true]);
}


public function actualizarRPC(Request $request)
{
    $data = $request->validate([
        'idContrato'         => 'required|integer|exists:contratos,id',
        'rpc'                => 'required|string',
        'fecha_rpc'          => 'required|date',
        'fecha_venc_rpc'     => 'required|date',
    ]);

    $contrato = \App\Models\Contrato::find($data['idContrato']);

    if ($contrato) {
        $contrato->RPC                 = $data['rpc'];
        $contrato->Fecha_Suscripcion   = $data['fecha_rpc'];
        $contrato->Fecha_Venc_RPC      = $data['fecha_venc_rpc'];
        $contrato->save(); // ✅ Esto dispara el observer y crea bitácora
    }

    return response()->json(['success' => true]);
}

public function cambioEstadoContrato(Request $request)
{
    $accion         = $request->estado;        // 1 o 2
    $idContrato     = $request->idContrato;
    $estadoContrato = DB::table('contratos')
                        ->where('id', $idContrato)
                        ->value('Estado');
    $idEstadoAct    = DB::table('contratos')
                        ->where('id', $idContrato)
                        ->value('id_estado');

    $updated = false;
    $nuevoEstadoId = null;

    if ($accion == 1) {
        // Avanzar al siguiente estado
        $pos = DB::table('Cambio_estado')
                 ->where('id', $idEstadoAct)
                 ->value('pos_estado');

        $next = DB::table('Cambio_estado')
                  ->where('id', $pos)
                  ->first();

        if ($next) {
            // ✅ Usar Eloquent para que dispare observer
            $contrato = \App\Models\Contrato::find($idContrato);
            if ($contrato) {
                $contrato->Estado         = $next->EstadoUsuario;
                $contrato->Estado_interno = $next->EstadoInterno;
                $contrato->id_estado      = $next->id;
                $updated = $contrato->save(); // 🔥 Aquí se dispara el observer
                $nuevoEstadoId = $next->id;
            }
        }
    }

    return response()->json([
        'success' => $updated,
        'nuevo_estado_id' => $nuevoEstadoId,
    ]);
}

   



}