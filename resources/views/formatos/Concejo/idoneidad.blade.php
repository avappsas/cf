<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Certificado de Idoneidad</title>
  <style>
    @page { margin: 2cm 0cm 1cm 0cm; }

    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      font-size: 13px;
      line-height: 1.5;
    }

    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 0cm;
      padding: 0 2cm;
      box-sizing: border-box;
      background: #fff;
    }
    .header-table {
      width: 100%;
      border-collapse: collapse;
    }
    .header-table td {
      border: 1px solid #000;
      padding: 3px;
      text-align: center;
      vertical-align: middle;
    }
    .logo-cell { width: 18%; }
    .title-cell { width: 30%; font-weight: bold; font-size: 1.3em; }
    .meta-cell { width: 30%; }
    .meta-cell table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.9em;
    }
    .meta-cell td {
      border: 1px solid #000;
      padding: 10px;
      text-align: center;
    }

    .contenido {
      margin: 4cm 3cm 3cm 3cm;
      text-align: justify;
      line-height: 1.5;
    }

 

    .footer .left { float: left; text-align: left; }
    .footer div { display: inline-block; }
  </style>
</head>
<body>

<header>
  <table class="header-table">
    <tr>
      <td class="logo-cell">
        <img src="{{ asset('images/formatos/concejo.png') }}" alt="Logo Concejo" style="max-width:100%; height:auto;">
      </td>
      <td class="title-cell">
        CERTIFICADO DE<br>IDONEIDAD
      </td>
      <td class="meta-cell">
        <table>
          <tr><td colspan="2">JD01.F001</td></tr>
          <tr><td>FECHA EMISIÓN</td><td>  7-Junio-2024 </td></tr>
          <tr><td>VERSIÓN</td><td> 002 </td></tr>
        </table>
      </td>
    </tr>
  </table>
  <br><br>
</header>

<div class="contenido">
  <br><br><br>
  <p> 
    Conforme a los estudios y experiencia específica que relaciona en la hoja de vida y que obra en la carpeta del respectivo contrato a suscribir entre el 
    Concejo Distrital de Santiago de Cali y el (la) señor(a) <strong>{{ $datosPdf->Nombre }}</strong>, identificado(a) con la Cédula de Ciudadanía No 
    <strong>{{ $datosPdf->CEDULA }}</strong>. Se considera la idoneidad del mencionado(a) para desarrollar el contrato de prestación de servicios de apoyo a 
    la gestión cuyo objeto contractual es: {{ $datosPdf->Objeto }}. Con Certificado de Disponibilidad Presupuestal {{ $datosPdf->CDP }}, del {{ $datosPdf->Fecha_CDP }},
    con el código de Apropiación Presupuestal {{ $datosPdf->Apropiacion ?? '4001/0-1102/01019999999' }}.
 <br><br>
    Este certificado de idoneidad se expide en cumplimiento de lo establecido por el Decreto 1082 de 2016, Artículo 2.2.1.2.1.4.9.
 <br><br>
    Para constancia se firma en Santiago de Cali, el día {{ $datosPdf->Fecha_Idoneidad }}.
    <br><br>
  </p>

  <p>Atentamente,</p> 
  <br><br>
 <table border="0" class="tabla-tdatos">
   <tr>
     <td>
       <img src="{{ asset('storage/firmas/Interventores/Concejo/94371090.png') }}" alt="firma" style="max-width:100%; height:auto;">
     </td>
   </tr>
 </table>

 <p>
   <strong>RICARDO MONTERO GONZALEZ</strong><br>
   Jefe oficina jurídica<br>
   Concejo Distrital de Santiago de Cali
   <br><br>
   Elaboró: {{ $datosPdf->Login ?? auth()->user()->name }}<br>
 </p>
</div>
@if (isset($pdf))
  <script type="text/php">
    $font = $fontMetrics->get_font("Arial", "normal");
    $size = 9;
    $text = "Página $PAGE_NUM de $PAGE_COUNT";
    $width = $fontMetrics->get_text_width($text, $font, $size);

    // Centrado horizontal
    $x = (612 - $width) / 2;

    // Altura: parte inferior del contenido, pero dentro del área visible
    $y = 780;

    $pdf->text($x, $y, $text, $font, $size);
  </script>
@endif

<footer style="text-align:center;">
  <div class="left">
 
    Concejo Distrital de Santiago de Cali
  </div> 
  <div style="clear:both;"></div>
  Av. 2 N No. 10-65 CAM - PBX 6678200 | www.concejodecali.gov.co<br>
  Este documento es propiedad del Concejo Distrital de Santiago de Cali. Prohibida su alteración o modificación.
</footer>

</body>
</html>
