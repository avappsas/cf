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
        .logo-cell { width: 14%; }
        .title-cell { width: 30%; font-weight: bold; font-size: 1.3em; }
        .meta-cell { width: 30%; }
        .meta-cell table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9em;
        }
        .meta-cell td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
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
                  <td class="logo-cell">
                    <img src="{{ asset('images/formatos/concejo.png') }}" alt="Logo Concejo" style="max-width:100%; height:auto;">
                  </td>
                  <td class="title-cell">
                    INFORME DE EJECUCIÓN DE ACTIVIDADES
                  </td>
                  <td class="meta-cell">
                    <table>
                      <tr><td colspan="2">JD01.F018</td></tr>
                      <tr><td>FECHA EMISIÓN</td><td>01/Sep/2024</td></tr>
                      <tr><td>VERSIÓN</td><td>002</td></tr>
                    </table>
                  </td>
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
                <tr class="altocuadro">
                    <td style="width: 40%;">
                        <table border="1" class="tabla-cizquierda">
                            <tr class="altocuadro">
                                <td><strong>CONTRATISTA</strong></td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 5%;"></td>
                    <td style="width: auto; max-width: 55%;">
                        <table border="1" class="tabla-cizquierda" style="width: 100%; table-layout: auto;">
                            <tr class="altocuadro">
                                <td style="white-space: normal; word-break: break-word; font-size: 13px;">
                                    {{ $datosPdf->V_nombre }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br class="altocuadro">  
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>NÚMERO DEL CONTRATO</strong></td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>{{$datosPdf->V_Num_Contrato}}</td></tr></table></td>
                </tr>
            </table>
            <br class="altocuadro">  
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>FECHA DE INICIO</strong></td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>{{$datosPdf->V_fecha_inicio}}</td></tr></table></td>
                </tr>
            </table>
            <br class="altocuadro">  
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>FECHA DE TERMINACIÓN</strong> </td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>{{$datosPdf->V_fecha_terminacion}}</td></tr></table></td>
                </tr>
            </table>
            <br class="altocuadro">  
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>VALOR DEL CONTRATO</strong></td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>  {{ $datosPdf->V_valor_contrato   }}</td></tr></table></td>
                </tr>
            </table>
            <br class="altocuadro">  
            <table border="0" class="tabla-tdatos">
               <tr class="altocuadro" >
                    <td style="width: 40%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td><strong>VALOR DE LA CUOTA</strong></td></tr></table></td>
                    <td style="width: 5%;" >  </td>
                    <td style="width: 60%;" ><table border="1" class="tabla-cizquierda"><tr class="altocuadro"><td>  {{ $datosPdf->V_valor_cuota }} 
                   </td></tr></table></td>
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
                    {!! nl2br(e($datosPdf->V_actividades_pp)) !!}
                </td></table>
            <br>
            <table border="0" class="tabla-tdatos">
                <td style="font-family: Arial, Helvetica, sans-serif;" >Para constancia de lo anterior se firma en Santiago de Cali, el día {{  $datosPdf->V_fecha_cuenta  }}. </td>
            </table>
            <br>
            <br>
            <table border="0" class="tabla-tdatos">
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $datosPdf->V_firma) }}" alt="Firma" style="max-width: 250px; height: auto; display: block;">
                    </td>
                </tr>
            </table>
            
            <table border="0" class="tabla-tdatos">
                <td style="font-family: Arial, Helvetica, sans-serif; font-weight: bold;" >{{$datosPdf->V_nombre}} </td>
            </table>
            <table border="0" class="tabla-tdatos">
                <td style="font-family: Arial, Helvetica, sans-serif;" >CC. {{$datosPdf->V_CC}} </td>
            </table>
            <br>