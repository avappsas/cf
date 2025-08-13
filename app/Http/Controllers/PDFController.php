<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;


class PDFController extends Controller
{
    public function mostrarVista($documento, $pdf_id)
    {
        $persona = DB::table('Base_Datos')
            ->select('firma')
            ->where('Documento', $documento)
            ->first();

        if (!$persona || empty($persona->firma)) {
            return abort(404, 'Firma no encontrada para este documento');
        }

        return view('firmar', [
            'pdf_id' => $pdf_id,
            'rutaFirma' => $persona->firma
        ]);
    }



public function convertirPdfConGhostscript($rutaOriginal)
{
    if (!file_exists($rutaOriginal)) {
        throw new \Exception("PDF original no encontrado");
    }

    $nombreTemp = 'temp_' . \Str::random(10) . '.pdf';
    $salida = storage_path('app/temp/' . $nombreTemp);

    // Asegurar carpeta temp
    if (!file_exists(storage_path('app/temp'))) {
        mkdir(storage_path('app/temp'), 0755, true);
    }

    // Ruta absoluta al ejecutable de Ghostscript en Windows
    $gsPath = '"C:\Program Files\gs\gs10.05.1\bin\gswin64c.exe"';

    // Comando completo
    $cmd = $gsPath . ' -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH ' .
           '-sOutputFile="' . $salida . '" "' . $rutaOriginal . '"';

    // Ejecutar
    exec($cmd, $output, $code);

    // Debug opcional
    \Log::info("GS Output: " . implode("\n", $output));
    \Log::info("GS Exit Code: " . $code);

    // Validar conversión
    if ($code !== 0 || !file_exists($salida)) {
        throw new \Exception("Ghostscript falló. No se generó el PDF.");
    }

    return $salida;
}

 
public function firmarDesdeEmbed(Request $request)
{
    try {
        // Validar existencia del PDF original
        $rutaCompleta = storage_path('app/public/' . ltrim($request->ruta, '/'));
        if (!file_exists($rutaCompleta)) {
            return response()->json(['success' => false, 'error' => 'Archivo no encontrado']);
        }

        // Obtener ruta de firma del usuario autenticado
        $firma = DB::table('Base_Datos')
            ->where('Documento', auth()->user()->usuario)
            ->value('firma');
        $rutaFirma = storage_path('app/public/' . $firma);
        if (!file_exists($rutaFirma)) {
            return response()->json(['success' => false, 'error' => 'Firma no encontrada']);
        }
 
        // Función anónima para firmar un PDF
        $firmarPdf = function ($archivoPDF) use ($request, $rutaFirma) {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($archivoPDF);

            for ($page = 1; $page <= $pageCount; $page++) {
                $templateId = $pdf->importPage($page);
                $size = $pdf->getTemplateSize($templateId);
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);

                // Solo insertar firma en la página solicitada
                if ($page === (int)$request->pagina) {
                    $x = $request->x_rel * $size['width'];
                    $y = $request->y_rel * $size['height'];
                    $w = $request->ancho_rel * $size['width']* 1;
                    $h = $request->alto_rel * $size['height']* 0.5;
 
                    $pdf->Image($rutaFirma, $x, $y, $w, $h);
                }
            }

            return $pdf;
        };


        try {
            // Intentar firmar directamente
            $pdf = $firmarPdf($rutaCompleta);
        } catch (CrossReferenceException $e) { 

            // Reintentar con versión convertida
            $rutaConvertido = $this->convertirPdfConGhostscript($rutaCompleta);
            $pdf = $firmarPdf($rutaConvertido);
        }

        // Guardar directamente en el mismo archivo original (sobrescribir)
        $pdf->Output('F', $rutaCompleta);

        // Guardar directamente en el mismo archivo original (sobrescribir) 
        DB::table('Cargue_Archivo') 
            ->where('Id_contrato', $request->idContrato)
            ->where('Id_cuota', $request->idCuota)
            ->where('Id_formato', $request->idCargue)
            ->whereIn('Estado', ['CARGADO', 'APROBADA','PENDIENTE'])
            ->update([
                'Estado'              => 'FIRMADO',
                'Fecha_actualizacion' => now(), 
            ]);

return response()->json(['success' => true, 'archivo_firmado' => basename($rutaCompleta)]);

    } catch (\Throwable $e) {
        \Log::error('❌ Error al firmar PDF: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}



}