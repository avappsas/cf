<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Cuota;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use App\Exports\exportLote;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\Exception\Exception;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Cache;
use Spatie\Async\Pool;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use PhpOffice\PhpWord\PhpWord;
use PDF;
use TCPDF;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use Spatie\PdfToText\Pdf as pdfTex;
use Carbon\Carbon; // Asegúrate de importar Carbon
use App\Mail\Notificacion;
use Illuminate\Support\Facades\Mail;

/**
 * Class ContratoController
 * @package App\Http\Controllers
 */
class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fecha_actual = Carbon::now();
        $id_dp = auth()->user()->id_dp;
        $fecha_c = DB::table('fecha_cuenta')->where('id_dp', $id_dp)->where('fecha_max', '>=', $fecha_actual)->value('fecha_cuenta');
        $fecha_formateada = date('d-m-Y', strtotime($fecha_c));
        
        if ($fecha_c) {
            // La fecha_cuenta está definida
            $fecha_mensaje = 'Informa que tu fecha para pasar cuenta es: ' . $fecha_formateada;
        } else {
            // La fecha_cuenta no está definida
            $fecha_mensaje = 'Informa que tu fecha para pasar cuenta No se ha definido';
        }

        $idusuario = auth()->user()->usuario;
        $contratos = Contrato::where('No_Documento',$idusuario)
        ->simplePaginate(50);

        // $contratos = DB::select("select c.id as Id, Estado, Num_Contrato, o.oficina as Oficina, Plazo, Cuotas from contratos c
        // join oficinas o on o.id=c.oficina
        // where  No_Documento = $idusuario");
        
        $operadores = DB::table('Operadores_planillas')
        // ->select()
        ->pluck(
            'Operador',
            'Id');

        // print_r($operadores);die();

        return view('contrato.index', compact('contratos','operadores','fecha_mensaje','fecha_formateada'))
            ->with('i', (request()->input('page', 1) - 1) * $contratos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contrato = new Contrato();

        $oficinas = DB::table ('Oficinas')
        ->pluck('Oficina', 'Id'); 

        $interventores = DB::table ('Interventores')
        ->pluck('nombre', 'Id'); 
        // print_r( $interventores); die();


        return view('contrato.create', compact('contrato','oficinas','interventores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Contrato::$rules);

        $contrato = Contrato::create($request->all()); 

        return redirect()->route('contratos_vigentes')
            ->with('success', 'Contrato created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contrato = Contrato::find($id);

        return view('contrato.show', compact('contrato'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contrato = Contrato::find($id);

        return view('contrato.edit', compact('contrato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Contrato $contrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contrato $contrato)
    {
        request()->validate(Contrato::$rules);

        $contrato->update($request->all());

        return redirect()->route('contratos.index')
            ->with('success', 'Contrato updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $contrato = Contrato::find($id)->delete();

        return redirect()->route('contratos.index')
            ->with('success', 'Contrato deleted successfully');
    }
    

    public function generarDocumentosPDFs(Request $request)
    {
        // Obtener valores para reemplazar en el script desde la base de datos
        $cuotasId = 7;
        $result = DB::select('EXEC GetJsonData ?', [$cuotasId]);
        // print_r($result);die();
        // Verificar si hay resultados y si la propiedad Resp existe y no es nula
        if (!empty($result) && isset($result[0]->Resp)) {
            // Decodificar el resultado JSON
            $jsonResult = json_decode($result[0]->Resp, true);

            // Verificar si hay archivos en el resultado
            if (isset($jsonResult['archivos']) && is_array($jsonResult['archivos'])) {
                // Iterar sobre cada archivo en el resultado
                foreach ($jsonResult['archivos'] as $archivo) {
                    // Generar nombres de archivo aleatorios
                    $nombreAleatorio = uniqid('script_', true);
                    $rutaScript = public_path("scripts/$nombreAleatorio.ps1");

                    $nombreArchivoAleatorio = uniqid('documento_', true);
                    $rutaDocumentoSalida = public_path("documentos/$nombreArchivoAleatorio.docx");

                    // Construir un arreglo asociativo de llaves y valores
                    $reemplazos = [];
                    foreach ($archivo['Detalles'] as $detalle) {
                        $reemplazos[$detalle['llave']] = $detalle['Valor'];
                    }

                    // Contenido del script PowerShell con el valor de la base de datos
                    $scriptContenido = "
                        \$templatePath = '{$archivo['Ruta']}'
                        \$outputPath = '$rutaDocumentoSalida'
                        
                        \$word = New-Object -ComObject Word.Application
                        \$document = \$word.Documents.Open(\$templatePath)

                        # Rellenar campos en la plantilla
                    ";

                    // Agregar líneas al script para cada llave y valor
                    foreach ($reemplazos as $llave => $valor) {
                        $scriptContenido .= "                    \$document.Content.Find.Execute('<<$llave>>', \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, '$valor')\n";
                        $scriptContenido .= "                    \$document.Content.Find.Execute('<<$llave>>', \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, '$valor')\n";
                        $scriptContenido .= "                    \$document.Content.Find.Execute('<<$llave>>', \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, '$valor')\n";
                    }

                    // Resto del código...
                    
                    // Guardar el nuevo documento
                    $scriptContenido .= "                    \$document.SaveAs([ref]\$outputPath, [ref]16) # 16 indica el formato de documento Word\n";
                    $scriptContenido .= "                    \$document.Close()\n";
                    $scriptContenido .= "                    \$word.Quit()\n";
                    
                    // Guardar el script en un archivo
                    file_put_contents($rutaScript, $scriptContenido);

                    // Construir el comando PowerShell para ejecutar el script generado
                    $comandoPowerShell = "powershell.exe -File $rutaScript";
                    // print_r($comandoPowerShell);die();
                    // Ejecutar el comando PowerShell
                    $resultado = exec($comandoPowerShell);

                    // Realizar otras acciones según tus necesidades (puede que desees almacenar las rutas generadas en una colección, por ejemplo)
                }

                // Retornar alguna respuesta o realizar otras acciones según tus necesidades
                return response()->json(['message' => 'Documentos generados con éxito']);
            } else {
                // En caso de que no haya archivos, puedes retornar un mensaje de error o realizar otras acciones según tus necesidades
                return response()->json(['message' => 'No hay archivos en el resultado JSON']);
            }
        } else {
            // Manejo de error si no hay resultados o la propiedad Resp no está presente
            return response()->json(['message' => 'Error en la consulta o propiedad Resp no presente']);
        }
    }

    public function generarDocumentosPDF(Request $request)
    {
        $cuotasId = 7;
        $result = DB::select('EXEC GetJsonData ?', [$cuotasId]);

        if (!empty($result) && isset($result[0]->Resp)) {
            $jsonResult = json_decode($result[0]->Resp, true);

            if (isset($jsonResult['archivos']) && is_array($jsonResult['archivos'])) {
                $generatedFiles = [];

                foreach ($jsonResult['archivos'] as $archivo) {
                    $randomScriptName = uniqid('script_', true);
                    $scriptPath = public_path("scripts/$randomScriptName.ps1");

                    $randomFileName = uniqid('documento_', true);
                    $outputDocPath = public_path("documentos/$randomFileName.docx");

                    $replacements = [];
                    foreach ($archivo['Detalles'] as $detalle) {
                        $replacements[$detalle['llave']] = $detalle['Valor'];
                    }

                    $powerShellScript = $this->generatePowerShellScript($archivo['Ruta'], $outputDocPath, $replacements);
                    file_put_contents($scriptPath, $powerShellScript);

                    $powerShellCommand = "powershell.exe -File $scriptPath";
                    $result = exec($powerShellCommand);

                    $generatedFiles[] = $outputDocPath;

                    // Limpieza de archivos temporales (opcional)
                    // unlink($scriptPath);
                }

                return response()->json(['message' => 'Documentos generados con éxito', 'files' => $generatedFiles]);
            } else {
                return response()->json(['message' => 'No hay archivos en el resultado JSON']);
            }
        } else {
            return response()->json(['message' => 'Error en la consulta o propiedad Resp no presente']);
        }
    }

    private function generatePowerShellScript($templatePath, $outputPath, $replacements)
    {
        $randomFileName = uniqid('documento_', true);
        $scriptContent = "
            \$templatePath = '{$templatePath}'
            \$outputPath = '{$outputPath}'
            
            \$word = New-Object -ComObject Word.Application
            \$document = \$word.Documents.Open(\$templatePath)

            # Rellenar campos en la plantilla
        ";

        foreach ($replacements as $key => $value) {
            $scriptContent .= "        \$document.Content.Find.Execute('<<$key>>', \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, '$value')\n";
        }

        // Nueva ubicación del archivo Word (copia)
        $copiedTemplatePath = public_path("documentos/copia_$randomFileName.docx");
        $scriptContent .= "        \$copiedTemplatePath = '{$copiedTemplatePath}'\n";
        $scriptContent .= "        \$document.SaveAs([ref]\$copiedTemplatePath, [ref]16)\n";

        // Rellenar campos en la copia
        foreach ($replacements as $key => $value) {
            $scriptContent .= "        \$document.Content.Find.Execute('<<$key>>', \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, '$value')\n";
        }

        // Guardar el documento modificado como PDF
        $scriptContent .= "        \$pdfOutputPath = '{$outputPath}.pdf'\n";
        $scriptContent .= "        \$document.ExportAsFixedFormat([ref]\$pdfOutputPath, 17) # 17 indica el formato de documento PDF\n";


        $scriptContent .= "        \$document.Close()\n";
        $scriptContent .= "        \$word.Quit()\n";

        // Eliminar el archivo Word después de generar el PDF
        $scriptContent .= "        Remove-Item -Path \$copiedTemplatePath -Force\n";

        return $scriptContent;
    }

    public function btnMostrarPDF(Request $request)
    {
        $id = $request->id;
        // $id = 7;
        $queryFormatos = DB::select("select a.*
        from Formatos a
        inner join Contratos b
        on a.Id_Dp = b.Id_Dp
        inner join Cuotas c
        on b.Id = c.Contrato
        where c.Id = $id
        and a.etapa <= case when c.Cuota = b.Cuotas then 2 else 1 end");
        
        
        return view('modalPDF', compact('queryFormatos','id'));
        
    }

    public function gpdf(Request $request)
    {
        $id = $request->id; 
        $idCuota = $request->idCuota;
        // $idCuota = 7;
        // $id = 2;
        $queryFormatos = DB::select("select * from Formatos where Id = $id");
        $vista = $queryFormatos[0]->Vista;

        $queryResult = DB::select("SELECT 
            CONVERT(VARCHAR(5000),b.Nombre) AS 'V_nombre', 
            CONVERT(VARCHAR(5000),LTRIM(RTRIM(STR(c.No_Documento)))) AS 'V_CC', 
            CONVERT(VARCHAR(5000),c.Estado) AS V_Estado, 
            CONVERT(VARCHAR(5000),LTRIM(RTRIM(STR(c.Tipo_Contrato)))) AS V_Tipo_Contrato, 
            CONVERT(VARCHAR(5000),c.Num_Contrato) AS V_Num_Contrato, 
            CONVERT(VARCHAR(5000),c.Objeto) AS 'V_objeto', 
            CONVERT(VARCHAR(5000),c.Plazo,103) AS V_Plazo, 
            CONVERT(VARCHAR(5000),LTRIM(RTRIM(STR(c.Valor_Total)))) AS 'V_valor_contrato', 
            CONVERT(VARCHAR(5000),LTRIM(RTRIM(STR(c.Cuotas)))) AS V_Cuotas, 
            CONVERT(VARCHAR(5000),c.Cuotas_Letras) AS V_Cuotas_Letras, 
            CONVERT(VARCHAR(5000),c.Oficina) AS 'V_oficina', 
            CONVERT(VARCHAR(5000),c.CDP) AS V_CDP, 
            CONVERT(VARCHAR(5000),c.Fecha_CDP,103) AS 'V_fecha_inicio', 
            CONVERT(VARCHAR(5000),LTRIM(RTRIM(STR(c.Apropiacion)))) AS V_Apropiacion, 
            CONVERT(VARCHAR(5000),c.Interventor) AS 'V_supervisor', 
            CONVERT(VARCHAR(5000),c.Fecha_Estudios,103) AS V_Fecha_Estudios, 
            CONVERT(VARCHAR(5000),c.Fecha_Idoneidad,103) AS V_Fecha_Idoneidad, 
            CONVERT(VARCHAR(5000),c.Fecha_Notificacion,103) AS V_Fecha_Notificacion, 
            CONVERT(VARCHAR(5000),c.Fecha_Suscripcion,103) AS V_Fecha_Suscripcion, 
            CONVERT(VARCHAR(5000),c.RPC) AS V_RPC, 
            CONVERT(VARCHAR(5000),c.Fecha_Invitacion,103) AS V_Fecha_Invitacion, 
            CONVERT(VARCHAR(5000),c.Cargo_Interventor) AS V_Cargo_Interventor, 
            CONVERT(VARCHAR(5000),c.Valor_Total_letras) AS 'V_valor_letras', 
            CONVERT(VARCHAR(5000),LTRIM(RTRIM(STR(c.Valor_Mensual)))) AS 'V_valor_cuota', 
			CONVERT(VARCHAR(5000),LTRIM(RTRIM(STR(c.Valor_Cuota_1)))) AS 'V_valor_cuota1', 
            CONVERT(VARCHAR(5000),c.Valor_Mensual_Letras) AS V_Valor_Mensual_Letras, 
            CONVERT(VARCHAR(5000),LTRIM(RTRIM(STR(c.N_C)))) AS 'V_no_contrato', 
            CONVERT(VARCHAR(5000),c.Fecha_Venc_CDP,103) AS 'V_fecha_terminacion', 
            CONVERT(VARCHAR(5000),c.Nivel) AS V_Nivel, 
            CONVERT(VARCHAR(5000),LTRIM(RTRIM(STR(cc.Contrato)))) AS V_Contrato, 
            CONVERT(VARCHAR(5000),cc.Cuota) AS 'V_no_cuota', 
            CONVERT(VARCHAR(5000),cc.Fecha_Acta,103) AS 'V_fecha_cuenta', 
            CONVERT(VARCHAR(5000),LTRIM(RTRIM(STR(cc.Porcentaje)))) AS V_Porcentaje, 
            CONVERT(VARCHAR(5000),cc.Actividades) AS 'V_actividades', 
            CONVERT(VARCHAR(5000),cc.Planilla) AS 'V_planilla', 
            CONVERT(VARCHAR(5000),(select operador from cuenta.dbo.Operadores_planillas where id=cc.Operador_planilla)) as 'V_operador_p',             
	        DATENAME(month, DATEADD(month, cc.Perioro_Planilla - 1, '1900-01-01')) AS 'V_periodo_nombre', 
            CONVERT(VARCHAR(5000),cc.Pin_planilla) AS 'V_pin_planilla', 
            CONVERT(VARCHAR(5000),cc.Operador_planilla) AS 'V_operador', 
            CONVERT(VARCHAR(5000),cc.Fecha_pago_planilla,103) AS 'V_Fecha_pago_planilla', 
            CONVERT(VARCHAR(5000),cc.Parcial) AS V_Parcial, 
            CONVERT(VARCHAR(5000),cc.Mes_cobro) AS V_Mes_cobro, 
            CONVERT(VARCHAR(5000),cc.Actividades_pp) AS 'V_actividades_pp',
            CONVERT(VARCHAR(5000),cc.Actividades_tp) AS 'V_actividades_tp',
            CONVERT(VARCHAR(5000),(SELECT sum(case when cuota=1 then b.[Valor_Cuota_1] else b.Valor_Mensual end) AS VM FROM cuotas a INNER JOIN Contratos b ON a.Contrato = b.id WHERE a.id <= $idCuota and contrato = (select contrato  from cuotas where id=$idCuota)  )) AS 'V_cancelado'
        
        FROM cuenta.dbo.Contratos c
        INNER JOIN cuenta.dbo.Base_Datos b ON c.No_Documento = b.Documento
        INNER JOIN cuenta.dbo.Cuotas cc ON c.id = cc.Contrato
        WHERE cc.Id = $idCuota;");
        
        $datosPdf = $queryResult[0];
        
        return view($vista, compact('datosPdf'));
        
    }
        

    public function registroCuotaa(Request $request)
    {
        $miIdContrato = $request->miIdContrato;
        $cuota = $request->cuota;
        $fecActa = $request->fecActa;
        $numPlantilla = $request->numPlantilla;
        $pinPlantilla = $request->pinPlantilla;
        $Operador = $request->Operador;
        $fecPago = $request->fecPago;
        $periodoPlanilla = $request->periodoPlanilla;
        $Actividades = $request->Actividades;
        
        $queryResult = DB::update("DECLARE @idCuota INT;
            EXEC [dbo].[registroCuota] $miIdContrato,
            $cuota,
            '$Actividades',
            '$numPlantilla',
            '$periodoPlanilla',
            '$fecActa',
            '$pinPlantilla',
            '$Operador',
            '$fecPago',@idCuota OUTPUT;
            SELECT @idCuota AS idCuota;");
        print_r($queryResult);die();
        // Obtén el valor de idCuota del resultado
        $idCuota = $queryResult[0]->idCuota;

        return $idCuota;
    }


    public function registroCuota(Request $request)
    {
        $idUser = auth()->user()->id; 
        $miIdContrato = $request->miIdContrato;
        $cuotas = $request->cuota;
        $fecActa = $request->fecActa;
        $numPlantilla = $request->numPlantilla;
        $pinPlantilla = $request->pinPlantilla;
        $Operador = $request->Operador;
        $fecPago = $request->fecPago;
        $periodoPlanilla = $request->periodoPlanilla;
        $Actividades = $request->Actividades;
        $Accion = $request->accion;

        $Actividades = str_replace('"',"",$Actividades);

        $primeProm = "cambiar el siguiente texto en primera y tercera persona de todos los puntos y no incluyas pronombre luego corrige la ortografia y puntuaciones y comas y conservando los '<br>': '";
        $segundoProm = "' y  retorna un json donde este los items primera_persona y dentro de este esten todos los puntos en primera persona en un solo texto y tercera_persona y dentro de este esten todos los puntos en tercera persona , guardando los saltos de linea con numeracion colocando un pipe . en un solo texto  ";
        $prom = $primeProm .$Actividades .$segundoProm;
        $apiKey = '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';
        $endpoint = 'https://api.openai.com/v1/chat/completions';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json; charset=utf-8',
        ])->post($endpoint, [
            'model' => 'gpt-3.5-turbo',
            // 'max_tokens' => 100000,
            'messages' => [
                ['role' => 'system', 'content' => 'eres la encargada de corregir ortografia acentos y puntuaciones de los texto que te pasen.'],
                ['role' => 'user', 'content' => $prom],
            ],
        ]);

        $respuestaActividades = $response->json()['choices'][0]['message']['content'];
        $respuestaActividades = json_decode($respuestaActividades, true);

        // Reemplazar "|" por saltos de línea
        // $respuestaActividades = str_replace('|', PHP_EOL, $respuestaActividades);
        $respuestaActividades = str_replace('|', '<br>', $respuestaActividades);

        // print_r($respuestaActividades);die();
        $Actividades_pp = $respuestaActividades['primera_persona'];
        $Actividades_tp = $respuestaActividades['tercera_persona'];

        // print_r($Actividades_pp);
        // print_r($Actividades_tp);die();

        // Verificar el valor de $Accion
        if ($Accion == 1) {
            // Crear una nueva instancia del modelo Cuota
            $cuota = new Cuota;
    
            // Calcular el porcentaje según la lógica del procedimiento almacenado
            $contrato = Contrato::find($miIdContrato);
            $cuotasTotales = $contrato->Cuotas;
            $Oficina = $contrato->Oficina;
            $porcentaje = round(($cuotas * 100) / $cuotasTotales,0);
            // print_r($porcentaje);die();
            // Calcular el parcial según la lógica del procedimiento almacenado
            $parcial = ($cuotas < $cuotasTotales) ? 'Parcial' : 'Final';
        
            // Establecer los valores de los atributos
            $cuota->Contrato = $miIdContrato;
            $cuota->Cuota = $cuotas;
            $cuota->Fecha_Acta = $fecActa;
            $cuota->Porcentaje = $porcentaje;
            $cuota->Actividades = $Actividades;
            $cuota->Planilla = $numPlantilla;
            $cuota->Perioro_Planilla = $periodoPlanilla;
            $cuota->Parcial = $parcial;
            $cuota->Mes_cobro = $fecPago;
            $cuota->Oficina = $Oficina;
            $cuota->Pin_planilla = $pinPlantilla;
            $cuota->Operador_planilla = $Operador;
            $cuota->Fecha_pago_planilla = $fecPago;
            // $cuota->Estado = 'CREADA';
            $cuota->Actividades_pp = $Actividades_pp;
            $cuota->Actividades_tp = $Actividades_tp;
        
            // Guardar la instancia del modelo en la base de datos
            $registrar = $cuota->save();
            // print_r($registrar);die();
            // Obtener el ID de la cuota después de guardar o actualizar  Actividades_pp
            $idCuota = $cuota->id;
            
            $cambioEstado = DB::update("EXEC [sp_cambioEstado] $idCuota,1,1,$idUser;");
        } elseif ($Accion == 2) {
            
            $contrato = Contrato::find($miIdContrato);
            $Oficina = $contrato->Oficina;
            $cuotaId = $request->idCuotaPro;
            $idCuota = $cuotaId;
            // Actualizar el modelo con los nuevos valores
            $actualizar = DB::update("update cuotas set Fecha_Acta = '$fecActa',Actividades = '$Actividades',Planilla = '$numPlantilla',Perioro_Planilla = '$periodoPlanilla' 
            ,Mes_cobro = '$fecPago',Pin_planilla = '$pinPlantilla',Operador_planilla = '$Operador', Fecha_pago_planilla = '$fecPago',Oficina = '$Oficina',Actividades_pp = '$Actividades_pp',Actividades_tp = '$Actividades_tp'
            where id = $cuotaId");
        } else {
            // Valor no válido para $Accion
            return response()->json(['error' => 'Valor no válido para Accion.'], 400);
        }
    
        return $idCuota;
    }

    


    public function tablaCuotas(Request $request)
    {
   

        $id = $request->id;
        // print_r($id);die();
        $datos = Cuota::where('Contrato',$id)->orderBy('Cuota','asc')->simplePaginate(12);
        $format = DB::select("select a.*,c.Cuota,c.Id as idCuota
        from Formatos a
        inner join Contratos b
        on a.Id_Dp = b.Id_Dp
        inner join Cuotas c
        on b.Id = c.Contrato
        where b.Id = $id
        and a.etapa <= (case when c.Cuota = b.Cuotas then 2 else 1 end) and a.etapa > 0
		order by c.Cuota,a.Id");
        // Convertir los datos a formato JSON
        $datosJson = json_encode($datos);   
        // print_r($datos);die();
        
        return view('tabla-parcial', compact('datos','format','datosJson'));
    }

    


    public function cargueDoc(Request $request)
    {
        
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
        ,$idCuota as idCuota
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
        // Convertir los datos a formato JSON
        // $datosJson = json_encode($datos);   
        // print_r($datos);die();
        
        return view('tablaCargueDoc', compact('datos'));
    }

    


    public function uploadFile(Request $request)
    {
        
        // $idContrato = $request->id;
        $idCuota = $request->idCuota;
        $idContrato = $request->idContrato;
        $idFormato = $request->idFormato;

        // print_r($idCuota);die();
        
        // $datos = DB::select("");

        // Validar y procesar el archivo PDF
        $request->validate([
            'archivo_pdf' => 'required|mimes:pdf|max:2048', // PDF y tamaño máximo 2MB
        ]);

        $archivoPDF = $request->file('archivo_pdf');

        // Generar un nombre de archivo único
        $nombreArchivo = $idCuota . '_' .$idFormato  .'.' .$archivoPDF->getClientOriginalExtension();

        // Guardar el archivo en storage/app/doc_cuenta
        $rutaAlmacenamiento = 'public\doc_cuenta';
        $archivoPDF->storeAs($rutaAlmacenamiento, $nombreArchivo);

        // Obtener la URL del archivo almacenado
        $rutaCompleta = Storage::path($rutaAlmacenamiento . '/' . $nombreArchivo);
        
        $queryResult = DB::select("SET NOCOUNT ON ;  DECLARE @idCuota INT; 
            EXEC [dbo].[registroCargueArchivo] $idContrato,
            $idCuota,
            '$rutaCompleta',
            $idFormato,@idCuota OUTPUT;
            SELECT @idCuota AS idCuota");
        
        $idCargueArchivo = $queryResult[0]->idCuota;    
        
        $datos = DB::select("SELECT f.Id
        ,ca.Ruta
        ,upper(ca.Estado) Estado
        ,ca.Observacion
        ,upper(f.Nombre) Nombre,f.tipo
        ,$idContrato as idContrato
        ,$idCuota as idCuota
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
        
        return view('tablaCargueDoc', compact('datos'));
    }

    


    public function btnEnviarCuota(Request $request)
    {
        $idUser = auth()->user()->id;
        $idContrato = $request->idContrato;
        $idCuota = $request->idCuota;
        $cambioEstado = DB::update("EXEC [sp_cambioEstado] $idCuota,2,1,$idUser;");
        
        // $queryResult = DB::update("UPDATE Cuotas SET Estado = 'ENVIADA',estado_juridica = 'PENDIENTE',UPDATED_AT = GETDATE()  WHERE Id = $idCuota");
        
        // print_r($id);die();
        $datos = Cuota::where('Contrato',$idContrato)->orderBy('Cuota','asc')->simplePaginate(12);
        $format = DB::select("select a.*,c.Cuota,c.Id as idCuota
        from Formatos a
        inner join Contratos b
        on a.Id_Dp = b.Id_Dp
        inner join Cuotas c
        on b.Id = c.Contrato
        where b.Id = $idContrato
        and a.etapa = case when c.Cuota = b.Cuotas then 2 else 1 end
		order by c.Cuota,a.Id");
        // Convertir los datos a formato JSON
        $datosJson = json_encode($datos);   
        // print_r($datos);die();
        
        return view('tabla-parcial', compact('datos','format','datosJson'));
    }


    public function nextCuenta(Request $request)
    {
        
        $idContrato = $request->idContrato;
        
        $datos = DB::select("select b.Id
        ,case when (max(a.Cuota) + 1) <= b.Cuotas then (max(a.Cuota) + 1) else 1 end  cuota
        ,case when (max(a.Cuota) + 1) <= b.Cuotas then 'Cuota ' + ltrim(rtrim(str((max(a.Cuota) + 1)))) else str(1) end  txtCuota
        ,b.Cuotas
        from Contratos b
        left join Cuotas a on b.Id = a.Contrato
        where b.id = $idContrato
        group by b.Id,b.Cuotas");

        // Convertir los datos a formato JSON
        $datosJson = json_encode($datos);
        
        return $datos;
    }

    public function generarZipSap(Request $request)
    {
        // print_r($request->idCuota);die();
        $idCuota = $request->idCuota;
        $idUsuario = auth()->user()->id;

        // Obtén la lista de archivos a comprimir
        $archivosAComprimir = DB::select("select a.Id_contrato 
        ,replace(a.Ruta,'http://avapp.digital/cf/public/storage','public') as Ruta
        ,d.Nombre as nameContratista,c.Nombre as nameFile,id_cuota 
        ,e.Cuota
        from Cargue_Archivo a
        left join Contratos b on a.Id_contrato = b.id
        inner join Formatos c on a.Id_formato = c.Id
        left join Base_Datos d on b.No_Documento = d.Documento
        inner join Cuotas e on a.id_cuota = e.Id
        where e.Estado_juridica = 'APROBADA'
        and id_cuota = $idCuota and a.Estado = 'APROBADA'
        union all
        select distinct a.Id_contrato
        ,replace(a.Ruta,'http://avapp.digital/cf/public/storage','public') as Ruta
        ,d.Nombre as nameContratista,c.Nombre as nameFile,e.Id 
        ,e.Cuota
        from Cargue_Archivo a
        left join Contratos b on a.Id_contrato = b.id
        inner join Formatos c on a.Id_formato = c.Id
        left join Base_Datos d on b.No_Documento = d.Documento
        inner join Cuotas e on a.Id_contrato = e.Contrato
        where a.Estado = 'APROBADA' and e.estado = 'APROBADA'
		and e.Id = $idCuota
        and c.Tipo = 1");

        $numeroAleatorio = strval(rand(1000, 9999)); // Genera un número aleatorio de 10 dígitos
        
        // print_r($archivosAComprimir);die();
        $cadenaAleatoriaNumerica = Str::substr($numeroAleatorio, 0, 4); // Asegura que la cadena tenga exactamente 10 caracteres
        $nombreZip = 'FUID_' .$cadenaAleatoriaNumerica .'.zip';
        
        // Crea un archivo zip temporal
        $archivoZip = storage_path('app/temp/' . $nombreZip);
        $zip = new ZipArchive;
        if ($zip->open($archivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Crear el archivo Excel temporal
            
            // $excelFile = Excel::store(new exportLote, 'temp');
            $excelFile = Excel::store(new exportLote, 'temp/FUID_' .$cadenaAleatoriaNumerica .'.xlsx');

            // print_r($excelFile);die();
            foreach ($archivosAComprimir as $archivo) {
                // Agrega cada archivo al zip
                $rutaArchivo = storage_path('app/' . $archivo->Ruta);
                $nombreArchivo = $archivo->nameFile .'.pdf';

                // Especifica la ruta relativa (subcarpeta)
                $rutaRelativa = $archivo->Id_contrato .'_Cuota_' .$archivo->Cuota .'_' .$archivo->nameContratista .'/' . $nombreArchivo;
                $nombreZip = 'Cuota_' .$archivo->Cuota .'_' .$archivo->nameContratista;
                $zip->addFile($rutaArchivo, $rutaRelativa);
                // print_r($zip);die();
            }
            
            // $zip->addFile(storage_path('app/temp/FUID_' .$cadenaAleatoriaNumerica .'.xlsx'), 'data.xlsx');
            // $zip->addFromString('data.xlsx', $excelFile->getFile()->getContents());
            $zip->close();
            // $up = DB::update("exec InsertAndUpdateLotes '$idLote',$idDependencia");
            // Devuelve el archivo zip al usuario
            return response()->download($archivoZip, $nombreZip)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'No se pudo crear el archivo comprimido'], 500);
        }
    }

    public function enviarAdmin(Request $request)
    {
        $idUsuario = auth()->user()->id;
        $idDependencia = auth()->user()->id_dp;
        // print_r($idUsuario);die();
        $update = DB::update("exec InsertAndUpdateLotes $idDependencia,$idUsuario");

        return $update;
    }

    public function generarZipOld(Request $request)
    {
        
        $idUsuario = auth()->user()->id;
        $idLote = $request->idLote;
        $idDependencia = 1;

        // Obtén la lista de archivos a comprimir
        $archivosAComprimir = DB::select("select a.Id_contrato 
        ,replace(a.Ruta,'http://avapp.digital/cf/public/storage','public') as Ruta
        ,d.Nombre as nameContratista,c.Nombre as nameFile,id_cuota 
        ,e.Cuota
        from Cargue_Archivo a
        left join Contratos b on a.Id_contrato = b.id
        inner join Formatos c on a.Id_formato = c.Id
        left join Base_Datos d on b.No_Documento = d.Documento
        inner join Cuotas e on a.id_cuota = e.Id
        where e.Estado_juridica = 'APROBADA'
        and id_cuota is not null
        union all
        select distinct a.Id_contrato
        ,replace(a.Ruta,'http://avapp.digital/cf/public/storage','public') as Ruta
        ,d.Nombre as nameContratista,c.Nombre as nameFile,e.Id 
        ,e.Cuota
        from Cargue_Archivo a
        left join Contratos b on a.Id_contrato = b.id
        inner join Formatos c on a.Id_formato = c.Id
        left join Base_Datos d on b.No_Documento = d.Documento
        inner join Cuotas e on a.Id_contrato = e.Contrato
        where a.Estado = 'APROBADA' and e.estado = 'APROBADA'
        and c.Tipo = 1");

        $numeroAleatorio = strval(rand(1000, 9999)); // Genera un número aleatorio de 10 dígitos
        
        // print_r($archivosAComprimir);die();
        $cadenaAleatoriaNumerica = Str::substr($numeroAleatorio, 0, 4); // Asegura que la cadena tenga exactamente 10 caracteres
        $nombreZip = 'FUID_' .$cadenaAleatoriaNumerica .'.zip';
        
        // Crea un archivo zip temporal
        $archivoZip = storage_path('app/temp/' . $nombreZip);
        $zip = new ZipArchive;
        if ($zip->open($archivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Crear el archivo Excel temporal
            
            // $excelFile = Excel::store(new exportLote, 'temp');
            $excelFile = Excel::store(new exportLote, 'temp/FUID_' .$cadenaAleatoriaNumerica .'.xlsx');

            // print_r($excelFile);die();
            foreach ($archivosAComprimir as $archivo) {
                // Agrega cada archivo al zip
                $rutaArchivo = storage_path('app/' . $archivo->Ruta);
                $nombreArchivo = $archivo->nameFile .'.pdf';

                // Especifica la ruta relativa (subcarpeta)
                $rutaRelativa = $archivo->Id_contrato .'_Cuota_' .$archivo->Cuota .'_' .$archivo->nameContratista .'/' . $nombreArchivo;
                
                $zip->addFile($rutaArchivo, $rutaRelativa);
                // print_r($zip);die();
            }
            
            $zip->addFile(storage_path('app/temp/FUID_' .$cadenaAleatoriaNumerica .'.xlsx'), 'data.xlsx');
            // $zip->addFromString('data.xlsx', $excelFile->getFile()->getContents());
            $zip->close();
            $up = DB::update("exec InsertAndUpdateLotes '$idLote',$idDependencia");
            // Devuelve el archivo zip al usuario
            return response()->download($archivoZip, $nombreZip)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'No se pudo crear el archivo comprimido'], 500);
        }
    }


public function contratos_vigentes(Request $request)
{
    $periodoSeleccionado = $request->input('periodo', ''); 
    $documento = $request->input('documento', ''); 
    $nombre = $request->input('nombre', ''); 
    $id_dp = auth()->user()->id_dp;

    // Generar dinámicamente las opciones de periodo
    $opcionesPeriodo = [];

    // Obtener el mes y el año actuales
    $mesActual = date('m');
    $anioActual = date('Y');

    // Concatenar el mes y el año para formar el período actual
    $periodoActual = str_pad($mesActual, 2, '0', STR_PAD_LEFT) . $anioActual;

    for ($i = 1; $i <= 12; $i++) {
        $mes = str_pad($i, 2, '0', STR_PAD_LEFT);
        $anio = date('Y');

        $periodo = "$mes$anio";

        // Agregar la opción con un marcador para identificar el período actual
        $opcionesPeriodo[$periodo] = ($i == $mesActual) ? "Periodo $periodo (Actual)" : "Periodo $periodo";
    }

    // Si no se ha seleccionado ningún período, establecer el período actual como seleccionado por defecto
    if (empty($periodoSeleccionado)) {
        $periodoSeleccionado = $periodoActual;
    }

    $query = "
    SELECT DISTINCT Num_Contrato, No_Documento, b.nombre, a.Estado, a.Interventor, Plazo, Cuotas, (select Oficina from oficinas where id=a.oficina) as Oficina,
   (SELECT RIGHT(REPLACE(CONVERT(VARCHAR(10), DATEADD(MONTH, cuota - 1, CONVERT(DATETIME, a.Fecha_Notificacion, 105)), 105), '-', ''), 6)
    FROM cuenta.dbo.cuotas
    WHERE a.id = contrato AND (RIGHT(REPLACE(CONVERT(VARCHAR(10), DATEADD(MONTH, cuota - 1, CONVERT(DATETIME, a.Fecha_Notificacion, 105)), 105), '-', ''), 6))
    ='$periodoSeleccionado') AS mes,
   (SELECT Cuota FROM cuenta.dbo.cuotas WHERE a.id = contrato AND (RIGHT(REPLACE(CONVERT(VARCHAR(10), DATEADD(MONTH, cuota - 1, CONVERT(DATETIME, a.Fecha_Notificacion, 105)), 105), '-', ''), 6))
   ='$periodoSeleccionado') AS Cuota,
   (SELECT Estado_juridica FROM cuenta.dbo.cuotas WHERE a.id = contrato AND (RIGHT(REPLACE(CONVERT(VARCHAR(10), DATEADD(MONTH, cuota - 1, CONVERT(DATETIME, a.Fecha_Notificacion, 105)), 105), '-', ''), 6))
   ='$periodoSeleccionado') AS Estado_juridica,
   (SELECT name FROM cuenta.dbo.cuotas INNER JOIN Cuenta.dbo.users u ON id_user = u.id WHERE a.id = contrato AND (RIGHT(REPLACE(CONVERT(VARCHAR(10), DATEADD(MONTH, cuota - 1, CONVERT(DATETIME, a.Fecha_Notificacion, 105)), 105), '-', ''), 6))
   ='$periodoSeleccionado') AS Responsable
   FROM [Cuenta].[dbo].[Contratos] a
   INNER JOIN cuenta.dbo.Base_Datos b ON a.No_Documento = b.Documento
   WHERE a.ESTADO = 'VIGENTE' and Id_Dp = $id_dp
   ";

    if ($documento != '') {
        $query .= " AND a.No_Documento = '$documento'";
    }

    if ($nombre != '') {
        $query .= " AND b.nombre LIKE '%$nombre%'";
    }

    // Ejecutar la consulta y obtener los datos
    $datos = DB::select($query);

    return view('contratos_vigentes', compact("datos", "periodoSeleccionado", "opcionesPeriodo", "periodoActual"));
}



    public function readPdf(Request $request)
    {
        // Obtener el archivo PDF del objeto Request
        $pdfFile = $request->file('pdf');
        print_r($request);die();

        // Leer el contenido del PDF
        $pdfContent = $pdfFile->get();

        // Usar la biblioteca para extraer texto del PDF
        $text = (new pdfTex())->setPdf($pdfContent)->text();
        print_r($text);die();

        // Utilizar expresiones regulares para encontrar el valor del campo "RPC No."
        preg_match('/RPC No\. (\d+)/', $text, $matches);

        // El valor buscado estará en $matches[1]
        $rpcNumber = isset($matches[1]) ? $matches[1] : null;

        return $rpcNumber;
    }

    public function validarDocumento(Request $request){
        $documento = $request->documento;
        $consultar = DB::select("select count(id) as val from base_datos where documento = $documento");
        // print_r($consultar[0]->val);die();
        return $consultar[0]->val;
    }


    public function notificacion(Request $request)
    {
        $id = $request->id; 
        $idCuota = $request->idCuota;
        
        $queryResult = DB::select("SELECT 
            CONVERT(VARCHAR(5000),b.Nombre) AS 'V_nombre', 
            CONVERT(VARCHAR(5000),LTRIM(RTRIM(STR(c.No_Documento)))) AS 'V_CC', 
			CONVERT(VARCHAR(5000),b.correo) AS 'V_Correo', 
            CONVERT(VARCHAR(5000),cc.Cuota) AS 'V_no_cuota', 
            CONVERT(VARCHAR(5000),cc.Fecha_Acta,103) AS 'V_fecha_cuenta', 
			CONVERT(VARCHAR(5000),cc.idEstado) AS 'V_id_estado', 
			CONVERT(VARCHAR(5000),(select estadoUsuario from Cambio_estado where id=cc.idEstado)) as 'Estado',
			DATENAME(month, DATEADD(month, cc.Perioro_Planilla - 1, '1900-01-01')) AS 'V_periodo_nombre'
        FROM cuenta.dbo.Contratos c
        INNER JOIN cuenta.dbo.Base_Datos b ON c.No_Documento = b.Documento
        INNER JOIN cuenta.dbo.Cuotas cc ON c.id = cc.Contrato
        WHERE cc.Id = $idCuota;");

        $data = $queryResult[0];
        
        Mail::to($data->V_Correo)->send(new Notificacion($data));

        return "Correo electrónico enviado correctamente.";
    }




    public function asignarUser(Request $request){
        $idCuota = $request->idCuota;
        $idUser = $request->idUser;

        $actualizacion = DB::update("update cuotas set id_user = $idUser where id = $idCuota");
        return $actualizacion;
        
    }

}
