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
            width: 95%;
            border-collapse: collapse;
            border: 2px solid #333;
            margin: auto;
        }

        .tabla-custom td {
            font-family: Arial, Helvetica, sans-serif;
			line-height: 24px;
        }

        .titulos {
			background-color: #ddd; /* Color de fondo gris */
			padding: 8px; /* Espaciado interno para mejorar la apariencia */
			font-family: Arial, Helvetica, sans-serif;
            padding: 8px;
            text-align: center;
			}

        .cuadrolargo {
         line-height: 7px;
		 font-family: Arial, Helvetica, sans-serif;
		 padding: 8px;
		 text-align:left;
         }

		 .cuadromedio {
			line-height: 7px;
			font-family: Arial, Helvetica, sans-serif;
			padding: 8px;
			text-align:center;
			}

			.altocuadro {
				line-height: 7px;
				padding: 10px;
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
                <tr class="titulos" > <td colspan="2"><strong>1. TIPO DE INFORME</strong></td></tr>
				<tr class="cuadrolargo" >
					@if($datosPdf->V_Parcial == 'Parcial')
						<td><table><tr><td colspan="1"><strong>CUOTA PARCIAL:</strong> ___X___</td></tr></table></td>
						<td><table><tr><td colspan="1" ><strong>CUOTA FINAL:</strong> ______</td></tr></table></td>
					@endif
					@if($datosPdf->V_Parcial == 'Final')
						<td><table><tr><td colspan="1"><strong>CUOTA PARCIAL: </strong>______</td></tr></table></td>
						<td><table><tr><td colspan="1" ><strong>CUOTA FINAL: </strong>___X___</td></tr></table></td>
					@endif
				</tr>
				<tr class="cuadrolargo" > <td colspan="2" style="text-align: center" ><strong>NO DE CUOTA: </strong> {{$datosPdf->V_no_cuota}}  </td></tr>
				<tr class="titulos" > <td colspan="2"><strong>2. ASPECTOS GENERALES DE CONTRATO Y SU EJECUCIÓN</strong></td></tr>
				<tr class="cuadrolargo" > <td colspan="2"><strong>Contrato No.:</strong>  100.8.4.{{$datosPdf->V_no_contrato}}.2024</td></tr>
				<tr class="cuadrolargo" > <td colspan="2"><strong>Nombre completo del contratista:</strong> {{$datosPdf->V_nombre}}  </td></tr>
				<tr class="cuadrolargo" > <td colspan="2"><strong>Documento de identificación:</strong> {{ number_format($datosPdf->V_CC, 0, ',', '.') }}  </td></tr>
				<tr class="cuadrolargo" > <td colspan="2"><strong>Nombre del supervisor:</strong> {{$datosPdf->V_supervisor}}   </td></tr>
				<tr class="cuadrolargo" > <td colspan="2"><strong>Organismo:</strong> {{$datosPdf->V_oficina}}  </td></tr>
				<tr class="cuadrolargo" > <td colspan="2"><strong>Objeto del contrato: </strong> {{$datosPdf->V_objeto}}   </td></tr>
            </table>
			<br class="altocuadro"> 
			<table border="1" class="tabla-custom">
				<tr class="titulos" > <td colspan="2" ><strong>3.INFORME JURÍDICO</strong></td> </tr>
				<tr class="cuadromedio" > <td><strong>Fecha de Inicio:</strong> </td>	<td><strong>Fecha terminación:</strong></td>
				<tr class="cuadromedio"><td>{{ \Carbon\Carbon::createFromFormat('d/m/Y', $datosPdf->V_fecha_inicio)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}</td><td>{{ \Carbon\Carbon::createFromFormat('d/m/Y', $datosPdf->V_fecha_terminacion)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}</td></tr></tr>
				<tr class="cuadrolargo" > <td colspan="2" ><strong>Modificación(es) al contrato: </strong> N/A</td></tr>
				<tr class="cuadrolargo" > <td colspan="2" ><strong>Suspensión: </strong> N/A</td></tr>
				<tr class="cuadrolargo" > <td colspan="2" ><strong>Reanudación: </strong> N/A</td></tr>
				<tr class="cuadrolargo" > <td colspan="2" ><strong>Cesión: </strong> N/A</td></tr>
				<tr class="cuadrolargo" > <td colspan="2" ><strong>Terminación anticipada: </strong> N/A</td></tr>
			</table>
			<br class="altocuadro"> 
            <table border="1" class="tabla-custom">
				<tr class="titulos" > <td colspan="4"><strong>4. INFORME CONTABLE Y FINANCIERO</strong></td></tr>
				<tr class="cuadrolargo" > <td colspan="4"><strong>Valor inicial del contrato:</strong>  Es hasta por la suma de: {{$datosPdf->V_valor_letras}} , $ {{ number_format($datosPdf->V_valor_contrato, 0, ',', '.') }}</td></tr>
				<tr class="cuadrolargo" > <td colspan="4"><strong>Adición No:</strong> </td></tr>
				<tr class="cuadrolargo" > <td colspan="4"><strong>Prórroga No:</strong></td></tr>
				<tr class="cuadrolargo" > <td colspan="4"><strong>Información para Retención en la fuente:</strong></td></tr>

            </table>

			<table border="1" class="tabla-custom">
				<tr class="cuadrolargo" >
                    <td style="width: 80%;" ><table><tr><td colspan="2"><strong>Para efectos de disminución de la base de retención en la fuente, anexo copia legible de los siguientes documentos:</strong></td></tr></table></td>
                    <td style="width: 10%;" ><table><tr><td colspan="1"><strong>SI</strong></td></tr></table></td>
					<td style="width: 10%;" ><table><tr><td colspan="1"><strong>NO</strong></td></tr></table></td>
				</tr>
				<tr class="cuadrolargo" >
                    <td style="width: 80%;" ><table><tr><td colspan="2">•	Recibo de consignación en mi cuenta de Apoyo al Fomento de la Construcción AFC, del periodo de la cuota.</td></tr></table></td>
                    <td style="width: 10%;" ><table><tr><td colspan="1"> </td></tr></table></td>
					<td style="width: 10%;" ><table><tr><td colspan="1"> X </td></tr></table></td>
				</tr>
				<tr class="cuadrolargo" >
                    <td style="width: 80%;" ><table><tr><td colspan="2">•	Recibo de consignación en mi cuenta de Fondo de Pensiones voluntarias del periodo de la cuota.</td></tr></table></td>
                    <td style="width: 10%;" ><table><tr><td colspan="1"> </td></tr></table></td>
					<td style="width: 10%;" ><table><tr><td colspan="1"> X </td></tr></table></td>
				</tr>
					<tr class="cuadrolargo" > <td colspan="4"><strong>Información:</strong> </td></tr>
	
			</table>


			<table border="1" class="tabla-custom"> 
				<tr>
				<td><table><tr class="titulos"><td><strong>Valor Total del Contrato</strong></td></tr></table></td>
				<td><table><tr class="titulos"><td><strong>Valor Cuota a cancelar</strong></td></tr></table></td>
				<td><table><tr class="titulos"><td><strong>Valor Acumulado Cancelado</strong></td></tr></table></td>
				<td><table><tr class="titulos"><td><strong> Saldo pendiente por Cancelar </strong></td></tr></table></td>
				</tr>
				<tr>
					<td><table><tr><td class="cuadromedio" ><strong>{{ number_format($datosPdf->V_valor_contrato, 0, ',', '.') }}</strong></td></tr></table></td>
					<td><table><tr><td class="cuadromedio"><strong> @if ($datosPdf->V_no_cuota == 1){{ number_format($datosPdf->V_valor_cuota1, 0, ',', '.') }}@else{{ number_format($datosPdf->V_valor_cuota, 0, ',', '.') }}@endif  </strong></td></tr></table></td>
					<td><table><tr><td class="cuadromedio"><strong>{{ number_format($datosPdf->V_cancelado, 0, ',', '.') }}</strong></td></tr></table></td>
					<td><table><tr><td class="cuadromedio"><strong>{{ number_format($datosPdf->V_valor_contrato - $datosPdf->V_valor_cuota - $datosPdf->V_cancelado , 0, ',', '.') }}</strong></td></tr></table></td>
				</tr>
				
				
				<tr class="cuadrolargo" > 
					@if($datosPdf->V_operador == '0')
					<td colspan="4"><strong>Información del pago de seguridad social:</strong> Con fundamento en el artículo 1 del Decreto 1273 de 2018, el cual exige el pago de las cotizaciones al Sistema de Seguridad Social Integral a los contratistas independientes teniendo en cuenta los ingresos percibidos durante el periodo de cotización del mes anterior, circunstancia que para el caso no aplica, ya que la contratista no recibió honorarios en este periodo, se aporta certificado de afiliación a la EPS, fondo de pensión y ARL. </td>
					@else
					<td colspan="4"><strong>Información del pago de seguridad social:</strong></td>
					@endif
				</tr>
			</table>

			<table border="1" class="tabla-custom"> 
				<tr class="titulos" ><td><table><tr class="titulos"><td style="width: 40%;"><strong>Obligación</strong></td></tr></table></td>
				<td><table><tr class="titulos"><td><strong>Datos Certificación o Planilla de Pago</strong></td></tr></table></td></tr>
				<tr><td><table><tr><td style="width: 40%;"> </td></tr></table></td>
				<td><table><tr><td><strong>No. Planilla:</strong> {{$datosPdf->V_planilla}}</td></tr></table></td></tr>
				<tr><td><table><tr><td style="width: 40%;"><strong>Sistema de Salud, Sistema de </strong></td></tr></table></td>
				<td><table><tr><td><strong>No. PIN, Autorización, Referencia, Pago:</strong> {{$datosPdf->V_pin_planilla}} </td></tr></table></td></tr>
				<tr><td><table><tr><td style="width: 40%;"><strong>Pensiones y Riesgos </strong></td></tr></table></td>
				<td><table><tr><td><strong>Operador: </strong>{{$datosPdf->V_operador_p}} </td></tr></table></td></tr>
				<tr><td><table><tr><td style="width: 40%;"><strong>Laborales.</strong></td></tr></table></td>
				<td><table><tr><td ><strong>Fecha de Pago:</strong> {{ \Carbon\Carbon::parse($datosPdf->V_Fecha_pago_planilla)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }}</td></tr></table></td></tr>
				<tr><td><table><tr><td style="width: 40%;"></td></tr></table></td>
				<td><table><tr><td><strong>Periodo de pago de la seguridad social:</strong> {{$datosPdf->V_periodo_nombre}} de 2024 </td></tr></table></td>
				

					<tr class="cuadrolargo" >
						@if($datosPdf->V_Parcial == 'Parcial')
						<td colspan="2"><strong>Observaciones al informe financiero y contable: </strong></td>
						@endif
						@if($datosPdf->V_Parcial == 'Final')
						<td colspan="2"><strong>Observaciones al informe financiero y contable:</strong> el contratista acreditó el pago de los aportes a la Seguridad Social Integral correspondiente al mes de {{$datosPdf->V_periodo_nombre}} del 2024; último mes legalmente exigible al contratista para el trámite de la última cuota del contrato, de conformidad con lo dispuesto en decreto 1273 de 2018. No obstante, en cumplimiento a lo señalado en el artículo 50 de la Ley 789 de 2002 que establece que: "Las Entidades públicas en el momento de liquidar los contratos deberán verificar y dejar constancia del cumplimiento de las obligaciones del contratista frente a los aportes mencionados durante toda su vigencia, estableciendo una correcta relación entre el monto cancelado y las sumas que debieron haber sido cotizadas", y teniendo en cuenta que a la luz del artículo 60 de la Ley 80 de 1993 la liquidación de los contratos de prestación de servicios profesionales y de apoyo a la gestión no es obligatoria, la contratista deberá acreditar ante el Supervisor el pago de los aportes su seguridad social del mes de marzo 2024 remitiendo los correspondientes soportes al correo electrónico institucional del Supervisor con copia al correo institucional del Organismo, dentro de los cinco (5) días hábiles siguientes al vencimiento del plazo para la autoliquidación y el pago de los aportes al Sistema de Seguridad Social Integral y Aportes Parafiscales, establecido en el Decreto 1990 de 2016, o la disposición que la derogue o modifique. La acreditación del pago de los aportes se anexará al expediente. En caso de que el contratista no cumpla esta obligación, el Supervisor deberá reportar el eventual incumplimiento en el pago de aportes a la Unidad Administrativa Especial de Gestión Pensional y Contribuciones Parafiscales de la Protección Social (UGPP), con el fin que esta entidad adelante las acciones pertinentes a que haya lugar. </td>
						@endif
					</tr>

			</table>

			<table border="1" class="tabla-custom">
                <tr class="titulos" > <td><strong>5. INFORME TÉCNICO</strong></td></tr>
				<tr class="altocuadro" > <td> <strong>Concepto Supervisor: </strong> El contratista realizó las siguientes actividades durante el periodo: <br> CUOTA No. {{$datosPdf->V_no_cuota}} <br> {!! $datosPdf->V_actividades_tp !!}</td></tr>
				<tr class="altocuadro" > <td> <strong>Recibo a Satisfacción de Servicios:</strong>  N/A </td></tr>
				<tr class="altocuadro" > <td> <strong>Constancia de Paz y Salvo: </strong> N/A</td></tr>
				<tr class="altocuadro" > <td> <strong>Observaciones al informe técnico: </strong> </td></tr>
				<tr class="titulos" > <td><strong>6. RECOMENDACIONES PARA EL CONTRATISTA</strong></td></tr>
				<tr class="altocuadro" > <td>No se reportan recomendaciones para este periodo.</td></tr>
				<tr class="titulos" > <td><strong>7. FIRMAS RESPONSABLES</strong></td></tr>
				<tr class="cuadromedio" > <td> <br><br><br><br><br> </td></tr>
				<tr class="cuadromedio" > <td> <strong>{{$datosPdf->V_supervisor}} </strong> </td></tr>
				<tr class="cuadromedio" > <td> Nombre y firma del Supervisor </td></tr>
				<tr class="altocuadro"><td> Fecha de suscripción del informe de supervisión: Santiago de Cali,  {{ \Carbon\Carbon::parse($datosPdf->V_fecha_cuenta)->locale('es')->isoFormat('D [de] MMMM [del] YYYY') }} </td></tr>
           
			</table>