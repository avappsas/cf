<!DOCTYPE html>
<html>
<head>
    <title>Hoja Tamaño Carta con Encabezado y Pie de Página</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 1cm;
            margin: 1cm auto;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .header {
            width: 100%;
            height: auto;
            padding: 0.5cm;
            text-align: center;
            margin-bottom: 1cm;
            box-sizing: border-box;
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
            .content {
                margin-top: 4cm; /* Adjust based on header height */
                margin-bottom: 3cm; /* Adjust based on footer height */
            page-break-inside: avoid;
            }

        .footer {
            width: 100%;
            height: 2cm;
            background-color: #f0f0f0;
            padding: 0.5cm;
            text-align: center;
            box-sizing: border-box;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo-cell {
            width: 30%;
            text-align: left;
            }

        .title-cell {
            width: 40%;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            }

        .meta-cell {
            width: 30%;
            text-align: right;
        }

        .meta-cell table {
            width: 100%;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .page {
                margin: 0;
                box-shadow: none;
                page-break-after: always;
            }

            .page:last-child {
                page-break-after: avoid;
            }
             .header {
                 display: table-header-group;
             }

             .footer {
                 display: table-footer-group;
             }
            .content {
                 margin-top: 4cm; /* Adjust based on header height */
                margin-bottom: 3cm; /* Adjust based on footer height */
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <img src="{{ asset('images/formatos/concejo.png') }}" alt="Logo Concejo" style="max-width:100%; height:auto;">
                </td>
                <td class="title-cell">
                  NOTIFICACIÓN SUPERVISIÓN Y/O INTERVENTORÍA DEL CONTRATO DE PRESTACIÓN DE SERVICIOS
                </td>
                <td class="meta-cell">
                    <table>
                        <tr><td colspan="2">JD01.F001</td></tr>
                        <tr><td>FECHA EMISIÓN</td><td>  7-Junio-2024 </td></tr>
                        <tr><td>VERSIÓN</td><td> 002 </td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="footer">
        <p>Pie de página de la hoja - Página </p>
    </div>
   <div class="page">
    <div class="content">
 
      <p> 
        <br> 
        <strong>NOMBRE DEL PROYECTO O FICHA:</strong> FUNCIONAMIENTO
        <br><br> 
        <strong>ORGANISMO SOLICITANTE O SUPERVISOR DEL PROCESO: </strong> CONCEJO DE SANTIAGO DE CALI
        <br><br>
        Elegir una de las opciones según el origen de los recursos:
        <br>
        <br>
        <p><strong>Origen de los recursos:</strong></p>
    
        <div style="font-family: Arial, sans-serif; font-size: 15px; margin-top: 10px; display: flex; gap: 30px; align-items: center;">
          <div style="display: flex; align-items: center; gap: 8px;">
            <span>Inversión</span>
            <span style="display: inline-block; width: 25px; height: 25px; border: 1.5px solid green; border-radius: 5px; text-align: center; line-height: 25px;"></span>
          </div>
        
          <div style="display: flex; align-items: center; gap: 8px;">
            <span>Funcionamiento</span>
            <span style="display: inline-block; width: 25px; height: 25px; border: 1.5px solid green; border-radius: 5px; text-align: center; line-height: 25px; font-weight: bold;">X</span>
          </div>
        
          <div style="display: flex; align-items: center; gap: 8px;">
            <span>Otros</span>
            <span style="display: inline-block; width: 25px; height: 25px; border: 1.5px solid green; border-radius: 5px; text-align: center; line-height: 25px;"></span>
          </div>
        </div>
        
        <p>
          <strong>CERTIFICADO DE DISPONIBILIDAD PRESUPUESTAL No.:</strong> {{ $datosPdf->CDP }}<br>
          <strong>RUBRO:</strong> 4001/1.2.1.0.00/2120202009/01019999999
        </p>
        
        <p>
          <strong>FECHA DE EXPEDICIÓN:</strong> {{ $datosPdf->Fecha_CDP }}<br>
          <strong>FECHA DE VENCIMIENTO:</strong> {{ $datosPdf->Fecha_Venc_CDP }}
        </p>
        
        <p>
          <strong>TIPO DE CONTRATACIÓN:</strong> Contrato de prestación de servicios  {{ $datosPdf->servicios }}
        </p>
        
        <p>
          <strong>CLASIFICACIÓN UNSPSC</strong>
        </p>
        
        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
          <thead>
            <tr>
              <th style="border: 1px solid #000; padding: 5px;">CÓDIGO</th>
              <th style="border: 1px solid #000; padding: 5px;">SEGMENTO</th>
              <th style="border: 1px solid #000; padding: 5px;">FAMILIA</th>
              <th style="border: 1px solid #000; padding: 5px;">CLASE</th>
              <th style="border: 1px solid #000; padding: 5px;">PRODUCTO</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="border: 1px solid #000; padding: 5px;">80000000</td>
              <td style="border: 1px solid #000; padding: 5px;">80110000</td>
              <td style="border: 1px solid #000; padding: 5px;">80111600</td>
              <td style="border: 1px solid #000; padding: 5px;">80111600</td>
              <td style="border: 1px solid #000; padding: 5px;">Servicios de Personal Temporal</td>
            </tr>
          </tbody>
        </table>
        <br><br>
        <strong>ANTECEDENTES</strong>  
        <br><br>
        Para garantizar el cumplimiento de los fines constitucionales, el presidente del Honorable Concejo Distrital de Santiago de Cali, de acuerdo con lo dispuesto por los numerales 7 y 12 del artículo 25 de la Ley 80 de 1993 y el decreto 1082 de 2015, y en ejercicio de las funciones contempladas en la resolución 21.2.22.583 de 2013, procede a adelantar el siguiente análisis de conveniencia y oportunidad para la contratación:
        <br><br>    
        El artículo 312 de la Constitución Política dispone que en cada municipio haya una corporación político-administrativa elegida popularmente para períodos de cuatro (4) años que se denominará concejo Distrital, 
        integrado por no menos de 7, ni más de 21 miembros según lo determine la ley de acuerdo con la población respectiva. Esta corporación podrá ejercer control político sobre la administración Distrital. 
        <br><br>
        Mediante Acuerdo No. 220 de 24 de diciembre de 2007 se modificó la estructura administrativa y se adoptó una nueva planta de personal en la Honorable Corporación Concejo Distrital de Santiago de Cali. En dicha 
        norma se consagra que El Concejo Distrital de Santiago de Cali, como Corporación Administrativa pública, es el espacio de representación democrática de los habitantes de Santiago de Cali, que promueve mediante 
        Acuerdos el desarrollo integral y sostenible de la sociedad Caleña; ejerciendo control político administrativo y asesorando a las comunidades en iniciativas que coadyuven a mejorar su calidad de vida, en cumplimiento 
        de los fines esenciales del Estado, a través de su organización administrativa autónoma, eficiente, moderna e integrada por servidores públicos competentes e idóneos.” (Artículo 2º).
        <br><br>
        @if ($datosPdf->Supervisor == 1)  
        La oficina de <strong>{{ $datosPdf->Oficina }}</strong> ha manifestado la necesidad de la contratación del personal para la prestación de servicios para las diferentes áreas administrativas, previa certificación 
        de la Oficina de Talento Humano de que no existe el personal de planta que desempeñe las tareas específicas relacionadas. Teniendo en cuenta que en la planta global de cargos de la Corporación 
        no se creó un empleo del nivel profesional, técnico, operativo o asistencial que permita desarrollar las actividades requeridas. Por lo anterior se hace necesario la contratación de una 
        persona que preste sus servicios en la oficina de <strong>{{ $datosPdf->Oficina }}</strong>, que cumpla el perfil requerido para el óptimo cumplimiento del objeto contractual.
        <br><br>
        <strong>ANALISIS DE ALTERNATIVAS PARA SATISFACER LA NECESIDAD</strong>
        <br><br>
        De acuerdo a lo contemplado en el plan de compras y servicios 2025, la opción para satisfacer la necesidad descrita es la contratación con una persona natural o jurídica, se requiere por 
        lo tanto de un contratista para prestar el servicio en la oficina de <strong>{{ $datosPdf->Oficina }}</strong> del Concejo Distrital de Santiago de Cali dentro del rango del presupuesto oficial 
        estimado, que acredite los requisitos de capacidad legal y experiencia relacionada con el objeto del contrato a celebrar, el cual es: Prestar el servicio como Profesional en la Presidencia del 
        Concejo Distrital de Santiago de Cali. De acuerdo con las necesidades y requerimientos del área solicitante.
        <br><br> 
        Teniendo en cuenta que el objeto a contratar se encuentra sujeto a la necesidad del servicio del organismo, entendiéndose que su duración es por tiempo limitado e indispensable para ejecutar 
        obligaciones contractuales. El futuro contratista estará sujeto a la coordinación de sus actividades y a las instrucciones que sobre el particular le imparta el supervisor, conservando en 
        todo caso plena autonomía para la ejecución eficiente del contrato.
        <br><br> 
        LA DESCRIPCION DEL OBJETO A CONTRATAR, CON SUS ESPECIFICACIONES
        <br><br>
        De conformidad con la necesidad manifestada por el (la) jefe de la dependencia se requiere un contratista para cumplir con el objeto del contrato a celebrar el cual es:  {{ $datosPdf->Objeto }}
        <br><br>
        <strong>ESPECIFICACIONES</strong> <br> 
        {{ $datosPdf->Actividades }}. 
        <br><br> 
        PRESENTAR LAS CUENTAS DE COBRO OPORTUNAMENTE, CUMPLIENDO, CON LOS REQUISITOS EXIGIDOS POR LA EMPRESA, ACOMPAÑADOS DE LA PLANILLA DE PAGO Y CERTIFICADO DEL CUMPLIMIENTO DE SUS OBLIGACIONES 
        FRENTE AL SISTEMA GENERAL DE SEGURIDAD SOCIAL (ARP, PENSIÓN Y EPS), DE ACUERDO A LA NORMATIVIDAD VIGENTE.
        <br><br>
        @else 
        En su artículo 53 señala que de conformidad con lo establecido en el artículo 78 de la ley 617 de 2000, la corporación contará con unidades de apoyo normativo para asesorar a los concejales, 
        en el cumplimiento de sus responsabilidades constitucionales y misionales de carácter normativo y de control político, además, servir de grupo de asesor a las comunidades. El mismo acuerdo 
        creó las Unidades de Apoyo Normativo que agrupan un conjunto de empleos contemplados en el artículo 56 ídem. El parágrafo 2° del artículo establece que “los servidores públicos de las unidades 
        de apoyo normativo de cada concejal se vincularán al Concejo Distrital mediante acto legal y reglado, es decir como empleados de libre nombramiento y remoción. Pero, se podrá contratar personal 
        para tareas específicas mediante Contrato de prestación de servicios profesionales, en las respectivas unidades de apoyo, siempre y cuando no supere los 42.5 salarios asignados, para lo cual se 
        debe tener siempre en cuenta el valor total de la respectiva vigencia fiscal”.
        <br><br>
        Dando efectivo cumplimiento a lo preceptuado en el artículo 56 del Acuerdo 220 de 2007, la unidad de apoyo normativo del concejal <strong>{{ $datosPdf->Supervisor }}</strong> ha conformado 
        a su criterio la combinación de rangos y denominaciones, la distribución salarial, equivalente en Salario Mínimo Legal Mensual Vigente (SMLMV), respetando en todo caso, el monto o presupuesto 
        señalado en el artículo 55 del Acuerdo. Postulando al señor (a) <strong>{{ $datosPdf->Nombre }}</strong> para que desarrolle tareas específicas sea contratado mediante un contrato de prestación 
        de servicios.
        <br><br>    
        Que el parágrafo 2 del artículo 56 del acuerdo No. 220 de 2007 establece que: “… se podrá contratar personal para tareas específicas, mediante Contrato de prestación de servicios profesionales, 
        en la respectiva Unidad de Apoyo, siempre y cuando no superen los 42.5 salarios asignados, para lo cual se debe tener siempre en cuenta el valor total de la respectiva vigencia fiscal”.
        <br><br>  
        El artículo 32 de la Ley 80 de 1993 define los Contrato de prestación de servicios profesionales como aquellos que “celebren las entidades estatales para desarrollar actividades relacionadas con 
        la administración o funcionamiento de la entidad. Estos contratos sólo podrán celebrarse con personas naturales cuando dichas actividades no puedan realizarse con personal de planta o requieran 
        conocimiento especializados.
        <br><br>   
        <strong>LA DESCRIPCIÓN DE LA NECESIDAD Y ANÁLISIS DE ALTERNATIVAS PARA SATISFACERLA:</strong> Mediante acuerdo número 220 del 24 de diciembre de 2007, se modificó la estructura administrativa y 
        se adoptó una nueva planta de personal en la honorable Corporación Concejo Distrital Santiago de Cali.
        <br><br>   
        De acuerdo a lo contemplado en el plan de compras y servicios 2025, la opción para satisfacer la necesidad descrita es la contratación con una persona natural, se requiere por lo tanto de un 
        contratista para prestar el servicio al Honorable Concejal <strong>{{ $datosPdf->Supervisor }}</strong> del Concejo Distrital de Santiago de Cali que oferte dentro del rango del presupuesto oficial estimado, que acredite 
        los requisitos de capacidad legal y experiencia relacionada con el objeto del contrato a celebrar, el cual es Prestar Apoyo Asistencial en la unidad de apoyo del honorable concejal 
        <strong>{{ $datosPdf->Supervisor }}</strong> en el Concejo Distrital de Santiago de Cali. de acuerdo con las necesidades y requerimientos del área solicitante. Teniendo en cuenta el anterior estudio la opción más 
        conveniente es la contratación por la modalidad de CONTRATACION DIRECTA.
        <br><br>   
        Teniendo en cuenta que el objeto a contratar se encuentra sujeto a la necesidad del servicio del organismo, entendiéndose que su duración es por tiempo limitado e indispensable para ejecutar 
        obligaciones contractuales. El futuro contratista estará sujeto a la coordinación de sus actividades y a las instrucciones que sobre el particular le imparta el supervisor, conservando en todo 
        caso plena autonomía para la ejecución eficiente del contrato.
        <br><br>   
        <strong>LA DESCRIPCION DEL OBJETO A CONTRATAR, CON SUS ESPECIFICACIONES</strong> <br>
        De conformidad con la necesidad manifestada por el (la) Honorable concejal <strong>{{ $datosPdf->Supervisor }}</strong> se requiere un contratista para cumplir con el objeto del contrato a celebrar el cual 
        es: {{ $datosPdf->Objeto }}
        <br><br>
        <strong>ESPECIFICACIONES</strong> <br> 
        {{ $datosPdf->Actividades }}. 
        <br><br>
        @endif
          
        <strong>PLAZO DEL CONTRATO:</strong> El término de duración del presente contrato será contado a partir del cumplimiento de los requisitos de perfeccionamiento y ejecución, y hasta el, {{ $datosPdf->Plazo }}
         previa suscripción del acta de inicio, según el artículo 41 de la Ley 80 de 1993 y el artículo 23 de la Ley 1150 de 2007.
         <br><br>    
        <strong>LUGAR DE EJECUCION:</strong> Para efectos contractuales el domicilio pactado será la ciudad de Santiago de Cali.
        <br><br>   
        <strong>ALCANCE DEL OBJETO DEL CONTRATO:</strong> Toda vez que comprenden actividades relacionadas con el funcionamiento de la entidad el cumplimiento de sus funciones, el logro de sus fines se trata de 
        un contrato para servir de instrumento de apoyo o colaboración para que la entidad cumpla sus funciones obteniendo en su beneficio el desarrollo de actividades que tengan un nexo causal claro o 
        correlación con las tareas que tienen asignadas la entidad.
        <br><br>
        <strong>OBLIGACIONES GENERALES DEL CONTRATISTA:</strong> En virtud del presente contrato EL <strong>CONTRATISTA</strong> adquiere las siguientes obligaciones generales: A) Utilizar todos sus conocimientos 
        e idoneidad en la ejecución del presente contrato, comprometiéndose a tramitar y entregar los productos y actividades que hacen parte del presente contrato con calidad y oportunidad. 
        B) Presentar los informes requeridos por el <strong>CONTRATANTE</strong> para el seguimiento de las tareas encomendadas. Una vez finalice el objeto del contrato, el <strong>CONTRATISTA</strong> deberá entregar al supervisor, 
        un informe detallado de las actividades realizadas durante su ejecución indicando los asuntos asignados, tramitados y pendientes por resolver, así como los archivos físicos y magnéticos 
        que se hubieren generado durante la ejecución del mismo, los informes antes citados deben entregarse en una (1) copia de seguridad, que deberá reposar en las instalaciones del <strong>CONTRATANTE</strong>. 
        C) Manejar la documentación a su cargo de conformidad con la Ley 594 de 2000, Ley General de Archivo, las políticas operativas del Proceso Gestión Documental, la política del Sistema de 
        Gestión Documental y demás plataformas institucionales. El <strong>CONTRATISTA</strong> debe entregar inventariada al <strong>CONTRATANTE</strong> y/o al supervisor, las carpetas y documentación que tenga a su cargo en 
        virtud del desarrollo del objeto del presente contrato, entrega que deberá hacerse de acuerdo con los procedimientos establecidos por el <strong>CONTRATANTE</strong>. D) El <strong>CONTRATISTA</strong> se compromete a 
        cumplir con las normas y procedimientos sobre el Sistema de Gestión de Seguridad Social y Salud en el trabajo de la Entidad. Si en el desarrollo del objeto contractual se realizan actividades 
        de campo y/o visitas a obras, el <strong>CONTRATISTA</strong>, a sus expensas, deberá dotarse y acudir a estos lugares con los implementos de seguridad industrial mínimos requeridos, tales como casco, botas, 
        gafas protectoras, etc. E) En el evento en que el <strong>CONTRATISTA</strong> al momento de suscribir el presente contrato pertenezca al régimen tributario simplificado y durante la vigencia del mismo adquiera 
        la obligación de inscribirse en el régimen común, se compromete a realizar cambio de régimen ante la DIAN dentro de los términos que otorga la ley y a reportar dicha situación al <strong>CONTRATANTE</strong> 
        para lo cual aportará el RUT actualizado, lo anterior de conformidad con la normativa vigente aplicable. F) El <strong>CONTRATISTA</strong> se compromete a mantener actualizados todos sus documentos en la Entidad, 
        especialmente el RUT. G) Velar por el buen uso de los bienes entregados por el supervisor o el <strong>CONTRATANTE</strong> para realizar sus actividades. H) Reportar al <strong>CONTRATANTE</strong> el número de cuenta bancaria de 
        ahorro o corriente, donde se le ha de consignar el pago derivado de la ejecución del presente contrato. I) Conocer y aplicar las directrices, metodologías, políticas y procedimientos enmarcados 
        dentro de los Sistemas de Gestión y Control Integrado adoptados por la Administración Central del Concejo Santiago de Cali y, particularmente, los que se relacionan con el objeto del presente 
        contrato. J) Se compromete a cumplir con la política de seguridad de la información establecida por la entidad, con el fin de garantizar la confidencialidad, integridad y disponibilidad de la 
        información bajo su responsabilidad. K) Mantener actualizado el registro en los sistemas de información del <strong>CONTRATANTE</strong> en tiempo real, cuando a ello hubiere lugar. L) Toda información o formatos 
        generados por el <strong>CONTRATISTA</strong> son propiedad del concejo de Santiago de Cali. M) Se compromete a que, en desarrollo de su objeto contractual, cuando se requiera utilizar dispositivo y/o equipos 
        tecnológicos personales o de la administración, deberá velar porque todo software y herramientas utilizada e instalada en la ejecución de sus obligaciones no vulneran ninguna normativa, contrato, 
        derecho, interés, patentes, legalidad o propiedad de tercero, y que por el contrario todo lo utilizado este debidamente licenciado. N) Se compromete a cumplir con las estrategias, políticas y 
        actividades en materia de transparencia, integridad, prevención y detección de la corrupción y ante cualquier conocimiento de hechos que atente contra este principio lo hará conocer al <strong>CONTRATANTE</strong>. 
        O) Si el prestador del servicio contratado hace parte del equipo estructurador de los procesos de contratación del organismo, deberá acreditar el curso de inducción adoptado para tal fin por el 
        Departamento Administrativo de Contratación Pública. P) Divulgar y aplicar la política ambiental, de seguridad y salud ocupacional establecida por EL <strong>CONTRATANTE</strong>, al ejecutar sus actividades o 
        servicios sin crear riesgo para la salud, la seguridad o el ambiente. El (la) <strong>CONTRATISTA</strong> deberá tomar todas las medidas conducentes a evitar la contaminación ambiental, la prevención de riesgos 
        durante la ejecución de sus operaciones o actividades y cumplirá con todas las leyes ambientales, de seguridad y salud ocupacional, aplicables. El (la) <strong>CONTRATISTA</strong> no dejará sustancias o materiales 
        nocivos para la flora, fauna o salud humana, ni contaminará la atmósfera, el suelo o los cuerpos del agua. La violación de estas normas se considerará incumplimiento grave del contrato, y 
        EL <strong>CONTRATANTE</strong> podrá aplicar la cláusula penal o multas a que hubiere lugar, sin perjuicio de las demás acciones legales o sanciones que adelante la autoridad o ente competente de orden Municipal 
        o Nacional. Q) El <strong>CONTRATISTA</strong> deberá coordinar con el supervisor la ejecución de las actividades contractuales, acatando sus instrucciones, con el fin de asegurar las condiciones necesarias para el 
        desarrollo eficiente del objeto contractual.
        <br><br>
        <strong>OBLIGACIONES DEL CONTRATANTE:</strong> En virtud del presente contrato de prestación de servicios se obliga a: 1) Pagar al <strong>CONTRATISTA</strong> las sumas estipuladas en el contrato, en la 
        oportunidad y formas allí establecidas. 2) Proporcionar la información y documentación requerida para la normal ejecución del objeto contractual. 3) Vigilar, supervisar y/o controlar la 
        ejecución idónea y oportuna del objeto del contrato. 4) Todas aquellas inherentes para el cumplimiento del objeto contractual.
        <br><br>
        <strong>MODALIDAD DE CONTRATACION:</strong> En cumplimiento de los principios de transparencia y responsabilidad que rigen la contratación pública, la Ley 1150 de 2007, artículo 2, numeral 4, 
        prevé dentro de las modalidades de selección <strong>LA CONTRATACION DIRECTA</strong>. Que el literal h del numeral 4 del artículo 2º de la Ley 1150 de 2007, señala como causal de contratación 
        directa la prestación de servicios profesionales y de apoyo a la gestión, o para la ejecución de trabajos artísticos que solo pueden encomendarse a ciertas personas naturales.
        <br><br>   
        <strong>VALOR Y FORMA DE PAGO: </strong>El presente contrato tiene un valor total de ($ <strong>{{ $datosPdf->Valor_Total }}</strong>) (<strong>{{ $datosPdf->Valor_Total_Letras }} de pesos</strong>) 
        <strong>{{ $datosPdf->Txt_iva }}</strong>. Que el Distrito de Santiago de Cali, el Concejo Distrital de Cali, entregará de la siguiente forma: <strong>{{ $datosPdf->texto_cuotas }}</strong>,
         cada una previa presentación de los informes parciales de las actividades realizadas, con visto bueno del supervisor. En todo caso el pago se hará previa disposición de giros de P.A.C por parte 
         de la entidad correspondiente. Todos los informes deben presentarse por escrito con todos los soportes legales y financieros. Los pagos se efectuarán con cargo al CDP No <strong>{{ $datosPdf->CDP }}</strong> 
        del <strong>{{ $datosPdf->Fecha_Venc_CDP }}</strong>, para la vigencia fiscal 2025.
        <br><br>  
        <strong>ANALISIS QUE SOPORTA EL VALOR ESTIMADO DEL CONTRATO:</strong>
        Para establecer el valor de la remuneración de los servicios profesionales y de apoyo a la gestión se tomó como referencia las condiciones del mercado en el sector público, se revisaron los costos históricos, 
        promediando los valores de contrataciones anteriores, dadas las responsabilidades y especificidad de las actividades a realizar por parte del contratista. Por lo anterior se definió un valor de 
        ($ <strong>{{ $datosPdf->Valor_Total }}</strong>) (<strong>{{ $datosPdf->Valor_Total_Letras }} de pesos</strong>) <strong>{{ $datosPdf->Txt_iva }}</strong>.  Para lo cual el Honorable Concejo Distrito de 
        Santiago de Cali, tiene disponibilidad presupuestal, según Certificado  No. <strong>{{ $datosPdf->CDP }}</strong>  del <strong>{{ $datosPdf->Fecha_Venc_CDP }}</strong> para la vigencia fiscal 2025, expedido 
        por el Honorable Concejo Distrital de Santiago de Cali- con cargo al presupuesto de la presente vigencia fiscal, Código de Apropiación 4001/0-1104/ 2120202009/01019999999.
        <br><br>
        El oferente, deberá presentar su oferta ajustada al presupuesto oficial asignado.
        <br><br>
        <strong>PRESUPUESTO OFICIAL ESTIMADO Y COSTOS ASIGNADOS AL MONTO:</strong>
        El valor de la propuesta deberá incluir todos los costos directos del servicio, así como los indirectos (impuestos, IVA, gravámenes, estampillas municipales, seguros, retención en la fuente, publicación, etc.).
        <br><br>   
        <strong>EXISTENCIA DE LA DISPONIBILIDAD PRESUPUESTAL</strong>
        El Honorable Concejo Distrital de Santiago de Cali, dispone de un presupuesto oficial estimado de ($ <strong>{{ $datosPdf->Valor_Total }}</strong>) (<strong>{{ $datosPdf->Valor_Total_Letras }} de pesos</strong> ) 
        <strong>{{ $datosPdf->Txt_iva }}</strong>.  y demás impuestos de ley, para el cumplimiento del objeto del presente proceso, de acuerdo con el certificado de disponibilidad número <strong>{{ $datosPdf->CDP }}</strong>
         del <strong>{{ $datosPdf->Fecha_Venc_CDP }}</strong>.
         <br><br>
    
    
         @if ($datosPdf->Supervisor == 1)   
         <strong>FUNDAMENTOS JURÍDICOS QUE SOPORTAN LA MODALIDAD DE SELECCIÓN</strong> <br>
         Es un contrato de prestación de servicios profesionales, cuando se requiera de actividades que no puedan adelantar los propios operarios de la entidad o se requieran conocimientos especializados, como lo prevé el numeral 3° del artículo 32 del Régimen de contratación Estatal, el artículo en comento reza: “Articulo 32. De los Contratos Estatales. Son contratos estatales todos los actos jurídicos generadores de obligaciones que celebren las entidades a que se refiere el presente estatuto, previstos en el derecho privado o en disposiciones especiales, o derivados del ejercicio de la autonomía de la voluntad, así como los que, a título enunciativo, se definen a continuación:
         <br><br>
         3º. Contrato de prestación de servicios profesionales 
         <br><br>   
         Son contratos de prestación de servicios los que celebren las entidades estatales para desarrollar actividades relacionadas con la administración o funcionamiento de la entidad. Estos contratos solo podrán celebrarse con personas naturales cuando dichas actividades no puedan realizarse con personal de planta o requieran conocimientos especializados…” 
         <br><br>  
         La modalidad de contratación es contratación directa, por tratarse de un contrato de prestación de servicios profesionales y de apoyo a la gestión, o para la ejecución de trabajos artísticos que sólo puedan encomendarse a determinadas personas naturales; contenido en el literal h, numeral 4, artículo 2 de la Ley 1150 de 2007 y el artículo 2.2.1.2.1.4.9. del Decreto 1082 de 2015. 
         <br><br>   
         El artículo 2.2.1.2.1.4.9. del Decreto 1082 de 2015, establece que: 
         <br><br>   
         “Contratos de prestación de servicios profesionales y de apoyo a la gestión, o para la ejecución de trabajos artísticos que solo pueden encomendarse a determinadas personas naturales. Las entidades estatales pueden contratar bajo la modalidad de contratación directa la prestación de servicios profesionales y de apoyo a la gestión con la persona natural o jurídica que esté en capacidad de ejecutar el objeto del contrato, siempre y cuando la Entidad Estatal verifique la idoneidad o experiencia requerida y relacionada con el área de que se trate. En este caso, no es necesario que la entidad estatal haya obtenido previamente varias ofertas, de lo cual el ordenador del gasto debe dejar constancia escrita. 
         <br><br>   
         Los servicios profesionales y de apoyo a la gestión corresponden a aquellos de naturaleza intelectual diferentes a los de consultoría que se derivan del cumplimiento de las funciones de la entidad estatal, así como los relacionados con actividades operativas, logísticas, o asistenciales”. 
         <br><br>     
         La entidad estatal, para la contratación de trabajos artísticos que solamente puedan encomendarse a determinadas personas naturales, debe justificar esta situación en los estudios y documentos previos”. 
         <br><br>   
         De conformidad con la norma transcrita, es claro que: 
         <br><br>   
         - Los contratos de servicios profesionales corresponden a aquellos de naturaleza intelectual distintos a los de consultoría, a los que se refiere el numeral 3 del artículo 32 de la Ley 80. <br>
         - En los contratos de prestación de servicios profesionales, existen también los contratos de prestación de servicios de apoyo a la gestión, entendiendo por éstos aquellos de naturaleza no intelectual “relacionados con actividades operativas, logísticas, o asistenciales” de la entidad estatal contratante <br>
         - De conformidad con lo consagrado en el literal h) del numeral 4 del artículo 2 de la Ley 1150 de 2007, tanto los contratos de prestación de servicios profesionales como los contratos de prestación de servicios de apoyo a la gestión, se erigen como causal de contratación directa. <br>
         <br> 
         El contrato a celebrar se trata de un contrato de prestación de servicios profesionales y de apoyo a la gestión, en la medida en que el mismo consistirá en la realización de las actividades de capacitación, actividades operativas, logísticas y asistenciales requeridas por el Concejo Distrital de Santiago de Cali para cumplir con su misión y funciones constitucionales, legales y administrativas, circunstancia que como ya se indicó, autoriza el uso de la modalidad de selección de contratación directa, y en consecuencia la posibilidad para el Concejo Distrital contrate una persona natural o jurídica que habiendo demostrado la idoneidad y experiencia directamente relacionada con el objeto del contrato a celebrar sin que sea necesario la obtención previa de varias ofertas, al tenor de lo consagrado en el artículo 2.2.1.2.1.4.9. del Decreto 1082 de 2015
         <br><br>   
        @else 
        <strong>FUNDAMENTOS JURIDICOS QUE SOPORTAN LA MODALIDAD DE SELECION:</strong>
        La modalidad de selección del presente proceso es la Contratación Directa, modalidad que se fundamenta en lo establecido en el literal h, numeral 4, articulo 2 de la Ley 1150 de 2007 y el Artículo 2.2.1.2.1.4.9. del Decreto Único Reglamentario del Sector Administrativo de Planeación Nacional 1082 de 2015, los cuales permiten contratar servicios profesionales o de apoyo a la gestión en forma directa con la persona natural o jurídica que esté en capacidad de ejecutar el objeto del contrato y que haya demostrado la idoneidad y experiencia directamente relacionada con el área de que se trate, sin que sea necesario que haya obtenido previamente varias ofertas.
        <br><br>
       <strong>JUSTIFICACION DE LOS FACTORES DE SELECCIÓN QUE PERMITAN IDENTIFICAR LA OFERTA MAS FAVORABLE</strong>
        La Ley 1150 de 2007, Decreto 1082 de 2015 establece como procedimiento para suscribir contratos de prestación de servicios profesionales y de apoyo a la gestión, mediante la contratación directa los siguientes lineamientos: 
        <br><br>
       Justificar de manera previa a la apertura del proceso los fundamentos jurídicos que soportan la modalidad de selección que se propone adelantar. 
       <br><br>
       Contratar con la persona natural que este en capacidad de ejecutar el contrato.
       <br><br>
       Con quien se contrate debe tener la idoneidad y experiencia, relacionada con el área u objeto a contratar.
       <br><br>
       No es necesario haber obtenido previamente varias ofertas, pero el ordenador del gasto debe dejar constancia escrita.
       <br><br>
        @endif
        <strong>LA DISTRIBUCIÓN DE LOS RIESGOS</strong>
        En la ejecución del contrato pueden llegar a presentarse causas previsibles que afectan la carga económica o financiera de las partes que, en virtud del artículo 4 de la Ley 1150 de 2007, 
        deben ser reconocidas y asumidas con el objeto de salvaguardar la adecuada marcha de la gestión contractual y la finalidad de las partes en la contratación.
        <br><br>
        Son riesgos previsibles: <br>
        1. Retraso en los pagos por parte de la entidad. <br>
        2. Incumplimiento en las obligaciones del contrato por parte del contratista. <br>
        <br> 
        <strong>1.	RETRASO EN LOS PAGOS POR PARTE DE LA ENTIDAD </strong>
        Tipificación: Ocurre en aquellos casos, cuando la entidad sin justa causa y a pesar del cumplimiento del lleno de los requisitos para el pago de las actividades del <strong>CONTRATISTA</strong>, incurre en mora en los mismos. 
        <br>
        Asignación: La ocurrencia de este riesgo será resuelto a favor del <strong>CONTRATISTA</strong>, solo si se verifica que el contratista no incurrió en errores de facturación y que no existen motivos de 
        fuerza mayor o caso fortuito que generaron el no pago por parte del <strong>DISTRITO</strong>. 
        <br>
        Estimación: El contratista deberá tener en cuenta que los pagos serán efectuados por el DISTRITO en los términos previstos en la minuta del contrato y de acuerdo al cronograma o PAC.
        <br><br>
        <strong>2.	INCUMPLIMIENTO EN LAS OBLIGACIONES DEL CONTRATO POR PARTE DEL CONTRATISTA</strong>
        <br><br>
        <strong>Tipificación:</strong> Ocurre cuando el contratista no cumple con los requerimientos efectuados por la administración Distrital dentro de los plazos que para el efecto establezca aquella y acorde con 
        los plazos indicados por el contratista en su propuesta.
        <br><br>
        <strong>Asignación:</strong> La ocurrencia de los eventuales riesgos por incumplimiento serán asumidos por el  <strong>CONTRATISTA</strong>.
        <br><br>
        <strong>Estimación:</strong> Para mitigar este riesgo en caso que el <strong>CONTRATISTA</strong> incurra en mora o incumplimiento parcial de alguna de las obligaciones adquiridas en el contrato, el <strong>DISTRITO</strong> podrá imponer 
        mediante resolución motivada multas sucesivas equivalentes al uno por mil (1/1000) del valor del contrato por cada día de atraso en el cumplimiento de las obligaciones contraídas, precedida 
        de una audiencia al contratista que garantice el derecho al debido proceso, acogiéndonos al procedimiento que sobre esta materia esté vigente al momento de imponer la multa. Dado que se trata 
        de un contrato de prestación de servicios profesionales y de apoyo a la gestión con persona natural, en la cual la selección del contratista se basa en la capacidad de ejecutar el objeto del 
        contrato y que la entidad deba de verificar la idoneidad o experiencia requerida y relacionada con el área de que se trate, y que el pago sea previsto a contra entrega del servicio, se establece 
        que los posibles riesgos asociados al proceso de contratación que para este tipo de contratos se relaciona con el retraso o limitaciones de actividades comprendidas en el objeto contractual, 
        se mitigan a través del seguimiento técnico, administrativo, financiero, contable y jurídico sobre el cumplimiento del objeto del contrato por parte del supervisor del mismo.
        <br><br>
        <strong>EXCEPCIONES AL OTORGAMIENTO DEL MECANISMO DE COBERTURA DEL RIESGO.</strong> Por tratarse de un contrato en modalidad de contratación directa, según el Artículo 2.2.1.2.1.4.5 del Decreto 1082 de 2015 
        No hay obligatoriedad de garantías.
        <br><br>
        <strong>RELACION DE DOCUMENTOS QUE SIRVIERON DE SUSTENTO PARA ELABORAR EL ESTUDIO DE CONVENIENCIA.</strong>
        <br><br>
        • Solicitud de contratación <strong>FORMATO CODIGO 100.8.4</strong> <br>
        • Certificado de disponibilidad presupuestal <strong>{{ $datosPdf->CDP }}</strong> de <strong>{{ $datosPdf->Fecha_Venc_CDP }}</strong>. <br>
        • Contratos de años anteriores con objetos iguales o similares <br>
        • Certificación de la Oficina de Talento Humano. <br>
        <br>
        <strong>REQUISITOS HABILITANTES E INTEGRANTES DE LA PROPUESTA DE OBLIGATORIO CUMPLIMIENTO:</strong> Las propuestas deberán presentarse dentro del plazo fijado en la invitación y anexando todos los documentos 
        requeridos que acrediten la experiencia en el área objeto de la contratación. <strong>{{ $datosPdf->CDP }}</strong> de <strong>{{ $datosPdf->Fecha_Venc_CDP }}</strong>.
        <br><br>
        <strong>DOCUMENTOS INTEGRANTES DE LA PROPUESTA -</strong> La propuesta contará con los siguientes documentos:
        <br><br>         
        <strong>DOCUMENTOS CONTRACTUALES: </strong>
        1. Fotocopia de Cédula <br>
        2. Examen médico pre ocupacional <br>
        3. Fotocopia Examen psicocensométrico (si aplica) <br>
        4. Certificado de cuenta bancaria <br>
        5. Carta de presentación de oferta <br>
        6. Fotocopia de Registro Único Tributario - RUT <br>
        7. Certificados de estudio <br>
        8. Fotocopia de la Tarjeta Profesional (Si aplica) <br>
        9. Certificado de Vigencia de la Tarjeta Profesional (Si aplica) Vigente <br>
        10. Fotocopia de Certificado de antecedentes disciplinarios en el ejercicio de la profesión) Vigente <br>
        11. Fotocopia de Certificados de experiencia laboral y profesional <br>
        12. Certificado de antecedentes judiciales (Policía) Vigente <br>
        13. Certificado de antecedentes disciplinarios (Procuraduría)- vigente <br>
        14. Certificado de no figurar en el boletín de responsabilidad fiscal (Contraloría) Vigente <br>
        15. Verificación Registro Nacional de Medidas Correctivas (Código Nacional de Policía) Vigente <br>
        16. Certificado de afiliación a la EPS Vigente <br>
        17. Certificado de afiliación a pensión o Resolución de Pensión Vigente <br>
        18. Fotocopia de Libreta Militar (si aplica) - Documento por ambas caras <br>
        19. Fotocopia de Licencia de conducción (si aplica) - Solo para conductores <br>
        20. Verificación SIMIT (si aplica) - Solo para conductores <br>
        21. Otro Documento (si aplica) - A solicitud del organismo <br>
        22. Otro Documento (si aplica) - A solicitud del organismo <br>
        23. Certificado del Portal de Anticorrupción de Colombia (PACO) - Pagina en formato pdf - https://portal.paco.gov.co <br>
        24. Foto del Contratista - Adjuntar imagen jpg o png de max 3 Mg, Foto de frente sobre fondo blanco, sin accesorios. <br>
        25. Certificado de inhabilidades por delitos sexuales a menores de edad (Si aplica) Certificado expedido por autoridad correspondiente. <br>
        26. Certificado del Registro de Deudores Alimentarios Morosos (REDAM) <br>
        <br>
        <strong>DOCUMENTOS ECONOMICOS Y FINANCIEROS</strong><br>
        Estarán constituidos por La Propuesta Económica. 
        <br><br>
        <strong>DOCUMENTOS TECNICOS U OPERATIVOS </strong> <br>
        El Concejo Distrital de Cali verificará como requisito habilitante, la experiencia del proponente, en los siguientes términos:
        <br><br>
        El proponente debe soportar la información, mediante certificaciones expedidas por el contratante y/o copia del contrato y/o actas de recibo total y/o actas de liquidación, debidamente legalizadas. Los documentos suministrados deberán contener toda la información necesaria para que la Corporación pueda verificar este requisito y poseer como mínimo la información requerida.
        <br><br>
        El Concejo podrá solicitar al proponente se repitan los documentos que sean susceptibles de ser subsanados.
        <br><br>
        <strong>VEEDURÍAS CIUDADANAS:</strong> En cumplimiento de lo establecido en la Ley 850/03, Articulo 66 de la Ley 80 de 1993. Las vedarías ciudadanas podrán ejercer control social sobre el presente proceso de contratación. De conformidad a la resolución número 579 de septiembre 25 de 2013 "por medio de la cual se delega unas funciones" el jefe de la oficina jurídica del Concejo Distrital de Santiago de Cali suscribe el presente documento de estudio previo, así como la invitación, certificado de idoneidad y comunicación de interventora y/o supervisor
        <br><br>
        <strong>CONDICIONES DE LA PROPUESTA</strong>
        <br><br>
        <strong>VER ANEXO</strong>
        <br><br>    
        <strong>ANEXO 1</strong>
        <br><br>   
        <strong>CARTA DE PRESENTACION DE LA PROPUESTA</strong>
        <br><br>
        @if ($datosPdf->Supervisor == 1)   
        Objeto a contratar {{ $datosPdf->Objeto }}      
        @else
        Proceso de selección para contratar Prestar Apoyo Asistencial en la unidad de apoyo del honorable concejal {{ $datosPdf->Supervisor }} en el Concejo Distrital de Santiago de Cali.
        @endif
        El suscrito (a) ________________________________________, Obrando en mi propio nombre, identificado con la cedula de ciudadanía número ________________ manifiesto en la presente carta de intención el propósito e interés de participar en la invitación para la prestación del servicio de la referencia y en consecuencia a presentar propuesta económica para tal efecto. 
        <br><br>   
        De acuerdo con los estudios y documentos previos hago la presente propuesta económica y en caso de que me sea aceptada por el Honorable Concejo Distrital de Cali, me comprometo a firmar el contrato correspondiente.
        <br><br>   
        Declaro así mismo: 
        <br><br>  
        1. Que el suscrito posee la capacidad legal para contraer obligaciones y para contratar con el Honorable Concejo Distrital de Cali de acuerdo con las disposiciones legales. 
        <br><br>   
        2. Que conozco plenamente el contenido de los estudios y documentos previos, elaborados por el Honorable Concejo Distrital de Cali, así como la información general y demás documentos de la invitación y acepto los requerimientos solicitados a través de los mismos. 
        <br><br>    
        3. Que si me es adjudicado el contrato me comprometo a efectuar la legalización y cumplimiento del mismo, dentro de los términos y condiciones señaladas tanto en el contrato, como en los estudios y documentos previos. 
        <br><br>   
        4. Que la presente propuesta contiene las condiciones económicas de la misma, de acuerdo a los estudios establecidos por el Honorable Concejo Distrital de Cali. 
        <br><br>    
        5. Declaro bajo la gravedad del juramento que no estoy incurso en ninguna causal de inhabilidad, incompatibilidad, prohibición o conflicto de intereses de carácter constitucional o legal. 
        <br><br>   
        6. Así mismo manifiesto que no he sido y/o me encuentro sancionado por la entidad oficial u organismo de control por incumplimiento de contratos estatales mediante providencia ejecutoriada, dentro de los dos (2) años anteriores a la fecha de cierre de la invitación. 
        <br><br>   
        7. Que declaro que toda la documentación e información es verídica y veraz, la cual aporto haciendo uso del principio de la buena fe y que por tanto exonero a la entidad de responsabilidades. 
        <br><br>    
        8. Autorizo al Concejo Distrital de Cali para que consulte mis antecedentes penales ante la autoridad competente, conforme al Decreto Ley 019 de enero 10 de 2012. 
        <br><br>    
        9. Que conozco y acepto en un todo las leyes generales y especiales aplicables a este proceso
        <br><br>   
        <br><br>    
        ______________________ <br>
        Nombre: <br>
        CC: <br>
        <br>
        <br> 
        <br>
        <p>Para constancia se firma en Santiago de Cali, el {{ $datosPdf->Fecha_Estudios }}.</p> 
        <br><br>
       <table border="0" class="tabla-tdatos">
         <tr>
           <td>
             <img src="{{ asset('storage/firmas/Interventores/Concejo/94371090.png') }}" alt="firma" style="max-width:100%; height:auto;">
           </td>
         </tr>
       </table>
      
       <p>
         <strong>RICARDO MONTERO GONZALEZ</strong><br>
         Jefe oficina jurídica<br>
         Concejo Distrital de Santiago de Cali
     <br><br>
         Elaboró: {{ $datosPdf->Login ?? auth()->user()->name }} <br> 
    
      </p>
     

    </div>
    </div>

</body>
</html>
