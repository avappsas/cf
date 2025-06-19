<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;
use ZipArchive;

class gernarPdf extends Controller
{
    /**
     * Genera un ZIP con PDFs de contratos rellenados desde plantillas DOCX,
     * usando PhpWord + Dompdf, sin depender de LibreOffice.
     * Ruta: GET /generar-zip/{numContrato}/{idGrupo}
     */
    public function generarZip(string $numContrato, int $idGrupo, int $idCuota)
    {
        // 1) Validar parámetros
        if (empty($numContrato) || empty($idGrupo)) {
            return response('Se requieren numContrato e idGrupo', 400);
        }

        // 2) Obtener datos del contrato
        $record = DB::table('Cuenta.dbo.generacion_contratos')
            ->where('Num_Contrato', $numContrato)
            ->first();
        if (!$record) {
            return response('Contrato no encontrado', 404);
        }

        // 3) Preparar array de datos (texto)
        $data = array_map(fn($v) => $v !== null ? (string) $v : '', (array) $record);

        // 4) Obtener plantillas del grupo
        $tplRows = DB::table('cuenta.dbo.grupo_plantilla as g')
            ->join('cuenta.dbo.Plantilla_Contratos as p', 'p.id', 'g.id_plantilla')
            ->where('g.id_grupo', $idGrupo)
            ->select('p.Url', 'p.Formato')
            ->get();
        if ($tplRows->isEmpty()) {
            return response('No se encontraron plantillas para ese grupo', 404);
        }

        // 5) Configurar PDF renderer de PHPWord con Dompdf
        Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
        Settings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));

        // 6) Crear directorio temporal
        $tmpDir = storage_path('app/tmp');
        if (!is_dir($tmpDir)) mkdir($tmpDir, 0755, true);

        // 7) Crear ZIP
        $zipPath = "$tmpDir/Contratos_{$numContrato}.zip";
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return response('Error al crear ZIP', 500);
        }

        // 8) Procesar cada plantilla
        foreach ($tplRows as $tpl) {
            $baseName = "{$tpl->Formato}_{$numContrato}";
            try {
                // 8.1) Descargar plantilla DOCX
                $resp = Http::withOptions(['verify' => false])->get($tpl->Url);
                if (!$resp->ok()) {
                    \Log::warning("No se pudo descargar plantilla: {$tpl->Url}");
                    continue;
                }
                $docxFile = "$tmpDir/{$baseName}.docx";
                file_put_contents($docxFile, $resp->body());

                // 8.2) Rellenar plantilla
                $tplProc = new TemplateProcessor($docxFile);
                foreach ($data as $key => $val) {
                    $tplProc->setValue($key, $val);
                }
                // Ejemplo de reemplazo de imagen (opcional)
                if (!empty($data['logo_path'])) {
                    $tplProc->setImageValue(
                        'logo',
                        [
                            'path' => public_path($data['logo_path']),
                            'width' => 150,
                            'height' => 50,
                        ]
                    );
                }
                $filledDocx = "$tmpDir/filled_{$baseName}.docx";
                $tplProc->saveAs($filledDocx);

                // 8.3) Convertir a PDF con PHPWord + Dompdf
                $phpWord = IOFactory::load($filledDocx);
                $pdfFile = "$tmpDir/{$baseName}.pdf";
                $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
                $pdfWriter->save($pdfFile);

                // 8.4) Añadir PDF al ZIP
                if (file_exists($pdfFile)) {
                    $zip->addFile($pdfFile, "{$baseName}.pdf");
                }
                // Opcional: limpiar archivos intermedios
                @unlink($docxFile);
                @unlink($filledDocx);

            } catch (\Exception $e) {
                \Log::error("Error procesando plantilla {$baseName}: " . $e->getMessage());
                continue;
            }
        }

        // 9) Finalizar ZIP
        $zip->close();

        // 10) Descargar ZIP y borrar después
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
