
                        $templatePath = 'C:\compartida\1.FORMATO EJECUCION DE ACTIVIDADES.docx'
                        $outputPath = 'C:\laragon\www\cf\public\documentos/documento_65d67a1be4f9e5.33939497.docx'
                        
                        $word = New-Object -ComObject Word.Application
                        $document = $word.Documents.Open($templatePath)

                        # Rellenar campos en la plantilla
                                        $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'DIANA ALEJANDRA MOLINA AMELINES')
                    $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'DIANA ALEJANDRA MOLINA AMELINES')
                    $document.Content.Find.Execute('<<V_nombre>>', $false, $false, $false, $false, $false, $true, 1, $false, 'DIANA ALEJANDRA MOLINA AMELINES')
                    $document.Content.Find.Execute('<<V_no_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '553')
                    $document.Content.Find.Execute('<<V_no_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '553')
                    $document.Content.Find.Execute('<<V_no_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '553')
                    $document.Content.Find.Execute('<<V_fecha_inicio>>', $false, $false, $false, $false, $false, $true, 1, $false, '17/11/2022')
                    $document.Content.Find.Execute('<<V_fecha_inicio>>', $false, $false, $false, $false, $false, $true, 1, $false, '17/11/2022')
                    $document.Content.Find.Execute('<<V_fecha_inicio>>', $false, $false, $false, $false, $false, $true, 1, $false, '17/11/2022')
                    $document.Content.Find.Execute('<<V_fecha_terminacion>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/12/2022')
                    $document.Content.Find.Execute('<<V_fecha_terminacion>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/12/2022')
                    $document.Content.Find.Execute('<<V_fecha_terminacion>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/12/2022')
                    $document.Content.Find.Execute('<<V_valor_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '9000000')
                    $document.Content.Find.Execute('<<V_valor_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '9000000')
                    $document.Content.Find.Execute('<<V_valor_contrato>>', $false, $false, $false, $false, $false, $true, 1, $false, '9000000')
                    $document.Content.Find.Execute('<<V_valor_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '4500000')
                    $document.Content.Find.Execute('<<V_valor_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '4500000')
                    $document.Content.Find.Execute('<<V_valor_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '4500000')
                    $document.Content.Find.Execute('<<V_no_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '1')
                    $document.Content.Find.Execute('<<V_no_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '1')
                    $document.Content.Find.Execute('<<V_no_cuota>>', $false, $false, $false, $false, $false, $true, 1, $false, '1')
                    $document.Content.Find.Execute('<<V_actividades>>', $false, $false, $false, $false, $false, $true, 1, $false, '1. Apoyó profesionalmente en el manejo de la información que se adelanta en la oficina de la Presidencia del Concejo Distrital de Santiago de Cali. 2. Prestar apoyo profesional en el acompañamiento de las actividades necesarias en la presidencia realizadas en el concejo Distrital de Santiago de Cali. 3. Apoyó en la citación a plenaria del día 2, 8, 9, 10, 15, 16, 17, 18, 19, 21, 22, 23, 25 de noviembre. 4. Apoyó en la citación a comisión del día 1, 2, 3, 4, 9, 11, 12, 16, 17, 18, 19, 21, 22, 23, 24, 25 de noviembre.')
                    $document.Content.Find.Execute('<<V_actividades>>', $false, $false, $false, $false, $false, $true, 1, $false, '1. Apoyó profesionalmente en el manejo de la información que se adelanta en la oficina de la Presidencia del Concejo Distrital de Santiago de Cali. 2. Prestar apoyo profesional en el acompañamiento de las actividades necesarias en la presidencia realizadas en el concejo Distrital de Santiago de Cali. 3. Apoyó en la citación a plenaria del día 2, 8, 9, 10, 15, 16, 17, 18, 19, 21, 22, 23, 25 de noviembre. 4. Apoyó en la citación a comisión del día 1, 2, 3, 4, 9, 11, 12, 16, 17, 18, 19, 21, 22, 23, 24, 25 de noviembre.')
                    $document.Content.Find.Execute('<<V_actividades>>', $false, $false, $false, $false, $false, $true, 1, $false, '1. Apoyó profesionalmente en el manejo de la información que se adelanta en la oficina de la Presidencia del Concejo Distrital de Santiago de Cali. 2. Prestar apoyo profesional en el acompañamiento de las actividades necesarias en la presidencia realizadas en el concejo Distrital de Santiago de Cali. 3. Apoyó en la citación a plenaria del día 2, 8, 9, 10, 15, 16, 17, 18, 19, 21, 22, 23, 25 de noviembre. 4. Apoyó en la citación a comisión del día 1, 2, 3, 4, 9, 11, 12, 16, 17, 18, 19, 21, 22, 23, 24, 25 de noviembre.')
                    $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
                    $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
                    $document.Content.Find.Execute('<<V_fecha_cuenta>>', $false, $false, $false, $false, $false, $true, 1, $false, '30/11/2022')
                    $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1144028976')
                    $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1144028976')
                    $document.Content.Find.Execute('<<V_CC>>', $false, $false, $false, $false, $false, $true, 1, $false, '1144028976')
                    $document.SaveAs([ref]$outputPath, [ref]16) # 16 indica el formato de documento Word
                    $document.Close()
                    $word.Quit()
