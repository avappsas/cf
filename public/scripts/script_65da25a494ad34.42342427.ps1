
            $templatePath = 'C:\compartida\4.CERTIFICADO DEPENDIENTE.docx'
            $outputPath = 'C:\laragon\www\cf\public\documentos/documento_65da25a494ae91.09784587.docx'
            
            $word = New-Object -ComObject Word.Application
            $document = $word.Documents.Open($templatePath)

            # Rellenar campos en la plantilla
                $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'ADRIANA MARÍA CHUD PAQUER')
        $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1006008559')
        $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
        $copiedTemplatePath = 'C:\laragon\www\cf\public\documentos/copia_documento_65da25a494af27.46076281.docx'
        $document.SaveAs([ref]$copiedTemplatePath, [ref]16)
        $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'ADRIANA MARÍA CHUD PAQUER')
        $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1006008559')
        $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
        $pdfOutputPath = 'C:\laragon\www\cf\public\documentos/documento_65da25a494ae91.09784587.docx.pdf'
        $document.ExportAsFixedFormat([ref]$pdfOutputPath, 17) # 17 indica el formato de documento PDF
        $document.Close()
        $word.Quit()
        Remove-Item -Path $copiedTemplatePath -Force
