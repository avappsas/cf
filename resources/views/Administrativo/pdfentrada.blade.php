<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vale de Entrada - N° {{ $datos['numero_vale'] ?? '5001344640' }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace; /* Fuente monoespaciada */
            font-size: 10pt; /* Ajusta según sea necesario */
            line-height: 1.4; /* Espaciado de línea para legibilidad */
            margin: 0;
            padding: 0;
            background-color: #fff;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .page {
            width: 8.5in;
            /* height: 11in; */ /* Puede ser automático o fijo */
            padding: 0.5in 0.75in; /* Ajusta márgenes laterales si es necesario */
            margin: 0 auto;
            box-sizing: border-box;
            background-color: white;
        }

        .header-line, .info-line, .item-line, .footer-line {
            display: flex;
            justify-content: space-between;
            white-space: pre; /* Clave para mantener espacios y alineación monoespaciada */
        }
        .header-line span, .info-line span, .item-line span, .footer-line span {
            display: inline-block;
        }

        .title {
            text-align: center;
            font-weight: bold; /* Aunque en la imagen no es muy bold, es el título */
            margin-bottom: 5px; /* Reducido */
        }

        .separator-line {
            border-top: 1px dashed #000;
            margin: 8px 0; /* Espacio alrededor de las líneas */
        }

        .item-header-line {
            margin-bottom: 3px; /* Menos espacio antes de los items */
        }
        .item-header-line span {
            font-weight: normal; /* En la imagen no se ve bold */
        }

        .item-details {
            padding-left: 0px; /* Ajusta si la indentación de "K" es diferente */
        }
        .item-details .sub-item {
            padding-left: 10px; /* Indentación para la línea K */
            white-space: pre;
        }

        .footer-content {
            margin-top: 30px; /* Más espacio antes del footer */
        }

        @media print {
            body {
                margin: 0;
                background-color: white;
            }
            .page {
                margin: 0;
                padding: 0.5in;
                width: 7.5in;
                height: 10in;
                box-shadow: none;
                border: none;
            }
            .separator-line {
                border-top: 1px dashed #000 !important; /* Asegurar visibilidad en impresión */
            }
        }

        /* Clases para anchos específicos basados en caracteres (aprox) */
        .w-pos { width: 5ch; }
        .w-material { width: 10ch; }
        .w-denominacion { width: 45ch; text-align: left;} /* Ajustar según contenido */
        .w-cantidad { width: 8ch; text-align: right; }
        .w-k-header { width: 10ch; text-align: left; } /* Para el encabezado K si es necesario */

    </style>
</head>
<body>
    <div class="page">
        <div class="header-line">
            <span >{{ $datos['titulo_vale'] ?? 'VALE DE ENTRADA DE MERCANCÍAS' }}</span>
            <span>N°. {{ $datos['numero_vale'] ?? '5001344640' }}</span>
            <span>Pág.  {{ $datos['pagina'] ?? '1' }}</span>
        </div>

        <div class="separator-line"></div>

        <div class="info-line">
            <span>Fecha EM      : {{ $datos['fecha_em'] ?? '19.03.2025' }}</span>
        </div>
        <div class="info-line">
            <span>Fecha actual  : {{ $datos['fecha_actual'] ?? '19.03.2025' }}</span>
        </div>

        <div class="separator-line"></div>

        <div class="info-line">
            <span>Centro        : {{ $datos['centro_codigo'] ?? 'CONC' }}</span>
        </div>
        <div class="info-line">
            <span>Denominación  : {{ $datos['centro_denominacion'] ?? 'concejo municipal' }}</span>
        </div>
        <div class="info-line">
            <span>              </span> {{-- Línea vacía para espaciado si es necesario --}}
        </div>
        <div class="info-line">
            <span>Proveedor     : {{ $datos['proveedor_codigo'] ?? '0300006675' }}</span>
        </div>
        <div class="info-line">
            <span>Nombre        : {{ $datos['proveedor_nombre'] ?? 'SANCHEZ MUÑOZ TATIANA' }}</span>
        </div>
        <div class="info-line">
            <span>Pedido        : {{ $datos['pedido'] ?? '4500357818' }}</span>
        </div>
        <div class="info-line">
            <span>Texto Cabecera: {{ $datos['texto_cabecera'] ?? 'pago cuota 3' }}</span>
        </div>
        <div class="info-line">
            <span>Grp compras   : {{ $datos['grp_compras_codigo'] ?? '071' }} {{ $datos['grp_compras_denominacion'] ?? 'Concejo Municipal' }} Teléfono : {{ $datos['telefono'] ?? '6687200' }}</span>
        </div>

        <div class="separator-line"></div>

        <div class="item-header-line">
            <span class="w-pos">Pos</span>
            <span class="w-material">Material</span>
            <span class="w-denominacion">              Denominación</span>
       
            {{-- No hay encabezado 'K' explícito en la misma línea en la imagen, pero sí para la cantidad --}}
            <span class="w-cantidad"> </span> {{-- Espacio para alinear con cantidad si es necesario o dejar vacío --}}
        </div>

        @forelse ($datos['items'] ?? [['pos' => '0001', 'material' => '1007573', 'denominacion_l1' => 'Otros servicios de la administracion pub', 'denominacion_l2' => '300006675', 'k_l1' => '4001020101', 'cantidad' => '1 UN']] as $item)
            <div class="item-line">
                <span class="w-pos">{{ str_pad($item['pos'] ?? '', 4) }}</span>
                <span class="w-material">{{ $item['material'] ?? '' }}</span>
                <span class="w-denominacion">{{ $item['denominacion_l1'] ?? '' }} {{ $item['denominacion_l2'] ?? '' }}</span>
                <span class="w-cantidad">{{ $item['cantidad'] ?? '' }}</span>
            </div>
            @if(isset($item['k_l1']) && !empty($item['k_l1']))
            <div class="item-line item-details">
                <span class="w-pos"> </span> {{-- Espacio vacío para alinear con Pos --}}
                <span class="sub-item">K {{ $item['k_l1'] }}</span>
            </div>
            @endif
        @empty
            <div class="item-line">
                <span>No hay items.</span>
            </div>
        @endforelse
<br><br><br><br><br><br><br><br><br>
        <div class="separator-line footer-content"></div>
        <div class="footer-line">
            <span>Emisor      {{ $datos['emisor'] ?? 'VALERIA' }}</span>
 
            <img src="{{ asset('storage/firmas/Interventores/Concejo/94371090.png') }}" alt="firma" style="max-width:100%; height:auto;">
 

            <span>F I R M A</span>
            <span></span> {{-- Para empujar FIRMA al centro si es necesario o ajustar con flex --}}
        </div>
        <div class="separator-line"></div>

    </div>
</body>
</html>