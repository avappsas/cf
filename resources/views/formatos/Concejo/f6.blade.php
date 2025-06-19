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
                EVIDENCIAS Cuota {{$datosPdf->V_no_cuota}}
            </div>

                <strong> CONTRATISTA: </strong>
                {{$datosPdf->V_nombre}}
                <br>
                <strong> CONTRATO: </strong> 
                {{$datosPdf->V_Num_Contrato}}
                <br>
                <strong>FECHA DE INICIO</strong>
                {{ $datosPdf->V_fecha_inicio }}
                <br>
                <strong>FECHA DE TERMINACIÓN</strong> 
                {{   $datosPdf->V_fecha_terminacion }}
                <br>
                <strong>OBJETO DEL CONTRATO</strong> 
                {!! $datosPdf->V_objeto !!} 
                <br><br>
                <strong>DESARROLLO DE ACTIVIDADES (anexar fotos de evidencias por cada actividad)</strong> <br><br>
                {!! nl2br(e($datosPdf->V_actividades_pp)) !!}
                <br><br>
                <br>
                
 
        </div>
    </div>
</body>
</html>
