<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade as PDF;
use ZipArchive;
use App\Models\Contrato;
use App\Models\Cuota;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use App\Exports\exportLote; 
use PhpOffice\PhpWord\Exception\Exception; 
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Cache;
use Spatie\Async\Pool;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use PhpOffice\PhpWord\PhpWord; 
use TCPDF; 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use Spatie\PdfToText\Pdf as pdfTex;
use Carbon\Carbon; // Asegúrate de importar Carbon
use App\Mail\Notificacion;
use Illuminate\Support\Facades\Mail; 
use App\Exports\ContratosExport;   // ← Asegúrate de esta línea
use App\Services\GoogleDocPdfService;
use Illuminate\Support\Arr;      
/**
 * Class ContratoController
 * @package App\Http\Controllers
 */

class ContratacionController extends Controller
{
    public function bandejacontrato(Request $request)
    {
        $idUser = auth()->user()->id;
        $id_dp = auth()->user()->id_dp;
        $hoy = now()->toDateString();
        $buscar = $request->input('buscar');
        $tabDestino = null;

        $recordatoriosHoy = DB::table('recordatorios_enviados')
            ->whereDate('enviado_en', $hoy)
            ->pluck('id_contrato')
            ->toArray();

        $perfiUser = DB::table('UserPerfil')->where('idUser', $idUser)->where('idPerfil', '!=', 2)->pluck('idPerfil')->toArray();
        $perfil = $perfiUser[0];

        // Estados
        $estadoA = 'Documentos Enviados';
        $estadoA1 = 'Hoja de Vida Enviada';
        $estadoB = 'Documentos Devueltos';
        $estadoC = 'Documentación';
        $estadoD = 'Documentos Aprobados';
        $estadoF = 'Firma Hoja de Vida';
        $estadoG = 'Hoja de Vida Aprobada';
        $estadoH = 'CDP - Aprobado';
        $estadoI = 'Firma Secop-Contratista';
        $estadoJ = 'RPC - Aprobado';
        $estadoK = 'Firma Secop-Presidencia';

        // 🟡 Buscador: función para aplicar búsqueda
        $filtrar = function ($query) use ($buscar) {
            return $query->when($buscar, function ($q) use ($buscar) {
                $q->where(function ($sub) use ($buscar) {
                    $sub->where('b.Nombre', 'like', "%{$buscar}%")
                        ->orWhere('b.Documento', 'like', "%{$buscar}%");
                });
            });
        };

        // Pestaña: Documentos Recibidos
        $contratos = $filtrar(DB::table('contratos as cc')
            ->join('base_datos as b', 'cc.No_Documento', '=', 'b.Documento')
            ->leftJoin('users as u', 'cc.id_user', '=', 'u.id')
            ->leftJoin('oficinas as o', 'cc.Oficina', '=', 'o.id')
            ->where('cc.Id_Dp', $id_dp)
            ->where(function ($q) use ($estadoA, $estadoA1) {
                $q->where('cc.Estado_Interno', $estadoA)
                ->orWhere('cc.Estado_Interno', $estadoA1);
            })
            ->select('cc.*', 'b.*', 'u.name as nombre_usuario', 'o.Oficina as nombre_oficina'))
            ->simplePaginate(50);

        // Pestaña: Documentos Devueltos
        $contratosB = $filtrar(DB::table('contratos as cc')
            ->join('base_datos as b', 'cc.No_Documento', '=', 'b.Documento')
            ->leftJoin('users as u', 'cc.id_user', '=', 'u.id')
            ->leftJoin('oficinas as o', 'cc.Oficina', '=', 'o.id')
            ->where('cc.Id_Dp', $id_dp)
            ->where('cc.Estado_Interno', $estadoB)
            ->select('cc.*', 'b.*', 'u.name as nombre_usuario', 'o.Oficina as nombre_oficina'))
            ->simplePaginate(50);

        // Pestaña: Habilitados sin envío
        $contratosC = $filtrar(DB::table('contratos as cc')
            ->join('base_datos as b', 'cc.No_Documento', '=', 'b.Documento')
            ->leftJoin('users as u', 'cc.id_user', '=', 'u.id')
            ->leftJoin('oficinas as o', 'cc.Oficina', '=', 'o.id')
            ->where('cc.Id_Dp', $id_dp)
            ->where('cc.Estado_Interno', $estadoC)
            ->select('cc.*', 'b.*', 'u.name as nombre_usuario', 'o.Oficina as nombre_oficina')
            ->orderBy('cc.Id', 'DESC'))
            ->simplePaginate(100);

        // Pestaña: Documentos Aprobados
        $contratosD = $filtrar(DB::table('contratos as cc')
            ->join('base_datos as b', 'cc.No_Documento', '=', 'b.Documento')
            ->leftJoin('users as u', 'cc.id_user', '=', 'u.id')
            ->leftJoin('oficinas as o', 'cc.Oficina', '=', 'o.id')
            ->where('cc.Id_Dp', $id_dp)
            ->where(function ($q) use ($estadoD, $estadoF, $estadoG) {
                $q->whereIn('cc.Estado_Interno', [$estadoD, $estadoF, $estadoG]);
            })
            ->select('cc.*', 'b.*', 'u.name as nombre_usuario', 'o.Oficina as nombre_oficina'))
            ->simplePaginate(50);

        // Pestaña: Para Contratación
        $contratosF = $filtrar(DB::table('contratos as cc')
            ->join('base_datos as b', 'cc.No_Documento', '=', 'b.Documento')
            ->leftJoin('users as u', 'cc.id_user', '=', 'u.id')
            ->leftJoin('oficinas as o', 'cc.Oficina', '=', 'o.id')
            ->where('cc.Id_Dp', $id_dp)
            ->whereIn('cc.Estado_Interno', [$estadoH, $estadoI, $estadoJ, $estadoK])
            ->select('cc.*', 'b.*', 'u.name as nombre_usuario', 'o.Oficina as nombre_oficina'))
            ->simplePaginate(50);

        // Pestaña: En trámite
        $contratosT = Contrato::from('contratos as c')
            ->join('base_datos as b', 'b.Documento', '=', 'c.No_Documento')
            ->leftJoin('oficinas as o', 'c.Oficina', '=', 'o.id')
            ->whereBetween('c.id_estado', [16, 32])
            ->whereNotIn('c.id_estado', [23, 32])
            ->when($buscar, function ($q) use ($buscar) {
                $q->where(function ($sub) use ($buscar) {
                    $sub->where('b.Nombre', 'like', "%{$buscar}%")
                        ->orWhere('b.Documento', 'like', "%{$buscar}%");
                });
            })
            ->select('c.*', 'b.Nombre', 'o.Oficina as nombre_oficina')
            ->paginate(15);

        // 🔁 Detectar en qué bandeja está el resultado
        if ($buscar) {
            if ($contratos->count() > 0) $tabDestino = 'pendientes';
            elseif ($contratosB->count() > 0) $tabDestino = 'aprobadas';
            elseif ($contratosC->count() > 0) $tabDestino = 'devueltas';
            elseif ($contratosD->count() > 0) $tabDestino = 'enviadas';
            elseif ($contratosF->count() > 0) $tabDestino = 'contratacion';
            elseif ($contratosT->count() > 0) $tabDestino = 'todas';
        }

        return view('contratacion.bandejacontrato', compact(
            'contratos', 'contratosB', 'contratosC', 'contratosD', 'contratosF', 'contratosT',
            'perfil', 'recordatoriosHoy', 'tabDestino'
        ))->with('i', (request()->input('page', 1) - 1) * 100);
    }
    

        public function solicitudCDP(Request $request)
        {
            $idContrato = $request->input('id');

            // Obtener estado destino desde tabla Cambio_estado (puedes ajustar la lógica según tu estructura)
            $idEstadoActual = DB::table('contratos')->where('Id', $idContrato)->value('id_estado');
            $estadoDestinoId = DB::table('Cambio_estado')->where('id', $idEstadoActual)->value('pos_estado');

            $idnuevoestado = DB::table('Cambio_estado')->where('id', $estadoDestinoId)->first();

            if ($idnuevoestado) {
                $contrato = \App\Models\Contrato::find($idContrato);
                if ($contrato) {
                    $contrato->Estado = $idnuevoestado->EstadoUsuario ?? 'Solicitud CDP';
                    $contrato->Estado_interno = $idnuevoestado->EstadoInterno ?? 'Solicitud CDP';
                    $contrato->id_estado = $idnuevoestado->id;
                    $contrato->save(); // 🔥 dispara observer y bitácora
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Solicitud de CDP enviada'
            ]);
        }


    public function verDoccontratos(Request $request)
        { 
            $idUser = auth()->user()->id;
                    
            $perfiUser = DB::table('UserPerfil') ->where('idUser', $idUser) ->where('idPerfil', '!=', 2) ->pluck('idPerfil')  ->toArray();       
            $perfil = $perfiUser[0] ; 
            $idContrato = $request->idContrato;
            $estadoContrato = DB::table('contratos')->where('id', $idContrato)->value('Estado'); 
    
            $tipos = [3]; 
            $estadoLow = strtolower($estadoContrato);        // Llevamos todo a minúsculas para comparar 
            if ($estadoLow === 'firma hoja de vida' || $estadoLow === 'documentos aprobados'|| $estadoLow === 'hoja de vida enviada'|| $estadoLow === 'hoja de vida aprobada') { $tipos[] = 5; } 
            $inLista = implode(',', $tipos);
 
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
            order by f.orden asc ");
 

            return view('tablaDocJuridica', compact('datos','estadoContrato','perfil'));
        }




        
        public function apigoogle(Request $request)
        {
            // 1) Validamos que nos llegue template_id y los placeholders
            $data = $request->json()->all();
    
            try {
                // 2) Construimos el payload dinámico
                $payload = array_merge(
                    ['template_id' => $data['template_id']],
                    Arr::except($data, ['template_id'])
                );
    
                // 3) Llamamos al Web App de Apps Script para generar el PDF
                $scriptUrl = 'https://script.google.com/macros/s/AKfycbzppwbIzkUVBIfegDeMScOVdpjDm1UA0aXwwozcxJlHfIh2BXtDvk22XeaOuZf389KT0g/exec'; 
                $resp = Http::withHeaders(['Content-Type' => 'application/json'])
                            ->post($scriptUrl, $payload);
    
                if (! $resp->ok()) {
                    throw new \Exception('Error al generar PDF: '.$resp->body());
                }
    
                $result = $resp->json();
                if (empty($result['url']) || empty($result['id'])) {
                    throw new \Exception('Respuesta inválida del servicio de Google: '.$resp->body());
                }
    
                $downloadUrl = $result['url'];
    
                // 4) Descargamos el PDF desde Drive hacia nuestro servidor
                $pdfResp = Http::withHeaders(['Accept' => 'application/pdf'])
                               ->get($downloadUrl);
    
                if (! $pdfResp->ok()) {
                    throw new \Exception('No se pudo descargar el PDF desde Drive.');
                }
    
                // 5) Lo entregamos al cliente como descarga
                return response()->streamDownload(function () use ($pdfResp) {
                    echo $pdfResp->body();
                }, 'documento_generado.pdf', [
                    'Content-Type'        => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="documento_generado.pdf"',
                ]);
    
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        public function apigoogleMultiple(Request $request)
        {
            // 1) Validación mínima
            $data = $request->validate([
                'documents'               => 'required|array|min:1',
                'documents.*.template_id' => 'required|string',
            ]);

            $id_contrato=$request->Id;

 
            // 2) Preparar carpeta temporal
            $tmpDir = storage_path('app/temp_pdfs');
            if (! File::isDirectory($tmpDir)) {
                File::makeDirectory($tmpDir, 0755, true);
            }
    
            $scriptUrl = 'https://script.google.com/macros/s/AKfycbz9RiDDUuxawsjd6NUuMl1SN4b_8Ngei72CZ8KdfoD-Nc8LdFBDrP1sxihPOFZanwGj8g/exec'; 

    
            $pdfPaths = [];
    
            try {
                // 3) Generar y descargar cada PDF
                foreach ($data['documents'] as $i => $doc) {
                    $payload = array_merge(
                        ['template_id' => $doc['template_id']],
                        Arr::except($doc, ['template_id'])
                    );
    
                    // Llamada a Apps Script
                    $resp = Http::withHeaders([
                        'Content-Type' => 'application/json',
                    ])->post($scriptUrl, $payload);
    
                    if (! $resp->ok()) {
                        throw new \Exception("Error generando PDF #{$i}: ".$resp->body());
                    }
    
                    $json = $resp->json();
                    if (empty($json['url'])) {
                        throw new \Exception("No se recibió URL para PDF #{$i}");
                    }
    
                    // Descarga binaria
                    $pdfResp = Http::get($json['url']);
                    if (! $pdfResp->ok()) {
                        throw new \Exception("Error descargando PDF #{$i}");
                    }
    
                    // Guardar en disco
                    $fileName = "documento_{$i}.pdf";
                    $path     = "{$tmpDir}/{$fileName}";
                    File::put($path, $pdfResp->body());
                    $pdfPaths[] = $path;
                }
    
                // 4) Crear el ZIP
                $zipName = 'documents_' . time() . '.zip';
                $zipPath = "{$tmpDir}/{$zipName}";
                $zip     = new ZipArchive();
                if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                    throw new \Exception("No se pudo abrir ZIP para escritura");
                }
                foreach ($pdfPaths as $pdf) {
                    $zip->addFile($pdf, basename($pdf));
                }
                $zip->close();
    
                // 5) Limpiar buffers PHP
                while (ob_get_level()) {
                    ob_end_clean();
                }
    
                // 6) Enviar ZIP con BinaryFileResponse
                return new BinaryFileResponse(
                    $zipPath,
                    200,
                    [
                        'Content-Type'        => 'application/zip',
                        'Content-Disposition' => 'attachment; filename="'.$zipName.'"',
                        'Content-Length'      => filesize($zipPath),
                        'Pragma'              => 'public',
                        'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                        'Expires'             => '0',
                    ],
                    true
                );
    
            } catch (\Exception $e) {
                // Si algo falla, devolver JSON de error
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }
        }


 
 
        public function contratoJson(Request $request)
        {
            $num = $request->query('num');
            if (! $num) {
                return response()->json(['error'=>'Falta parámetro num'], 400);
            }
        
            $registros = DB::select(
                "SELECT gc.*, f.Id_Google
                 FROM generacion_contratos gc
                 cross JOIN Formatos f 
                 WHERE gc.Num_Contrato = ?
                   AND f.Id_Google IS NOT NULL",
                [$num]
            );
        
            if (empty($registros)) {
                return response()->json(['error'=>'No se encontraron registros'], 404);
            }
        
            // Mapear a arrays y renombrar Id_Google → template_id
            $documents = array_map(function($item) {
                $arr = (array) $item;
        
                // Extraemos y renombramos
                $template = $arr['Id_Google'];  
                unset($arr['Id_Google']);        // opcional: ya no lo necesitamos
        
                // Insertamos al principio (si quieres que quede first)
                return array_merge(['template_id' => $template], $arr);
            }, $registros);
        
            
            // Crear subrequest POST con documents en el body
            $subRequest = Request::create(
                '/api/contratacion/apigoogle-multiple',
                'POST',
                ['documents' => $documents]
            );
 

            return $this->apigoogleMultiple($subRequest);
        }

 
        public function generarDocumentosZip($numContrato)
        {
            // 1. Buscar los datos del contrato
            $datosPdf = DB::table('generacion_contratos')
                        ->where('Num_Contrato', $numContrato)
                        ->first();
        
            if (!$datosPdf) {
                return response()->json(['error' => 'Contrato no encontrado'], 404);
            }
        
            // 2. Consultar vistas desde la tabla Formatos
            $vistas = DB::table('Formatos')
                        ->select('Vista')
                        ->where('tipo', 4)
                        ->where('id_dp', 1)
                        ->get();
        
            if ($vistas->isEmpty()) {
                return response()->json(['error' => 'No se encontraron vistas para generar.'], 404);
            }
        
            // 3. Crear carpeta temporal
            $tempDir = storage_path('app/temp_zip_' . uniqid());
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
        
            $pdfFiles = [];
        
            // 4. Generar PDFs desde cada vista dinámica
            foreach ($vistas as $vista) {
                $rutaVista = str_replace('/', '.', $vista->Vista);
            
                if (!view()->exists($rutaVista)) {
                    \Log::warning("Vista no existe: " . $rutaVista);
                    continue;
                }
            
                $pdf = PDF::loadView($rutaVista, [
                    'datosPdf' => $datosPdf,
                    'pdf' => true
                ])->setPaper('letter');

                $filePath = $tempDir . '/' . basename($vista->Vista) . '_' . $numContrato . '.pdf';
                $pdf->save($filePath);
                $pdfFiles[] = $filePath;
            }
        
            if (empty($pdfFiles)) {
                return response()->json(['error' => 'No se pudo generar ningún PDF.'], 500);
            }
        
            // 5. Crear archivo ZIP
            $zipName = 'documentos_' . $numContrato . '.zip';
            $zipPath = storage_path('app/' . $zipName);
        
            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                foreach ($pdfFiles as $file) {
                    $zip->addFile($file, basename($file));
                }
                $zip->close();
            } else {
                return response()->json(['error' => 'No se pudo crear el archivo ZIP.'], 500);
            }
        
            // 6. Limpiar archivos temporales
            foreach ($pdfFiles as $file) {
                unlink($file);
            }
            rmdir($tempDir);
        
            // 7. Retornar descarga
            return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
        }
        

        public function descargarNotificacionPDF($numContrato)
        {
            // 1. Buscar los datos del contrato
            $datosPdf = DB::table('generacion_contratos')
                        ->where('Num_Contrato', $numContrato)
                        ->first();
        
            if (!$datosPdf) {
                return response()->json(['error' => 'Contrato no encontrado'], 404);
            }
        
            // 2. Verificar que la vista exista
            $vista = 'formatos.Concejo.notificacion'; // ajusta si está en otra carpeta
        
            if (!view()->exists($vista)) {
                return response()->json(['error' => 'La vista de notificación no existe'], 404);
            }
        
            // 3. Generar el PDF directamente
            $pdf = PDF::loadView($vista, [
                'datosPdf' => $datosPdf,
                'pdf' => true
            ])->setPaper('letter');
        
            // 4. Descargar el archivo directamente
            $nombreArchivo = 'notificacion_' . $numContrato . '.pdf';
            return $pdf->download($nombreArchivo);
        }


        public function verInvitacion($id)
        {
            $datosPdf = DB::table('generacion_contratos')->where('Id', $id)->first();
       
            if (!$datosPdf) {
                abort(404, 'Contrato no encontrado');
            }
    
            return view('formatos.Concejo.Fichatecnica', compact('datosPdf'));
        }


        public function ficha($id)
        {
            $datosPdf = DB::table('generacion_contratos')->where('Id', $id)->first();
       
            if (!$datosPdf) {
                abort(404, 'Contrato no encontrado');
            }
    
            return view('formatos.Concejo.Fichatecnica', compact('datosPdf'));
        }


        public function DocEquivalente($id)
        {
            $datosPdf = DB::table('bandeja_cuentas')->where('Id', $id)->first();
       
            if (!$datosPdf) {
                abort(404, 'Contrato no encontrado');
            }
    
            return view('formatos.Concejo.DocEquivalente', compact('datosPdf'));
        }


        public function documentosContrato(Request $request)
        {
            
            $idContrato = $request->idContrato; 
            $estadoContrato = DB::table('contratos')->where('id', $idContrato)->value('Estado_interno'); 
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
            where tipo IN (3,5,6)
            order by f.id asc"); 
            
            return view('Contratacion.tablaDocContratos', compact('datos','estadoContrato'));
        }

 
 public function descargarZip($idContrato, $idCuota, $tipo)
{
    // Obtener el número de contrato
    $contrato = DB::table('contratos')
        ->select('Num_Contrato')
        ->where('id', $idContrato)
        ->first();

    $numContrato = $contrato->Num_Contrato ?? 'sin_numero';

    // Obtener archivos según el tipo de descarga
    $archivos = DB::table('Cargue_Archivo as ca')
        ->join('Formatos as f', 'ca.Id_formato', '=', 'f.Id')
        ->where('ca.Id_contrato', $idContrato)
        ->where('f.descarga', $tipo)
        ->where(function ($q) use ($idCuota) {
            $q->where('ca.id_cuota', $idCuota)
              ->orWhereNull('ca.id_cuota');
        })
        ->where('ca.Estado', '!=', 'ANULADO')
        ->select('ca.Ruta', 'f.Nombre')
        ->get();

    if ($archivos->isEmpty()) {
        return back()->with('error', 'No se encontraron archivos para descargar.');
    }

    $zip = new ZipArchive();
    switch ($tipo) {
        case 1:
            $nombreZip = "Anexos_Contrato_{$numContrato}.zip";
            break;
        case 2:
            $nombreZip = "Documentos_Contrato_{$numContrato}.zip";
            break;
        case 3:
            $nombreZip = "Minutas_Contrato_{$numContrato}.zip";
            break;
        default:
            $nombreZip = "Contrato_{$idContrato}_cuota_{$idCuota}.zip";
            break;
    }

    $rutaZip = storage_path("app/public/tmp/$nombreZip");

    // Asegurar carpeta y limpiar anterior
    Storage::makeDirectory('public/tmp');
    if (file_exists($rutaZip)) {
        unlink($rutaZip);
    }

    if ($zip->open($rutaZip, ZipArchive::CREATE) !== true) {
        return back()->with('error', 'No se pudo crear el archivo ZIP.');
    }

    foreach ($archivos as $archivo) {
        $rutaFisica = public_path(str_replace('https://cuentafacil.co/', '', $archivo->Ruta));
        if (file_exists($rutaFisica)) {
            $nombreLimpio = self::limpiarNombre($archivo->Nombre) . '.pdf';
            $zip->addFile($rutaFisica, $nombreLimpio);
        }
    }

    $zip->close();

    return response()->download($rutaZip)->deleteFileAfterSend(true);
}

public static function limpiarNombre($cadena)
{
    // Reemplazo manual de tildes comunes (mejor control que iconv solo)
    $acentos = [
        'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
        'Ñ' => 'N', 'ñ' => 'n'
    ];
    $cadena = strtr($cadena, $acentos);

    // Luego usar iconv para otros casos
    $cadena = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $cadena);

    // Reemplazar caracteres no permitidos
    $cadena = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $cadena);
    $cadena = preg_replace('/_+/', '_', $cadena); // quitar múltiples guiones bajos
    return trim($cadena, '_');
}
}

  
 