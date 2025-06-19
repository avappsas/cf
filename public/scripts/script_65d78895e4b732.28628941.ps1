
            $templatePath = 'C:\compartida\3.CERTIFICACION TRIBUTARIA.docx'
            $outputPath = 'C:\laragon\www\cf\public\documentos/documento_65d78895e4b8a5.02625100.docx'
            
            $word = New-Object -ComObject Word.Application
            $document = $word.Documents.Open($templatePath)

            # Rellenar campos en la plantilla
                \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        \$document.Content.Find.Execute("<<\$key>>", \$false, \$false, \$false, \$false, \$false, \$true, 1, \$false, "\$value")\n        $document.SaveAs([ref]$outputPath, [ref]16) # 16 indica el formato de documento Word
        $document.Close()
        $word.Quit()
