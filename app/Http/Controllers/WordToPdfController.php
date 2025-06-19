<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ConvertController extends Controller
{
    public function convert(Request $request)
    {
        // Validar archivo
        $request->validate([
            'file' => 'required|file|mimes:doc,docx,application/msword'
        ]);

        // Guardar archivo temporal
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = storage_path('app/temp/' . $fileName);
        $file->move(storage_path('app/temp'), $fileName);

        // Ruta de salida PDF
        $outputDir = storage_path('app/temp');
        $pdfName = pathinfo($fileName, PATHINFO_FILENAME) . '.pdf';
        $pdfPath = $outputDir . '/' . $pdfName;

        // Comando de conversión
        $command = "libreoffice --headless --convert-to pdf --outdir {$outputDir} {$filePath}";

        // Ejecutar comando
        exec($command, $output, $returnCode);

        // Verificar conversión
        if ($returnCode !== 0 || !file_exists($pdfPath)) {
            return response()->json(['error' => 'Error en la conversión'], 500);
        }

        // Devolver PDF y limpiar archivos
        register_shutdown_function(function () use ($filePath, $pdfPath) {
            @unlink($filePath);
            @unlink($pdfPath);
        });

        return response()->download($pdfPath, $pdfName);
    }
}