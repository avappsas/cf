
            $templatePath = 'C:\compartida\3.CERTIFICACION TRIBUTARIA.docx'
            $outputPath = 'C:\laragon\www\cf\public\documentos/documento_65d79bf439bf15.65949576.docx'
            
            $word = New-Object -ComObject Word.Application
            $document = $word.Documents.Open($templatePath)

            # Rellenar campos en la plantilla
                $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'DIANA ALEJANDRA MOLINA AMELINES')
        $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1144028976')
        $document.Content.Find.Execute('<<V_fecha_terminacion>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/12/2022')
        $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
        $copiedTemplatePath = 'C:\laragon\www\cf\public\documentos/copia_documento_65d79bf439bfa8.89351853.docx'
        $document.SaveAs([ref]$copiedTemplatePath, [ref]16)
        $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'DIANA ALEJANDRA MOLINA AMELINES')
        $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1144028976')
        $document.Content.Find.Execute('<<V_fecha_terminacion>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/12/2022')
        $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
        $pdfOutputPath = 'C:\laragon\www\cf\public\documentos/documento_65d79bf439bf15.65949576.docx.pdf'
        $document.ExportAsFixedFormat([ref]$pdfOutputPath, 17) # 17 indica el formato de documento PDF
        $document.Close()
        $word.Quit()
        Remove-Item -Path $copiedTemplatePath -Force
