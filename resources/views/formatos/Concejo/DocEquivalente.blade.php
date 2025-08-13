<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento Equivalente </title>
 <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 9px;
            font-family: Arial, Helvetica, sans-serif;
            background: #f0f0f0;
        }

        .pagina {
            width: 8.27in; /* tamaño carta real */
            background-color: #fff;
            padding: 0.3in;
            margin: 0 auto;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #333;
            margin-bottom: 5px;
        }

        .tabla-custom {
            width: 95%;
            border-collapse: collapse;
            border: 1px solid #333;
            margin-bottom: 5px;
            margin-left: auto;
            margin-right: auto;
        }

        .header-table td,
        .tabla-custom td {
            border: 1px solid #000;
            padding: 2px 3px;
            font-size: 10px;
            vertical-align: middle; 
        }

        .header-table .logo-cell {
            width: 14%;
            text-align: center;
        }

        .header-table .title-cell {
            width: 30%;
            font-weight: bold;
            font-size: 10px;
            text-align: center;
        }

        .titulos {
            background-color: #ddd;
            font-weight: bold;
            text-align: left;
            padding: 3px;
        }

        .font-large {
            font-size: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        @media print {
            body, html {
                background: white;
                margin: 0;
                padding: 0;
            }

            .pagina {
                margin: 0;
                padding: 0.3in;
                width: 8.27in;
                height: auto;
                box-shadow: none;
                page-break-after: avoid;
            }

            table, tr, td {
                page-break-inside: avoid !important;
            }

            @page {
                size: letter portrait;
                margin: 0.3in;
            }
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
				    <td class="logo-cell" rowspan="3"> <img src="{{ asset('images/formatos/concejo.png') }}" alt="Logo Concejo" style="max-width:70%; height:auto;"> <br>GESTIÓN DE HACIENDA PUBLICA CONTABILIDAD GENERAL</td>	
					<td class="title-cell" rowspan="3" >  SISTEMAS DE GESTIÓN Y CONTROL INTEGRADOS (SISTEDA, SGC y MECI) <br><br> DOCUMENTO EQUIVALENTE A LA FACTURA 
                        <br><br> OPERACIONES CON PERSONAS NATURALES NO OBLIGADAS A FACTURAR NO RESPONSABLES DEL IVA </td>
					<td class="title-cell" colspan="2">MAHP03.03.01.18.P11.F01</td> 
				</tr>                
				<tr>
				   <td style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; text-align:center;"><b><span >VERSIÓN</span></b></td><td style="text-align: center;"><b><span style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">2</span></b></td>
				</tr> 
                <tr>
				   <td style="font-family: Arial, Helvetica, sans-serif; font-size: 11px; text-align:center;" ><b><span >FECHA DE ENTRADA EN VIGENCIA</span></b></td><td style="text-align: center;"><b><span style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">13/abr/2020</span></b></td>
				</tr> 
            </table> 
        </header>

        <section>
            <table class="tabla-custom">
                <colgroup>
                    <col style="width:20%;"> <col style="width:15%;"> <col style="width:20%;">
                    <col style="width:15%;"> <col style="width:15%;"> <col style="width:15%;"> 
                </colgroup>
                <tr>
                    <td colspan="7" class="titulos font-large text-center"><strong>A. DATOS DEL ADQUIRENTE</strong></td>
                </tr>
                <tr>
                    <td class="titulos"><strong>1. Fecha de la Transacción </strong></td>
                    <td class="font-large text-center"><strong>{{\Carbon\Carbon::now()->format('d-m-Y')}}</strong></td>
                    <td class="titulos"><strong>2. Número Consecutivo</strong></td>
                    <td class="font-large text-center"><strong>DE</strong></td>
                    <td class="font-large text-center"><strong>4001</strong></td>
                    <td class="font-large text-center"><strong> {{$datosPdf->consecutivo}}</strong></td>
                </tr>
                <tr>
                    <td class="titulos"><strong>3. Nombre/Razón Social  </strong></td>
                    <td colspan="2"  class="font-large text-center"><strong>MUNICIPIO SANTIAGO DE CALI </strong></td>
                    <td class="titulos"><strong>4. RUT/NIT</strong></td>
                    <td class="font-large text-center"><strong>890399011</strong></td>
                    <td class="font-large text-center"><strong>2</strong></td> 
                </tr>       
                <tr>
                    <td class="titulos"><strong>5. Organismo</strong></td>
                    <td colspan="2"  class="font-large text-center"><strong>CONCEJO DE SANTIAGO DE CALI</strong></td>
                    <td class="titulos"><strong>6. Centro Gestor</strong></td>
                    <td colspan="2"  class="font-large text-center"><strong>CONCEJO - 4001</strong></td>
                 </tr>                        
                 <tr>
                    <td class="titulos"><strong>7. Dirección - Organismo</strong></td>
                    <td colspan="2"  class="font-large text-center"><strong>Av. Norte N° 10-65 CAM</strong></td>
                    <td class="titulos"><strong>8. Teléfono</strong></td>
                    <td colspan="2"  class="font-large text-center"><strong>667 8200</strong></td>
                 </tr>        
            </table>
            <table class="tabla-custom">
                <colgroup>
                    <col style="width:20%;"> <col style="width:15%;"> <col style="width:20%;">
                    <col style="width:15%;"> <col style="width:15%;"> <col style="width:15%;"> 
                </colgroup>
                <tr>
                    <td colspan="7" class="titulos font-large text-center"><strong>B. DATOS DEL PROVEEDOR DE BIENES Y/O SERVICIOS BENEFICIARIO DEL PAGO</strong></td>
                </tr>
                <tr>
                    <td class="titulos"><strong>9.Nombres Completos del Proveedor de Servicios</strong></td>
                    <td colspan="2"  class="font-large"><strong>{{$datosPdf->Nombre}} </strong></td>
                    <td class="titulos"><strong>10. NIT/C.C.</strong></td>
                    <td class="font-large text-center"><strong>{{$datosPdf->Documento}}</strong></td>
                    <td class="font-large text-center"><strong><strong>{{$datosPdf->Dv}}</strong></td> 
                </tr>       
                <tr>
                    <td class="titulos"><strong>11. Dirección</strong></td>
                    <td colspan="2"  class="font-large"><strong><strong>{{$datosPdf->Direccion}}</strong></td>
                    <td class="titulos"><strong>12. Ciudad</strong></td>
                    <td colspan="2"  class="font-large text-center"><strong>{{$datosPdf->Municipio}}</strong></td>
                 </tr>                        
                 <tr>
                    <td class="titulos"><strong>13. Correo Electrónico</strong></td>
                    <td colspan="2"  class="font-large"><strong>{{$datosPdf->Correo}}</strong></td>
                    <td class="titulos"><strong>Teléfono</strong></td>
                    <td colspan="2"  class="font-large text-center"><strong>{{$datosPdf->Celular}}</strong></td>
                 </tr>       
            </table>

            <table class="tabla-custom">
                <colgroup>
                    <col style="width:20%;"> <col style="width:15%;"> <col style="width:20%;"> <col style="width:15%;">  
                </colgroup>
                <tr>
                    <td colspan="7" class="titulos font-large text-center"><strong>C. INFORMACIÓN DE LA OPERACIÓN</strong></td>
                </tr>
                <tr>
                    <td class="titulos" rowspan="2"><strong>15. Concepto de la Operación</strong></td>
                    <td colspan="4"  class="font-large text-center"> <strong> @if(str_contains(strtoupper($datosPdf->Nivel), 'PROFESIONAL') || str_contains(strtoupper($datosPdf->Nivel), 'ESPECIALIZADO')) PRESTACION DE SERVICIOS PROFESIONALES @else PRESTACION DE SERVICIOS TECNICOS  @endif</strong> </td>  
                </tr>       
                <tr>
                     <td class="font-large text-center"> Cuota N° </td>  <td class="font-large text-center"> {{$datosPdf->Cuota}}</td>  <td class="font-large text-center"> {{$datosPdf->Cuota_Letras}}</td>  
                </tr>   
                <tr>
                    <td class="titulos" ><strong>16. Valor de la Operación</strong></td>
                    <td   class="font-large text-center"> <strong> {{$datosPdf->Valor_cuota}}  </strong> </td>  
                    <td colspan="2" class="font-large text-center"> {{$datosPdf->Valor_cuota_Letras}} </td>  
                </tr>     
            </table>
            
            <table class="tabla-custom">
                <colgroup>
                    <col style="width:20%;"> <col style="width:15%;"> <col style="width:20%;"> <col style="width:15%;">   <col style="width:15%;">  
                </colgroup>
                <tr>
                    <td colspan="7" class="titulos font-large text-center"><strong>D. INFORMACIÓN CONTRACTUAL</strong></td>
                </tr>
                <tr>
                    <td class="titulos" rowspan="4"><strong>17. Número Contrato</strong></td>
                    <td colspan="2" rowspan="4" class="font-large"> <strong> {{$datosPdf->Num_Contrato}}  </strong> </td> 
                    <td class="titulos" ><strong>18. CDP</strong></td> 
                    <td><strong>{{$datosPdf->CDP}}</strong></td> 
                </tr>       
                <tr>  
                    <td class="titulos" ><strong> </strong></td><td><strong> </strong></td> 
                </tr>     
                <tr> 
                    <td class="titulos" ><strong>19. RPC</strong></td>  
                    <td><strong>{{$datosPdf->RPC}}</strong></td> 
                </tr> 
                <tr> 
                    <td class="titulos" ><strong> </strong></td><td><strong> </strong></td> 
                </tr>  
                <tr>
                    <td class="titulos" ><strong>20. Objeto del Contrato</strong></td>
                    <td colspan="5" class="font-large text-center">   {{$datosPdf->Objeto}}   </td>  
                </tr>  
                <tr>
                    <td class="titulos" ><strong>21. Valor del Contrato</strong></td>
                    <td class="font-large text-center"> <strong> {{$datosPdf->Valor_contrato}}  </strong> </td> 
                    <td colspan="4" class="font-large text-center">   {{$datosPdf->Valor_contrato_letras}}    </td>  
                </tr>   
            </table>



            <table class="tabla-custom"> 
                <tr>
                    <td class="text-left"> Elaborado por: Lucila Cecilia Herrera Mosquera </td>
                    <td class="text-left"> Cargo:  Profesional Universitario Grado 04 </td> 
                    <td class="text-left"> Fecha:  13/abr/2020 </td>
                    <td class="text-left"> Firma: Trámite Virtual </td> 
                </tr>
                <tr>
                    <td class="text-left">  Revisado por: Luz Stella Arenas Aponte </td>
                    <td class="text-left"> Cargo: Asesora </td> 
                    <td class="text-left"> Fecha:  13/abr/2020 </td>
                    <td class="text-left"> Firma: Trámite Virtual </td> 
                </tr>
                <tr>
                    <td class="text-left"> Aprobado por: Genes Larry Velasco Velasco </td>
                    <td class="text-left"> Cargo: Jefe Oficina Contaduria General de Santiago de Cali </td> 
                    <td class="text-left"> Fecha:  13/abr/2020 </td>
                    <td class="text-left"> Firma: Trámite Virtual </td> 
                </tr>
            </table>
        </section>
    </div>
</body>
</html>

 