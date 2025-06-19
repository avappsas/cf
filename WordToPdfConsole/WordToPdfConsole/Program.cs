using System;
using System.IO;
using System.IO.Compression;
using System.Collections.Generic;
using Microsoft.Office.Interop.Word;
using Newtonsoft.Json;
using System.Runtime.InteropServices;

namespace WordToPdfConsole
{
    class InputData
    {
        public List<TemplateItem> Plantillas { get; set; }
    }

    class TemplateItem
    {
        public string PlantillaPath { get; set; }
        public Dictionary<string, string> Campos { get; set; }
    }

    class Program
    {
        private static Application _wordApp;

        static int Main(string[] args)
        {
            if (args.Length < 1)
            {
                Console.Error.WriteLine("Uso: WordToPdfConsole.exe <inputJsonPath>");
                return 1;
            }

            string inputJsonPath = args[0];
            if (!File.Exists(inputJsonPath))
            {
                Console.Error.WriteLine($"No se encontró el JSON de entrada: {inputJsonPath}");
                return 1;
            }

            InputData input;
            try
            {
                string json = File.ReadAllText(inputJsonPath);
                input = JsonConvert.DeserializeObject<InputData>(json);
            }
            catch (Exception ex)
            {
                Console.Error.WriteLine("Error al leer JSON: " + ex.Message);
                return 1;
            }

            var pdfPaths = new List<string>();
            string zipPath = null;

            try
            {
                InitWordApplication();

                foreach (var tpl in input.Plantillas)
                {
                    Document doc = null;
                    try
                    {
                        doc = _wordApp.Documents.Open(
                            FileName: tpl.PlantillaPath,
                            ReadOnly: true,
                            Visible: false,
                            AddToRecentFiles: false,
                            OpenAndRepair: false,
                            NoEncodingDialog: true);

                        var find = doc.Content.Find;
                        find.ClearFormatting();
                        find.Replacement.ClearFormatting();
                        foreach (var kv in tpl.Campos)
                        {
                            find.Text = $"<<{kv.Key}>>";
                            find.Replacement.Text = kv.Value ?? string.Empty;
                            find.Wrap = WdFindWrap.wdFindContinue;
                            find.Execute(Replace: WdReplace.wdReplaceAll);
                        }

                        string pdfTemp = Path.Combine(
                            Path.GetTempPath(),
                            Path.GetFileNameWithoutExtension(tpl.PlantillaPath)
                              + "_" + Guid.NewGuid() + ".pdf"
                        );
                        doc.SaveAs2(pdfTemp, WdSaveFormat.wdFormatPDF);
                        pdfPaths.Add(pdfTemp);
                    }
                    finally
                    {
                        if (doc != null)
                        {
                            doc.Close(SaveChanges: false);
                            ReleaseComObject(doc);
                        }
                    }
                }

                zipPath = Path.Combine(
                    Path.GetTempPath(),
                    $"salida_{Guid.NewGuid()}.zip"
                );
                using var zip = ZipFile.Open(zipPath, ZipArchiveMode.Create);
                foreach (var pdf in pdfPaths)
                {
                    zip.CreateEntryFromFile(pdf, Path.GetFileName(pdf));
                }

                Console.WriteLine(zipPath);
                return 0;
            }
            catch (Exception ex)
            {
                Console.Error.WriteLine("ERROR: " + ex.Message);
                return 2;
            }
            finally
            {
                CleanupWordApplication();
                foreach (var pdf in pdfPaths)
                    TryDelete(pdf);
            }
        }

        private static void InitWordApplication()
        {
            _wordApp = new Application
            {
                Visible = false,
                ScreenUpdating = false,
                DisplayAlerts = WdAlertLevel.wdAlertsNone
            };
            _wordApp.Options.SaveNormalPrompt    = false;
            _wordApp.Options.ConfirmConversions  = false;
        }

        private static void CleanupWordApplication()
        {
            if (_wordApp != null)
            {
                try { _wordApp.Quit(SaveChanges: false); } catch { }
                ReleaseComObject(_wordApp);
                _wordApp = null;
                GC.Collect();
                GC.WaitForPendingFinalizers();
            }
        }

        private static void ReleaseComObject(object comObj)
        {
            try { Marshal.ReleaseComObject(comObj); }
            catch { }
        }

        private static void TryDelete(string path)
        {
            try { if (File.Exists(path)) File.Delete(path); } catch { }
        }
    }
}