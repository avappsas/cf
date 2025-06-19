
            $templatePath = 'C:\compartida\4.CERTIFICADO DEPENDIENTE.docx'
            $outputPath = 'C:\laragon\www\cf\public\documentos/documento_65d7863cf38ee8.71822743.docx'
            
            $word = New-Object -ComObject Word.Application
            $document = $word.Documents.Open($templatePath)

            # Rellenar campos en la plantilla
                $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'DIANA ALEJANDRA MOLINA AMELINES')
        $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1144028976')
        $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
        $document.SaveAs([ref]$outputPath, [ref]16) # 16 indica el formato de documento Word
        $document.Close()
        $word.Quit()
