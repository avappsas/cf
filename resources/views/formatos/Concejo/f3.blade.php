<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado de No Uso de Costos</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-size: 14px;
        }

        body {
            background-color: #f0f0f0;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            min-height: 100vh;
            overflow-y: auto;
        }

        .pagina {
            width: 8.5in;
            min-height: 11in;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 2cm 3cm;
            box-sizing: border-box;
            margin: 20px auto;
            max-width: 100%;
            display: flex;
            flex-direction: column;
        }

        .titulo-principal {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .subtitulo {
            text-align: center;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .contenido {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            text-align: justify;
        }

        .firma {
            margin-top: 40px;
        }

        .firma span {
            display: inline-block;
            border-top: 1px solid #000;
            width: 250px;
            margin-top: 10px;
        }

        .organismo {
            margin-top: 20px;
        }

        .organismo a {
            color: #0000EE;
            text-decoration: underline;
        }

        .centrado {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="pagina">
        <div class="contenido">
            <div class="titulo-principal">
				<table border="1" >
					<tr><td >__________________________________________________________________</td> </tr> 
				</table>
				<br>
                CERTIFICADO DE NO UTILIZACION DE COSTOS Y DEDUCCIONES<br>
                ASOCIADOS A RENTAS DE TRABAJO
            </div>

            <div class="subtitulo">
                (Inciso 1 del Parágrafo 2 del Artículo 383 del E.T., modificado por el artículo 8 de la Ley 2277 de 2022 - Numeral 6 del artículo 1.2.4.1.6 y parágrafo 4 del artículo 1.2.4.1.17 del Decreto 1625 de 2016 modificados por los artículos 9 y 11 del Decreto 2231 de 2023)
            </div>
			<br>
            <p class="centrado"><strong>FAVOR DILIGENCIAR A MANO POR QUIEN INFORMA</strong></p>

            <p>Yo, <strong>{{$datosPdf->V_nombre}}</strong> con documento de identificación No. <strong>{{ number_format($datosPdf->V_CC, 0, ',', '.') }}</strong></p>

            <p class="centrado"><strong>MANIFIESTO BAJO LA GRAVEDAD DE JURAMENTO QUE:</strong></p>

            <p>
                Estoy vinculado al Distrito Santiago de Cali, hasta <strong>{{$datosPdf->V_fecha_terminacion}}</strong> mediante contrato por prestación de servicios y para efectos 
				de la aplicación de la tabla de retención en la fuente de que trata el artículo 383 del Estatuto tributario a las rentas de trabajo, informo que no haré uso de costos
				 y deducciones asociadas a los pagos o abonos en cuenta por concepto de <strong>HONORARIOS</strong>; o por compensaciones por <strong>SERVICIOS PERSONALES</strong> originados en el contrato suscrito con la entidad (Parágrafo 4 del artículo 1.2.4.1.17 del Decreto 1625 de 2016).
            </p>

            <p>
                Por lo anterior, solicito que al momento de la depuración de la base de la retención en la fuente sea tenida en cuenta la exención prevista en el numeral 10 del artículo 206 del Estatuto Tributario. Toda vez que cumplo con las previsiones del numeral 6 del artículo 1.2.4.1.6 del Decreto 1625 de 2016 modificado por el artículo 9 del Decreto 2231 de 2023.
            </p>

            <p><strong>CIUDAD Y FECHA:</strong> CALI, {{  $datosPdf->V_fecha_cuenta  }}</p>
			<br>
			<br>
            <table border="0" class="tabla-tdatos">
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $datosPdf->V_firma) }}" alt="Firma" style="max-width: 250px; height: auto; display: block;">
                        <br> ______________________ <br> Firma:
                    </td>
                </tr>
            </table> 
 

            <div class="organismo">
                <strong>ORGANISMO:</strong> 
				<br>
                CONCEJO DISTRITAL DE SANTIAGO DE CALI
            </div>
        </div>
    </div>
</body>
</html>
 