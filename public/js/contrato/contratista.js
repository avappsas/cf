let slcchange = 0;
let dataToken = $('meta[name="csrf-token"]').attr('content');
let idContrato = 0

let accionEjecucion = 0;
let idCuotaPro = 0;
function AbrirModal(id){
    idContrato = id;
    console.log(idContrato);
    // $("#num_id").val(ido);
    $("#mediumModal").modal("show");
    // let slcchange = 0;
};

 function btnGenerarCuentaq(){
    var dataToken = $('meta[name="csrf-token"]').attr('content');

    var miIdContrato = idContrato;
    var cuota = document.getElementById('Cuota');
    var fecActa = document.getElementById('fecActa');
    var numPlantilla = document.getElementById('numPlantilla');
    var pinPlantilla = document.getElementById('pinPlantilla');
    var Operador = document.getElementById('Operador');
    var fecPago = document.getElementById('fecPago');
    var periodoPlanilla = document.getElementById('periodoPlanilla');
    var Actividades = document.getElementById('Actividades');
    

    if (!cuota.value || !fecActa.value || !numPlantilla.value || !pinPlantilla.value || !Operador.value || !fecPago.value || !periodoPlanilla.value || !Actividades.value) {
        
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes llenar todos los campos!',
            footer: ''
          })
      }else{
        
        $.ajax({
            url: ('/registroCuota'),
            type:'POST',
            data: {_token:dataToken, miIdContrato:miIdContrato, cuota:cuota.value,fecActa:fecActa.value,Actividades:Actividades.value
                ,numPlantilla:numPlantilla.value,periodoPlanilla:periodoPlanilla.value,fecPago:fecPago.value,pinPlantilla:pinPlantilla.value
                ,Operador:Operador.value,fecPago:fecPago.value,accion:accionEjecucion,idCuotaPro:idCuotaPro},
            success: function(data) {
                // miIdContrato.value = '';
                cuota.value = '';
                fecActa.value = '';
                numPlantilla.value = '';
                pinPlantilla.value = '';
                Operador.value = '';
                fecPago.value = '';
                periodoPlanilla.value = '';
                Actividades.value = '';
                Swal.fire({
                    // title: "The Internet?",
                    text: "Datos guardados exitosamente.",
                    icon: "success"
                  });
                  $('#modalRegCuota').modal('hide');
                btnRegistrarCuenta(miIdContrato);
            }
        });
      }

 } 



//  async function btnGenerarCuenta() {
//     var dataToken = $('meta[name="csrf-token"]').attr('content');

//     var miIdContrato   = idContrato;
//     var cuota          = document.getElementById('Cuota');
//     var fecActa        = document.getElementById('fecActa');
//     var numPlantilla   = document.getElementById('numPlantilla');
//     var pinPlantilla   = document.getElementById('pinPlantilla');
//     var Operador       = document.getElementById('Operador');
//     var fecPago        = document.getElementById('fecPago');
//     var periodoPlanilla= document.getElementById('periodoPlanilla');
//     var id_pro         = document.getElementById('id_pro');
//     var Actividades    = document.getElementById('Actividades');
//     Actividades.value  = Actividades.value.replace(/\n/g, '<br>');

//     // Validación según el valor de cuota
//     if (cuota.value === '1') {
//         // Si cuota es "1", solo validamos cuota, operador y actividades
//         if (!cuota.value || !Operador.value || !Actividades.value) {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Oops...',
//                 text: 'Debes llenar los campos Cuota, Operador y Actividades!',
//                 footer: ''
//             });
//             return; // Detenemos la ejecución si falta algún campo
//         }
//     } else {
//         // Si cuota != 1, validamos todos los campos
//         if (
//             !cuota.value || !fecActa.value || !numPlantilla.value || !pinPlantilla.value ||
//             !Operador.value || !fecPago.value || !periodoPlanilla.value || !Actividades.value
//         ) {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Oops...',
//                 text: 'Debes llenar todos los campos!',
//                 footer: ''
//             });
//             return; // Detenemos la ejecución si falta algún campo
//         }
//     }

//     // Si llegamos aquí, las validaciones se han cumplido
//     Swal.fire({
//         title: "Aplicando correcciones",
//         text: "Corrigiendo ortografia y generando actividades en primera y tercera persona. ¡Espere por favor!",
//         imageUrl: "https://cdn.pixabay.com/animation/2023/05/02/04/29/04-29-06-428_512.gif",
//         imageWidth: 70,
//         imageHeight: 70,
//         imageAlt: "Custom image",
//         showConfirmButton: false,
//         didOpen: async () => {
//             try {
//                 // Esperar la respuesta de la llamada AJAX
//                 const response = await $.ajax({
//                     url: ('/registroCuota'),
//                     type: 'POST',
//                     data: {
//                         _token: dataToken,
//                         miIdContrato: miIdContrato,
//                         cuota: cuota.value,
//                         fecActa: fecActa.value,
//                         Actividades: Actividades.value,
//                         numPlantilla: numPlantilla.value,
//                         periodoPlanilla: periodoPlanilla.value,
//                         fecPago: fecPago.value,
//                         pinPlantilla: pinPlantilla.value,
//                         Operador: Operador.value,
//                         fecPago: fecPago.value,
//                         accion: accionEjecucion,
//                         idCuotaPro: idCuotaPro
//                     },
//                 });
                
//                 // Limpia los campos y muestra el mensaje de éxito
//                 cuota.value          = '';
//                 fecActa.value        = '';
//                 numPlantilla.value   = '';
//                 pinPlantilla.value   = '';
//                 Operador.value       = '';
//                 fecPago.value        = '';
//                 periodoPlanilla.value= '';
//                 Actividades.value    = '';

//                 Swal.fire({
//                     text: "Datos guardados exitosamente.",
//                     icon: "success"
//                 });

//                 $('#modalRegCuota').modal('hide');
//                 btnRegistrarCuenta(miIdContrato);

//             } catch (error) {
//                 // Manejo de errores
//                 console.error(error);
//                 Swal.fire({
//                     text: "Hubo un error al procesar la solicitud.",
//                     icon: "error"
//                 });
//             }
//         }
//     });
// }


async function btnGenerarCuenta() {

    var dataToken = $('meta[name="csrf-token"]').attr('content');

    var miIdContrato   = idContrato;
    var cuota          = document.getElementById('Cuota');
    var fecActa        = document.getElementById('fecActa');
    var numPlantilla   = document.getElementById('numPlantilla');
    var pinPlantilla   = document.getElementById('pinPlantilla');
    var Operador       = document.getElementById('Operador');
    var fecPago        = document.getElementById('fecPago');
    var periodoPlanilla= document.getElementById('periodoPlanilla');
    var id_pro         = document.getElementById('id_pro');
    var Actividades    = document.getElementById('Actividades');
    var Actividades_pp    = document.getElementById('Actividades_pp');
    var Actividades_tp    = document.getElementById('Actividades_tp'); 

    // Validación según el valor de cuota
    if (cuota.value === '1') {
        // Si cuota es "1", solo validamos cuota, operador y actividades
        if (!cuota.value || !fecActa.value || !Operador.value || !Actividades_pp.value || !Actividades_tp.value) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debes llenar los campos Cuota, Operador y Actividades!',
                footer: ''
            });
            return; // Detenemos la ejecución si falta algún campo
        }
    } else {
        // Si cuota != 1, validamos todos los campos
        if (
            !cuota.value || !fecActa.value || !numPlantilla.value || !pinPlantilla.value ||
            !Operador.value || !fecPago.value || !periodoPlanilla.value || !Actividades_pp.value || !Actividades_tp.value
        ) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debes llenar todos los campos!',
                footer: ''
            });
            return; // Detenemos la ejecución si falta algún campo
        }
    }

    // Si llegamos aquí, las validaciones se han cumplido
    Swal.fire({
        title: "Aplicando correcciones",
        text: "Corrigiendo ortografia ¡Espere por favor!",
        imageUrl: "https://cdn.pixabay.com/animation/2023/05/02/04/29/04-29-06-428_512.gif",
        imageWidth: 70,
        imageHeight: 70,
        imageAlt: "Custom image",
        showConfirmButton: false,
        didOpen: async () => {
            try {
                // Esperar la respuesta de la llamada AJAX
                const response = await $.ajax({
                    url: ('/registroCuota'),
                    type: 'POST',
                    data: {
                        _token: dataToken,
                        miIdContrato: miIdContrato,
                        cuota: cuota.value,
                        fecActa: fecActa.value,
                        Actividades_pp: Actividades_pp.value,
                        Actividades_tp: Actividades_tp.value,
                        numPlantilla: numPlantilla.value,
                        periodoPlanilla: periodoPlanilla.value,
                        fecPago: fecPago.value,
                        pinPlantilla: pinPlantilla.value,
                        Operador: Operador.value,
                        fecPago: fecPago.value,
                        accion: accionEjecucion,
                        idCuotaPro: idCuotaPro
                    },
                });
                
                // Limpia los campos y muestra el mensaje de éxito
                cuota.value          = '';
                fecActa.value        = '';
                numPlantilla.value   = '';
                pinPlantilla.value   = '';
                Operador.value       = '';
                fecPago.value        = '';
                periodoPlanilla.value= '';
                Actividades.value    = '';

                Swal.fire({
                    text: "Datos guardados exitosamente.",
                    icon: "success"
                });

                $('#modalRegCuota').modal('hide');
                btnRegistrarCuenta(miIdContrato);

            } catch (error) {
                // Manejo de errores
                console.error(error);
                Swal.fire({
                    text: "Hubo un error al procesar la solicitud.",
                    icon: "error"
                });
            }
        }
    });
}




function btnRegistrarCuenta(id){
        idContrato = id;
        $.ajax({
            url: ('/tablaCuotas'),
            type:'get',
            data: {_token:dataToken, id:id},
            success: function(data) {
                $('#tablaCuotas').empty();
                $('#tablaCuotas').html(data);
                // console.log(data);
                $('#mediumModal').modal('show');
            }
        });
}


function btnMostrarPDF(id){
    
        $.ajax({
            url: ('/btnMostrarPDF'),
            type:'get',
            data: {_token:dataToken, id:id},
            success: function(data) {
                $('#modalPDF').empty();
                $('#modalPDF').html(data);
                // console.log(data);
                $('#modalPDFRender').modal('show');
            }
        });
}


 function traerPDF(idCuota,idFormato,nombreFormato){
    
    // var formatoSeleccionado = document.getElementById("formatos").value;
    // var formatoSeleccionado = 4;
    
    $.ajax({
        url: ('/gpdf'),
        type:'get',
        data: {_token:dataToken, id:idFormato,idCuota:idCuota},
        success: function(data) {
            // Abrir la URL en una nueva pestaña
            var nuevaPestana = window.open('', '_blank');
            
            // Escribir el contenido HTML en el elemento con id 'render' en la nueva pestaña
            nuevaPestana.document.write('<html><head><link rel="icon" href="https://cuentafacil.co/images/logo_CuentaFacil/icon_only/color_with_background.ico"><title>' + nombreFormato + ' | CuentaFacil</title></head><body>');
            nuevaPestana.document.write('<div id="render">' + data + '</div>');
            nuevaPestana.document.write('</body></html>');
            nuevaPestana.document.close();
            // $('#render').empty();
            // $('#render').html(data);
            // console.log(data)
        }
    });
 }

 function btnmodalRegCuota(accion){
    accionEjecucion = accion
    
    var cuota = document.getElementById('Cuota');
    var Mes_cuota = document.getElementById('Mes_cuota');
    var fecActa = document.getElementById('fecActa');
    var numPlantilla = document.getElementById('numPlantilla');
    var pinPlantilla = document.getElementById('pinPlantilla');
    var Operador = document.getElementById('Operador');
    var fecPago = document.getElementById('fecPago');
    var periodoPlanilla = document.getElementById('periodoPlanilla');
    var Actividades = document.getElementById('Actividades');
    
    $.ajax({
        url: ('/nextCuenta'),
        type:'get',
        data: {_token:dataToken, idContrato:idContrato},
        success: function(data) {
            cuota.value = data[0].cuota;
            Mes_cuota.value = data[0].Mes_cuota;
            fecActa.value = '';
            numPlantilla.value = '';
            pinPlantilla.value = ''; 
            if(data[0].cuota == 1){ Operador.value = '0'; } else { Operador.value = ''; }
            fecPago.value = '';
            periodoPlanilla.value = '';
            Actividades.value = '';
            $('#modalRegCuota').modal('show');
        }
    });
 }


    
function mostrarSubTabla(e){
    var trPrincipal = $(e).closest('.tr-principal');
    var tablaAnidada = trPrincipal.find('.tabla-anidada');
    tablaAnidada.toggle();
}


function btnModCuota(idCuota,datos,accion){
    accionEjecucion = accion;
    idCuotaPro = idCuota;
    //datos = datos.replace(/	/g, ' ');
    datos = datos.replace(/\n/g, ' ');
    // datos = datos.replace(/<br>/g, '\n');
    console.log('Cleaned JSON:', datos.replace(/\\/g, ''))
    datos = JSON.parse(datos);
    var dataToken = $('meta[name="csrf-token"]').attr('content');

    var miIdContrato = idContrato;
    var cuota = document.getElementById('Cuota');
    var fecActa = document.getElementById('fecActa');
    var numPlantilla = document.getElementById('numPlantilla');
    var pinPlantilla = document.getElementById('pinPlantilla');
    var Operador = document.getElementById('Operador');
    var fecPago = document.getElementById('fecPago');
    var periodoPlanilla = document.getElementById('periodoPlanilla');
    var Actividades = document.getElementById('Actividades');
    var Actividades_pp = document.getElementById('Actividades_pp');
    var Actividades_tp = document.getElementById('Actividades_tp');
    // Actividades.value = Actividades.value.replace('<br>',/\n/g);
    
    cuota.value = datos.Cuota
    fecActa.value = datos.Fecha_Acta
    numPlantilla.value = datos.Planilla
    pinPlantilla.value = datos.Pin_planilla
    Operador.value = datos.Operador_planilla
    fecPago.value = datos.Fecha_pago_planilla
    periodoPlanilla.value = datos.Perioro_Planilla
    Actividades.value = datos.Actividades
    Actividades_pp.value = datos.Actividades_pp
    Actividades_tp.value = datos.Actividades_tp
    $('#modalRegCuota').modal('show');
}



function btnAbrirModalCarguePDF(idContrato,idCuota){
    
    $.ajax({
        url: ('/cargueDoc'),
        type:'get',
        data: {_token:dataToken, idContrato:idContrato,idCuota:idCuota},
        success: function(data) {
            $('#tablaDocs').empty();
            $('#tablaDocs').html(data);
            // console.log(data);
            $('#modalDocUploadCuota').modal('show');
        }
    });
}


function btnAbrirModalCarguecontrato(idContrato){
    
    $.ajax({
        url: ('/cargueContrato'),
        type:'get',
        data: {_token:dataToken, idContrato:idContrato},
        success: function(data) {
            $('#tablaDocs').empty();
            $('#tablaDocs').html(data);
            // console.log(data);
            $('#modalDocUploadCuota').modal('show');
        }
    });
}

function selccionarArchivo(idFormato,idContrato,idCuota){
        // Crear un input de tipo file en memoria y hacer clic en él
        var inputPDF = document.createElement('input');
        inputPDF.type = 'file';
        inputPDF.accept = '.pdf';
        inputPDF.style.display = 'none';

        inputPDF.addEventListener('change', function() {
            // Archivo seleccionado
            var archivoSeleccionado = this.files[0];

            // Puedes mostrar el nombre del archivo seleccionado si lo deseas
            console.log(archivoSeleccionado.name);

            // Enviar el formulario con el archivo seleccionado (puedes usar AJAX si es necesario)
            var formulario = new FormData();
            formulario.append('archivo_pdf', archivoSeleccionado);
            formulario.append('idFormato', idFormato);
            formulario.append('idContrato', idContrato);
            formulario.append('idCuota', idCuota);
            formulario.append('_token',dataToken);
            fetch('/uploadFile', {
                method: 'POST',
                body: formulario
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La solicitud falló con el código: ' + response.status);
                }
                return response.text(); // Se espera HTML en este caso
            })
            .then(data => {
                // Actualizar el contenido del modal con la nueva vista
                $('#tablaDocs').html(data);
            })
            .catch(error => console.error('Error:', error));
        });

        document.body.appendChild(inputPDF);
        inputPDF.click();
        document.body.removeChild(inputPDF);
}


function AbrirPDFM2(Ruta){
    console.log(Ruta)
    document.getElementById('pdfEmbed').src = Ruta;
    $('#modalVerDocCuota').modal('show'); 
}

 function AbrirPDFM(ruta) {
    console.log('Cargando PDF:', ruta);

    // 1) Poner la ruta en el objeto y el enlace de descarga
    document.getElementById('pdfViewer').setAttribute('data', ruta);
    document.getElementById('pdfDownload').setAttribute('href', ruta);

    // 2) Mostrar el modal
    $('#modalVerDocCuota').modal('show');
  }

// function btnEnvioCuenta(idContrato){
//     // Obtener la referencia a la tabla
//     var miTabla = document.getElementById('tablaDocss');
//     var idCuota = document.getElementById('idCuota').value;
//     var idContrato = document.getElementById('idContrato').value;
//     console.log(miTabla)
//     // Bandera para indicar si todos los registros están cargados
//     var todosCargados = true;

//     // Iterar sobre las filas de la tabla
//     for (var i = 1, row; row = miTabla.rows[i]; i++) {
//         // Asegurarse de que hay al menos tres celdas (para evitar errores si algunas filas son más cortas)
//         if (row.cells.length >= 3) {
//             // Obtener el valor de la segunda celda (índice 1 en base a cero)
//             var valorCelda = row.cells[2].innerText;

//             // Verificar si el valor no es "Cargado"
//             if (valorCelda.trim().toLowerCase() !== "cargado") {
//                 if (valorCelda.trim().toLowerCase() !== "aprobada") {
//                     todosCargados = false;
//                     break;  // No es necesario seguir verificando si ya encontramos uno no cargado
//                 }
//             }
//         }
//     } 
//}

function btnEnvioCuenta(idContrato) {
    var miTabla = document.getElementById('tablaDocss');
    var idCuota = document.getElementById('idCuota').value;
    var idContrato = document.getElementById('idContrato').value;

    var todosCargados = true;
    const estadosValidos = ["cargado", "aprobada", "opcional", "(si aplica)"];

    for (var i = 1, row; row = miTabla.rows[i]; i++) {
        if (row.cells.length >= 3) {
            var valorCelda = row.cells[2].textContent.trim().toLowerCase();
            console.log(`Fila ${i} - Estado: "${valorCelda}"`);

            if (!estadosValidos.includes(valorCelda)) {
                todosCargados = false;
                break;
            }
        }
    }

    
    if (todosCargados) { 
        $.ajax({
            url: '/btnEnviarCuota',
            type: 'get',
            data: { _token: dataToken, idCuota: idCuota, idContrato: idContrato },
            success: function (data) {
                $('#tablaCuotas').html(data);
                $('#modalDocUploadCuota').modal('hide'); 

                Swal.fire({
                    text: "Cuenta enviada exitosamente.",
                    imageUrl: "https://crearhogares.com/wp-content/uploads/2022/03/74623-email-successfully-sent.gif",
                    imageWidth: 200,
                    imageHeight: 200,
                    imageAlt: "Custom image"
                });
                  // Esperar 3 segundos (3000 milisegundos) antes de recargar
                setTimeout(function () {
                    location.reload();
                }, 3000);
        
            }
        });
    } else {
        Swal.fire({
            text: "Al menos un documento no está cargado.",
            icon: "error"
        });
    }
}


 

function btnAbrirModalVerDocBuzon(idContrato, nombre) {
  $.ajax({
    url: '/verDocBuzon',
    type: 'GET',
    dataType: 'json',
    data: { idContrato },

    success(resp) {
      // 1) Rellenar CDP/RPC
      $('#inputCdp').val(resp.cdp || '');
      $('#inputRpc').val(resp.rpc || '');

      // 2) Rellenar fechas en YYYY-MM-DD
      $('#inputFechaInicio').val(resp.fecha_cdp ? resp.fecha_cdp.substr(0,10) : '');
      $('#inputFechaVencimiento').val(resp.fecha_venc_cdp ? resp.fecha_venc_cdp.substr(0,10) : '');
      $('#inputFechaRpc').val(resp.fecha_rpc ? resp.fecha_rpc.substr(0,10) : '');
      $('#inputFechaNotificacion').val(resp.fecha_venc_rpc ? resp.fecha_venc_rpc.substr(0,10) : '');

      // 3) Inyectar el HTML de la tabla
      $('#tablaDocs').html(resp.html);

      // 4) Título del modal
      $('#nameContratista').html(
        '<i class="fa fa-fw fa-file-contract"></i> ' + nombre
      );

      // 5) Guardar el contrato en un hidden
      $('#idContratoModal').val(idContrato);

      // 6) Mostrar u ocultar inputs y botón “Actualizar CDP”
      //    Primero ocultamos todo:
      $('#inputCdp, #labelinputCdp, #inputFechaInicio, #labelinputFechaInicio, #inputFechaVencimiento, #labelinputFechaVencimiento')
        .hide();
      $('#btnActualizarCdp').hide();

      //    Luego, si estamos en Solicitud CDP:
      if ( String(resp.estadoContrato).toLowerCase().includes('solicitud cdp') ) {
        $('#inputCdp, #labelinputCdp, #inputFechaInicio, #labelinputFechaInicio, #inputFechaVencimiento, #labelinputFechaVencimiento')
          .show();
        const perfil = Number(resp.userPerfil);
        if (perfil === 4 || perfil === 9   ) {
          $('#btnActualizarCdp').show();
        }
      }

      // 7) Mostrar u ocultar inputs y botón “Actualizar RPC”
      $('#inputRpc, #labelinputRpc, #inputFechaRpc, #labelinputFechaRpc, #inputFechaNotificacion, #labelinputFechaNotificacion')
        .hide();
      $('#btnActualizarRpc').hide();

      if ( String(resp.estadoContrato).toLowerCase().includes('rpc') ) {
        $('#inputRpc, #labelinputRpc, #inputFechaRpc, #labelinputFechaRpc, #inputFechaNotificacion, #labelinputFechaNotificacion')
          .show();
        const perfil = Number(resp.userPerfil);
        if (perfil === 4 || perfil === 9  ) {
          $('#btnActualizarRpc').show();
        }
      } 
      // 8) MOSTRAR BOTONES
      const perfil = Number(resp.userPerfil);
      if (perfil !== 10 && perfil !== 11) {
      $('#btnDevolver').off('click').on('click', function() {
        cambioEstadoBuzon(0, idContrato);
      });
      $('#btnAprobar').off('click').on('click', function() {
        cambioEstadoBuzon(1, idContrato);
      });
      } else {
        $('#btnDevolver').hide();
        $('#btnAprobar').hide();
      }

      // 9) Finalmente, abrir el modal
      $('#modalDocUploadCuota').modal('show');
    },

    error() {
      Swal.fire('Error','No se pudieron cargar los datos','error');
    }
  });
}


function btnAbrirModalVerDocBuzonver(idContrato, nombre) {
  $.ajax({
    url: '/verDocBuzon',
    type: 'get',
    data: { _token: dataToken, idContrato: idContrato },
    success: function(data) {
      // 1) Limpia la tabla de documentos
      $('#tablaDocs').html(data.html);

      // 2) Actualiza el título del modal
      $('#nameContratista').html('<i class="fa fa-fw fa-file-contract"></i> ' + nombre);

      // 3) Inyecta el idContrato en un input hidden (si lo tienes en tu modal)
      $('#idContratoModal').val(idContrato);
 
      // 4) Limpia y vuelve a armar el selector de rutas
      $('#docSelect').remove();
      $('#pdfEmbed').attr('src', '');
      const $sel = $('<select id="docSelect" class="form-control mb-3"></select>');
      data.docs.forEach(function(d) {
        if (d.Ruta) {
          $sel.append(`<option value="${d.Ruta}">${d.Nombre}</option>`);
        }
      });
      $('#pdfEmbed').before($sel);

      // 5) Al cambiar la opción, carga el PDF correspondiente
      $sel.on('change', function() {
        $('#pdfEmbed').attr('src', this.value);
      });

      // 6) Carga por defecto la primera opción, si existe
      if (data.docs.length && data.docs[0].Ruta) {
        $sel.val(data.docs[0].Ruta).trigger('change');
      }

      // 7) Actualiza los botones Devolver/Aprobar para usar el idContrato correcto
      // remueve clicks previos y asocia uno nuevo
      $('#btnDevolver, #btnAprobar')
        .off('click')
        .on('click', function() {
          const estado = $(this).data('estado');
          const contrato = $('#idContratoModal').val();
          cambioEstadoBuzon(estado, contrato);
        });

      // 8) Finalmente, muestra el modal
      $('#modalDocUploadCuotaver').modal('show');
    },
    error: function() {
      alert('❌ Error al cargar documentos.');
    }
  });
}

 



function actualizarCDP(idContrato) {

  const cdp           = document.getElementById('inputCdp').value.trim();
  const fechaInicio   = document.getElementById('inputFechaInicio').value;
  const fechaVenc     = document.getElementById('inputFechaVencimiento').value;

  if (!cdp || !fechaInicio || !fechaVenc) {
    return Swal.fire({
      text: 'Por favor llena todos los campos.',
      icon: 'error'
    });
  }

  $.ajax({
    url: '/contratos/actualizarCDP',
    method: 'POST', 
    data: {
    _token: dataToken,
    idContrato: idContrato,
    cdp: cdp,
    fecha_cdp: fechaInicio,        // antes lo llamabas fecha_inicio
    fecha_venc_cdp: fechaVenc     // antes lo llamabas fecha_vencimiento
    },
    success(resp) {
      Swal.fire({
        text: 'Contrato actualizado correctamente.',
        icon: 'success'
      });
      // si quieres, recarga la tabla o página:
      // $('#modalDocUploadCuota').modal('hide');
      // location.reload();
    },
    error(err) {
      Swal.fire({
        text: 'Error al actualizar el contrato.',
        icon: 'error'
      });
      console.error(err);
    }
  });
}


function actualizarRPC(idContrato) {

  const rpc           = document.getElementById('inputRpc').value.trim();
  const fechaInicio   = document.getElementById('inputFechaRpc').value;
  const fechaVenc     = document.getElementById('inputFechaNotificacion').value;

  if (!rpc || !fechaInicio || !fechaVenc) {
    return Swal.fire({
      text: 'Por favor llena todos los campos.',
      icon: 'error'
    });
  }

  $.ajax({
    url: '/contratos/actualizarRPC',
    method: 'POST', 
    data: {
    _token: dataToken,
    idContrato: idContrato,
    rpc: rpc,
    fecha_rpc: fechaInicio,        // antes lo llamabas fecha_inicio
    fecha_venc_rpc: fechaVenc     // antes lo llamabas fecha_vencimiento
    },
    success(resp) {
      Swal.fire({
        text: 'Contrato actualizado correctamente.',
        icon: 'success'
      });
      // si quieres, recarga la tabla o página:
      // $('#modalDocUploadCuota').modal('hide');
      // location.reload();
    },
    error(err) {
      Swal.fire({
        text: 'Error al actualizar el contrato.',
        icon: 'error'
      });
      console.error(err);
    }
  });
}


function cambioEstadoBuzon(estado, idContrato) {
  // 1) Si intentas APROBAR (estado == 1), validamos en la tabla
  if (estado === 1) {
    let filas = document.querySelectorAll('#tablaDocs tbody tr');
    let faltan = false;
    filas.forEach(row => {
      // asumiendo que la columna 3 es "Estado"
      const texto = row.cells[2].textContent.trim().toUpperCase();
      // permitimos sólo "CARGADO" o cadena vacía
      if (texto !== '' && texto !== 'CARGADO') {
        faltan = true;
      }
    });
    if (faltan) {
      return Swal.fire({
        icon: 'error',
        text: 'No puedes aprobar: primero debes cargar todos los archivos firmados.'
      });
    }
  }
 
  $.ajax({
    url: '/cambioEstadoBuzon',
    type: 'get',
    dataType: 'json',       // para forzar JSON
    data: {
      _token: dataToken,
      estado:    estado,
      idContrato: idContrato,
      idCuota:   1          // ← lo que te faltaba
    },
    success: function(resp) {
      if (resp.success) {
        Swal.fire({
            text: "Estado Actualizado Correctamente.",
            icon: "success"
        });
        $('#modalDocUploadCuota').modal('hide');
        setTimeout(function () {
            location.reload();
        }, 2000);
      } else {
        alert('❌ No se pudo actualizar el estado. Inténtalo de nuevo.');
      }
    },
    error: function() {
      alert('❌ Ocurrió un error en el servidor.');
    }
  });
}



$(document).ready(function () {
    $('#tabAprobadas').on('click', function () {
        $('#pendientes').removeClass('show active');
        $('#enviadas').removeClass('show active');
        $('#aprobadas').addClass('show active');
        $('#devueltas').removeClass('show active');
    });

    $('#tabPendientes').on('click', function () {
        $('#aprobadas').removeClass('show active');
        $('#pendientes').addClass('show active');
        $('#devueltas').removeClass('show active');
        $('#enviadas').removeClass('show active');
    });

    $('#tabDevueltas').on('click', function () {
        $('#aprobadas').removeClass('show active');
        $('#pendientes').removeClass('show active');
        $('#devueltas').addClass('show active');
        $('#enviadas').removeClass('show active');
    });

    $('#tabEnviadas').on('click', function () {
        $('#aprobadas').removeClass('show active');
        $('#pendientes').removeClass('show active');
        $('#enviadas').addClass('show active');
        $('#devueltas').removeClass('show active');
    });
});





function cambioEstadoContrato(estado, idContrato) {
  // 1) Si intentas APROBAR (estado == 1), validamos en la tabla 
        Swal.fire({
    title: '¿Estás seguro?',
    text: `¿Deseas ${estado == 1 ? 'aprobar' : 'devolver'} este documento?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, ¡adelante!',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
     
        url: '/cambioEstadoContrato',
        type: 'get',
        dataType: 'json',       // para forzar JSON
        data: {
          _token: dataToken,
          estado:    estado,
          idContrato: idContrato,
          idCuota:   1          // ← lo que te faltaba
        },
        success: function(resp) {
          if (resp.success) {
            Swal.fire({
                text: "Estado Actualizado Correctamente.",
                icon: "success"
            });
        location.reload(); // Recarga la página actual
      } else {
            Swal.fire({
                text: '❌ No se pudo actualizar el estado. Inténtalo de nuevo.',
                icon: 'error'
            });
      }
    },
    error: function() {
          Swal.fire({
                text: '❌ Ocurrió un error en el servidor.',
                icon: 'error'
  });
}
      });
    }
  });
}