<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrato;  // Asegúrate de que tu modelo esté aquí
use Illuminate\Support\Facades\DB;


class InboxController extends Controller
{
    /**
     * Display a listing of contratos con estado "Solicitud CDP".
     */
 
    public function index()
        {

            $id_dp = auth()->user()->id_dp;   
            $perfiUser = auth()->user()->id_buzon;  

            if (is_null($perfiUser)) {
                return response()->json(['error' => 'No está autorizado para acceder a este recurso.'], 403);
            }
 

            if ($perfiUser == 4) {   // 4=ADMINISTRATIVO
                $id_formato = 34;
                $estado1 = ['Solicitud CDP', 'Solicitud RPC-A']; 
                $estado2 = ['Solicitud CDP-A'];
                $estado3 = ['Solicitud CDP-D', 'Solicitud CDP-PD'];  

             }elseif ($perfiUser == 9) {   // 4=EJECUCION ADMINISTRATIVO
                $id_formato = 34;
                $estado1 = null; 
                $estado2 = ['Solicitud CDP-A1', 'Solicitud RPC', 'Solicitud RPC-A1'];
                $estado3 = null; 

             }elseif ($perfiUser == 8) {   // 8=PRESIDENCIA
                $id_formato = 1031;
                $estado1 = ['Secop-Presidencia', 'Solicitud RPC-P']; 
                $estado2 = ['Solicitud CDP-PA', 'Solicitud RPC-PA' ];
                $estado3 = ['Solicitud CDP-D'];  

             }  elseif ($perfiUser == 10) {   // 10=CONTADURIA
                $id_formato = 34;
                $estado1  = null; 
                $estado2  = ['Solicitud RPC','Solicitud RPC-A','Solicitud RPC-P','Solicitud RPC-A1','Solicitud RPC-PA','Solicitud RPC-D','RPC - Aprobado'];
                $estado3  = null; 
             }  elseif ($perfiUser == 11) {   // 10=TALENTO HUMANO
                $id_formato = 34;
                $estado1  = null; 
                $estado2  = ['Solicitud RPC','Solicitud RPC-A','Solicitud RPC-P','Solicitud RPC-A1','Solicitud RPC-PA','Solicitud RPC-D','RPC - Aprobado'];
                $estado3  = null; 
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
                        ->whereIn('c.Estado', (array)$estado1)
                        ->select('c.*', 'b.Nombre', 'ca.ruta', 'o.Oficina as nombre_oficina')
                        ->paginate(15);
 
            // APROBADOS
            $contratosB = Contrato::from('Contratos as c')
                        ->join('Base_Datos as b', 'b.Documento', '=', 'c.No_Documento') 
                        ->leftjoin('Oficinas as o', 'c.Oficina', '=', 'o.id') 
                        ->whereIn('c.Estado', (array)$estado2)
                        ->select('c.*', 'b.Nombre',   'o.Oficina as nombre_oficina')
                        ->paginate(15);

             //DEVUELTOS           
             $contratosC = Contrato::from('Contratos as c')
                        ->join('Base_Datos as b', 'b.Documento', '=', 'c.No_Documento') 
                        ->leftjoin('Oficinas as o', 'c.Oficina', '=', 'o.id')
                        ->join('Cargue_Archivo as ca', function ($join) use ($id_formato) {
                            $join->on('ca.Id_contrato', '=', 'c.id')
                                 ->where('ca.Id_formato', '=', $id_formato)
                                 ->where('ca.Estado', '!=', 'ANULADO'); })
                        ->whereIn('c.Estado', (array)$estado3)
                        ->select('c.*', 'b.Nombre', 'ca.ruta', 'o.Oficina as nombre_oficina')
                        ->paginate(15);    

             //TODOS
             $contratosT = Contrato::from('Contratos as c')
                        ->join('Base_Datos as b', 'b.Documento', '=', 'c.No_Documento') 
                        ->leftjoin('Oficinas as o', 'c.Oficina', '=', 'o.id') 
                        ->whereNotIn('c.Estado', ['VIGENTE', 'FINALIZADO', 'CANCELADO', 'RECHAZADO', 'LIQUIDADO'])
                        ->select('c.*', 'b.Nombre',  'o.Oficina as nombre_oficina')
                        ->paginate(15); 
 

            return view('inbox.index', compact('contratos','contratosB','contratosC', 'contratosT', 'id_formato', 'perfiUser'));
        }


        
    public function verDocBuzon(Request $request)
        {
 
            $idContrato = $request->idContrato;
            $estadoContrato = DB::table('contratos')->where('id', $idContrato)->value('Estado'); 
            $id_dp = auth()->user()->id_dp;   
            $perfiUser = auth()->user()->id_buzon;    

            \Log::info('verDocBuzon - idContrato: ' . $idContrato . ', estadoContrato: ' . $estadoContrato . ', id_dp: ' . $id_dp . ', perfiUser: ' . $perfiUser);

            if( str_contains($estadoContrato,'Solicitud CDP')){
                $buzon = [1];
                $inLista = implode(',', $buzon); 
            }elseif( str_contains($estadoContrato,'Solicitud RPC')){
                $buzon = [2];
                $inLista = implode(',', $buzon); 
            }elseif( str_contains($estadoContrato,'RPC') && $perfiUser == 10){
                $buzon = [3];
                $inLista = implode(',', $buzon); 
            }elseif( str_contains($estadoContrato,'RPC') && $perfiUser == 11){
                $buzon = [4];
                $inLista = implode(',', $buzon); 
            }

            $datos = DB::select(" SELECT f.Id
                    ,ca.Ruta
                    ,CASE WHEN ESTADO IS NULL THEN  (case when  f.Opcional=1  then '(SI APLICA)' else upper(ca.Estado) end)   else Estado end AS Estado
                    ,ca.Observacion
                    ,upper(f.Nombre) Nombre,f.tipo
                    ,$idContrato as idContrato
                    ,1 as idCuota
                    FROM Formatos f Left JOIN 
                    (select * from Cargue_Archivo ca WHERE ca.Id_contrato=$idContrato  AND isnull(ca.id_cuota,1) =1 AND Estado != 'ANULADO')ca ON f.Id = ca.Id_formato
                    inner join (
                    select a.* , b.Nivel 
                            from Formatos a
                            inner join Contratos b
                            on a.Id_Dp = b.Id_Dp 
                            where b.Id = $idContrato  
                    ) c on f.Id = c.Id
                    where c.buzon IN ($inLista)
                    order by f.Id asc"); 
 
    $contrato = DB::table('contratos')
                  ->select('CDP','Fecha_CDP as fecha_cdp','Fecha_Venc_CDP as fecha_venc_cdp', 'RPC','Fecha_Suscripcion', 'Fecha_Notificacion')
                  ->where('id',$idContrato)
                  ->first();
  
    $htmlTabla = view('inbox.tablaCargueBuzon', compact('datos'))
                   ->render();  

    return response()->json([
      'html'                => $htmlTabla,
      'cdp'                 => $contrato->CDP,
      'fecha_cdp'           => $contrato->fecha_cdp,
      'fecha_venc_cdp'      => $contrato->fecha_venc_cdp,
      'rpc'                 => $contrato->RPC,
      'fecha_rpc'           => $contrato->Fecha_Suscripcion,
      'fecha_venc_rpc'      => $contrato->Fecha_Notificacion,
      'estadoContrato'      => $estadoContrato, 
      'userPerfil'          => $perfiUser,
      'docs'                => $datos,   
    ]);
            
    }

 


public function cambioEstadoBuzon(Request $request)
{
    $opcion     = $request->estado;
    $idCuota    = $request->idCuota;
    $idContrato = $request->idContrato; 
    $estadoContrato = DB::table('contratos')->where('id', $idContrato)->value('Estado');   
    $idestadoContrato = DB::table('contratos')->where('id', $idContrato)->value('id_estado');   
    $updated = false; 
    $perfiUser = auth()->user()->id_buzon;   

 
        if ($opcion == 0) { //DEVOLUCION 

            $estado = DB::table('Cambio_estado')->where('id', $idestadoContrato)->value('pre_estado'); 
            $idnuevoestado = DB::table('Cambio_estado')->where('id', $estado)->first();

                if ($idnuevoestado) {
                    $updated = DB::table('contratos')
                        ->where('id', $idContrato) 
                        ->update(['Estado' => $idnuevoestado->EstadoUsuario,'id_estado' => $idnuevoestado->id]);
                }
 

        } elseif ($opcion == 1 || $opcion == 2) { //APROBADO

            // 4=ADMINISTRATIVO   // 8=PRESIDENCIA
            if( str_contains($estadoContrato,'Solicitud CDP')){
                $buzon = [1];
                $inLista = implode(',', $buzon); 
            }else{
                $buzon = [2];
                $inLista = implode(',', $buzon); 
            }

            $estado = DB::table('Cambio_estado')->where('id', $idestadoContrato)->value('pos_estado'); 
            $idnuevoestado = DB::table('Cambio_estado')->where('id', $estado)->first();

            if ($idnuevoestado) {
                $updated = DB::table('contratos')
                    ->where('id', $idContrato) 
                    ->update(['Estado' => $idnuevoestado->EstadoUsuario,'id_estado' => $idnuevoestado->id]); 

                    if( str_contains($estadoContrato,'Solicitud CDP-PA')){  
                    
                    }else{  
                    $updateformato= DB::table('Cargue_Archivo as ca')
                    ->leftJoin('Formatos as f', 'ca.Id_formato', '=', 'f.Id')
                        ->where('ca.Id_contrato', $idContrato)
                        ->whereIn('ca.Estado', ['CARGADO', 'APROBADA'])
                        ->whereIn('f.buzon', $buzon) 
                        ->update(['ca.Estado' => 'PENDIENTE']);
                     } 
            } 
        }  
 

    return response()->json([
        'success' => $updated,
        'estado'  => $estado
    ]);
}



public function actualizarCDP(Request $request)
{
    $data = $request->validate([
      'idContrato'       => 'required|integer|exists:contratos,id',
      'cdp'              => 'required|string',
      'fecha_cdp'        => 'required|date',
      'fecha_venc_cdp'   => 'required|date',
    ]);

    DB::table('contratos')
      ->where('Id', $data['idContrato'])
      ->update([
        'CDP'            => $data['cdp'],
        'Fecha_CDP'      => $data['fecha_cdp'],
        'Fecha_Venc_CDP' => $data['fecha_venc_cdp'],
      ]);

    return response()->json(['success' => true]);
}


public function actualizarRPC(Request $request)
{
    $data = $request->validate([
      'idContrato'           => 'required|integer|exists:contratos,id',
      'rpc'                  => 'required|string',
      'fecha_rpc'            => 'required|date',
      'fecha_venc_rpc'       => 'required|date',
    ]);

    DB::table('contratos')
      ->where('Id', $data['idContrato'])
      ->update([
        'RPC'                => $data['rpc'],
        'Fecha_Suscripcion'  => $data['fecha_rpc'],
        'Fecha_Notificacion' => $data['fecha_venc_rpc'],
      ]);

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
        // FIRMAR SECOP-CONTRATISTA: sólo si está en "CDP - Aprobado"
         
            // **Avanzar** al siguiente estado
            $pos = DB::table('Cambio_estado')
                     ->where('id', $idEstadoAct)
                     ->value('pos_estado');
            $next = DB::table('Cambio_estado')
                      ->where('id', $pos)
                      ->first();

            if ($next) {
                $updated = DB::table('contratos')
                    ->where('id', $idContrato)
                    ->update([
                        'Estado'    => $next->EstadoUsuario,
                        'id_estado' => $next->id
                    ]);
                $nuevoEstadoId = $next->id;
            }
         
    }

 
    return response()->json([
        'success' => (bool) $updated,
        // devolvemos el nuevo estado si hubo update, o null
        'estado'  => $nuevoEstadoId
    ]);
}




}