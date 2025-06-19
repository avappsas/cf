<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentConverterController extends Controller
{
    public function convertToPdf(Request $request)
    {
        // Validar el archivo de entrada
        $request->validate([
            'document' => 'required|mimes:doc,docx|max:10240' // máximo 10MB
        ]);

        try {
            // Obtener el archivo
            $wordFile = $request->file('document');
            $fileName = Str::random(40);
            
            // Guardar el archivo Word temporalmente
            $wordPath = Storage::disk('local')->putFileAs(
                'temp',
                $wordFile,
                $fileName . '.' . $wordFile->getClientOriginalExtension()
            );
            
            $wordFullPath = Storage::disk('local')->path($wordPath);
            $pdfFullPath = Storage::disk('local')->path('temp/' . $fileName . '.pdf');

            // Comando para convertir usando LibreOffice (debe estar instalado)
            $command = "soffice --headless --convert-to pdf:writer_pdf_Export --outdir " . 
                      storage_path('app/temp') . " " . $wordFullPath;
            
            // Ejecutar el comando
            exec($command, $output, $returnCode);

            if ($returnCode !== 0) {
                throw new \Exception('Error al convertir el documento');
            }

            // Leer el PDF generado
            $pdfContent = file_get_contents($pdfFullPath);

            // Limpiar archivos temporales
            Storage::delete([
                'temp/' . $fileName . '.' . $wordFile->getClientOriginalExtension(),
                'temp/' . $fileName . '.pdf'
            ]);

            // Devolver el PDF
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . 
                    $wordFile->getClientOriginalName() . '.pdf"');

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en la conversión: ' . $e->getMessage()
            ], 500);
        }
    }
}