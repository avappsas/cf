<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Tecnica </title>
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
            font-size: 10px;
            font-family: Arial, Helvetica, sans-serif;
            overflow-y: auto;
        }

        .pagina {
            width: 8.5in; /* Ancho fijo para simular el tamaño carta */
            min-height: 11in; /* Altura mínima para el tamaño carta */
            background-color: #fff; /* Fondo blanco para la página */
            
            padding: 10px; /* Espaciado interno reducido alrededor del contenido */
            margin: 25px auto; /* Margen automático para centrar la página horizontalmente y espacio vertical */
            max-width: calc(100% - 30px); /* Ancho máximo adaptable con margen */
            display: flex; /* Utiliza flexbox para organizar el contenido */
            flex-direction: column; /* Organiza el contenido en una columna vertical */
        }

        .header-table {
            width: 95%;
            border-collapse: collapse;
            border: 2px solid #333;
            margin-bottom: 10px; /* Espacio después del encabezado */
			margin-left: auto;
            margin-right: auto;
        }
        .header-table td {
            border: 1px solid #000;
            padding: 2px; /* Reducido */
            text-align: center;
            vertical-align: middle;
        }
        .logo-cell { width: 14%; }
        .title-cell { width: 30%; font-weight: bold; font-size: 1.2em; }
        .meta-cell { width: 30%; }
        .meta-cell table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9em;
        }
        .meta-cell td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
        }

        .titulos {
            background-color: #ddd;
            font-weight: bold;
            text-align: left;
            padding: 4px; /* Espaciado interno consistente */
        }

        .tabla-custom {
            width: 90%;
            border-collapse: collapse;
            border: 2px solid #333;
            margin-bottom: 3px; /* Espacio entre tablas */
            margin-left: auto;
            margin-right: auto;
        }
        .tabla-custom td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            line-height: 1.1; /* Ligeramente ajustado */
            padding: 2px 4px; /* Reducido */
            border: 1px solid #333; 
            vertical-align: middle;
        }

        .tabla-custom tr {
            height: 19px; /* Altura de fila reducida */
        }
        
        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .font-large {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="pagina">
        <header>

            <table class="header-table">
                <colgroup>
                    <col style="width:25%;"> 
                    <col style="width:45%;"> 
                    <col style="width:15%;"> 
					<col style="width:15%;"> 
                </colgroup>
                <tr>
				    <td class="logo-cell" rowspan="2"> <img src="{{ asset('images/formatos/concejo.png') }}" alt="Logo Concejo" style="max-width:70%; height:auto;"> </td>	
					<td class="title-cell" rowspan="2" > MODELO INTEGRADO DE PLANEACIÓN Y GESTIÓN (MIPG) <br><br> FICHA TÉCNICA DE IMPUESTOS Y CONTABILIDAD PRESTADORES DE SERVICIO (PS) </td>
					<td class="title-cell" colspan="2">MAHP03.03.01.P020.F001</td> 
				</tr>                
				<tr>
				   <td ><b><span style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">VERSIÓN</span></b></td><td><b><span style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">014</span></b></td>
				</tr> 
            </table> 
        </header>

        <section>
            <table class="tabla-custom">
                <colgroup>
                    <col style="width:20%;"> <col style="width:10%;"> <col style="width:10%;">
                    <col style="width:10%;"> <col style="width:10%;"> <col style="width:20%;">
                    <col style="width:10%;"> <col style="width:10%;">
                </colgroup>
                <tr>
                    <td colspan="8" class="titulos font-large text-center"><strong>A. DATOS GENERALES</strong></td>
                </tr>
                <tr>
                    <td class="titulos"><strong>1. Contratista:</strong></td>
                    <td colspan="4" class="font-large"><strong>{{$datosPdf->Nombre}}</strong></td>
                    <td class="titulos"><strong>2. Ficha No:</strong></td>
                    <td class="font-large text-center"><strong>{{$datosPdf->N_C}}</strong></td>
                    <td class="font-large text-center"><strong>PS</strong></td>
                </tr>
                <tr>
                    <td class="titulos"><strong>3. Contrato No.:</strong></td>
                    <td colspan="4" class="font-large"><strong>{{$datosPdf->Num_Contrato}}</strong></td>
                    <td class="titulos"><strong>4. RUT/NIT:</strong></td>
                    <td class="text-center"><strong>{{$datosPdf->No_Documento}}</strong></td>
                    <td class="text-center"><strong>{{$datosPdf->Dv ?? '-'}}</strong></td>
                </tr>
                <tr>
                    <td class="titulos" colspan="2"><strong>5. Régimen Tributario Renta:</strong></td>
                    <td colspan="3" class="font-large text-center"><strong>{{$datosPdf->renta}}</strong></td>
                    <td class="titulos" rowspan="2"><strong>6. Actividad Económica:</strong></td>
                    <td class="text-center"><strong>Principal:</strong></td>
                    <td class="text-center"><strong>{{$datosPdf->actividad_principal}}</strong></td>
                </tr>
                <tr>
                    <td class="titulos" colspan="2"><strong>7. Régimen Tributario Ventas:</strong></td>
                    <td colspan="3" class="font-large text-center"><strong>{{ ($datosPdf->iva) }}</strong></td>
                    <td class="text-center"><strong>Contractual:</strong></td>
                    <td class="text-center"><strong>{{$datosPdf->actividad_contractual}}</strong></td>
                </tr>
                <tr>
                    <td class="titulos" colspan="2"><strong>8. Facturador Electrónico:</strong></td>
                    <td colspan="3" class="font-large text-center"><strong> {{ ($datosPdf->iva == 'R-48') ? 'SI (X)' : 'NO (X)' }}  </strong></td>
                    <td class="titulos"><strong>9. Régimen Simple de Tributación:</strong></td>
                    <td colspan="2" class="font-large text-center"><strong>{{ ($datosPdf->renta == 'R47') ? 'SI (X)' : 'NO (X)' }}</strong></td>
                </tr>
                <tr>
                    <td class="titulos" colspan="2"><strong>10. Dependencia – Centro Gestor:</strong></td>
                    <td colspan="3" class="font-large text-center"><strong>4001</strong></td>
                    <td class="titulos"><strong>11. CDP No.:</strong></td>
                    <td colspan="2" class="font-large text-center"><strong>{{$datosPdf->CDP}}</strong></td>
                </tr>
                <tr>
                    <td class="titulos" colspan="2"><strong>12. Valor Total del Contrato:</strong></td>
                    <td colspan="3" class="font-large text-center"><strong>$ {{$datosPdf->Valor_Total}}</strong></td>
                    <td class="titulos"><strong>13. Valor IVA:</strong></td>
                    <td colspan="2" class="font-large text-center"><strong>{{ ($datosPdf->iva == 'SI') ? '$' . number_format(floatval(str_replace('.', '', $datosPdf->Valor_Total)) * 0.19, 0, ',', '.') : '$0' }}</strong></td>
                </tr>
            </table>

            <table class="tabla-custom">
                <colgroup>
                    <col style="width:10%;"> <col style="width:30%;"> <col style="width:8%;">
                    <col style="width:10%;"> <col style="width:10%;"> <col style="width:8%;">
                    <col style="width:8%;"> <col style="width:8%;">
                </colgroup>
                <tr>
                    <td colspan="8" class="titulos font-large text-center"><strong>B. DEDUCCIONES Y RETENCIONES CON LOS CÓDIGOS SGAFT-SAP</strong></td>
                </tr>
                <tr>
                    <td class="titulos" rowspan="9"><strong>14. DEDUCCIONES</strong></td>
                    <td class="titulos text-center" colspan="3"><strong>CONCEPTO</strong></td>
                    <td class="titulos text-center"><strong>16. BASE (Valor sin IVA)</strong></td>
                    <td class="titulos text-center"><strong>NO</strong></td>
                    <td class="titulos text-center"><strong>SI</strong></td>
                    <td class="titulos text-center"><strong>%</strong></td>
                </tr>
                <tr>
                    <td colspan="3">Pro-Desarrollo Urbano – EP < a 2.196 UVT (De $1 y < $109.358.604)</td>
                    <td rowspan="13" class="text-center"> @php $valorBruto = floatval(str_replace('.', '', $datosPdf->Valor_Total));
    					$iva = ($datosPdf->iva == 'SI') ? $valorBruto * 0.19 : 0; $valorSinIva = $valorBruto - $iva; @endphp
 							{{ '$' . number_format($valorSinIva, 0, ',', '.') }}</td>
                    <td class="text-center font-bold">@if(floatval(str_replace('.', '', $datosPdf->Valor_Total)) >= 109358604) X @endif</td>
                    <td class="text-center font-bold">@if(floatval(str_replace('.', '', $datosPdf->Valor_Total)) <= 109358604) X @endif</td>
                    <td class="text-center font-bold">1,00</td>
                </tr>
                <tr>
                    <td colspan="3">Pro-Desarrollo Urbano – EP >= a 2.196 UVT (Mayor o Igual A $109.358.604)</td>
                    <td class="text-center font-bold">@if(floatval(str_replace('.', '', $datosPdf->Valor_Total)) <= 109358604) X @endif</td>
                    <td class="text-center font-bold">@if(floatval(str_replace('.', '', $datosPdf->Valor_Total)) >= 109358604) X @endif</td>
                    <td class="text-center font-bold">3,50</td>
                </tr>
                <tr>
                    <td colspan="3">Pro-Bienestar del adulto Adulto Mayor-EA</td>
                    <td class="text-center font-bold">X</td>
                    <td class="text-center font-bold"> </td>
                    <td class="text-center font-bold">2,00</td>
                </tr>
                <tr>
                    <td colspan="3">Pro-Deporte y Recreacion-ED</td>
                    <td class="text-center font-bold">X</td>
                    <td class="text-center font-bold"> </td>
                    <td class="text-center font-bold">2,00</td>
                </tr>
                <tr>
                    <td colspan="3">Pro-Justicia Familiar- EJ Cuota Mensual => 10 SMMLV (Igual o Mayor a $14.235.000)</td>
                    <td class="text-center font-bold">X</td>
                    <td class="text-center font-bold"> </td>
                    <td class="text-center font-bold">2,00</td>
                </tr>
                <tr>
                    <td colspan="3">Pro-Univalle – EV</td>
                    <td class="text-center font-bold"> </td>
                    <td class="text-center font-bold">X</td>
                    <td class="text-center font-bold">2,00</td>
                </tr>
                <tr>
                    <td colspan="3">Pro-Hospital – EH</td>
                    <td class="text-center font-bold"> </td>
                    <td class="text-center font-bold">X</td>
                    <td class="text-center font-bold">1,00</td>
                </tr>
                <tr>
                    <td colspan="3">Pro-Unipacifico – EU Cuota Mensual > 6 SMMLV (Mayor a $8.541.000) Prestación de Servicios Persona Natural</td>
                    <td class="text-center font-bold">@if(floatval(str_replace('.', '', $datosPdf->Valor_Total)) <= 8541000) X @endif</td>
                    <td class="text-center font-bold">@if(floatval(str_replace('.', '', $datosPdf->Valor_Total)) >= 8541000) X @endif</td>
                    <td class="text-center font-bold">0,50</td>
                </tr>
                <tr>
                    <td class="titulos" rowspan="5"><strong>15. RETENCIONES</strong></td>
                    <td colspan="3">RETE ICA – IV – IS</td>
                    <td class="text-center font-bold">@if($datosPdf->Nivel_Contrato == 'Profesional' || $datosPdf->Nivel_Contrato == 'Asesor' || $datosPdf->Nivel_Contrato == 'Especializado') X @endif</td>
                    <td class="text-center font-bold">X</td>
                    <td class="text-center font-bold">0,50</td>
                </tr>
                <tr>
                    <td colspan="2">Adjuntó certificación de NO Utilización de Costos y Deducciones asociados al Ingreso? SI - NO</td>
                    <td class="text-center font-bold"> <select name="certificacion_costos" id="certificacion_costos" style="border: none;" class="form-control"> <option value="SI">SI</option> <option value="NO">NO</option> </select></td>
                    <td class="text-center font-bold"> </td>
                    <td class="text-center font-bold"> </td>
                    <td class="text-center font-bold"> </td>
                </tr>
                <tr>
                    <td colspan="2">Retefuente – RS – RH</td>
                    <td class="text-center font-bold">@if($datosPdf->Nivel_Contrato == 'Profesional' || $datosPdf->Nivel_Contrato == 'Asesor') RH @else RS @endif</td>
                    <td class="text-center"> <span id="retencion_1"></span> </td>
                    <td class="text-center font-bold"><span id="retencion_2"></span></td>
                    <td class="text-center font-bold"><span id="retencion_3"></span></td>
                </tr>
                <tr>
                    <td colspan="2">Ret. Fte. Personas Naturales Cédulas Rentas de Trabajo Art. 383 E.T. - RW</td>
                    <td class="text-center font-bold"><span id="retencion_7"></span> </td>
                    <td class="text-center font-bold"><span id="retencion_4"></span></td>
                    <td class="text-center font-bold"><span id="retencion_5"></span></td>
                    <td class="text-center font-bold"><span id="retencion_6"></span></td>
                </tr>
                <tr>
                    <td colspan="3">RETE IVA – RI</td>
                    <td class="text-center font-bold">{{ ($datosPdf->iva == 'NO') ? 'X' : '' }}</td>
                    <td class="text-center font-bold">{{ ($datosPdf->iva == 'SI') ? 'X' : '' }}</td>
                    <td class="text-center font-bold">15,00</td>
                </tr>
            </table>

            <table class="tabla-custom">
                <colgroup> <col style="width:25%;"> <col style="width:25%;"> <col style="width:25%;"> <col style="width:25%;"> </colgroup>
                <tr>
                    <td colspan="4" class="titulos font-large text-center"><strong>17. VALOR UVT AÑO 2025 $49.799</strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="font-large text-center"><strong>C. CONTABILIZACIÓN</strong></td>
                </tr>
                <tr>
                    <td class="titulos text-center" colspan="2"><strong>18. CONTABILIZACIÓN - CUENTA No.</strong></td>
                    <td class="titulos text-center"><strong>VALOR DÉBITO</strong></td>
                    <td class="titulos text-center"><strong>VALOR CRÉDITO</strong></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><strong>@if($datosPdf->Nivel_Contrato == 'Profesional') 5111790000 @else 5111800175 @endif</strong></td>
                    <td class="text-center"><strong>{{$datosPdf->Valor_Total}}</strong></td>
                    <td class="text-center"><strong>0</strong></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><strong>@if($datosPdf->Nivel_Contrato == 'Profesional') 2490540000 @else 2490550000 @endif</strong></td>
                    <td class="text-center"><strong>0</strong></td>
                    <td class="text-center"><strong>{{$datosPdf->Valor_Total}}</strong></td>
                </tr>
                <tr>
                    <td class="titulos text-center"><strong>19. FORMA DE PAGO</strong></td>
                    <td class="titulos text-center"><strong>20. OBSERVACIÓN</strong></td>
                    <td class="titulos text-center"><strong>21. VALOR</strong></td>
                    <td class="titulos text-center"><strong>22. PORCENTAJE</strong></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>{{$datosPdf->Cuotas}}</strong></td>
                    <td class="text-center"><strong> </strong></td>
                    <td class="text-center"><strong>{{$datosPdf->Valor_Mensual}}</strong></td>
                    <td class="text-center"><strong>0%</strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="titulos font-large text-center"><strong>23. OBJETO DEL CONTRATO</strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="font-large text-center"><strong>{{$datosPdf->Objeto}}</strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="titulos font-large text-center"><strong>24. OBSERVACIONES</strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-center" style="font-size: 9px;"><strong>Decreto 1625 de 2016, artículo 1.2.4.1.17 Parágrafo 4, modificado por el artículo 11 del Decreto 2231 de 2023: Las personas naturales que perciban rentas de trabajo diferentes a las provenientes de una relación laboral o legal y reglamentaria que no soliciten al agente retenedor la aplicación de costos y deducciones de conformidad con lo previsto en el numeral 6 del artículo 1.2.4.1.6 de este Decreto, se rigen por lo previsto en el artículo 383 del Estatuto Tributario. En caso contrario tendrá lugar a aplicar las tarifas de retención en la fuente previstas en los artículos 392 y 401 del Estatuto Tributario según corresponda.</strong></td>
                </tr>
            </table>
            
            <table class="tabla-custom">
                <colgroup> <col style="width:20%;"> <col style="width:30%;"> <col style="width:20%;"> <col style="width:30%;"> </colgroup>
                <tr>
                    <td class="titulos font-large" rowspan="3"><strong>25. ELABORÓ</strong></td>
                    <td class="text-left"><strong>Firma: TRAMITE VIRTUAL</strong></td>
                    <td class="titulos font-large" rowspan="3"><strong>26. REVISION CONTADURIA</strong></td>
                    <td class="text-left"><strong>Firma: TRAMITE VIRTUAL</strong></td>
                </tr>
                <tr>
                    <td class="text-left"><strong>Nombre: Jesús Antonio Galeano M.</strong></td>
                    <td class="text-left"><strong>Nombre:</strong></td>
                </tr>
                <tr>
                    <td class="text-left"><strong>Fecha: 17/junio/2025</strong></td>
                    <td class="text-left"><strong>Fecha:</strong></td>
                </tr>
            </table>
        </section>
    </div>
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('certificacion_costos');

        const span1 = document.getElementById('retencion_1');
        const span2 = document.getElementById('retencion_2');
        const span3 = document.getElementById('retencion_3');
        const span4 = document.getElementById('retencion_4');
        const span5 = document.getElementById('retencion_5');
		const span6 = document.getElementById('retencion_6');
		const span7 = document.getElementById('retencion_7');

        function actualizarMarca() {
            if (select.value === 'SI') {
                span1.textContent = 'X';
                span2.textContent = '';
                span3.textContent = '';
                span4.textContent = '';
                span5.textContent = 'X';
				span6.textContent = '0';
				span7.textContent = '1';
            } else {
                span1.textContent = '';
                span2.textContent = 'X';
                span3.textContent = '11%';
                span4.textContent = 'X';
                span5.textContent = '';
				span6.textContent = '';
				span7.textContent = '';
            }
        }

        select.addEventListener('change', actualizarMarca);
        actualizarMarca(); // Inicializa al cargar la página
    });
</script>