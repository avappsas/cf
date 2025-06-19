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
            font-size: 10px;
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
        .title-cell { width: 30%; font-weight: bold; font-size: 1em; }
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
        .tabla-custom2 {
            width: 95%;
            border-collapse: collapse;
            border: 1px solid #333;
            margin: 0px;
        }
        .tabla-custom td {
            font-family: Arial, Helvetica, sans-serif;
			font-size: 8px;
			line-height: 10px;
			padding: 2px 4px;
        }

		.tabla-custom tr {
			height: 18px;
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
		 font-size: 8px;
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
                  <td class="logo-cell">
                    <img src="{{ asset('images/formatos/concejo.png') }}" alt="Logo Concejo" style="max-width:100%; height:auto;">
                  </td>
                  <td class="title-cell">
					REEVALUACIÓN DE PROVEEDORES DE BIENES, OBRAS Y SERVICIOS  
                  </td>
                  <td class="meta-cell">
                    <table>
                      <tr><td colspan="2">JD01.F023</td></tr>
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
				<colgroup>
					<col style="width:15%; line-height: 1px;">
					<col style="width:10%; line-height: 1px;">
					<col style="width:10%; line-height: 1px;">
					<col style="width:10%; line-height: 1px;">
					<col style="width:10%; line-height: 1px;">
					<col style="width:10%; line-height: 1px;">
					<col style="width:10%; line-height: 1px;"> 
				  </colgroup>
				<tr> 
						<td class="titulos"> <table ><tr ><td><strong>TIPO DE PROVEEDOR:</strong></td></tr></table></td>
						<td colspan="1"><table><tr><td><strong>1. BIENES:</strong></td></tr></table></td>
						<td><table><tr><td><strong> 	</strong></td></tr></table></td>
						<td><table><tr><td><strong>2. OBRAS:</strong></td></tr></table></td>
						<td><table><tr><td ><strong> 	</strong></td></tr></table></td> 
						<td><table><tr><td ><strong>3. PRESTACIÓN DE SERVICIOS:</strong></td></tr></table></td>
						<td ><table><tr><td style="text-align:center; font-size: 12px; "><strong> X </strong></td></tr></table></td> 
				</tr>
 
				<tr> 
					<td class="titulos"> <table ><tr ><td><strong>NOMBRE DEL PROVEEDOR:</strong></td></tr></table></td>
					<td colspan="3"><table><tr><td style="font-size: 12px; "><strong> {{$datosPdf->V_nombre}}</strong></td></tr></table></td>  
					<td class="titulos" colspan="1"><table><tr><td ><strong>FECHA DE EVALUACIÓN:</strong></td></tr></table></td>
					<td colspan="3"><table><tr><td style="font-size: 12px; "><strong> {{ $datosPdf->V_fecha_cuenta }}	</strong></td></tr></table></td> 
					  
				</tr>
				<tr> 
					<td class="titulos"> <table ><tr ><td><strong>NIT o CC:</strong></td></tr></table></td> 
					<td colspan="3"><table><tr><td style="font-size: 12px; "><strong> {{ number_format($datosPdf->V_CC, 0, ',', '.') }}  </strong></td></tr></table></td>
					<td class="titulos"><table><tr><td><strong>PERIODO EVALUADO</strong></td></tr></table></td>
					<td><table border="1" class="tabla-custom2"><tr><td class="titulos" ><strong> DESDE </strong></td></tr><tr><td ><strong>   {{  $datosPdf->V_fecha_inicio }}   </strong></td></tr></table></td> 
					<td><table border="1" class="tabla-custom2"><tr><td class="titulos" ><strong> HASTA </strong></td></tr><tr><td ><strong>   {{  $datosPdf->V_fecha_terminacion  }}  	</strong></td></tr></table></td>
					
				</tr>
				<tr> 
					<td class="titulos"  > <table ><tr ><td><strong>DIRECCIÓN Y TELEFONO:</strong></td></tr></table></td> 
					<td colspan="3"><table><tr><td  style="font-size: 12px; ">{{$datosPdf->V_Direccion}}</td></tr></table></td>
					<td class="titulos"><table><tr><td><strong>CORREO ELECTRONICO</strong></td></tr></table></td> 
					<td colspan="4"><table><tr><td style="font-size: 12px; ">{{$datosPdf->V_Correo}}</td></tr></table></td> 
				</tr>
				<tr> 
					<td class="titulos"  > <table ><tr ><td ><strong>NUMERO DE CONTRATO:</strong></td></tr></table></td> 
					<td colspan="3"><table><tr><td style="font-size: 12px; ">  {{$datosPdf->V_Num_Contrato}}	 </td></tr></table></td>
					<td class="titulos"><table><tr><td ><strong>FECHA SUSCRIPCIÓN:</strong></td></tr></table></td> 
					<td colspan="4"><table><tr><td style="font-size: 12px; ">  {{  $datosPdf->V_fecha_inicio  }}   </td></tr></table></td> 
				</tr>
				<tr> 
					<td class="titulos"  > <table ><tr ><td  ><strong>OBJETO DEL CONTRATO:</strong></td></tr></table></td> 
					<td colspan="8"><table><tr><td style="font-size: 11px; ">  {{$datosPdf->V_objeto}}	 </td></tr></table></td>

				</tr>
			</table>

			<br class="altocuadro"> 
			<table border="1" class="tabla-custom"> 
				<colgroup>
					<col style="width:50%; line-height: 1px;">
					<col style="width:5%; line-height: 1px;">
					<col style="width:20%; line-height: 1px;">
					<col style="width:5%; line-height: 1px;">
					<col style="width:20%; line-height: 1px;"> 
				  </colgroup>
				<tr> 
						<td class="titulos" rowspan="3" > <table ><tr ><td><strong>ESCALA DE CALIFICACIÓN DEL PROVEEDOR  
							DE BIENES, OBRAS O SERVICIOS:</strong></td></tr></table></td>
						<td colspan="1"><table><tr><td><strong>0</strong></td></tr></table></td>
						<td><table><tr><td><strong> No Aplica	</strong></td></tr></table></td>
						<td><table><tr><td><strong>3</strong></td></tr></table></td> 
						<td><table><tr><td><strong>Cumple Parcialemte</strong></td></tr></table></td> 
				</tr> 
				<tr> 
					<td > <table ><tr ><td><strong> 1 </strong></td></tr></table></td>
					<td ><table><tr><td ><strong> No Cumple  </strong></td></tr></table></td>  
					<td ><table><tr><td ><strong> 4</strong></td></tr></table></td>
					<td ><table><tr><td ><strong>  Cumple Plenamente </strong></td></tr></table></td>  
				</tr>
				<tr> 
					<td > <table ><tr ><td><strong> 2 </strong></td></tr></table></td>
					<td ><table><tr><td ><strong> Cumple minimamente  </strong></td></tr></table></td>  
					<td ><table><tr><td ><strong> 5</strong></td></tr></table></td>
					<td ><table><tr><td ><strong>  Supera as expectativas </strong></td></tr></table></td>  
				</tr>
			</table>


			<br class="altocuadro"> 
			<table border="1" class="tabla-custom" id="tabla-evaluacion">
				<colgroup>
				  <col style="width:30%;">
				  <col style="width:50%;">
				  <col style="width:20%;">
				</colgroup>
				<tr class="titulos">  
				  <td><strong>CRITERIO</strong></td>
				  <td><strong>ATRIBUTO</strong></td> 
				  <td><strong>CALIFIQUE DE ACUERDO A LA ESCALA DEFINIDA</strong></td> 
				</tr> 
			  
				<!-- Fila 1 -->
				<tr>  
				  <td rowspan="2"><strong>NIVEL DE EFICACIA - CALIDAD - DEL BIEN, OBRA O SERVICIO</strong></td>
				  <td><strong>El Proveedor cumplió con el Objeto del Contrato?</strong></td> 
				  <td>
					<select class="calificacion" style="width:100%; font-size:12px; padding:2px;">
					  <option value="">--</option>
					  @for($i = 1; $i <= 5; $i++)
						<option value="{{ $i }}">{{ $i }}</option>
					  @endfor
					</select>
				  </td> 
				</tr> 
			  
				<!-- Fila 2 -->
				<tr> 
				  <td><strong>El Proveedor cumplió con las especificaciones...?</strong></td>
				  <td>
					<select class="calificacion" style="width:100%; font-size:12px; padding:2px;">
					  <option value="">--</option>
					  @for($i = 1; $i <= 5; $i++)
						<option value="{{ $i }}">{{ $i }}</option>
					  @endfor
					</select>
				  </td>  
				</tr>
			  
				<!-- Fila 3 -->
				<tr>  
				  <td rowspan="2"><strong>NIVEL DE EFICIENCIA Y EFICACIA EN LAS SOLUCIONES</strong></td>
				  <td><strong>Las soluciones presentadas generaron un impacto positivo...?</strong></td> 
				  <td>
					<select class="calificacion" style="width:100%; font-size:12px; padding:2px;">
					  <option value="">--</option>
					  @for($i = 1; $i <= 5; $i++)
						<option value="{{ $i }}">{{ $i }}</option>
					  @endfor
					</select>
				  </td> 
				</tr> 
			  
				<!-- Fila 4 -->
				<tr> 
				  <td><strong>Las soluciones cumplieron con los niveles de eficiencia...?</strong></td>
				  <td>
					<select class="calificacion" style="width:100%; font-size:12px; padding:2px;">
					  <option value="">--</option>
					  @for($i = 1; $i <= 5; $i++)
						<option value="{{ $i }}">{{ $i }}</option>
					  @endfor
					</select>
				  </td>  
				</tr>
			  
				<!-- Fila 5 -->
				<tr>  
				  <td rowspan="1"><strong>NIVEL DE CUMPLIMIENTO EN LA ENTREGA</strong></td>
				  <td><strong>El Proveedor entregó oportunamente el bien, obra o servicio?</strong></td>
				  <td>
					<select class="calificacion" style="width:100%; font-size:12px; padding:2px;">
					  <option value="">--</option>
					  @for($i = 1; $i <= 5; $i++)
						<option value="{{ $i }}">{{ $i }}</option>
					  @endfor
					</select>
				  </td>  
				</tr>
			  
				<!-- Total -->
				<tr class="titulos">
				  <td colspan="2" style="text-align:center;"><strong>TOTAL PUNTOS OBTENIDOS</strong></td>
				  <td id="total-puntos" style="font-size: 12px; ">0</td>
				</tr>
			  </table>

 
			  
<!-- Resumen de Puntos -->
<br class="altocuadro"> 
<table border="1" class="tabla-custom">
  <colgroup>
    <col style="width:15%;">
    <col style="width:45%;">
    <col style="width:10%;">
    <col style="width:10%;">
    <col style="width:10%;">
    <col style="width:10%;">
  </colgroup>
  <tr>
    <td class="titulos" rowspan="2" style="text-align:center; vertical-align:middle;">
      EVALUACIÓN DEL PROVEEDOR
    </td>
    <td class="cuadrolargo" style="text-align:center;">
      <strong>TOTAL PUNTOS OBTENIDOS</strong><br>
      <span style="display:block; border-bottom:2px solid #000; margin:4px 0;"></span>
    </td>
    <td id="total-puntos2" class="cuadrolargo" style="text-align:center;">
      0
    </td>
    <td rowspan="2" class="cuadrolargo" style="text-align:center;">
      <strong>X 100</strong>
    </td>
	<td rowspan="2" class="cuadrolargo" style="text-align:center;">
		<strong>=</strong>
	  </td>
    <td rowspan="2" id="porcentaje-puntos" class="cuadrolargo" style="text-align:center;">
      0%
    </td>
 
  </tr>
  <tr>
    <td class="cuadrolargo" style="text-align:center;">
      <strong>TOTAL PUNTOS POSIBLES</strong>
    </td>
    <td class="cuadrolargo" style="text-align:center;">
      <strong>25</strong>
    </td>
    <td class="cuadrolargo" colspan="3"></td>
  </tr>
</table>




		<br class="altocuadro"> 
		<!-- Escala, Cantidad y Calificación -->
		<table border="1"  class="tabla-custom" >
			<tr valign="top">
			<!-- Escala -->
			<td style="width:25%; padding-right:8px;">
				<table border="1" class="tabla-custom2" cellspacing="0" cellpadding="2" style="width:100%;">
				<tr class="titulos">
					<td>EXCELENTE</td>
					<td>76% - 100%</td>
				</tr>
				<tr class="titulos">
					<td>BUENO</td>
					<td>51% - 75%</td>
				</tr>
				<tr class="titulos">
					<td>REGULAR</td>
					<td>26% - 50%</td>
				</tr>
				<tr class="titulos">
					<td>BAJO NIVEL</td>
					<td>0 - 25%</td>
				</tr>
		</table>
	  </td>
  
	  <!-- Cantidad de preguntas -->
	  <td style="width:25%; text-align:center; font-size:8px; padding:4px;">
		<strong>CANTIDAD DE PREGUNTAS</strong> (5)
	  </td>
  
	  <!-- Calificación -->
	  <td style="width:50%; padding-left:8px;">
		<table border="1"  class="tabla-custom" >
		  <colgroup>
			<col style="width:20%;">
			<col style="width:80%;">
		  </colgroup>
		  <tr>
			<td class="titulos" style="text-align:center;">CALIFICACIÓN</td>
			<td id="categoria-puntos" class="cuadrolargo" style="text-align:center;">--</td>
		  </tr>
		</table>
	  </td>
	</tr>
  </table>
  <br class="altocuadro"> 
  <!-- Observaciones -->
  <table border="1"  class="tabla-custom" >
	<tr>
	  <td class="cuadrolargo" style="font-weight:bold;">OBSERVACIONES:</td>
	</tr>
	<tr>
	  <td style="height:80px;"></td>
	</tr>
  </table>
  
			  
			  <br class="altocuadro"> 
			<table border="1" class="tabla-custom"> 
				<tr class="titulos" > <td><strong>SUPERVISOR</strong></td></tr>
				<tr class="cuadromedio" > <td> <br><br><br><br><br> </td></tr>
				<tr class="cuadromedio" > <td> <strong>{{$datosPdf->V_supervisor}} - {{$datosPdf->V_Cargo_Interventor}} </strong> </td></tr>
				<tr class="cuadromedio" > <td> Nombre y firma del Supervisor </td></tr>
 			</table>

 
						  
			<script>
				// cuando cualquiera de los selects cambie, recalculamos
				document.querySelectorAll('.calificacion').forEach(sel => {
				  sel.addEventListener('change', actualizarTotal);
				});
			  
				function actualizarTotal() {
				  let sum = 0;
				  document.querySelectorAll('.calificacion').forEach(sel => {
					const v = parseInt(sel.value);
					if (!isNaN(v)) sum += v;
				  });
				  document.getElementById('total-puntos').textContent = sum;
				  document.getElementById('total-puntos2').textContent = sum;
				}
			  
				// al cargar la página, inicializa el total
				actualizarTotal();
 
	// Reemplaza o extiende tu función de cálculo:
	function actualizarResumen() {
	  // 1) sumamos los selects (igual que antes)
	  let sum = 0;
	  document.querySelectorAll('.calificacion').forEach(sel => {
		const v = parseInt(sel.value);
		if (!isNaN(v)) sum += v;
	  });
  
	  // 2) volcamos el total
	  document.getElementById('total-puntos').textContent = sum;
  
	  // 3) calculamos porcentaje sobre 25
	  const posibles = 25;
	  const pct = posibles > 0
		? ((sum / posibles) * 100).toFixed(0) + '%'
		: '0%';
  
	  // 4) volcamos el porcentaje
	  document.getElementById('porcentaje-puntos').textContent = pct;
	}
  
	// engancha el evento en tus selects
	document.querySelectorAll('.calificacion').forEach(sel => {
	  sel.addEventListener('change', actualizarResumen);
	});
  
	// inicializa al cargar
	actualizarResumen();


	document.addEventListener('DOMContentLoaded', function(){
  const selects       = document.querySelectorAll('.calificacion');
  const totalCell     = document.getElementById('total-puntos');
  const pctCell       = document.getElementById('porcentaje-puntos');
  const categoriaCell = document.getElementById('categoria-puntos');
  const posibles      = 25;

  function actualizarResumen(){
    // 1) Sumar valores
    let sum = 0;
    selects.forEach(sel => {
      const v = parseInt(sel.value);
      if (!isNaN(v)) sum += v;
    });
    totalCell.textContent = sum;

    // 2) Calcular porcentaje entero
    const pctNum = posibles > 0
      ? Math.round((sum / posibles) * 100)
      : 0;
    pctCell.textContent = pctNum + '%';

    // 3) Determinar categoría
    let cat = 'BAJO NIVEL';
    if (pctNum >= 76)      cat = 'EXCELENTE';
    else if (pctNum >= 51) cat = 'BUENO';
    else if (pctNum >= 26) cat = 'REGULAR';

    categoriaCell.textContent = cat;
  }

  // Eventos y carga inicial
  selects.forEach(sel => sel.addEventListener('change', actualizarResumen));
  actualizarResumen();
});
  </script>