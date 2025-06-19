<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Invitación</title>
  <style>
    @page { margin: 1cm 0cm 0.5cm 0cm; }

    body {
      margin:  0; /* mismo espacio entre párrafos */
      padding: 0;
      font-family: Arial, sans-serif;
      font-size: 13px;
      line-height: 1.5;
    }

    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 0cm;
      padding: 0 2cm;
      box-sizing: border-box;
      background: #fff;
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
    .logo-cell { width: 18%; }
    .title-cell { width: 30%; font-weight: bold; font-size: 1.3em; }
    .meta-cell { width: 30%; }
    .meta-cell table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.9em;
    }
    .meta-cell td {
      border: 1px solid #000;
      padding: 10px;
      text-align: center;
    }

    .contenido {
      margin: 1cm 3cm 3cm 3cm; 
      text-align: justify; 
    }

    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: 1.8cm;
      padding: 4px 2cm;
      box-sizing: border-box;
      border-top: 1px solid #000;
      font-size: 10px;
      background: #fff;
    }
    .footer .left { float: left; text-align: left; }
    .footer div { display: inline-block; }
  </style>

<body>  
</head>   
  
<div class="contenido">
  <img src="{{ asset('images/formatos/concejo.png') }}" alt="Logo Concejo" style="max-width:100%; height:auto;"> 
  <p style="text-align: center;">
    <strong>
      COMPLEMENTO AL CONTRATO ELECTRÓNICO DE PRESTACIÓN DE SERVICIOS PROFESIONALES Y/O APOYO A LA GESTIÓN 
      <br>No. {{ $datosPdf->Num_Contrato }}
    </strong>
  </p>

  <p> 
    <br> 
    <strong>CONTRATANTE: </strong>CONCEJO DISTRITAL DE SANTIAGO DE CALI
    <br><br> 
    <strong>CONTRATISTA: </strong>{{ $datosPdf->Nombre }} - {{ $datosPdf->No_Documento }}  
    <br><br>
    <strong>OBJETO:</strong> {!! $datosPdf->Objeto !!}
    <br>
    <br>
    Entre los suscritos a saber <strong>EDISON LUCUMI LUCUMI</strong>, quien actúa en su calidad de presidente de la <strong>CORPORACIÓN CONCEJO DISTRITAL DE SANTIAGO DE CALI</strong>, 
    elegido en Sesión Plenaria según Acta No.200.1.2-129 del 03 de octubre del 2024, quien en lo sucesivo se denominará <strong>EL CONCEJO DISTRITAL DE SANTIAGO
    DE CALI</strong> , por una parte, y por otra, <strong>{{ $datosPdf->Nombre }}</strong> identificado con cédula de ciudadanía No. <strong>{{ $datosPdf->No_Documento }}</strong> , quien para los 
    efectos del presente Contrato se denominará <strong>EL CONTRATISTA</strong> , hemos convenido en celebrar el presente contrato, con observancia del trámite de contratación 
    directa previsto en la Ley 80 de 1993, Ley 1150 de 2007, Decreto Único Reglamentario 1082 de mayo 26 de 2015 y en las cláusulas que a continuación se enuncian.
    <br><br>
    <strong>CLÁUSULA PRIMERA. - ALCANCE DEL OBJETO CONTRACTUAL Y OBLIGACIONES ESPECÍFICAS DEL CONTRATISTA:</strong> Además de los deberes señalados en el en el artículo 5° de la Ley 80 de 
    1993 y de las actividades derivadas de la ley y de la naturaleza del Contrato de Prestación de Servicios, <strong>EL CONTRATISTA</strong> tiene las siguientes obligaciones específicas:
    <br><br>
    {{ $datosPdf->Actividades }}
    <br><br>
    <strong>CLÁUSULA SEGUNDA. -PLAZO DEL CONTRATO:</strong> El término de duración del presente contrato será contado a partir del cumplimiento de los requisitos de perfeccionamiento
     y ejecución, y hasta el, {{ $datosPdf->Plazo }} previa suscripción del acta de inicio, según el artículo 41 de la Ley 80 de 1993 y el artículo 23 de la Ley 1150 de 2007.
    <br><br>
    <strong>CLÁUSULA TERCERA. - FORMA DE PAGO:</strong> El Municipio de Santiago de Cali pagará el valor del contrato en {{ $datosPdf->texto_cuotas }}, valor total del contrato 
    ($ {{ $datosPdf->Valor_Total }}) ({{ $datosPdf->Valor_Total_Letras }} de pesos) {{ $datosPdf->Txt_iva }}, cada una, previa suscripción del informe de supervisión. 
    <strong>PARÁGRAFO I:</strong> Para la realización de los pagos, <strong>EL CONTRATISTA</strong> deberá acreditar que se encuentra al día en el pago de aportes parafiscales 
    relativos al sistema de seguridad social integral, así como los propios del Sena, ICBF y cajas de compensación familiar, cuando corresponda, conforme a la normativa vigente
    aplicable. <strong>PARÁGRAFO II.</strong> En todo caso los pagos que se hagan durante la ejecución del presente contrato correspondiente a las obligaciones contractuales se 
    subordinan a la apropiación y disponibilidad presupuestal, ajustándose al Programa Anual mensualizado de Caja (PAC). <strong>PARÁGRAFO III:</strong> Para cumplir con las 
    obligaciones fiscales que ordena la ley, el CONTRATANTE efectuará las retenciones que surjan del presente contrato, cuando a ello haya lugar, las cuales estarán a cargo del
    <strong>CONTRATISTA.</strong> 
    <br><br>
    <strong>CLÁUSULA CUARTA. - OBLIGACIONES GENERALES DEL CONTRATISTA:</strong> En virtud del presente contrato el <strong>CONTRATISTA</strong> adquiere las siguientes obligaciones generales: 
    <br><br>
    A) Utilizar todos sus conocimientos e idoneidad en la ejecución del presente contrato, comprometiéndose a tramitar y entregar los productos y actividades que hacen parte del 
    presente contrato con calidad y oportunidad. B) Presentar los informes requeridos por el contratante para el seguimiento de las tareas encomendadas. Una vez finalice el objeto 
    del contrato, el contratista deberá entregar al supervisor, un informe detallado de las actividades realizadas durante su ejecución indicando los asuntos asignados, tramitados 
    y pendientes por resolver, así como los archivos físicos y magnéticos que se hubieren generado durante la ejecución del mismo, los informes antes citados deben entregarse en 
    una (1) copia de seguridad, que deberá reposar en las instalaciones del contratante. C) Manejar la documentación a su cargo de conformidad con la Ley 594 de 2000, Ley General 
    de Archivo, las políticas operativas del Proceso Gestión Documental, la política del Sistema de Gestión Documental y demás plataformas institucionales. El contratista debe 
    entregar inventariada al contratante y/o al supervisor, las carpetas y documentación que tenga a su cargo en virtud del desarrollo del objeto del presente contrato, entrega 
    que deberá hacerse de acuerdo con los procedimientos establecidos por el contratante. D) El contratista se compromete a cumplir con las normas y procedimientos sobre el Sistema 
    de Gestión de Seguridad Social y Salud en el trabajo de la Entidad. Si en el desarrollo del objeto contractual se realizan actividades de campo y/o visitas a obras, 
    el contratista, a sus expensas, deberá dotarse y acudir a estos lugares con los implementos de seguridad industrial mínimos requeridos, tales como casco, botas, gafas 
    protectoras, etc. E) En el evento en que el contratista al momento de suscribir el presente contrato pertenezca al régimen tributario simplificado y durante la vigencia 
    del mismo adquiera la obligación de inscribirse en el régimen común, se compromete a realizar cambio de régimen ante la DIAN dentro de los términos que otorga la ley y a 
    reportar dicha situación al contratante para lo cual aportará el RUT actualizado, lo anterior de conformidad con la normativa vigente aplicable. F) El contratista se 
    compromete a mantener actualizados todos sus documentos en la Entidad, especialmente el RUT. G) Velar por el buen uso de los bienes entregados por el supervisor o el 
    contratante para realizar sus actividades. H) Reportar al contratante el número de cuenta bancaria de ahorro o corriente, donde se le ha de consignar el pago derivado 
    de la ejecución del presente contrato. I) Conocer y aplicar las directrices, metodologías, políticas y procedimientos enmarcados dentro de los Sistemas de Gestión y 
    Control Integrado adoptados por la Administración Central del Municipio Santiago de Cali y, particularmente, los que se relacionan con el objeto del presente contrato. 
    J) Se compromete a cumplir con la política de seguridad de la información establecida por la entidad, con el fin de garantizar la confidencialidad, integridad y 
    disponibilidad de la información bajo su responsabilidad. K) Mantener actualizado el registro en los sistemas de información del contratante en tiempo real, cuando a 
    ello hubiere lugar.  L) Toda información o formatos generados por el contratista son propiedad de la Alcaldía de Santiago de Cali. M) Se compromete a que, en desarrollo 
    de su objeto contractual, cuando se requiera utilizar dispositivo y/o equipos tecnológicos personales o de la administración, deberá velar porque todo software y 
    herramientas utilizada e instalada en la ejecución de sus obligaciones no vulneran ninguna normativa, contrato, derecho, interés, patentes, legalidad o propiedad de 
    tercero, y que por el contrario todo lo utilizado este debidamente licenciado. N) Se compromete a cumplir con las estrategias, políticas y actividades en materia de 
    transparencia, integridad, prevención y detección de la corrupción y ante cualquier conocimiento de hechos que atente contra este principio lo hará conocer 
    al CONTRATANTE. O) Si el prestador del servicio contratado hace parte del equipo estructurador de los procesos de contratación del organismo, deberá acreditar el 
    curso de inducción adoptado para tal fin por el Departamento Administrativo de Contratación Pública. P) Divulgar y aplicar la política ambiental, de seguridad y salud 
    ocupacional establecida por <strong>EL CONTRATANTE</strong>, al ejecutar sus actividades o servicios sin crear riesgo para la salud, la seguridad o el ambiente. El (la) <strong>CONTRATISTA</strong>
    deberá tomar todas las medidas conducentes a evitar la contaminación ambiental, la prevención de riesgos durante la ejecución de sus operaciones o actividades y cumplirá 
    con todas las leyes ambientales, de seguridad y salud ocupacional, aplicables. El (la) <strong>CONTRATISTA</strong>  no dejará sustancias o materiales nocivos para la flora, fauna o salud 
    humana, ni contaminará la atmósfera, el suelo o los cuerpos del agua. La violación de estas normas se considerará incumplimiento grave del contrato, y EL CONTRATANTE podrá 
    aplicar la cláusula penal o multas a que hubiere lugar, sin perjuicio de las demás acciones legales o sanciones que adelante la autoridad o ente competente de orden Municipal 
    o Nacional. Q) <strong>El CONTRATISTA</strong> deberá coordinar con el supervisor la ejecución de las actividades contractuales, acatando sus instrucciones, con el fin de asegurar las 
    condiciones necesarias para el desarrollo eficiente del objeto contractual. R) No ejercer ninguna forma de violencia contra las mujeres y basada en género, actos de racismo 
    o discriminación.
    <br><br>
    <strong>CLÁUSULA QUINTA. - OBLIGACIONES DEL CONTRATANTE:</strong> En virtud del presente contrato de prestación de servicios se obliga a: 1) Pagar al <strong>CONTRATISTA</strong>
     las sumas estipuladas en el contrato, en la oportunidad y forma allí establecidas. 2) Proporcionar la información y documentación requerida para la normal ejecución del objeto contractual. 
     3) Vigilar, supervisar y/o controlar la ejecución idónea y oportuna del objeto del contrato. 4) Todas aquellas inherentes para el cumplimiento del objeto contractual.
     <br><br>
     <strong>CLÁUSULA SEXTA. - EXCLUSIÓN DE LA RELACIÓN LABORAL, AUTONOMÍA Y RESPONSABILIDAD DEL CONTRATISTA.</strong> De conformidad con la normativa vigente aplicable, 
     en ningún caso el Contrato de Prestación de Servicios generará subordinación, ni relación laboral y, por consiguiente, <strong>El CONTRATISTA</strong> no tiene derecho a reclamar al 
     Municipio de Santiago de Cali ningún tipo de prestación social, de tal manera que la única retribución con motivo de este compromiso es el pago de los honorarios pactados. 
     <strong>El CONTRATISTA</strong> actuará con total autonomía y responsabilidad en el cumplimiento de las obligaciones que adquiere por el presente contrato. <strong>El CONTRATISTA</strong>
     será responsable ante las autoridades competentes por los actos u omisiones en el ejercicio de las actividades que desarrolle en virtud del contrato, cuando 
     con ellos cause perjuicio a la Administración o a terceros. Igualmente será responsable en los términos de la normativa vigente aplicable.
     <br><br>
     <strong>CLÁUSULA SÉPTIMA. - AFILIACIÓN AL SISTEMA DE SEGURIDAD SOCIAL Y ARL. El CONTRATISTA</strong> se obliga a mantener al día el pago correspondiente a los sistemas de 
     seguridad social en salud, pensiones y ARL de acuerdo con las bases de cotización establecidas en las normas vigentes. <strong>El CONTRATISTA</strong> antes de iniciar la ejecución 
     contractual deberá informar al <strong>CONTRATANTE</strong> la EPS y la AFP a los cuales se encuentre afiliado. Igualmente, cuando <strong>El CONTRATISTA</strong> determine trasladarse de empresa 
     promotora de salud (EPS) o de fondo de pensiones, deberá informar dicha situación al <strong>CONTRATANTE</strong>, con una antelación mínima de treinta (30) días a su ocurrencia. 
     Al vencimiento del contrato, deberá adelantar los trámites correspondientes a los reportes de novedades a las entidades de salud y pensiones. PARÁGRAFO. 
     <strong>El CONTRATISTA</strong> se compromete antes de iniciar la ejecución de su contrato a afiliarse al Sistema General de Riesgos Laborales de conformidad con lo señalado 
     en la normativa vigente aplicable.
     <br><br>
     <strong>CLÁUSULA OCTAVA. - SUPERVISIÓN: El CONTRATANTE</strong> ejercerá la supervisión del contrato a través del funcionario que designe, quien tendrá a cargo las 
     funciones señaladas en la normatividad vigente aplicable y el documento técnico de supervisión de la Administración. 
     <br><br>
    <strong>CLÁUSULA NOVENA. - MODIFICACIONES AL CONTRATO:</strong> Cualquier modificación al contrato deberá hacerse directamente en la plataforma electrónica y las 
    consideraciones que soporten la modificación deberá justificarse en los formatos previamente establecidos y publicarlos en el <strong>SECOP II. </strong>
    <br><br>
    <strong>CLÁUSULA DÉCIMA. - APLICACIÓN DE LAS CLÁUSULAS EXCEPCIONALES: EL CONTRATANTE</strong> podrá aplicar las cláusulas de interpretación, modificación, 
    terminación unilateral y caducidad al contrato según lo estipulado en la normativa vigente aplicable. 
    <br><br>
    <strong>CLÁUSULA DÉCIMA PRIMERA. - SANCIONES EN CASO DE INCUMPLIMIENTO.</strong> Las partes de mutuo acuerdo y, de conformidad con lo dispuesto en el Estatuto 
    General de Contratación Pública, establecemos las siguientes sanciones contractuales: 
    <strong>I. MULTAS:</strong> En virtud del deber de control y vigilancia sobre el contrato, <strong>EL CONTRATANTE</strong> tendrá la facultad de imponer al <strong>CONTRATISTA</strong> las multas 
    pactadas en el contrato con el fin de conminarlo al cumplimiento de sus obligaciones, en los términos que establece la normativa vigente aplicable. Para tales efectos, 
    las partes acuerdan que en caso de incumplimiento de alguna de las obligaciones adquiridas por el <strong>CONTRATISTA</strong> o cumplidas deficientemente o por fuera del término 
    estipulado para cada obligación, se causará una multa equivalente hasta el uno por mil (1/1000) del valor total del contrato por cada día calendario transcurrido a 
    partir de la fecha prevista para el cumplimiento de dichas obligaciones. La imposición de la multa atenderá los criterios de razonabilidad, proporcionalidad y gravedad 
    de la obligación incumplida. Si pasaren más de treinta (30) días calendario sin que el (la) <strong>CONTRATISTA</strong> haya cumplido la actividad obligacional en mora, 
    <strong>EL CONTRATANTE</strong> podrá declarar la caducidad del presente contrato ya que la mora por más de treinta (30) días se considera un incumplimiento grave. Contra dicha 
    resolución procede el recurso de reposición de conformidad con la normativa vigente aplicable. 
    <br>
    <strong>II. CLAUSULA PENAL PECUNIARIA: </strong>En caso de declaratoria de incumplimiento <strong>El CONTRATISTA</strong> pagará al <strong>CONTRATANTE</strong> a título de Cláusula Penal 
    Pecuniaria una suma equivalente al diez por ciento (10%) del valor total del Contrato de Prestación de Servicios. <strong>III. CADUCIDAD ADMINISTRATIVA:</strong>  
    <strong>EL CONTRATANTE</strong> podrá declarar la caducidad del contrato cuando se presenten hechos constitutivos de incumplimiento de las obligaciones a cargo de 
    <strong>El CONTRATISTA</strong> que afecten en forma grave y directa la ejecución del contrato y se evidencie que puede generar su paralización (normativa vigente aplicable), 
    dará lugar a la declaratoria de caducidad del contrato el incumplimiento de la obligación de informar inmediatamente al <strong>CONTRATANTE</strong> , sobre la ocurrencia de 
    peticiones o amenazas de quienes actúan por fuera de la Ley, con el objetivo de obligarlos a hacer u omitir algún acto o hecho y por las causales a que se 
    refiere la normativa vigente aplicable. Se entiende como incumplimiento grave la sistemática omisión en la respuesta o atención de las obligaciones a su cargo. 
    En caso de producirse la declaratoria de caducidad, no habrá lugar a la indemnización para <strong>El CONTRATISTA</strong> quien se hará acreedor a las sanciones e inhabilidades 
    establecidas en la normativa vigente aplicable. La resolución de caducidad se notificará personalmente a <strong>El CONTRATISTA</strong> a su representante o apoderado conforme 
    al Código de Procedimiento Administrativo y de lo Contencioso Administrativo (Ley 1437 de 2011). Contra la resolución de caducidad procede el recurso de reposición 
    en los términos consagrados en la normativa vigente aplicable. PARÁGRAFO: Para la imposición de las sanciones contractuales descritas en esta cláusula se deberá 
    seguir el procedimiento mínimo que garantice el debido proceso acorde a la normativa vigente aplicable.
    <br><br>
    <strong>CLÁUSULA DÉCIMA SEGUNDA. - TERMINACIÓN DEL CONTRATO:</strong> El contrato se puede terminar por:  1) Por mutuo acuerdo de las partes. 2) Cuando las condiciones 
    contractuales o las circunstancias que dieron lugar al nacimiento del contrato desaparezcan o hayan variado sustancialmente de tal manera que su ejecución resulte imposible 
    y/o inconveniente de conformidad con la justificación expedida por <strong>El CONTRATISTA</strong>.  3) Por decisión unilateral del <strong>CONTRATANTE</strong> en el caso de incumplimiento por parte 
    del <strong>CONTRATISTA</strong>, de conformidad con lo previsto en la cláusula décima quinta del presente contrato. 4) Por la inclusión del <strong>CONTRATISTA</strong>, algún miembro de su personal o 
    de lo dispuesto para la ejecución del contrato, en listas nacionales o extranjeras conformadas por personas proscritas en razón de lavados de activos, captación ilegal 
    de dineros, narcotráfico, terrorismo o cualquier actividad ilícita.  5) Por vencimiento del plazo contractual.  6) Por las demás establecidas en la ley. 
    <strong>PARÁGRAFO PRIMERO:</strong> Las partes de común acuerdo, establecen como causal de terminación anticipada, el hecho de que el Concejal que los haya postulado para hacer 
    parte de su Unidad de Apoyo Normativo, no pueda continuar en el ejercicio del cargo, ya sea por decisión judicial ejecutoriada o por cualquier otra situación 
    que implique la remoción del cargo o la imposibilidad de ejercerlo. <strong>PARÁGRAFO SEGUNDO:</strong> Cuando se presente el supuesto del parágrafo primero, previo aviso al 
    contratista, la entidad dará por terminado el contrato de prestación de servicios, mediante acto administrativo motivado, que será publicado en el 
    SECOP II. PARÁGRAFO TERCERO: <strong>El CONTRATISTA</strong>, hasta antes de la expedición del acto administrativo que ordene la terminación anticipada del contrato por el 
    supuesto de hecho contenido en el parágrafo primero, podrá solicitar a la entidad la terminación anticipada de mutuo acuerdo. 
    <br><br>
    <strong>CLÁUSULA DÉCIMA TERCERA. - SUSPENSIÓN DEL CONTRATO:</strong> El plazo para la ejecución del contrato podrá suspenderse por acuerdo entre las partes o cuando 
    ocurran hechos o circunstancias constitutivas de una situación de fuerza mayor o caso fortuito que impidan el cumplimiento de las obligaciones 
    asumidas. Si la suspensión es de mutuo acuerdo, deberá suscribirse un acta por las partes en la que conste la razón por la cual suspenden la 
    ejecución del contrato, la forma como se asumirán los costos que se generen con ocasión de la misma, las actividades que se desarrollarán tendientes 
    a superar el motivo de suspensión. Mientras subsistan hechos constitutivos de una situación de fuerza mayor o caso fortuito, y estas impidan la 
    ejecución total del contrato, el plazo para la ejecución del contrato se suspenderá de la siguiente manera: (i) por el término que dure la situación 
    que configura la circunstancia de caso fortuito o fuerza mayor. (ii) Si los hechos constitutivos de una situación de fuerza mayor y caso fortuito 
    no impiden la ejecución de la totalidad del contrato, sino sólo de manera parcial o de alguna o algunas de las obligaciones de este contrato, las 
    partes convendrán si tales circunstancias suponen o no la suspensión de la totalidad del contrato, y en su caso, el tiempo y los términos de suspensión. 
    La suspensión de la ejecución del contrato por fuerza mayor o caso fortuito se hará constar en actas suscritas por las partes, en las cuales se 
    indiquen los hechos que la motivan. Una vez cesen las causas de la suspensión se dejará constancia de este hecho y de la reiniciación de los plazos
     contractuales a que haya lugar; en actas suscritas por las partes. De generarse costos al CONTRATISTA producto de la suspensión,<strong>EL CONTRATANTE</strong> 
     deberá reconocerlos a efecto de llevar al <strong>CONTRATISTA</strong> a punto de no pérdida, siempre y cuando esté plenamente demostrado. 
     <br><br>
     <strong>CLÁUSULA DÉCIMA CUARTA. - CESIÓN: El (la) CONTRATISTA</strong> no podrá ceder parcial ni totalmente sus obligaciones o derechos derivados del presente 
     contrato de prestación de servicios sin la autorización previa y escrita del CONTRATANTE. La cesión se hará de conformidad con lo previsto en la normativa vigente 
     aplicable. En todo caso, EL CONTRATANTE verificará que la idoneidad y experiencia del (la) cesionario (a) sea igual o superior a la solicitada en los estudios 
     previos que dieron origen al contrato.
     <br><br>
     <strong>CLÁUSULA DÉCIMA QUINTA. - CONFIDENCIALIDAD: EL CONTRATISTA</strong> se compromete a guardar estricta confidencialidad y a dar cumplimiento a la Ley Estatutaria 1581 de 2012, 
     respecto de toda la información y datos personales que conozca y se le entregue por cualquier medio durante el plazo de ejecución, y por ende éste no podrá realizar 
     su publicación, divulgación y utilización para fines propios o de terceros no autorizados. Así mismo, respetará los acuerdos de confidencialidad suscritos por 
     EL CONTRATANTE con terceros para la celebración de negocios, preacuerdos o acuerdos por el mismo tiempo por el que <strong>EL CONTRATANTE</strong> se compromete con los terceros 
     a guardar la debida reserva. 
     <br><br>
     <strong>CLÁUSULA DÉCIMA SEXTA.- MANEJO DE DATOS PERSONALES: El CONTRATISTA</strong> autoriza de manera libre y voluntaria al <strong>CONTRATANTE</strong> a recopilar, utilizar, 
     transferir, almacenar, consultar, procesar, y en general a dar tratamiento a la información personal que este ha suministrado al <strong>CONTRATANTE</strong>, de conformidad con 
     lo dispuesto en la Ley 1581 de 2012, la cual se encuentra contenida en las bases de datos y archivos de propiedad de <strong>EL CONTRATANTE</strong> para los fines administrativos,
      contractuales, de publicidad y demás que sean necesarios, referentes a su nombre, documento de identidad, dirección, teléfono, correo electrónico. 
     <br><br>
     <STROng>CLÁUSULA DÉCIMA SÉPTIMA. - PUBLICACIÓN:</STROng> El presente contrato es objeto de publicación en el Sistema Electrónico para la Contratación Pública – SECOP II, que 
     administra la Agencia Nacional de Contratación Pública Colombia Compra Eficiente, de conformidad con lo dispuesto en la normativa vigente aplicable. 
     <br><br>
     <STRONg>CLÁUSULA DÉCIMA OCTAVA. - MARCO REGULATORIO DEL CONTRATO ELECTRÓNICO.</STRONg> En desarrollo con el artículo 3 de la ley 1150 de 2007, la Ley 1712 de 2014, el Decreto 
     4170 de 2011, el Decreto 1082 de 2015 y el Decreto 1083 de 2015, Colombia Compra Eficiente administra el <strong>SECOP II</strong>, plataforma transaccional que permite a Compradores y Proveedores 
     realizar el Proceso de Contratación en línea. Por ello, y de conformidad con lo dispuesto en la Ley 527 de 1999, la sustanciación de las actuaciones, la expedición de los actos 
     administrativos, los documentos, contratos y en general los actos derivados de la actividad precontractual, contractual y Postcontractual, tendrán lugar a través de la plataforma 
     del SECOP II. Todos los documentos del proceso publicados en la plataforma del <strong>SECOP II</strong> son integrales y complementarios entre sí. 
     <br><br>
     <STRONg>CLÁUSULA DÉCIMA NOVENA. - RÉGIMEN LEGAL Y JURISDICCIÓN:</STRONg> El presente contrato está sometido en un todo a la ley colombiana y se rige por las disposiciones de 
     la normativa vigente aplicable., en lo que no esté regulado expresamente, se regirá por las normas civiles y comerciales.
     <br><br>
     <STRONg>CLÁUSULA VIGÉCIMA. - CONTROVERSIAS CONTRACTUALES:</STRONg> Las Partes buscarán solucionar en forma ágil, rápida y directa las diferencias y discrepancias surgidas de 
     la actividad contractual. Para tal efecto, al surgir las diferencias acudirán al empleo de los mecanismos de solución de controversias contractuales previstos en el artículo 
     68 de la Ley 80 de 1993. 
     <br><br>
     El presente documento se entiende fechado y firmado una vez sea aprobado por ambas partes el contrato electrónico a través del Sistema Electrónico para la Contratación Pública – <strong>SECOP II.</strong>
     <br><br>     <br><br>
     EL CONCEJO,        
     <br><br>     
     <strong>EDISON LUCUMI LUCUMI  </strong> <br>  
     <strong>C.C. No. 94459505</strong> <br>
     PRESIDENTE CONCEJO <br>
      <br>
      <br>
    EL CONTRATISTA, 
    <br><br>    
    <strong>{{ $datosPdf->Nombre }}</strong>  <br>
    <strong>C.C. Nº {{ $datosPdf->No_Documento }}</strong>  
 
    </p>
 
   
</div>

@if (isset($pdf))
  <script type="text/php">
    $font = $fontMetrics->get_font("Arial", "normal");
    $size = 9;
    $text = "Página $PAGE_NUM de $PAGE_COUNT";
    $width = $fontMetrics->get_text_width($text, $font, $size);

    // Centrado horizontal
    $x = (612 - $width) / 2;

    // Altura: parte inferior del contenido, pero dentro del área visible
    $y = 780;

    $pdf->text($x, $y, $text, $font, $size);
  </script>
@endif

<footer style="text-align:center;">
  <div class="left">
    Elaboró: {{ $datosPdf->Login ?? auth()->user()->name }} <br> 
    Concejo Distrital de Santiago de Cali
  </div> 
  <div style="clear:both;"></div>
  Av. 2 N No. 10-65 CAM - PBX 6678200 | www.concejodecali.gov.co<br>
  Este documento es propiedad del Concejo Distrital de Santiago de Cali. Prohibida su alteración o modificación.
</footer>

</body>
</html>


