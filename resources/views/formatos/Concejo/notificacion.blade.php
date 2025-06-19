<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Invitación</title>
  <style>
    @page {
      margin: 1.5cm 0cm 3cm 0cm;
      @bottom-right {
        content: element(footer);
      }
    }

    body {
      margin:  0;
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
    .title-cell { width: 35%; font-weight: bold; font-size: 1.3em; }
    .meta-cell { width: 25%; }
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
      margin: 1cm 3cm 2.5cm 3cm; 
      text-align: justify; 
    }

    footer {
      position: running(footer);
      bottom: 0;
      left: 0;
      right: 0;
      height: 2cm;
      padding: 2px 1cm;
      box-sizing: border-box;
      border-top: 0px solid #000;
      font-size: 10px;
      background: #fff;
      text-align:center;
    }
  </style>

</head> 
<body>
  <div style="margin: 0 1cm;">
    <table class="header-table">
      <tr>
        <td class="logo-cell">
          <img src="{{ asset('images/formatos/concejo.png') }}" alt="Logo Concejo" style="max-width:100%; height:auto;">
        </td>
        <td class="title-cell">
          NOTIFICACIÓN SUPERVISIÓN Y/O INTERVENTORÍA DEL CONTRATO DE PRESTACIÓN DE SERVICIOS
        </td>
        <td class="meta-cell">
          <table>
            <tr><td colspan="2">JD01.F007</td></tr>
            <tr><td>FECHA EMISIÓN</td><td> 7-Junio-2024</td></tr>
            <tr><td>VERSIÓN</td><td> 002 </td></tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
  
  

<div class="contenido">

 
  <p> 
    Santiago de Cali, {{ $datosPdf->Fecha_Notificacion }}
    <br><br><br>
    Doctor(a):
    <br>
    <strong>{{ $datosPdf->Supervisor }}</strong> <br>
    <strong>{{ $datosPdf->CARGO }}</strong> <br>
    Concejo Distrital de Santiago de Cali <br>
    L.C.
    <br><br>
    <strong>ASUNTO:</strong> notificación supervisión del contrato de prestación de servicios {{ $datosPdf->servicios }} 
  </p>
 
  <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
    <tbody>
      <tr> <td style="border: 1px solid #000; padding: 5px;">
          <strong>CONTRATO DE PRESTACIÓN DE SERVICIOS No: {{ $datosPdf->Num_Contrato }}</strong> </td>  </tr>
      <tr> <td style="border: 1px solid #000; padding: 5px;">
        <strong>FECHA DE SUSCRIPCIÓN DEL CONTRATO:</strong> {{ $datosPdf->Fecha_Suscripcion }}</td>  </tr>    
      <tr> <td style="border: 1px solid #000; padding: 5px;">
        <strong>CONTRATANTE:</strong> MUNICIPIO SANTIAGO DE CALI – CONCEJO DISTRITAL</td>  </tr>
      <tr> <td style="border: 1px solid #000; padding: 5px;">
        <strong>CONTRATISTA:</strong>  {{ $datosPdf->Nombre }} </td>  </tr>    
      <tr> <td style="border: 1px solid #000; padding: 5px;">
        <strong>OBJETO: </strong> {{ $datosPdf->Objeto }} </td>  </tr>  
        <tr> <td style="border: 1px solid #000; padding: 5px;">
          <strong>VALOR DEL CONTRATO:</strong> $  {{ $datosPdf->Valor_Total }} ({{ $datosPdf->Valor_Total_Letras }} de pesos) {{ $datosPdf->Txt_iva }} </td>  </tr>    
        <tr> <td style="border: 1px solid #000; padding: 5px;">
          <strong>PLAZO DE EJECUCIÓN:</strong> {{ $datosPdf->Plazo }} </td>  </tr>
        <tr> <td style="border: 1px solid #000; padding: 5px;">
          <strong>NÚMERO DE CDP:</strong> {{ $datosPdf->CDP }}  </td>  </tr>    
        <tr> <td style="border: 1px solid #000; padding: 5px;">
          <strong>NUMERO DE RPC:</strong> {{ $datosPdf->RPC }} </td>  </tr>  
    </tbody>
  </table>

  <p>
  Respetuoso saludo.
  <br><br>
  Por medio del presente le comunico que, a partir de la fecha, le corresponde ejercer la supervisión del contrato de prestación de servicios No.  <strong>{{ $datosPdf->Num_Contrato }}</strong>, 
  suscrito con <strong>{{ $datosPdf->Nombre }}</strong>.
  <br><br>
  Lo anterior de conformidad a lo preceptuado en la cláusula Séptima del Contrato de prestación de servicios No. <strong>{{ $datosPdf->Num_Contrato }}</strong>, la cual señala que la supervisión 
  será ejercida por Acorde con lo dispuesto en el artículo 26 numeral 1º de la Ley 80 de 1993 y al Manual de Contratación del Concejo Distrital.
  <br><br>
  El Supervisor del contrato queda facultado para solicitar informes, aclaraciones y explicaciones sobre el desarrollo de la ejecución contractual, siendo el responsable de 
  mantener informada a la entidad contratante de los hechos, acciones o circunstancias que puedan constituir actos de corrupción tipificados como conductas punibles, o que 
  puedan poner o pongan en riesgo el cumplimiento del objeto del contrato, o cuando se presente un posible incumplimiento en la ejecución del mismo.
  <br><br> 
  En desarrollo de las actividades de supervisión, deberá estar al tanto del cumplimiento de los términos y condiciones pactados en el contrato de prestación de servicios No.<strong>{{ $datosPdf->Num_Contrato }}</strong>, de conformidad con lo establecido en los artículos 83 y 84 la Ley 1474 del 2011 (Estatuto Anticorrupción), los supervisores/interventores responderán civil, fiscal, penal y disciplinariamente, tanto por el cumplimiento de las obligaciones derivadas del contrato al cual se le realiza seguimiento, como por los hechos u omisiones que les sean imputables y causen daño o perjuicio a la entidad.
  <br><br> 
  Le Corresponde ejercer las funciones de supervisión en especial: <br>
  - Supervisar la correcta ejecución del Contrato. <br>
  - En caso de presentarse un presunto incumplimiento contractual, informar formalmente en oportunidad a la Presidencia de la Entidad para iniciar el procedimiento a que haya lugar. 
  <br><br> 
  El supervisor deberá presentar un informe del contrato respectivo, al Ordenador del Gasto, debe reunir los siguientes requisitos: <br>
  a). Motivación detallada en la que se expongan los hechos constitutivos del incumplimiento. <br>
  b). La relación de las obligaciones incumplidas. <br>
  c). La tasación de la multa de conformidad a lo pactado en el respectivo contrato, cuando a ella haya lugar. <br>
  d). La tasación de la cláusula penal pecuniaria de conformidad a lo pactado en el respectivo contrato, cuando a ella haya lugar. <br>
  e) La tasación de los posibles perjuicios derivados del incumplimiento del contrato, para la Corporación, cuando a ella haya lugar.  <br>
  f). Enumeración de las pruebas con fundamento en las cuales se verifica y constata el incumplimiento y que justifican el inicio de un proceso sancionatorio. <br>
  g) los soportes documentales en los cuales se observe los requerimientos y llamados de atención hechos por parte del supervisor al contratista dentro de la ejecución del contrato.  
  <br><br> 
  - Expedir los certificados de cumplimiento del contratista para efecto de trámites de pago. <br>
  - Solicitar al contratista presentar los informes que acrediten el cumplimiento de sus obligaciones, así como realizar el seguimiento oportuno para que el contratista realice el trámite 
  de pago ante la entidad cumpliendo las formalidades que para ello tenga establecido la Entidad a través de la Dirección Administrativa. <br>
  - Suscribir conjuntamente con el contratista el acta de inicio, acta de terminación y acta de liquidación. <br>
  - Las demás consagradas en el Contrato y que la ley exija.
  <br><br> 
  Comedidamente se le solicita allegar en debida oportunidad al expediente contractual, los informes y/o actas suscritas dentro de la ejecución del contrato, acreditación al cumplimiento 
  y pago de seguridad social, en cumplimiento de la normatividad legal vigente que rige la materia.
  <br><br> 
  Las copias de los contratos y demás documentos pertinentes para realizar seguimiento a la ejecución del contrato deberán ser solicitados en la oficina Jurídica del Concejo Distrital.
  <br><br>
 <br><br>
 
 
   Atentamente, 
   <br>
   <br>
   <br>
   ____________________________ <br>
   <strong>EDISON LUCUMI LUCUMI </strong><br>
   C.C. No. 94459505 <br>
   PRESIDENTE CONCEJO <br>
   <br><br><br>
   <strong>NOTIFICACIÓN PERSONAL</strong> <br>
   Nombre del notificado: <strong>{{ $datosPdf->Supervisor }}</strong>  
   <br>
   <br>
   <br>
  <br> 
  ____________________________ <br>
    Firma: <br>
    C.C: <strong>{{ $datosPdf->CEDULA }}  </strong><br>
    Cargo: <strong> {{ $datosPdf->CARGO }}    </strong><br>
    Email: {{ $datosPdf->CORREO }}  <br>
    Teléfono: 6678200 <br>
    Dirección: Av. 2N # 10 65 - CAM - Cali-Valle <br>
<br>
    Fecha y hora de la Notificación: {{ $datosPdf->Fecha_Notificacion }}    <br>
    Elaboró: {{ $datosPdf->Login ?? auth()->user()->name }} <br>
    Revisó Dr.: Ricardo Montero <br>
    Con copia a: Archivo del expediente contractual No. {{ $datosPdf->Num_Contrato }} <br>
    <br>
    Elaboró: {{ $datosPdf->Login ?? auth()->user()->name }} <br> 
<br><br>
 
  </p>
</div>
 


<footer>
  <div class="left">

    Concejo Distrital de Santiago de Cali
  </div> 
  <div style="clear:both;"></div>
  Av. 2 N No. 10-65 CAM - PBX 6678200 | www.concejodecali.gov.co<br>
  Este documento es propiedad del Concejo Distrital de Santiago de Cali. Prohibida su alteración o modificación.
</footer>

</body>
</html>
