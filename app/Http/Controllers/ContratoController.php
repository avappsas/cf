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
use App\Exports\ContratosExport;   // ← Asegúrate de esta línea

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
        $id_dp = auth()->user()->id_dp; // identidica la dependencia
        $id_pro = auth()->user()->pro ?? 0; // identifica si es version Pro
        $fecha_c = DB::table('fecha_cuenta')
            ->where('id_dp', $id_dp)
            ->where('fecha_max', '>=', Carbon::now()->format('Y-m-d'))
            ->value('fecha_cuenta');
        
        $fecha_formateada = $fecha_c ? Carbon::parse($fecha_c)->format('j-M-Y') : null;
 
 
        if ($fecha_c) {
            // La fecha_cuenta está definida
            $fecha_mensaje = 'Informa que tu fecha para pasar cuenta es: ' . $fecha_formateada;
        } else {
            // La fecha_cuenta no está definida
            $fecha_mensaje = 'Informa que tu fecha para pasar cuenta no se ha definido';
        }

        $idusuario = auth()->user()->usuario;
        
        $contratos = DB::table('contratos as c')
        ->leftjoin('oficinas as o', 'o.id', '=', 'c.oficina')
        ->select('c.*', 'o.oficina as N_Oficina')
        ->where('c.No_Documento', $idusuario)
        ->orderByDesc('c.id')
        ->simplePaginate(50);
        
        $contratoActividades = DB::table('contratos as c')
        ->where('c.No_Documento', $idusuario)
        ->where('c.Estado', 'Vigente')
        ->orderByDesc('c.id') // o 'c.Id' si tu campo es con mayúscula
        ->value('c.Actividades');
        

        $operadores = DB::table('Operadores_planillas')
        // ->select()
        ->pluck(
            'Operador',
            'Id');

        //print_r($contratoActividades);die();

        return view('contrato.index', compact('contratos','operadores','fecha_mensaje','fecha_formateada','id_pro','contratoActividades'))
            ->with('i', (request()->input('page', 1) - 1) * $contratos->perPage());
    }

  public function edit($id)
    {
        // 1) Traer el modelo o fallar con 404
        $contrato = Contrato::findOrFail($id);
        $id_dp = DB::table('contratos')
            ->where('id', $id) // ← corregido: usar $id en vez de $idContrato
            ->value('Id_Dp');

        // 2) Listados para selects
        $oficinas = DB::table('Oficinas')
            ->where('estado', 1)
            ->where('id_dp', $id_dp)
            ->pluck('Oficina', 'Id');

        $interventores = DB::table('Interventores')
            ->where('estado', 1)
            ->where('id_dp', $id_dp)
            ->pluck('nombre', 'Id');
        
        $max_nc = DB::table('contratos')
        ->where('Id_Dp', $id_dp)
        ->whereYear('Plazo', date('Y')) // solo del año actual
        ->max('N_C');

        $next_nc = $max_nc ? $max_nc + 1 : 1;

        $next_num_contrato = '100.8.4.' . $next_nc . '.' . date('Y');
    
            
        // 3) Obtener el nombre de la persona
        $Documento = $contrato->No_Documento;          // ← punto y coma
        $nombre    = DB::table('Base_Datos')
                       ->where('Documento', $Documento)
                       ->value('Nombre');             // devuelve string o null
    
        // 4) Renderizar la vista correcta con compact bien escrito
        return view('contrato.form', [
        'contrato'         => $contrato,
        'oficinas'         => $oficinas,
        'interventores'    => $interventores,
        'nombre'           => $nombre,
        'next_nc'          => $next_nc,
        'next_num_contrato'=> $next_num_contrato,
        ]);
    }
 
 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  
        public function create(Request $request)
        {
            // 1) Recibir la cédula por query-string: /contratos/create?documento=1234
            $documento = $request->query('documento');
        
            // 2) Crear el modelo vacío y precargar la cédula
            $contrato = new Contrato();
            $contrato->No_Documento = $documento;
        
            // 3) Buscar el nombre en Base_Datos (solo nombre ahora)
            $nombre = $documento
                ? DB::table('Base_Datos')
                    ->where('Documento', $documento)
                    ->value('Nombre')
                : null;
        
            // 4) Obtener id_dp desde el usuario autenticado
            $id_dp = auth()->user()->id_dp;

            $max_nc = DB::table('contratos')
            ->where('Id_Dp', $id_dp)
            ->whereYear('Plazo', date('Y')) // solo del año actual
            ->max('N_C');

            $next_nc = $max_nc ? $max_nc + 1 : 1;

            $next_num_contrato = '100.8.4.' . $next_nc . '.' . date('Y');
    
            // 5) Cargar selects filtrados por id_dp
            $oficinas = DB::table('Oficinas') ->where('estado', 1) ->where('id_dp', $id_dp) ->pluck('Oficina', 'Id');
        
            $interventores = DB::table('Interventores') ->where('estado', 1) ->where('id_dp', $id_dp) ->pluck('nombre', 'Id');
        
            // 6) Enviar datos a la vista
            return view('contrato.form', compact(
                'contrato',
                'nombre',
                'oficinas',
                'interventores' ,'next_nc','next_num_contrato'
            ));
        }


        public function create2(Request $request)
        {
            // 1) Recibir la cédula por query-string: /contratos/create?documento=1234
            $documento = $request->query('documento');
        
            // 2) Crear el modelo vacío y precargar la cédula
            $contrato = new Contrato();
            $contrato->No_Documento = $documento;
        
            // 3) Buscar el nombre en Base_Datos (solo nombre ahora)
            $nombre = $documento
                ? DB::table('Base_Datos')
                    ->where('Documento', $documento)
                    ->value('Nombre')
                : null;
        
            // 4) Obtener id_dp desde el usuario autenticado
            $id_dp = auth()->user()->id_dp; 

            $inicio_estado = DB::table('Dependencias') ->where('Id', $id_dp) ->value('inicio_estado_contratacion');
 
            // 5) Cargar selects filtrados por id_dp
            $oficinas = DB::table('Oficinas') ->where('estado', 1) ->where('id_dp', $id_dp) ->pluck('Oficina', 'Id'); 
        
            // 6) Enviar datos a la vista
            return view('contrato.inicio', compact('contrato','nombre','oficinas','inicio_estado'));

        }


           public function vercontratos($documento)
        {
            $id_dp    = auth()->user()->id_dp; 
            // si también necesitas filtrar por dependencia, agrégalo en el WHERE
            $idusuario = auth()->user()->usuario;

            $nombre = DB::table('Base_Datos')
            ->where('Documento', $documento)
            ->value('Nombre');  // devuelve la cadena o null

            $contratos = DB::table('contratos as c')
                ->leftjoin('oficinas as o', 'o.id', '=', 'c.oficina')
                ->select('c.*', 'o.oficina as N_Oficina')
                ->where('c.No_Documento', $documento)
                ->orderBy('c.Id', 'desc')   
                ->simplePaginate(50);
        
            return view('contrato.vercontratos', compact('contratos', 'nombre','documento'))
                ->with('i', (request()->input('page', 1) - 1) * $contratos->perPage());
        }
    
        public function otrosi($id)
        {
            // 1) Recupera el contrato original
            $orig = Contrato::findOrFail($id);
        
            // 2) Crea un nuevo Contrato y asigna sólo los campos que quieres copiar
            $nuevo = new Contrato();
            $nuevo->No_Documento  = $orig->No_Documento;
            $nuevo->N_C           = $orig->N_C;
            $nuevo->Num_Contrato  = $orig->Num_Contrato;
            $nuevo->Oficina       = $orig->Oficina;
            $nuevo->Interventor   = $orig->Interventor;
            $nuevo->Nivel         = $orig->Nivel;
            $nuevo->Objeto        = $orig->Objeto;
            $nuevo->Actividades   = $orig->Actividades;
            $nuevo->Modalidad     = 'Otrosí';
        
            // (Opcional) Si quieres que arranque en estado Vigente
            $nuevo->Estado        = 'Vigente';
        
            // 3) Guarda el nuevo registro (SQL Server generará un nuevo Id automáticamente)
            $nuevo->save();
        
            // 4) Redirige al edit del nuevo contrato
            return redirect()
                ->route('contratos.edit', $nuevo->Id)
                ->with('success', 'Se creó el Otrosí correctamente.');
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

        return redirect()->route('contratos.all')
            ->with('success', 'Contrato created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $contrato = Contrato::find($id);

    //     return view('contrato.show', compact('contrato'));
    // }
    public function show(Contrato $contrato)
    {
 
    
        return view('contrato.show', compact('contrato'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
 
  
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

        
 
        $doc = $contrato->No_Documento;
        return redirect()->away("https://cuentafacil.co/vercontratos/{$doc}");
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
    
    // ContratoController.php
    public function interventoresPorOficina($oficinaId)
    {
    
        $interventores = DB::table('Interventores')
            ->where('estado', 1)
            ->where('Id_oficina', $oficinaId) 
            ->pluck('nombre', 'id');

        return response()->json($interventores);
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
    $id      = $request->input('id');
    $idCuota = $request->input('idCuota');

    // 1) Obtengo el formato, con binding de parámetros
    $formato = DB::table('Formatos')->where('Id', $id)->first();
    if (! $formato) {
        abort(404, "Formato con Id {$id} no encontrado");
    }
    $vista = $formato->Vista;

    // 2) Obtengo los datos de la cuenta
    $datosPdf = DB::table('Datos_cuenta')
                  ->where('Id', $idCuota)
                  ->first();
    if (! $datosPdf) {
        abort(404, "Datos de cuenta con Id {$idCuota} no encontrados");
    }

    // 3) Dependientes
    $dependientes = DB::table('familiares_dependientes')
        ->select('categoria','nombre','identificacion','parentesco')
        ->where('documento_bd', $datosPdf->V_CC)
        ->orderBy('categoria')
        ->get();

    // 4) Retorno la vista dinámica
    return view($vista, compact('datosPdf', 'dependientes'));
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
        $Actividades_pp = $request->Actividades_pp;
        $Actividades_tp = $request->Actividades_tp;
        $Accion = $request->accion;

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
       
        $datos = Cuota::where('Contrato',$id)->orderBy('Cuota','asc')->simplePaginate(12);
        $num_contrato = DB::table('Contratos')
                        ->where('id', $id)
                        ->value('Num_Contrato');

 

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
        
        return view('tabla-parcial', compact('datos','format','datosJson','num_contrato'));
    }

    


    public function cargueDoc(Request $request)
    {
        
        // $idContrato = $request->id;
        $idCuota = $request->idCuota;
        $idContrato = $request->idContrato;

        // print_r($id);die();
        
        $datos = DB::select("SELECT f.Id
        ,ca.Ruta
        ,case when ca.Estado is null then (case when  f.Opcional=1  then 'OPCIONAL' else upper(ca.Estado) end) else upper(ca.Estado) end AS Estado
        ,ca.Observacion
        ,CASE  WHEN f.Nombre = 'PLANILLA' THEN  'PLANILLA - Base: $' + FORMAT(CASE   WHEN (SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 0.4 < 1423500 THEN CAST(1423500 AS MONEY)
        ELSE (SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 0.4 END,'N0','es-ES') ELSE UPPER(f.Nombre) END AS Nombre
        ,f.tipo
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
                and a.etapa <= (case when c.Cuota = b.Cuotas then 2 else 1 end) and a.tipo > (case when c.Cuota = 1 then -1 else 0 end)
        ) c on f.Id = c.Id
        order by f.tipo desc");
        // Convertir los datos a formato JSON
        // $datosJson = json_encode($datos);   
        // print_r($datos);die();
        
        return view('tablaCargueDoc', compact('datos'));
    }

    
    public function cargueContrato(Request $request)
    {
         
        $idContrato = $request->idContrato;
        $estadoContrato = DB::table('contratos')->where('id', $idContrato)->value('Estado'); 
    
        $tipos = [3]; 
        $estadoLow = strtolower($estadoContrato);        // Llevamos todo a minúsculas para comparar 
        if ($estadoLow === 'firma hoja de vida' || $estadoLow === 'documentos aprobados') { $tipos[] = 5; } 
        $inLista = implode(',', $tipos);

        $datos = DB::select("SELECT f.Id
        ,ca.Ruta
        ,CASE WHEN ESTADO IS NULL THEN  (case when  f.Opcional=1  then '(SI APLICA)' else upper(ca.Estado) end)   else Estado end AS Estado
        ,ca.Observacion
        ,upper(f.Nombre) Nombre,f.tipo
        ,1 as idCuota
        ,$idContrato as idContrato 
        FROM Formatos f 
		Left JOIN (select * from Cargue_Archivo ca WHERE ca.Id_contrato=$idContrato  AND Estado != 'ANULADO')ca ON f.Id = ca.Id_formato
        left join ( select distinct a.Id, b.Nivel
                from Formatos a
                inner join Contratos b
                on a.Id_Dp = b.Id_Dp 
                where b.Id = $idContrato   
        ) c on f.Id = c.Id
		where tipo IN ($inLista)
        order by f.id asc"); 
        
        return view('tablaCargueDoc', compact('datos','estadoContrato'));
    }


    public function uploadFile(Request $request)
    {
        
        // $idContrato = $request->id;
        $idCuota = $request->idCuota;
        $idContrato = $request->idContrato;
        $idFormato = $request->idFormato;
        $estadoContrato = DB::table('contratos')->where('id', $idContrato)->value('Estado');  
        $idestadoContrato = DB::table('contratos')->where('id', $idContrato)->value('id_estado'); 
        // print_r($idCuota);die();
        
        // $datos = DB::select("");

        // Validar y procesar el archivo PDF
        $request->validate([
            'archivo_pdf' => 'required|mimes:pdf|max:2048', // PDF y tamaño máximo 2MB
        ]);

        $archivoPDF = $request->file('archivo_pdf');

        // Generar un nombre de archivo único
        $nombreArchivo = $idContrato . '_' . $idCuota . '_' .$idFormato  .'.' .$archivoPDF->getClientOriginalExtension();

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

        if ($idCuota == 1) {

            if( str_contains($estadoContrato,'Solicitud CDP')){
 
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
                    where c.buzon IN (1)
                    order by f.Id asc"); 

            } elseif( str_contains($estadoContrato,'RPC')){
 
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
                    where c.buzon IN (2,3)
                    order by f.Id asc"); 

            }
            
            else {

                    $tipos = [3]; 
                    $estadoLow = strtolower($estadoContrato);        // Llevamos todo a minúsculas para comparar 
                    if ($estadoLow === 'firma hoja de vida' || $estadoLow === 'documentos aprobados'|| $estadoLow === 'documentos aprobados') { $tipos[] = 5; } 
                    $inLista = implode(',', $tipos); 

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
                        where f.tipo IN ($inLista)
                        order by f.Id asc"); 

            }



        } else {

            $datos = DB::select("SELECT f.Id
            ,ca.Ruta
            ,case when ca.Estado is null then (case when  f.Opcional=1  then 'OPCIONAL' else upper(ca.Estado) end) else upper(ca.Estado) end AS Estado
            ,ca.Observacion
            ,CASE  WHEN f.Nombre = 'PLANILLA' THEN  'PLANILLA - Base: $' + FORMAT(CASE   WHEN (SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 0.4 < 1423500 THEN CAST(1423500 AS MONEY)
            ELSE (SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 0.4 END,'N0','es-ES') ELSE UPPER(f.Nombre) END AS Nombre
            ,f.tipo
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
                    and a.etapa <= (case when c.Cuota = b.Cuotas then 2 else 1 end) and a.tipo > (case when c.Cuota = 1 then -1 else 0 end)
            ) c on f.Id = c.Id
            order by f.tipo desc");
        }


          
        return view('tablaCargueDoc', compact('datos'));
    }

     public function uploadHV(Request $request)
    {
         
        $idCuota = $request->idCuota;
        $idCuotafiltro = $request->idCuota;
        $idContrato = $request->idContrato;
        $idFormato = $request->idFormato;
        $estadoContrato = DB::table('contratos') ->where('id', $idContrato) ->value('Estado');
        $idUser = auth()->user()->id;
        $perfiUser = DB::table('UserPerfil') ->where('idUser', $idUser) ->where('idPerfil', '>', 2) ->pluck('idPerfil')  ->toArray();       
        $perfil = $perfiUser[0] ; 


        $request->validate([
            'archivo_pdf' => 'required|mimes:pdf|max:2048', // PDF y tamaño máximo 2MB
        ]);

        $archivoPDF = $request->file('archivo_pdf');

        // Generar un nombre de archivo único
        $nombreArchivo = $idContrato . '_' . $idCuota . '_' .$idFormato  .'.' .$archivoPDF->getClientOriginalExtension();

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

                $tipos = [3];
                if (strtoupper($estadoContrato) === 'Firma Hoja de Vida' || strtoupper($estadoContrato) === 'DOCUMENTOS APROBADOS') {
                    $tipos[] = 5;
                }
                // Convertimos a un string '3,5' o '3' para el IN()
                $inLista = implode(',', $tipos);
  
  
        if($idCuota > 1 ) {

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
            

        } else{   
 
                    $datos = DB::select("SELECT f.Id
                    ,ca.Ruta
                    ,upper(ca.Estado) Estado
                    ,ca.Observacion
                    ,CASE WHEN f.Nombre = 'PLANILLA' THEN  'PLANILLA - Base: $' +  FORMAT( CAST( CASE WHEN ((SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 40 / 100) < 1423500 THEN '1.423.500' 
                    ELSE ((SELECT Valor_Mensual FROM Contratos WHERE id = $idContrato) * 40 / 100)  END  AS MONEY), 'N0', 'es-ES')  ELSE UPPER(f.Nombre) END AS Nombre
                    ,f.tipo
                    ,$idContrato as idContrato
                    ,1 as idCuota,ca.Id as Id_cargue_archivo
                    FROM Formatos f Left JOIN 
                    (select * from Cargue_Archivo ca WHERE ca.Id_contrato=$idContrato   AND Estado != 'ANULADO')ca ON f.Id = ca.Id_formato
                    inner join (
                    select a.Id
                            from Formatos a
                            inner join Contratos b
                            on a.Id_Dp = b.Id_Dp 
                            where b.Id = $idContrato  
                            and a.tipo IN ($inLista)
                    ) c on f.Id = c.Id
                    order by f.tipo asc");
        }

            return view('tablaDocJuridica', compact('datos','estadoContrato','perfil')); 
    }

 

    public function btnEnviarCuota(Request $request)
    {
        $idUser = auth()->user()->id;
        $idContrato = $request->idContrato;
        $idCuota = $request->idCuota;
    
        // Validación: si idCuota es nulo o igual a 1, redirigir
        if (is_null($idCuota) || $idCuota == 1) {

            $estadoContrato = DB::table('contratos')->where('id', $idContrato)->value('id_estado');  
            $estado = DB::table('Cambio_estado')->where('id', $estadoContrato)->value('pos_estado'); 
            $idnuevoestado = DB::table('Cambio_estado')->where('id', $estado)->first();

            if ($idnuevoestado) {
            DB::table('contratos')
                ->where('id', $idContrato) 
                    ->update(['Estado' => $idnuevoestado->EstadoUsuario,'id_estado' => $idnuevoestado->id]);
            }

        }
 
        // Ejecutar SP
        $cambioEstado = DB::update("EXEC [sp_cambioEstado] $idCuota,2,1,$idUser;");
    
        // Obtener datos
        $datos = Cuota::where('Contrato', $idContrato)->orderBy('Cuota', 'asc')->simplePaginate(12);

        $num_contrato = DB::table('Contratos')
        ->where('id', $idContrato)
        ->value('Num_Contrato');

        $format = DB::select("
            select a.*, c.Cuota, c.Id as idCuota
            from Formatos a
            inner join Contratos b on a.Id_Dp = b.Id_Dp
            inner join Cuotas c on b.Id = c.Contrato
            where b.Id = $idContrato
            and a.etapa = case when c.Cuota = b.Cuotas then 2 else 1 end
            order by c.Cuota, a.Id
        ");
    
        $datosJson = json_encode($datos);
    
        return view('tabla-parcial', compact('datos', 'format', 'datosJson','num_contrato'));
    }


    public function nextCuenta(Request $request)
    {
        
        $idContrato = $request->idContrato;
        
        $datos = DB::select("SELECT
            b.Id, CASE  WHEN (MAX(a.Cuota) + 1) <= b.Cuotas THEN (MAX(a.Cuota) + 1)  ELSE 1 END AS cuota,
            CASE  WHEN (MAX(a.Cuota) + 1) <= b.Cuotas  THEN 'Cuota ' + LTRIM(RTRIM(STR((MAX(a.Cuota) + 1))))  ELSE STR(1) 
            END AS txtCuota, b.Cuotas,
            FORMAT( DATEADD(  MONTH, ( CASE WHEN (MAX(a.Cuota) + 1) <= b.Cuotas THEN (MAX(a.Cuota) + 1) ELSE 1 END ) - 1, b.Fecha_Suscripcion ), 'MMMM', 'es-ES' ) AS Mes_cuota
        FROM Contratos b
        LEFT JOIN Cuotas a ON b.Id = a.Contrato
        WHERE b.Id = $idContrato
        GROUP BY  b.Id, b.Cuotas, b.Fecha_Suscripcion;");
 

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
        ,replace(a.Ruta,'https://cuentafacil.co/storage','public') as Ruta
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
        ,replace(a.Ruta,'https://cuentafacil.co/storage','public') as Ruta
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
        ,replace(a.Ruta,'https://cuentafacil.co/storage','public') as Ruta
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
        ,replace(a.Ruta,'https://cuentafacil.co/storage','public') as Ruta
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


    public function allcontratos(Request $request)
    {
        // 1. Parámetros de búsqueda
        $query  = $request->input('query');
        $estado = $request->input('estado', '');
        $anio   = $request->input('anio', date('Y'));
        $mes    = $request->input('mes');
    
        // 2. Consulta base
        $q = DB::table('Historico_Contratos')
            ->orderByDesc('N_C');
    
        // 3. Filtro por nombre dividido o documento
        if (!empty($query)) {
            $partes = explode(' ', trim($query));
        
            $q->where(function ($sub) use ($partes, $query) {
                foreach ($partes as $parte) {
                    $sub->where('Nombre', 'like', "%{$parte}%"); // ← cambia a where para combinar con AND
                }
        
                // También buscar por documento si es numérico
                if (is_numeric($query)) {
                    $sub->orWhere('Documento', 'like', "%{$query}%");
                }
            });
        }
    
        // 4. Filtro por estado
        if ($estado !== null && $estado !== '') {
            $q->where('Estado', $estado);
        }
    
        // 5. Filtro por año (Fecha_Fin)
        if (!empty($anio)) {
            $q->whereYear('Fecha_Fin', $anio);
        }
    
        // 6. Filtro por mes (Fecha_Inicio)
        if (!empty($mes)) {
            $q->whereMonth('Fecha_Inicio', $mes);
        }
    
        // 7. Ejecutar paginación
        $contratos = $q->simplePaginate(50);
    
        // 8. Listas para filtros
        $estados = DB::table('Historico_Contratos')
            ->select('Estado')
            ->groupBy('Estado')
            ->pluck('Estado', 'Estado');
    
        $anios = DB::table('Historico_Contratos')
            ->selectRaw('YEAR(Fecha_Inicio) as year')
            ->groupByRaw('YEAR(Fecha_Inicio)')
            ->orderByDesc('year')
            ->pluck('year', 'year');
    
        $meses = [
            ''  => '-- Todos --',
            '1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo',
            '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio',
            '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];
    
        // 9. Retornar la vista
        return view('Contratacion.allcontratos', compact(
            'contratos', 'estados', 'anios', 'meses',
            'query', 'estado', 'anio', 'mes'
        ));
    }
    
    
    
    public function export(Request $request)
    {
        // Toma todos los filtros de la query string
        $filters = $request->only(['query','estado','anio','mes']);

        //validacion para forzar a exportar solo el anio 2025
        $filters['anio'] = '2025';

        // Genera y descarga el Excel
        return Excel::download(
            new ContratosExport($filters),
            'contratos_export_' . date('Ymd_His') . '.xlsx'
        );
    }

    public function contratos_vigentes(Request $request)
    {
        $id_dp               = auth()->user()->id_dp;
        $search              = trim($request->input('search',''));
        $periodoSeleccionado = $request->input('periodo');
        $fSupervisor         = $request->input('supervisor','');
    
        // Generar períodos...
        $mesActual     = now()->month;
        $anioActual    = now()->year;
        $periodoActual = str_pad($mesActual,2,'0',STR_PAD_LEFT) . $anioActual;
    
        $opcionesPeriodo = collect(range(1,12))
            ->mapWithKeys(fn($mes) => [
                $mm = str_pad($mes,2,'0',STR_PAD_LEFT) . $anioActual
                => "Periodo {$mm}" . ($mes === $mesActual ? ' (Actual)' : '')
            ])->toArray();
    
        $periodoSeleccionado ??= $periodoActual;
    
        $listaSupervisores = DB::table('interventores')
            ->where('estado',1)
            ->orderBy('NOMBRE')
            ->pluck('NOMBRE');
    
        $query = DB::table('Informe_Cuentas')
            ->where('Id_Dp', $id_dp)
            ->where(function($q) use ($periodoSeleccionado) {
                $q->where('periodo', $periodoSeleccionado)
                  ->orWhereNull('periodo');
            });
    
        // 1) Búsqueda flexible sólo en Nombre, documento o contrato
        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $like = "%{$search}%";
                $q->where('Nombre',       'like', $like)
                  ->orWhere('No_Documento','like', $like)
                  ->orWhere('Num_Contrato','like', $like);
            });
        }
    
        // 2) Filtro de supervisor sólo si no está vacío
        $fSupervisor = $request->input('supervisor');

        if ($request->filled('supervisor')) {
            // Sólo filtra si supervisor existe y no es cadena vacía
            $query->where('Supervisor', $fSupervisor);
        }
    
        $datos = $query
            ->orderBy('Nombre')
            ->paginate(25)
            ->appends($request->only(['periodo','search','supervisor']));
    
        return view('Contratacion.contratos_vigentes', compact(
            'datos','periodoSeleccionado','periodoActual',
            'opcionesPeriodo','search','fSupervisor','listaSupervisores'
        ));
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



    public function getCertificado(Request $request)
    {
        // Obtener parámetros de la solicitud
        $nombre = $request->input('nombre');
        $no_documento = $request->input('cedula');
        $anio = $request->input('anio');

        // Fecha actual
        $fecha_hoy = Carbon::now();

        // Consulta a la base de datos usando parámetros seguros
        $contratos = DB::select("
                         SELECT     *
            FROM            [Cuenta].[dbo].[Historico_Contratos] AS c  
            WHERE c.No_documento = :no_documento 
            AND isnull(c.Año,c.Año) = isnull($anio,c.Año)
            order by c.Año desc, c.N_C desc
        ", [
            'no_documento' => $no_documento
        ]);

        // Convertir resultados a arrays
        $contratos = array_map(function ($contrato) {
            return (array) $contrato;
        }, $contratos);
        // ddd($contratos);
        // Si no se encuentran contratos, retornar un error o mensaje
        if (empty($contratos)) {
            return back()->with('error', 'No se encontraron contratos para el documento y año especificados.');
        }

        // Retornar la vista con los datos
        // return view('Contratacion.Certificacionlaboral', compact(
        //     'nombre',
        //     'no_documento',
        //     'contratos',
        //     'fecha_hoy'
        // ));

        // Opcional: Generar PDF
        $pdf = PDF::loadView('Contratacion.Certificacionlaboral', compact('nombre', 'no_documento', 'contratos', 'fecha_hoy'));
        return $pdf->download("certificado-$nombre.pdf");
    }





    
}
