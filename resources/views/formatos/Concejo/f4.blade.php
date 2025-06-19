<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado de Dependientes</title>
    <link rel="stylesheet" href="{{ asset('css/estilo-carta.css') }}">
    <style>

        .pagina {
            width: 8.5in;
            min-height: 11in;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            /* espacio interno equivalente a los márgenes */
            padding: 2cm 2cm;
            box-sizing: border-box;
            margin: 20px auto;
            display: flex;
            flex-direction: column;
            }
        .encabezado {
            margin-bottom: 20px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }
        .encabezado p { margin: 2px 0; }
        .cuerpo {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            text-align: justify;
            margin-bottom: 20px;
        }
        .tabla-dep {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .tabla-dep th, .tabla-dep td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 13px;
        }
        .tabla-dep th {
            background-color: #ddd;
            text-align: center;
        }
        .anexo {
            border: 1px solid #000;
            padding: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .firma {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }
        .firma span.linea {
            display: inline-block;
            border-top: 1px solid #000;
            width: 200px;
            margin-left: 10px;
        }
        .centrado {
        text-align: center;
        vertical-align: middle;
       }
    </style>
</head>
<body>
    <div class="pagina">
        {{-- Encabezado de fecha y destinatario --}}
        <div class="encabezado">
            <p>Cali,  {{  $datosPdf->V_fecha_cuenta  }}</p>
            <p>Señores</p>
            <p>Departamento Administrativo de Hacienda Municipal</p>
            <p>Oficina de Contabilidad</p>
            <p>Alcaldía Municipal de Santiago de Cali</p>
            <p>Ciudad</p>
        </div>

        {{-- Párrafo introductorio --}}
        <div class="cuerpo">
            Para efectos de la deducción por dependientes (Artículos 387, modificado por el artículo 9 de la ley 2277 de 2022 y 388 del Estatuto Tributario; artículos 1.2.4.1.6 Decreto 1625 de 2016 y artículo 1.2.4.1.18 del Decreto 1625 de 2016 modificado por el Artículo 9 del Decreto 2250 de 2017), CERTIFICO BAJO LA GRAVEDAD DE JURAMENTO, que las siguientes personas que relaciono, son mis dependientes y que por ellos no se ha solicitado este beneficio por otro contribuyente:
        </div>

        {{-- Tabla categorías --}}
        <table class="tabla-dep">
            <thead>
                <tr>
                    <th style="width:10%">CATEGORÍA</th>
                    <th>CARACTERÍSTICAS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="centrado">1</td>
                    <td>Los hijos del contribuyente que tengan hasta 18 años de edad.</td>
                </tr>
                <tr>
                    <td class="centrado">2</td>
                    <td>Los hijos del contribuyente con edad entre 18 y 23 años, cuando el padre o madre contribuyente  persona  natural  se  encuentre  financiando  su  educación  en instituciones  formales  de  educación  superior  certificadas  por  el  ICFES  o  la autoridad  oficial  correspondiente;  o  en  los  programas  técnicos  de  educación  no formal debidamente acreditados por la autoridad competente.</td>
                </tr>
                <tr>
                    <td class="centrado">3</td>
                    <td>3. Los hijos del contribuyente mayores de dieciocho (18) años que se encuentren en situación de dependencia, originada en factores físicos o psicológicos que sean certificados por Medicina Legal</td>
                </tr>
                <tr>
                    <td class="centrado">4</td>
                    <td>El  cónyuge  o  compañero  permanente  del  contribuyente  que  se  encuentre  en situación  de  dependencia  sea  por  ausencia  de  ingresos  o  ingresos  en  el  año menores a 260 UVT ($11.027.120 para el año 2023), certificada por contador público, o por dependencia originada en factores físicos o psicológicos que sean certificados por Medicina Legal.</td>
                </tr>
                <tr>
                    <td class="centrado">5</td>
                    <td>Los padres y los hermanos del contribuyente que se encuentren en situación de dependencia, sea por ausencia de ingresos o ingresos en el año menores a 260 UVT  ($11.027.120  para el  año  2023),  certificada  por  contador  público,  o  por dependencia originada en factores físicos o psicológicos que sean certificados por Medicina Legal</td>
                </tr>
            </tbody>
        </table>

        {{-- Tabla de dependientes --}}
        <table class="tabla-dep">
            <thead>
                <tr>
                    <th style="width:15%">CATEGORÍA</th>
                    <th style="width:35%">NOMBRE</th>
                    <th style="width:25%">IDENTIFICACIÓN</th>
                    <th style="width:25%">PARENTESCO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dependientes as $dep)
                <tr>
                    <td class="centrado">{{ $dep->categoria }}</td>
                    <td class="centrado">{{ $dep->nombre }}</td>
                    <td class="centrado">{{ $dep->identificacion }}</td>
                    <td class="centrado">{{ $dep->parentesco }}</td>
                </tr>
                @endforeach
                {{-- Si quieres siempre mostrar N filas en blanco --}}
                @for($i = count($dependientes); $i < 3; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            </tbody>
        </table>
        Indicar la categoría a la que pertenece cada dependiente.
        ANEXO: 
        {{-- Anexo --}}
        <div class="anexo">
            <p>
                CERTIFICADO CORRECCIÓN MONETARIA — AÑO _______
                <label style="margin-left:1cm;"><input type="radio" name="cert_correc" value="SI"> SI</label>
                <label style="margin-left:1cm;"><input type="radio" name="cert_correc" value="NO"> NO</label>
            </p>
            <p>
                CERTIFICADO MEDICINA PREPAGADA — AÑO _______
                <label style="margin-left:1cm;"><input type="radio" name="cert_medprep" value="SI"> SI</label>
                <label style="margin-left:1cm;"><input type="radio" name="cert_medprep" value="NO"> NO</label>
            </p>
        </div>

        <table border="0" class="tabla-tdatos">
            <tr>
                <td>
                    <img src="{{ asset('storage/' . $datosPdf->V_firma) }}" alt="Firma" style="max-width: 250px; height: auto; display: block;">
                    <br> ______________________ <br> Firma:
                </td>
            </tr>
        </table> 
        {{-- Firma y datos finales --}}
        <div class="firma">
            <p><strong>Nombre:</strong> {{$datosPdf->V_nombre}}</p>
            <p><strong>No. de Documento:</strong> {{ number_format($datosPdf->V_CC, 0, ',', '.') }}</p>
            <p><strong>Organismo:</strong> CONCEJO DISTRITAL DE SANTIAGO DE CALI</p>
        </div>
    </div>
</body>
</html>
