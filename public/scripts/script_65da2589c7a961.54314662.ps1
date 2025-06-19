
            $templatePath = 'C:\compartida\1.FORMATO EJECUCION DE ACTIVIDADES.docx'
            $outputPath = 'C:\laragon\www\cf\public\documentos/documento_65da2589c7aa88.22661284.docx'
            
            $word = New-Object -ComObject Word.Application
            $document = $word.Documents.Open($templatePath)

            # Rellenar campos en la plantilla
                $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'ADRIANA MARÍA CHUD PAQUER')
        $document.Content.Find.Execute('<<V_no_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '396')
        $document.Content.Find.Execute('<<V_fecha_inicio>>', $false, $false, $false, $false, $false, $true, 1, $false, '17/08/2022')
        $document.Content.Find.Execute('<<V_fecha_terminacion>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/12/2022')
        $document.Content.Find.Execute('<<V_valor_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '12650000')
        $document.Content.Find.Execute('<<V_valor_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '2530000')
        $document.Content.Find.Execute('<<V_no_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '1')
        $document.Content.Find.Execute('<<V_actividades>>', $false, $false, $false, $false, $false, $true, 1, $false, '1. Apoyo profesionalmente en el manejo de la información que se adelanta en la oficina de la Presidencia del Concejo Distrital de Santiago de Cali. 2. Prestar apoyo profesional en el acompañamiento de las actividades')
        $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
        $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1006008559')
        $copiedTemplatePath = 'C:\laragon\www\cf\public\documentos/copia_documento_65da2589c7ab05.70291437.docx'
        $document.SaveAs([ref]$copiedTemplatePath, [ref]16)
        $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'ADRIANA MARÍA CHUD PAQUER')
        $document.Content.Find.Execute('<<V_no_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '396')
        $document.Content.Find.Execute('<<V_fecha_inicio>>', $false, $false, $false, $false, $false, $true, 1, $false, '17/08/2022')
        $document.Content.Find.Execute('<<V_fecha_terminacion>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/12/2022')
        $document.Content.Find.Execute('<<V_valor_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '12650000')
        $document.Content.Find.Execute('<<V_valor_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '2530000')
        $document.Content.Find.Execute('<<V_no_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '1')
        $document.Content.Find.Execute('<<V_actividades>>', $false, $false, $false, $false, $false, $true, 1, $false, '1. Apoyo profesionalmente en el manejo de la información que se adelanta en la oficina de la Presidencia del Concejo Distrital de Santiago de Cali. 2. Prestar apoyo profesional en el acompañamiento de las actividades')
        $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
        $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1006008559')
        $pdfOutputPath = 'C:\laragon\www\cf\public\documentos/documento_65da2589c7aa88.22661284.docx.pdf'
        $document.ExportAsFixedFormat([ref]$pdfOutputPath, 17) # 17 indica el formato de documento PDF
        $document.Close()
        $word.Quit()
        Remove-Item -Path $copiedTemplatePath -Force
