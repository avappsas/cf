<?php

namespace App\Http\Controllers;

use App\Models\Testigo;
use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Afiliado;
use DB;
use App\Models\PuestosVotacion;
use App\Models\users;
use App\User;
use App\Charts\SampleChart;

/**
 * Class TestigoController
 * @package App\Http\Controllers
 */
class TestigoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $Departamento = Departamento::orderBy('depto', 'ASC')->pluck('depto','ID_DPT');
        $id_dpto = 31;
        $municipio = Municipio::where('DPT', $id_dpto)->pluck('municipio','ID');
        $puestoVota = PuestosVotacion::where('Dpt',31)
                                   ->where('Mpio',1)
                                   ->where('Zonacomuna',1)->pluck('Puesto','Id');
        $comuna = PuestosVotacion::where('Dpt',31)
                                ->where('Mpio',1)->distinct()->pluck('ZonaComuna','ZonaComuna');

        $testigos = Testigo::where('id_departamento',1000)->simplepaginate(50);

        return view('testigo.index', compact('testigos','Departamento','municipio'))
            ->with('i', (request()->input('page', 1) - 1) * $testigos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $testigo = new Testigo();
        return view('testigo.create', compact('testigo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Testigo::$rules);

        $testigo = Testigo::create($request->all());

        return redirect()->route('testigos.index')
            ->with('success', 'Testigo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $testigo = Testigo::find($id);

        return view('testigo.show', compact('testigo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testigo = Testigo::find($id);

        return view('testigo.edit', compact('testigo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Testigo $testigo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testigo $testigo)
    {
        request()->validate(Testigo::$rules);

        $testigo->update($request->all());

        return redirect()->route('testigos.index')
            ->with('success', 'Testigo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $testigo = Testigo::find($id)->delete();

        return redirect()->route('testigos.index')
            ->with('success', 'Testigo deleted successfully');
    }

    public function selectList(Request $request){
        $tipo = $request->tipo;
        
        if ($tipo == 1){
            $idDepartameto = $request->idDepartameto;
            $muncipi = Municipio::select('municipio','Mpio')->where('DPT',$idDepartameto)->get();
            return response()->json($muncipi);

        }elseif ($tipo == 2) {
            $idDepartameto = $request->idDepartameto;
            $idMunicipio = $request->idMunicipio;
            // $zona = PuestosVotacion::select('Zonacomuna','Zonacomuna')->where('Dpt',$idDepartameto)
            //                          ->where('Mpio',$idMunicipio )->distinct()->get();

            $zona = PuestosVotacion::selectRaw("Zona,count(*) as cant")->where('Dpt',$idDepartameto)
            ->where('Mpio',$idMunicipio )
            ->groupBy("Zona")
            ->orderBy("Zona", "asc")
            ->get();
            
            return response()->json($zona);
        }elseif ($tipo == 3) {
            $idDepartameto = $request->idDepartameto;
            $idMunicipio = $request->idMunicipio;
            $idzona = $request->idZona;
            $puestoVota = PuestosVotacion::where('Dpt',$idDepartameto)
                                       ->where('Mpio',$idMunicipio)
                                       ->where('Zona',$idzona)->select('Puesto','id')->distinct()->get();
            return response()->json($puestoVota);
        }
    }

    public function getMesaVot(Request $request){
        $idDepartameto = $request->idDepartameto;
        $idMunicipio = $request->idMunicipio;
        $idZona = $request->idZona;
        $idPuesto = $request->idPuesto;
        // print_r($idPuesto);die();
        $Departamento = Departamento::orderBy('depto', 'ASC')->pluck('depto','ID_DPT');
        $municipio = Municipio::where('DPT', $idDepartameto)->pluck('municipio','ID');
        $puestoVota = PuestosVotacion::where('Dpt',$idDepartameto)
                                   ->where('Mpio',$idMunicipio)
                                   ->where('Zonacomuna',$idZona )->pluck('Puesto','Id');
        $comuna = PuestosVotacion::where('Dpt',$idDepartameto)
                                ->where('Mpio',$idMunicipio)->distinct()->pluck('ZonaComuna','ZonaComuna');

        $testigos = Testigo::where('id_departamento',$idDepartameto)->where('id_municipio',$idMunicipio)
                            ->where('id_Zona',$idZona)
                            ->where('id_puesto',$idPuesto)->orderBy('mesa', 'ASC')
                            ->simplepaginate(500);

        $tablaHTML =  view('testigo.tablaTestigos', compact('testigos','Departamento','municipio'))
        ->with('i')->render();
        return response()->json(['tabla' => $tablaHTML]);
        
    }

    public function reportes(Request $request){
        $Departamento = Departamento::orderBy('depto', 'ASC')->pluck('depto','ID_DPT');
        $id_dpto = 31;
        $municipio = Municipio::where('DPT', $id_dpto)->pluck('municipio','ID');
        
        
        return view('testigo.reportes', compact('Departamento','municipio'));
        
    }

    public function getReportes(Request $request){
        $idDepartameto = $request->idDepartameto;
        $idMunicipio = $request->idMunicipio;
        // print_r($idPuesto);die();
        
        $zonas = DB::table("ReportXZonas")->where('Dpt',$idDepartameto)->where('Mpio',$idMunicipio)->orderBy('Zona','asc')->simplePaginate(1000);
        $columnas = DB::getSchemaBuilder()->getColumnListing('ReportXZonas');   

        $totales = DB::select("SELECT [Dpt]
                                    ,[Mpio]
                                    ,count([Zona]) Zona
                                    ,sum([puestos]) puestos
                                    ,sum([mesas]) mesas
                                    ,sum(isnull([Testigos],0)) Testigos
                                    ,sum(isnull([Reportado],0)) Reportado
                                FROM [aie].[dbo].[ReportXZonas]
                                where id_campaña is not null
                                group by [id_campaña],[Dpt],[Mpio]");
        $totales = $totales[0];
        // print_r($totales[0]);die();


        // Crear un array vacío para almacenar los datos
        $datos = [];

        // Recorrer los resultados y obtener los datos para el gráfico
        foreach ($zonas as $zona) {
            $datos[] = $zona->Reportado; // Suponiendo que 'Valor' es el campo de datos
        }
         
        // print_r($datos);die();
        $tablaHTML =  view('testigo.tablaReporteXZonas', compact('zonas','totales'))
        ->with('i')->render();
        return response()->json(['tabla' => $tablaHTML,'columnas' => $columnas,'datos' => $datos]);
        
        // $tablaHTML =  view('moniCall', compact('monitoreoCalls'))->render();
        // $tablaHTMLLlamadas =  view('misLlamadas', compact('misLlamadas'))->render();
        // return response()->json(['tabla' => $tablaHTML,'tabla2' => $tablaHTMLLlamadas,'HoraInicio' => $horaInicio]);
        
    }

    public function getPuestDeZona(Request $request){
        $idDepartameto = $request->idDepartameto;
        $idMunicipio = $request->idMunicipio;
        $idZona = $request->idZona;
        
        $zonas = DB::table("ReportXpuestos")->where('Dpt',$idDepartameto)->where('Mpio',$idMunicipio)->where('Zona',$idZona)->orderBy('Pto','asc')->simplePaginate(1000);

        $totales = DB::select("SELECT [Dpt]
                                        ,[Mpio]
                                        ,[Zona]
                                        ,count([puesto]) puestos
                                        ,sum([mesas]) mesas
                                        ,sum(isnull([Testigos],0)) Testigos
                                        ,sum(isnull([Reportado],0)) Reportado
                                    FROM [aie].[dbo].[ReportXpuestos]
                                    where zona = $idZona
                                    group by [Dpt],[Mpio],[Zona]");
        $totales = $totales[0];
         
        // print_r($totales);die();
        
        $tablaHTML =  view('testigo.tablaReporteXPuestos', compact('zonas','totales','idZona'))
        ->with('i')->render();
        return response()->json(['tabla' => $tablaHTML]);
        
    }

    public function getMesasDePuesto(Request $request){
        $idDepartameto = $request->idDepartameto;
        $idMunicipio = $request->idMunicipio;
        $idZona = $request->idZona;
        $nomPuesto = $request->nomPuesto;
        $Pto = $request->Pto;
        
        $zonas = DB::table("ReportXMesa")->where('Dpt',$idDepartameto)->where('Mpio',$idMunicipio)->where('Zona',$idZona)->where('Pto',$Pto)->orderBy('Pto','asc')->simplePaginate(1000);

        $totales = DB::select("SELECT [Dpt]
                                        ,[Mpio]
                                        ,[Zona]
                                        ,[Pto]
                                        ,count([mesa]) mesas
                                        ,sum([GOBERNACION]) [GO]
                                        ,sum([ALCALDIA]) [AL]
                                        ,sum([CONCEJO]) [CO]
                                        ,sum([ASAMBLEA]) [AS]
                                    FROM [aie].[dbo].[ReportXMesa]
                                    where zona = $idZona and Pto= $Pto  and Dpt = $idDepartameto and Mpio = $idMunicipio
                                    group by [Dpt],[Mpio],[Zona],[Pto]");
        $totales = $totales[0];
         
        // print_r($totales);die();
        
        $tablaHTML =  view('testigo.tablaReporteXMesas', compact('zonas','totales','nomPuesto'))
        ->with('i')->render();
        return response()->json(['tabla' => $tablaHTML]);
        
    }
}
