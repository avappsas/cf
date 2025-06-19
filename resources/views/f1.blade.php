<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoja Tamaño Carta con Tabla</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            background-color: #f0f0f0;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            min-height: 100vh;
            font-size: 14px;
            margin: 0;
            overflow-y: auto;
        }

        .pagina {
            width: 8.5in;
            min-height: 11in;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            box-sizing: border-box;
            margin: 20px auto;
            max-width: calc(100% - 40px);
            display: flex;
            flex-direction: column;
        }

        .tabla-encabezado {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #333;
            margin: auto;
        }

        .tabla-encabezado td {
            padding: 8px;
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            font-weight: bold;
        }

        .tabla-custom {
            width: 90%;
            line-height: 10px;
            border-collapse: collapse;
            border: 1px solid #333;
            margin: auto;
        }

        .tabla-custom td {
            font-family: Arial, Helvetica, sans-serif;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }

        .tabla-tdatos {
            width: 80%;
            border-collapse: collapse;
            border: 0px solid #ffffff;
            margin: auto;
        }

        .tabla-cizquierda {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #030303;
        }
        .tabla-cizquierda td {
            font-family: Arial, Helvetica, sans-serif;
            padding: 8px;
            text-align: center; 
        }

        footer {
            margin-top: 20px;
        }

        .altocuadro {
         line-height: 7px;
         }

    </style>
</head>
<body>
    <div class="pagina">
        <header>
            <table border="1" class="tabla-encabezado">
                <tr>
                    <td rowspan="2" class="columna-imagen">
                        <img src="{{asset("/images/formatos/concejo.png")}}" alt="Imagen" />
                    </td>
                    <td colspan="3">INFORME PARCIAL Y/O FINAL DE SUPERVISIÓN DE CONTRATO</td>
                    <td rowspan="2" class="columna-imagen">
                        <img src="{{asset("/images/formatos/sistemagestion.png")}}" alt="Imagen" />
                    </td>
                </tr>
                <tr>
                    <td>CÓDIGO: FO.102.23.002</td>
                    <td>FECHA DE APROBACIÓN: 13-02-2023</td>
                    <td>VERSIÓN: 001</td>
                </tr>
            </table>
        </header>
        <br>
        <section>
            <table border="1" class="tabla-custom">
                <tr class="altocuadro" >
                    <td>INFORME CONTRATISTA</td>
                </tr>
            </table>
            <br class="altocuadro">   
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>CONTRATISTA</strong></td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>{{$datosPdf->V_nombre}}</td></tr></table></td>
                </tr>
            </table>
            <br class="altocuadro">  
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>NÚMERO DEL CONTRATO</strong></td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>100.8.4.{{$datosPdf->V_no_contrato}}.2024</td></tr></table></td>
                </tr>
            </table>
            <br class="altocuadro">  
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>FECHA DE INICIO</strong></td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>{{ \Carbon\Carbon::createFromFormat('d/m/Y', $datosPdf->V_fecha_inicio)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}</td></tr></table></td>
                </tr>
            </table>
            <br class="altocuadro">  
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>FECHA DE TERMINACIÓN</strong> </td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>{{ \Carbon\Carbon::createFromFormat('d/m/Y', $datosPdf->V_fecha_terminacion)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}</td></tr></table></td>
                </tr>
            </table>
            <br class="altocuadro">  
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>VALOR DEL CONTRATO</strong></td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>$ {{ number_format($datosPdf->V_valor_contrato, 0, ',', '.') }}</td></tr></table></td>
                </tr>
            </table>
            <br class="altocuadro">  
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>VALOR DE LA CUOTA</strong></td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>$  
                        @if ($datosPdf->V_no_cuota == 1)
                            {{ number_format($datosPdf->V_valor_cuota1, 0, ',', '.') }}
                            @else
                            {{ number_format($datosPdf->V_valor_cuota, 0, ',', '.') }}
                        @endif</td></tr></table></td>
                </tr>
            </table>
            <br class="altocuadro">  
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>NÚMERO DE CUOTA </strong></td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>{{$datosPdf->V_no_cuota}}</td></tr></table></td>
                </tr>
            </table>
            <br>

            <br>
            <table border="0" class="tabla-tdatos">
                <td style="font-family: Arial, Helvetica, sans-serif; text-align: justify; ">El presente documento corresponde al informe de contratista, donde se relacionan las actividades realizadas en la cuota antes descrita, las cuales, entre otras, se reflejan en la, CLÁUSULA PRIMERA. ALCANCE DEL OBJETO CONTRACTUAL Y OBLIGACIONES ESPECÍFICAS DEL CONTRATISTA, suscrito en el Concejo Distrital de Santiago de Cali.</td>
            </table>
            <br>
            <br>
            <table border="0" class="tabla-tdatos">
                <td style="font-family: Arial, Helvetica, sans-serif; font-weight: bold; ">DESARROLLO DE ACTIVIDADES:</td>
            </table>
            <br>
            <table border="0" class="tabla-tdatos">
                <td style="font-family: Arial, Helvetica, sans-serif; text-align: justify;">
                    {!! $datosPdf->V_actividades_pp !!}
                </td> </table>
            <br>
            <table border="0" class="tabla-tdatos">
                <td style="font-family: Arial, Helvetica, sans-serif;" >Para constancia de lo anterior se firma en Santiago de Cali, el día {{ \Carbon\Carbon::parse($datosPdf->V_fecha_cuenta)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}. </td>
            </table>
            <br>
            <br>
            <table border="0" class="tabla-tdatos">
                <td>
                    <img src="{{ asset("/images/formatos/firma.png") }}" alt="Imagen" width="140" height="70">
                </td>
            </table>
            
            <table border="0" class="tabla-tdatos">
                <td style="font-family: Arial, Helvetica, sans-serif; font-weight: bold;" >{{$datosPdf->V_nombre}} </td>
            </table>
            <table border="0" class="tabla-tdatos">
                <td style="font-family: Arial, Helvetica, sans-serif;" >CC. {{$datosPdf->V_CC}} </td>
            </table>
            <br>