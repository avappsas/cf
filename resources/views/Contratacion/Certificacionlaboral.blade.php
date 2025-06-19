<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado Laboral</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt; /* Tamaño de letra 11 */
            line-height: 1.6;
            margin: 1cm 40px 1px 40px; /* Margen superior reducido a 1cm */
        }

        .header {
            width: 100%; /* Asegura que el header ocupe toda la página */
            text-align: left; /* Alineación del logo a la izquierda */
            margin-bottom: 30px;
            padding: 5px 0;
        }

        .header img {
            max-width: 100px; /* Cambié el tamaño máximo del logo a 100px */
            vertical-align: middle; /* Alineación del logo con el texto */
            padding: 5px 0;
        }

        .header h2 {
            display: inline; /* Para que el texto y logo estén en la misma línea */
            margin-left: 10px;
            vertical-align: middle;
        }

        .title {
            font-weight: bold;
            text-align: center;
            margin: 5px 0; /* Reducir el espacio arriba y abajo */
            line-height: 1.2; /* Reducir el espacio entre líneas */
        }

        .content {
            margin-bottom: 30px;
        }

        .contract {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .contract:last-child {
            border-bottom: none;
        }

        .contract-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .contract-table td:first-child {
            width: 30%;
            font-weight: bold;
            vertical-align: top;
            padding-bottom: 10px;
        }

        .contract-table td:last-child {
            width: 70%;
            padding-bottom: 10px;
        }

        .signature {
            margin-top: 50px;
            text-align: center;
        }

        .stamp-section {
            margin-top: 50px;
            border-top: 1px dashed #ccc;
            padding-top: 20px;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.8em;
        }

        .bold {
            font-weight: bold;
            margin-bottom: 1px;
            margin-top: 1px;

        }
        .contract-table td {
            text-align: justify;
        }

        .footer {
            font-family: Arial, sans-serif;
            font-size: 11pt; /* Tamaño de letra 11 */
            margin-bottom: 1px;
            margin-top: 1px;
            text-align: center; /* Centra el texto dentro del pie de página */
        }

    </style>
</head>
<body>
 

    <div class="title">
        <img src="https://www.concejodecali.gov.co/info/concejo/media/bloque4302.png" alt="Logo Concejo Distrital" style="width: 3cm; margin-bottom: 1px;  margin-top: 1px">
        <p>
        <p style="text-align: center;font-weight: bold;font-size: 16px;margin-top: 1px;margin-bottom: 1px;">LA DIRECTORA ADMINISTRATIVA DEL HONORABLE</p> 
        <p style="text-align: center; font-weight: bold; font-size: 16px;margin-top: 1px;margin-bottom: 1px;">CONCEJO DISTRITAL DE SANTIAGO DE CALI</p>
        <br>
        <p>
        <p>CERTIFICA:</p>
    </div>

    <div class="content">
        <p>
            Que el(la) señor(a) <span class="bold">{{ $nombre }}</span>, identificado(a) con cédula de ciudadanía No. <span class="bold">{{ $no_documento }}</span> de Santiago de Cali (Valle), tuvo los siguientes contratos con esta entidad:
        </p>
        @foreach($contratos as $index => $contrato)
        <div class="contract">
            <table class="contract-table">
                <tr>
                    <td>Número de contrato:</td>
                    <td><strong>{{ $contrato['Num_Contrato'] }}  @if ($contrato['Cant'] == 2) con Otrosí @endif</strong></td>
                </tr>
                <tr>
                    <td>Objeto del contrato:</td>
                    <td>{{ $contrato['Objeto'] }}</td>
                </tr>
                <tr>
                    <td>Tiempo de servicio:</td>
                    <td>Del {{$contrato['Fecha_Suscripcion'] }} hasta el {{  $contrato['Plazo']  }}.</td>
                </tr>
                <tr>
                    <td>Valor del contrato:</td>
                    <td>{{ $contrato['Valor_Total_letras'] }} pesos mcte  (${{ number_format($contrato['Valor_Total'], 0, ',', '.') }}) diferido en {{ $contrato['Cuotas_Letras'] }} ({{ $contrato['Cuotas'] }}) cuotas de {{ $contrato['Valor_Mensual_Letras'] }} pesos mcte (${{ number_format($contrato['Valor_Mensual'], 0, ',', '.') }}).</td>
                </tr>
            </table>
               <strong>Actividades del contrato:</strong>  <div style="text-align: justify;">{{ $contrato['Actividades'] }}</div>  
        </div>
        @endforeach

        <p>
            Este certificado no tiene validez sin las estampillas de ley según (ordenanza 301 de 2009. Acuerdo Municipal No. 010 del 13 de mayo de 1983 y acuerdo 321 del 2011).
        </p>

        <p>
            Para constancia de lo anterior se firma en Santiago de Cali, el día <span class="bold">{{ \Carbon\Carbon::parse($fecha_hoy)->translatedFormat('j \d\e F \d\e Y') }}</span>
        </p>
    </div>

    <div class="signature">
        <br>
        <br>
        <br>
        <p class="bold">VALERIA GARCIA ARIAS</p>
        <p class="bold">DIRECTORA ADMINISTRATIVA DEL CONCEJO</p>
        <p class="bold">Tel. 8897884</p>
    </div>

    <div class="footer">
        <p>Elaborado: Gerardiny Mesa -Contratista</p> 
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br> 
    <div class="footer">
        <p style="  margin-top: 1px; margin-bottom: 1px; ">Concejo Distrital – Santiago de Cali – Colombia</p>
        <p style="  margin-top: 1px; margin-bottom: 1px; ">Av. 2 Norte N° 10 – 65 CAM – PBX:  667 8200</p>
        <p style="  margin-top: 1px; margin-bottom: 1px; ">www.concejodecali.gov.co</p>
    </div>
</body>
</html>
