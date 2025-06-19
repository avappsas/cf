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
        $idUser = auth()->user()->id;
        $perfiUser = DB::select("select *
        ,case when idPerfil in (1,3) then 'PENDIENTE ADMIN' when idPerfil in (4) then 'APROBADA' end as estadoA
        ,case when idPerfil in (1,3) then 'PENDIENTE' when idPerfil in (4) then 'PENDIENTE ADMIN' end as estadoP
        from UserPerfil where idUser = $idUser and idPerfil in (1,3,4)");
        $estadoInterno = $perfiUser[0]->estadoA;
        $estadoInternoP = $perfiUser[0]->estadoP;
        $perfil = $perfiUser[0]->idPerfil;
        // print_r($estadoInterno);die();
        $estadoP = $estadoInternoP;
        $estadoA = $estadoInterno;
        $estadoD = 'DEVUELTA';
        $estadoE = 'ENVIADO TESORERIA';
        $id_dp = auth()->user()->id_dp;

        // print_r($estadoA);die();
        // $listaAsignacion = DB::table('users as a')->select("a.name,a.id
        // inner join UserPerfil b
        // on a.id = b.idUser
        // where a.id_dp = $id_dp
        // and b.idPerfil = 3");
        $listaAsignacion = DB::select("select a.name,a.id from users a
        inner join UserPerfil b
        on a.id = b.idUser
        where a.id_dp = $id_dp
        and b.idPerfil = 3");
        $listaAsignacionFormateada = [];
        foreach ($listaAsignacion as $asignacion) {
            $listaAsignacionFormateada[$asignacion->id] = $asignacion->name;
        }
        // print_r($listaAsignacionFormateada);die();

        $cuotas = DB::table('cuotas as c')
        ->select(
            'c.Id',
            'c.Contrato',
            'c.Cuota',
            'c.Fecha_Acta',
            'c.Porcentaje',
            'c.Actividades',
            'c.Planilla',
            'c.Perioro_Planilla',
            'c.Parcial',
            'c.Mes_cobro',
            'c.Oficina',
            'c.Pin_planilla',
            'c.Operador_planilla',
            'c.Fecha_pago_planilla',
            'c.updated_at',
            'c.created_at',
            'c.Estado',
            'c.Estado_juridica',
            'c.Observacion','c.id_user',
            'b.Nombre',
            'u.name as nameUser' // Campo 'name' de la tabla 'users'
        )
        ->join('contratos as cc', 'c.Contrato', '=', 'cc.Id')
        ->join('base_datos as b', 'cc.No_Documento', '=', 'b.Documento')
        ->leftJoin('users as u', 'c.id_user', '=', 'u.id') // Unir la tabla 'users'
        ->where('c.estado_juridica', $estadoP)->where('cc.Id_Dp', $id_dp)
        ->simplePaginate(150);

        $cuotasA = DB::table('cuotas as c')
        ->select(
            'c.Id',
            'c.Contrato',
            'c.Cuota',
            'c.Fecha_Acta',
            'c.Porcentaje',
            'c.Actividades',
            'c.Planilla',
            'c.Perioro_Planilla',
            'c.Parcial',
            'c.Mes_cobro',
            'c.Oficina',
            'c.Pin_planilla',
            'c.Operador_planilla',
            'c.Fecha_pago_planilla',
            'c.updated_at',
            'c.created_at',
            'c.Estado',
            'c.Estado_juridica',
            'c.Observacion',
            'b.Nombre','b.documento','cc.Num_Contrato','cc.rpc','c.consecutivo',
            'u.name as nameUser' // Campo 'name' de la tabla 'users'
        )
        ->join('contratos as cc', 'c.Contrato', '=', 'cc.Id')
        ->join('base_datos as b', 'cc.No_Documento', '=', 'b.Documento')
        ->leftJoin('users as u', 'c.id_user', '=', 'u.id') // Unir la tabla 'users'
        ->where('c.estado_juridica', $estadoA)->where('cc.Id_Dp', $id_dp)
        // ->where('c.id_user',NULL)
        ->simplePaginate(150);
        

        $cuotasD = DB::table('cuotas as c')
        ->select(
            'c.Id',
            'c.Contrato',
            'c.Cuota',
            'c.Fecha_Acta',
            'c.Porcentaje',
            'c.Actividades',
            'c.Planilla',
            'c.Perioro_Planilla',
            'c.Parcial',
            'c.Mes_cobro',
            'c.Oficina',
            'c.Pin_planilla',
            'c.Operador_planilla',
            'c.Fecha_pago_planilla',
            'c.updated_at',
            'c.created_at',
            'c.Estado',
            'c.Estado_juridica',
            'c.Observacion',
            'b.Nombre',
            'u.name as nameUser' // Campo 'name' de la tabla 'users'
        )
        ->join('contratos as cc', 'c.Contrato', '=', 'cc.Id')
        ->join('base_datos as b', 'cc.No_Documento', '=', 'b.Documento')
        ->leftJoin('users as u', 'c.id_user', '=', 'u.id') // Unir la tabla 'users'
        ->where('c.estado_juridica', $estadoD)->where('cc.Id_Dp', $id_dp)
        ->simplePaginate(150);

        // print_r($cuotasD );die();

        $cuotasE = DB::table('lotes as a')->select('a.*',
        'u.name as nameUser')
        ->leftJoin('users as u', 'a.idUser', '=', 'u.id') // Unir la tabla 'users'
        ->simplePaginate(50);
        $cuotasE2 = DB::table('Cuotas as c')->select(
            'c.Id',
            'c.Contrato',
            'c.Cuota',
            'c.Fecha_Acta',
            'c.Porcentaje',
            'c.Actividades',
            'c.Planilla',
            'c.Perioro_Planilla',
            'c.Parcial',
            'c.Mes_cobro',
            'c.Oficina',
            'c.Pin_planilla',
            'c.Operador_planilla',
            'c.Fecha_pago_planilla',
            'c.updated_at',
            'c.created_at',
            'c.Estado',
            'c.Estado_juridica',
            'c.Observacion',
            'b.Nombre','b.documento','cc.Num_Contrato','cc.rpc','c.consecutivo',
            'c.FUID',
            'u.name as nameUser' // Campo 'name' de la tabla 'users'
        )
        ->join('lotes as lt', 'c.FUID', '=', 'lt.id')
        ->join('contratos as cc', 'c.Contrato', '=', 'cc.Id')
        ->join('base_datos as b', 'cc.No_Documento', '=', 'b.Documento')
        ->leftJoin('users as u', 'c.id_user', '=', 'u.id') // Unir la tabla 'users'
        ->where('cc.Id_Dp', $id_dp)
        ->where('c.Estado_juridica','APROBADA')
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

        // print_r($id);die();
        
        $datos = DB::select("SELECT f.Id
        ,ca.Ruta
        ,upper(ca.Estado) Estado
        ,ca.Observacion
        ,CASE WHEN f.Nombre = 'PLANILLA' THEN  'PLANILLA - Base: $' +  FORMAT( CAST( CASE WHEN ((SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 40 / 100) < 1300000 THEN '1.300.000' 
          ELSE ((SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 40 / 100)  END  AS MONEY), 'N0', 'es-ES')  ELSE UPPER(f.Nombre) END AS Nombre
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
        
        return view('tablaDocJuridica', compact('datos'));
    }

    
    public function cambioEstadoFile(Request $request)
    {
        
        $idArchivo = $request->idArchivo;
        $estado = $request->estado;
        $observacion = $request->observacion;
        
        $queryResult = DB::update("UPDATE Cargue_Archivo SET Estado = '$estado', Observacion = '$observacion' WHERE Id = $idArchivo");
        
        
        
        // $idContrato = $request->id;
        $idCuota = $request->idCuota;
        $idContrato = $request->idContrato;

        // print_r($id);die();
        
        $datos = DB::select("SELECT f.Id
        ,ca.Ruta
        ,upper(ca.Estado) Estado
        ,ca.Observacion
        ,upper(f.Nombre) Nombre,f.tipo
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
        
        return view('tablaDocJuridica', compact('datos'));
    }

    
    public function cambioEstadoCuenta(Request $request)
    {
        
        $idUsuario = auth()->user()->id;
        // print_r($idUsuario);die();
        $estado = $request->estado;
        $idCuota = $request->idCuota;
        
        $cambioEstado = DB::update("EXEC [sp_cambioEstado] $idCuota,2,$estado,$idUsuario;");
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
