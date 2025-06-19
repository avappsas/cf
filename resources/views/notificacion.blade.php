<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Estado de Cuenta</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-image: url(''); /* Cambiar 'ruta/de/tu/imagen.jpg' por la ruta de tu imagen de fondo */
            background-size: cover;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .header {
          background: #ddd
          color: #fff;
          text-align: center;
          border-top-left-radius: 8px;
          border-top-right-radius: 8px;
      }
      
        .content {
            padding-top: 10px;
            padding-left: 50px;
            padding-right: 50px;
            text-align: justify;
            border-bottom: 2px solid #ddd;
        }

        .content p {
            margin-bottom: 20px;
        }

        .footer {
            background-color: #f5f5f5;
            padding: 10px;
            text-align: center;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .columna-imagen {
            text-align: center;
            margin-bottom: 20px;
        }

        .columna-imagen img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
      <div style="text-align: center;">
        <img src="http://cuentafacil.co/images/logo_CuentaFacil/png/notificacion/CUENTAFACIL.png" alt="Logo" width="600" height="200">
    </div>
     <div class="header">
            <h2 style=" margin-top: 10px; margin-bottom: 2px; ">Notificación de Estado de Cuenta</h2>
        </div>
        <div class="content">
          <p>Estimado {{$data->V_nombre}},</p>
          <p>Espero que este mensaje te encuentre bien.</p> 
          @if($data->V_id_estado == '4')
					<p><strong>PRE APROBADO:</strong> Nos complace informarte que tras una revisión reciente, el estado de tu cuenta ha sido PRE APROBADO por el área correspondiente. Esto significa que tu solicitud ha superado la primera etapa de revisión y está en proceso de evaluación final.</p>
          <img src="http://cuentafacil.co/images/logo_CuentaFacil/png/notificacion/PREAPROBADO.png" alt="Logo" width="100" height="100">
          @elseif ($data->V_id_estado == '5')
					<p><strong>APROBADO:</strong> Es un placer comunicarte que tu cuenta ha sido APROBADA por todas las áreas pertinentes y ha sido remitida al departamento de HACIENDA para el procesamiento del pago. Este importante hito significa que todos los requisitos y procedimientos necesarios han sido cumplidos con éxito, y ahora estamos en la fase final antes del desembolso de los fondos.</p>
          <img src="http://cuentafacil.co/images/logo_CuentaFacil/png/notificacion/APROBADO.png" alt="Logo" width="100" height="100">
          @elseif ($data->V_id_estado == '3')
          <p><strong>DEVUELTA:</strong> Lamentamos informarte que tras una revisión reciente, hemos determinado que el estado de tu cuenta es RECHAZADO. Te pedimos que accedas a la plataforma para obtener más detalles, revisar el contrato y cargar los documentos necesarios. Esto te permitirá ver en detalle qué documento fue devuelto y tomar las acciones pertinentes.</p>
          <img src="http://cuentafacil.co/images/logo_CuentaFacil/png/notificacion/RECHAZADO.png" alt="Logo" width="150" height="100">
          @endif
         <p>Si tienes alguna pregunta o necesitas más información sobre el estado de tu cuenta, no dudes en ponerte en contacto con nosotros. Estamos aquí para ayudarte en cualquier momento.</p>
        </div>
        <div class="footer">
          <p>Este correo electrónico fue generado automáticamente. Por favor, no responder.</p>
          <div class="columna-imagen">
              <img src="http://cuentafacil.co/images/logo_CuentaFacil/png/color_transparent2.png" alt="Imagen" width="300" height="100">
          </div>
        </div>
    </div>
</body>
</html>
            