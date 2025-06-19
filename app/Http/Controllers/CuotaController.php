<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Class CuotaController
 * @package App\Http\Controllers
 */
class CuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuotas = Cuota::paginate();

        return view('cuota.index', compact('cuotas'))
            ->with('i', (request()->input('page', 1) - 1) * $cuotas->perPage());
    }

    public function bandeja(Request $request)
    {
        $id_dp = auth()->user()->id_dp; 
        $idUser = auth()->user()->id;

 
        $perfiUser = DB::table('UserPerfil')
                    ->where('idUser', $idUser) ->where('idPerfil', '>', 2) ->pluck('idPerfil')  ->toArray();             // [4, 5], [3], etc.
        $perfil = $perfiUser[0] ; 
        $estadoP = $estadoA = null;
 
            if (in_array(3, $perfiUser) || in_array(7, $perfiUser)) { // Si tiene el perfil 3 ó 7 (Cuentas / Cuentas Admin)
                $estadoP = 'PENDIENTE CUENTA';
                $estadoA = 'PENDIENTE ADMIN'; 
                $oficina =  null;
            } elseif (in_array(4, $perfiUser)) { // Si tiene el perfil 4 (Admin SAP)
                $estadoP = 'PENDIENTE ADMIN';
                $estadoA = 'APROBADA'; 
                $oficina =  null;
            } elseif (in_array(12, $perfiUser)) { // Si tiene el perfil 12 (Interventor)
                $estadoP = 'PENDIENTE SUPERVISOR';
                $estadoA = 'PENDIENTE';
                $ccUser = auth()->user()->usuario;
                $oficina = DB::table('Interventores')->where('cedula', '=', $ccUser) ->pluck('Id');
            }
  
        $estadoD = 'DEVUELTA';
        $estadoE = 'ENVIADO TESORERIA';
 
        $listaAsignacion = DB::select("select a.name,a.id from users a
        inner join UserPerfil b
        on a.id = b.idUser
        where a.id_dp = $id_dp
        and b.idPerfil = 3");

        $listaAsignacionFormateada = []; 
        foreach ($listaAsignacion as $asignacion) { $listaAsignacionFormateada[$asignacion->id] = $asignacion->name; } 

        $cuotas = DB::table('bandeja_cuentas')  //PENDIENTES
        ->where('estado_juridica', $estadoP)->where('Id_Dp', $id_dp)
        ->when($oficina, function ($query, $oficina) {return $query->where('Interventor', $oficina); })
        ->simplePaginate(150);
 
        $cuotasA = DB::table('bandeja_cuentas') 
        ->where('estado_juridica', $estadoA)->where('Id_Dp', $id_dp)
        ->when($oficina, function ($query, $oficina) {return $query->where('Interventor', $oficina); }) 
        ->whereNull('FUID')  
        ->simplePaginate(150); 

        $cuotasD = DB::table('bandeja_cuentas')
        ->where('estado_juridica', $estadoD)->where('Id_Dp', $id_dp)
        ->when($oficina, function ($query, $oficina) {return $query->where('Interventor', $oficina); })
        ->simplePaginate(150); 
 
        $cuotasE = DB::table('lotes as a')
        ->select('a.*', 'u.name as nameUser')
        ->leftJoin('users as u', 'a.idUser', '=', 'u.id')  
        ->orderBy('a.id', 'desc')
        ->simplePaginate(50);

        $cuotasE2 = DB::table('bandeja_cuentas') 
        ->where('Estado_juridica','APROBADA') 
        ->simplePaginate(50); 

        return view('cuota.index', compact('cuotas','cuotasA','cuotasD','cuotasE','cuotasE2','perfil','listaAsignacionFormateada'))
            ->with('i', (request()->input('page', 1) - 1) * $cuotas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cuota = new Cuota();
        return view('cuota.create', compact('cuota'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Cuota::$rules);

        $cuota = Cuota::create($request->all());

        return redirect()->route('cuotas.index')
            ->with('success', 'Cuota created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuota = Cuota::find($id);

        return view('cuota.show', compact('cuota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cuota = Cuota::find($id);

        return view('cuota.edit', compact('cuota'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Cuota $cuota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuota $cuota)
    {
        request()->validate(Cuota::$rules);

        $cuota->update($request->all());

        return redirect()->route('cuotas.index')
            ->with('success', 'Cuota updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $cuota = Cuota::find($id)->delete();

        return redirect()->route('cuotas.index')
            ->with('success', 'Cuota deleted successfully');
    }

    


    public function verDocJuridica(Request $request)
    {
        
        // $idContrato = $request->id;
        $idCuota = $request->idCuota;
        $idContrato = $request->idContrato;
        $estadoContrato = DB::table('contratos')->where('id', $idContrato)->value('Estado');
        $id_dp = auth()->user()->id_dp; 
        $idUser = auth()->user()->id;
        $perfiUser = DB::table('UserPerfil') ->where('idUser', $idUser) ->where('idPerfil', '>', 2) ->pluck('idPerfil')  ->toArray();       
        $perfil = $perfiUser[0] ; 
        
        $datos = DB::select("SELECT f.Id
        ,ca.Ruta
        ,upper(ca.Estado) Estado
        ,ca.Observacion
       ,CASE  WHEN f.Nombre = 'PLANILLA' THEN  'PLANILLA - Base: $' + FORMAT(CASE   WHEN (SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 0.4 < 1423500 THEN CAST(1423500 AS MONEY)
        ELSE (SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 0.4 END,'N0','es-ES') ELSE UPPER(f.Nombre) END AS Nombre
        ,f.tipo
        ,$idContrato as idContrato
        ,$idCuota as idCuota,ca.Id as Id_cargue_archivo
        FROM Formatos f Left JOIN 
        (select * from Cargue_Archivo ca WHERE ca.Id_contrato=$idContrato  AND isnull(ca.id_cuota,$idCuota) =$idCuota AND Estado != 'ANULADO')ca ON f.Id = ca.Id_formato
        inner join (
        select a.Id
                from Formatos a
                inner join Contratos b
                on a.Id_Dp = b.Id_Dp
                inner join Cuotas c
                on b.Id = c.Contrato
                where b.Id = $idContrato and c.Id = $idCuota
                and a.etapa <= (case when c.Cuota = b.Cuotas then 2 else 1 end) and a.tipo > (case when c.Cuota = 1 then -1 else 0 end)
        ) c on f.Id = c.Id
        order by f.tipo desc");
        
        return view('tablaDocJuridica', compact('datos','estadoContrato','perfil'));
    }

 
    public function cambioEstadoFile(Request $request)
    {
        $idArchivo = $request->idArchivo;
        $estado = $request->estado;
        $observacion = $request->observacion;
        $id_dp = auth()->user()->id_dp; 
        $idUser = auth()->user()->id;
        $perfiUser = DB::table('UserPerfil') ->where('idUser', $idUser) ->where('idPerfil', '>', 2) ->pluck('idPerfil')  ->toArray();       
        $perfil = $perfiUser[0] ; 

        // Actualizar estado del archivo cargado
        DB::update("UPDATE Cargue_Archivo SET Estado = ?, Observacion = ? WHERE Id = ?", [
            $estado, $observacion, $idArchivo
        ]);
    
        $idCuota = $request->idCuota;
        $idContrato = $request->idContrato;
    
        $estadoContrato = DB::table('contratos')->where('id', $idContrato)->value('Estado');


        // Caso especial: cuota nula o igual a 1
        if (is_null($idCuota) || $idCuota == 1) {

            $tipos = [3]; 
            $estadoLow = strtolower($estadoContrato);        // Llevamos todo a minúsculas para comparar 
            if ($estadoLow === 'firma hoja de vida' || $estadoLow === 'documentos aprobados'|| $estadoLow === 'hoja de vida enviada') { $tipos[] = 5; } 
            $inLista = implode(',', $tipos);
 

            $datos = DB::select("
                SELECT 
                    f.Id,
                    ca.Ruta,
                    UPPER(ca.Estado) AS Estado,
                    ca.Observacion,
                    CASE 
                        WHEN f.Nombre = 'PLANILLA' THEN  
                            'PLANILLA - Base: $' + FORMAT(
                                CAST(
                                    CASE 
                                        WHEN ((SELECT Valor_Mensual FROM Contratos WHERE id = ?) * 0.4) < 1423500 
                                        THEN 1423500 
                                        ELSE ((SELECT Valor_Mensual FROM Contratos WHERE id = ?) * 0.4) 
                                    END 
                                AS MONEY), 'N0', 'es-ES')
                        ELSE UPPER(f.Nombre) 
                    END AS Nombre,
                    f.tipo,
                    ? AS idContrato,
                    1 AS idCuota,
                    ca.Id AS Id_cargue_archivo
                FROM Formatos f
                LEFT JOIN (
                    SELECT * FROM Cargue_Archivo 
                    WHERE Id_contrato = ? AND Estado != 'ANULADO'
                ) ca ON f.Id = ca.Id_formato
                INNER JOIN (
                    SELECT a.Id
                    FROM Formatos a
                    INNER JOIN Contratos b ON a.Id_Dp = b.Id_Dp 
                    WHERE b.Id = ? AND a.tipo IN ($inLista)
                ) c ON f.Id = c.Id
                ORDER BY f.tipo asc
            ", [$idContrato, $idContrato, $idContrato, $idContrato, $idContrato, $inLista]);
        } else {
            // Consulta normal con cuota válida
            $datos = DB::select("SELECT f.Id
            ,ca.Ruta
            ,upper(ca.Estado) Estado
            ,ca.Observacion
        ,CASE  WHEN f.Nombre = 'PLANILLA' THEN  'PLANILLA - Base: $' + FORMAT(CASE   WHEN (SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 0.4 < 1423500 THEN CAST(1423500 AS MONEY)
            ELSE (SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 0.4 END,'N0','es-ES') ELSE UPPER(f.Nombre) END AS Nombre
            ,f.tipo
            ,$idContrato as idContrato
            ,$idCuota as idCuota,ca.Id as Id_cargue_archivo
            FROM Formatos f Left JOIN 
            (select * from Cargue_Archivo ca WHERE ca.Id_contrato=$idContrato  AND isnull(ca.id_cuota,$idCuota) =$idCuota AND Estado != 'ANULADO')ca ON f.Id = ca.Id_formato
            inner join (
            select a.Id
                    from Formatos a
                    inner join Contratos b
                    on a.Id_Dp = b.Id_Dp
                    inner join Cuotas c
                    on b.Id = c.Contrato
                    where b.Id = $idContrato and c.Id = $idCuota
                    and a.etapa <= case when c.Cuota = b.Cuotas then 2 else 1 end
            ) c on f.Id = c.Id
            order by f.tipo desc");
        }
    
        return view('tablaDocJuridica', compact('datos','estadoContrato','perfil'));
    }
    

    public function cambioEstadoCuenta(Request $request)
    {
        $idUsuario = auth()->user()->id;
        $estado = $request->estado;
        $idCuota = $request->idCuota;
        $idContrato = $request->idContrato;  
        $estadoContrato = DB::table('contratos')->where('id', $idContrato)->value('Estado');  
        $idestadoContrato = DB::table('contratos')->where('id', $idContrato)->value('id_estado');

        if  ($idCuota == 1)  { 

            // Actualizar estado en contratos basado en $estado
            
            if ($estado == 0) {

            $estado = DB::table('Cambio_estado')->where('id', $idestadoContrato)->value('pre_estado'); 
            $idnuevoestado = DB::table('Cambio_estado')->where('id', $estado)->first();
 
            if ($idnuevoestado) {
            DB::table('contratos')
                ->where('id', $idContrato) 
                    ->update(['Estado' => $idnuevoestado->EstadoUsuario,'id_estado' => $idnuevoestado->id]);
            }
 

            } elseif ($estado == 1) {

            $estado = DB::table('Cambio_estado')->where('id', $idestadoContrato)->value('pos_estado'); 
            $idnuevoestado = DB::table('Cambio_estado')->where('id', $estado)->first();
 
                if ($idnuevoestado) {
                DB::table('contratos')
                    ->where('id', $idContrato) 
                        ->update(['Estado' => $idnuevoestado->EstadoUsuario,'id_estado' => $idnuevoestado->id]);
                }

            }elseif ($estado == 2) {
               
            $estado = DB::table('Cambio_estado')->where('id', $idestadoContrato)->value('pos_estado'); 
            $idnuevoestado = DB::table('Cambio_estado')->where('id', $estado)->first();
 
                if ($idnuevoestado) {
                DB::table('contratos')
                    ->where('id', $idContrato) 
                        ->update(['Estado' => $idnuevoestado->EstadoUsuario,'id_estado' => $idnuevoestado->id]);
                
                DB::table('Cargue_Archivo')
                        ->where('Id_Contrato', $idContrato) 
                        ->where('Id_formato', 37) 
                        ->where('Estado', 'CARGADO') 
                        ->update(['Estado' => 'DEVUELTA'],['Observacion' => 'Pendiente por firmar hoja de vida']);       
                }               
               
 
            }
 
        }

        // Ejecutar SP si la cuota es válida
        $cambioEstado = DB::update("EXEC [sp_cambioEstado] ?, ?, ?, ?", [
            $idCuota, 2, $estado, $idUsuario
        ]);
        return $cambioEstado;
    }




    
    public function enviarLote(Request $request)
    {
        
        $idUsuario = auth()->user()->id;
        
        $idLote = $request->idLote;
        // print_r($idLote);die();
        $estado = $request->estado;
        $idCuota = $request->idCuota;
        
       
        $queryResult = DB::update("UPDATE Cuotas SET Estado = '$estado', Estado_juridica = '$estado', id_user = $idUsuario WHERE Id = $idCuota");
        
        return $queryResult;
    }
    
}
