
            $templatePath = 'C:\compartida\2.INFORME SUPERVISION CUOTA 1.docx'
            $outputPath = 'C:\laragon\www\cf\public\documentos/documento_65da259555f9a5.66893585.docx'
            
            $word = New-Object -ComObject Word.Application
            $document = $word.Documents.Open($templatePath)

            # Rellenar campos en la plantilla
                $document.Content.Find.Execute('<<V_parcial>>', $false, $false, $false, $false, $false, $true, 1, $false, 'Si')
        $document.Content.Find.Execute('<<V_no_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '1')
        $document.Content.Find.Execute('<<V_no_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '396')
        $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'ADRIANA MARÍA CHUD PAQUER')
        $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1006008559')
        $document.Content.Find.Execute('<<V_supervisor>>', $false, $false, $false, $false, $false, $true, 1, $false, 'ANA LEIDY ERAZO RUIZ')
        $document.Content.Find.Execute('<<V_oficina>>', $false, $false, $false, $false, $false, $true, 1, $false, 'UTL DE ANA LEIDY ERAZO RUIZ')
        $document.Content.Find.Execute('<<V_objeto>>', $false, $false, $false, $false, $false, $true, 1, $false, ' PRESTACIÓN DE SERVICIOS TÉCNICOS EN LA UNIDAD
DE APOYO NORMATIVO DE LA CONCEJALA ANA ERAZO RUIZ')
        $document.Content.Find.Execute('<<V_fecha_inicio>>', $false, $false, $false, $false, $false, $true, 1, $false, '17/08/2022')
        $document.Content.Find.Execute('<<V_fecha_terminacion>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/12/2022')
        $document.Content.Find.Execute('<<V_valor_letras>>', $false, $false, $false, $false, $false, $true, 1, $false, '  ( DOCE MILLONES SEISCIENTOS CINCUENTA MIL PESOS )')
        $document.Content.Find.Execute('<<V_valor_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '12650000')
        $document.Content.Find.Execute('<<V_valor_mensual>>', $false, $false, $false, $false, $false, $true, 1, $false, 'ND')
        $document.Content.Find.Execute('<<V_planilla>>', $false, $false, $false, $false, $false, $true, 1, $false, '1049385574')
        $document.Content.Find.Execute('<<V_pin_planilla>>', $false, $false, $false, $false, $false, $true, 1, $false, '32423423')
        $document.Content.Find.Execute('<<V_operador>>', $false, $false, $false, $false, $false, $true, 1, $false, 'Simple')
        $document.Content.Find.Execute('<<V_Fecha_pago_planilla>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
        $document.Content.Find.Execute('<<V_periodo>>', $false, $false, $false, $false, $false, $true, 1, $false, 'Octubre')
        $document.Content.Find.Execute('<<V_actividades>>', $false, $false, $false, $false, $false, $true, 1, $false, '1. Apoyo profesionalmente en el manejo de la información que se adelanta en la oficina de la Presidencia del Concejo Distrital de Santiago de Cali. 2. Prestar apoyo profesional en el acompañamiento de las actividades')
        $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
        $copiedTemplatePath = 'C:\laragon\www\cf\public\documentos/copia_documento_65da259555fa69.14033224.docx'
        $document.SaveAs([ref]$copiedTemplatePath, [ref]16)
        $document.Content.Find.Execute('<<V_parcial>>', $false, $false, $false, $false, $false, $true, 1, $false, 'Si')
        $document.Content.Find.Execute('<<V_no_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '1')
        $document.Content.Find.Execute('<<V_no_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '396')
        $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'ADRIANA MARÍA CHUD PAQUER')
        $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1006008559')
        $document.Content.Find.Execute('<<V_supervisor>>', $false, $false, $false, $false, $false, $true, 1, $false, 'ANA LEIDY ERAZO RUIZ')
        $document.Content.Find.Execute('<<V_oficina>>', $false, $false, $false, $false, $false, $true, 1, $false, 'UTL DE ANA LEIDY ERAZO RUIZ')
        $document.Content.Find.Execute('<<V_objeto>>', $false, $false, $false, $false, $false, $true, 1, $false, ' PRESTACIÓN DE SERVICIOS TÉCNICOS EN LA UNIDAD
DE APOYO NORMATIVO DE LA CONCEJALA ANA ERAZO RUIZ')
        $document.Content.Find.Execute('<<V_fecha_inicio>>', $false, $false, $false, $false, $false, $true, 1, $false, '17/08/2022')
        $document.Content.Find.Execute('<<V_fecha_terminacion>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/12/2022')
        $document.Content.Find.Execute('<<V_valor_letras>>', $false, $false, $false, $false, $false, $true, 1, $false, '  ( DOCE MILLONES SEISCIENTOS CINCUENTA MIL PESOS )')
        $document.Content.Find.Execute('<<V_valor_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '12650000')
        $document.Content.Find.Execute('<<V_valor_mensual>>', $false, $false, $false, $false, $false, $true, 1, $false, 'ND')
        $document.Content.Find.Execute('<<V_planilla>>', $false, $false, $false, $false, $false, $true, 1, $false, '1049385574')
        $document.Content.Find.Execute('<<V_pin_planilla>>', $false, $false, $false, $false, $false, $true, 1, $false, '32423423')
        $document.Content.Find.Execute('<<V_operador>>', $false, $false, $false, $false, $false, $true, 1, $false, 'Simple')
        $document.Content.Find.Execute('<<V_Fecha_pago_planilla>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
        $document.Content.Find.Execute('<<V_periodo>>', $false, $false, $false, $false, $false, $true, 1, $false, 'Octubre')
        $document.Content.Find.Execute('<<V_actividades>>', $false, $false, $false, $false, $false, $true, 1, $false, '1. Apoyo profesionalmente en el manejo de la información que se adelanta en la oficina de la Presidencia del Concejo Distrital de Santiago de Cali. 2. Prestar apoyo profesional en el acompañamiento de las actividades')
        $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
        $pdfOutputPath = 'C:\laragon\www\cf\public\documentos/documento_65da259555f9a5.66893585.docx.pdf'
        $document.ExportAsFixedFormat([ref]$pdfOutputPath, 17) # 17 indica el formato de documento PDF
        $document.Close()
        $word.Quit()
        Remove-Item -Path $copiedTemplatePath -Force
