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

// dentro de contratista.js
$(document).on('change', '#archivo_pdf', function () {
    const file = this.files[0];
    if (file && file.size > 8 * 1024 * 1024) {
        Swal.fire({
            icon: 'error',
            title: 'Archivo demasiado grande',
            text: 'El archivo supera los 8MB permitidos. Por favor selecciona uno más liviano.',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Entendido'
        });
        this.value = '';
    }
});



function selccionarArchivo(idFormato, idContrato, idCuota) {
    const inputPDF = document.createElement('input');
    inputPDF.type = 'file';
    inputPDF.accept = '.pdf';
    inputPDF.style.display = 'none';

    inputPDF.addEventListener('change', function () {
        const archivoSeleccionado = this.files[0];
        if (!archivoSeleccionado) return;


      // 🚫 Validación: máximo 8MB (8 * 1024 * 1024 bytes)
            if (archivoSeleccionado.size > 8 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Archivo demasiado grande',
                    text: 'El archivo supera los 8MB permitidos. Por favor selecciona uno más liviano.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Entendido'
                });
                return;
            }



        // Mostrar overlay de carga
        document.getElementById('cargandoArchivoOverlay').style.display = 'flex';

        const formulario = new FormData();
        formulario.append('archivo_pdf', archivoSeleccionado);
        formulario.append('idFormato', idFormato);
        formulario.append('idContrato', idContrato);
        formulario.append('idCuota', idCuota);
        
        formulario.append('_token', dataToken);

        fetch('/uploadFile', {
            method: 'POST',
            body: formulario
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('La solicitud falló con el código: ' + response.status);
            }
            return response.text();
        })
        .then(data => {
            // Ocultar overlay
            document.getElementById('cargandoArchivoOverlay').style.display = 'none';

            // Reemplazar contenido
            $('#tablaDocs').html(data);
        })
        .then(data => {
              // Ocultar overlay
              document.getElementById('cargandoArchivoOverlay').style.display = 'none';

              // Reemplazar contenido de la tabla
              $('#tablaDocs').html(data);

              // 🔁 Forzar recarga del visor PDF evitando caché
              const embed = document.getElementById('pdfEmbed');
              if (embed && embed.dataset.srcBase) {
                  const nuevoEmbed = embed.cloneNode(true);
                  const nuevaRuta = `${embed.dataset.srcBase}?t=${Date.now()}&r=${Math.random().toString(36).substring(2, 8)}`;
                  nuevoEmbed.src = nuevaRuta;
                  embed.parentNode.replaceChild(nuevoEmbed, embed);
              }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('cargandoArchivoOverlay').style.display = 'none';
            alert("Ocurrió un error al subir el archivo.");
        });
    });

    document.body.appendChild(inputPDF);
    inputPDF.click();
    document.body.removeChild(inputPDF);
}

 
function AbrirPDFM2(Ruta){ 
    const rutaConCacheBuster = Ruta + '?t=' + new Date().getTime();
    document.getElementById('pdfEmbed').src = rutaConCacheBuster;
    $('#modalVerDocCuota').modal('show'); 
}
 
function AbrirPDFM(ruta, idContrato = null, idCuota = null, nombreArchivoDescarga = null) {
  if (idContrato) $('#idContrato').val(idContrato);
  if (idCuota) $('#idCuota').val(idCuota);

  const timestamp = new Date().getTime();
  const rutaConCacheBuster = ruta + '?v=' + timestamp;

  // 1. Reemplazar el visor anterior (iframe)
  const pdfContainer = $('#pdfViewer').parent();
  $('#pdfViewer').remove();

  const nuevoIframe = $(`
    <iframe 
      id="pdfViewer"
      src="${rutaConCacheBuster}"
      width="100%"
      height="100%"
      frameborder="0"
      style="border: none;"
    ></iframe>
  `);

  pdfContainer.append(nuevoIframe);

  // 2. Botón de descarga externo con nombre personalizado
  const nombreFinal = nombreArchivoDescarga || 'documento.pdf';

  $('#btnDescargarPDFPersonalizado')
    .attr('href', rutaConCacheBuster) // 🔁 Usa la versión actualizada
    .attr('download', nombreFinal)
    .show();

  // 3. Mostrar modal
  $('#modalVerDocCuota').modal('show');
}


let yaEnviando = false;

function btnEnvioCuenta(idContrato) {
    if (yaEnviando) return;
    yaEnviando = true;

    // Desactivar todos los botones verdes
    document.querySelectorAll('.btn-success').forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Enviando...';
    });

    const miTabla = document.getElementById('tablaDocss');
    const idCuota = document.getElementById('idCuota').value;
    const idContratoVal = document.getElementById('idContrato').value;

    const estadosValidos = ["cargado", "aprobada", "opcional", "(si aplica)", "firmado"];
    let todosCargados = true;

    for (let i = 1, row; row = miTabla.rows[i]; i++) {
        if (row.cells.length >= 3) {
            const valorCelda = row.cells[2].textContent.trim().toLowerCase();
            if (!estadosValidos.includes(valorCelda)) {
                todosCargados = false;
                break;
            }
        }
    }

    if (!todosCargados) {
        Swal.fire({
            text: "Al menos un documento no está cargado.",
            icon: "error"
        });

        // Reactivar todos los botones y restaurar texto
        document.querySelectorAll('.btn-success').forEach(btn => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-paper-plane"></i> Enviar';
        });

        yaEnviando = false;
        return;
    }

    // ✅ Envío AJAX
    $.ajax({
        url: '/btnEnviarCuota',
        type: 'get',
        data: { _token: dataToken, idCuota: idCuota, idContrato: idContratoVal },
        success: function (data) {
            $('#tablaCuotas').html(data);
            $('#modalDocUploadCuota').modal('hide');

            Swal.fire({
                text: "Cuenta enviada exitosamente.",
                imageUrl: "https://crearhogares.com/wp-content/uploads/2022/03/74623-email-successfully-sent.gif",
                imageWidth: 200,
                imageHeight: 200,
                imageAlt: "Enviado"
            });

            setTimeout(() => {
                location.reload();
            }, 3000);
        },
        error: function () {
            document.querySelectorAll('.btn-success').forEach(btn => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-paper-plane"></i> Enviar';
            });

            yaEnviando = false;

            Swal.fire({
                text: "Ocurrió un error al enviar la cuenta.",
                icon: "error"
            });
        }
    });
}


 

function btnAbrirModalVerDocBuzon(idContrato, idCuota, nombre) {
  $.ajax({
    url: '/verDocBuzon',
    type: 'GET',
    dataType: 'json',
    data: {
      idContrato: idContrato,
      idCuota: idCuota  
    },

    success(resp) {

    const perfil = Number(resp.userPerfil); 
    // Mostrar u ocultar el card completo según el perfil
    if ([1, 4, 9].includes(perfil)) {
        $('#cardActualizarDatos').show();
        $('#cardCargarDoc').hide();
    } else {
        $('#cardActualizarDatos').hide();
        $('#cardCargarDoc').show();
    }
 
      // 1) Rellenar CDP/RPC/nivel
      $('#infoContrato').html(`Contrato #${idContrato} - ${nombre}`);

      $('#inputCdp').val(resp.cdp || '');
      $('#inputRpc').val(resp.rpc || '');
      $('#inputNivel').val(resp.nivel?.trim()).trigger('change'); 
      $('#inputNivel2').val(resp.nivel?.trim()).trigger('change'); 
     // 2) Rellenar fechas en YYYY-MM-DD
      $('#inputFechaInicio').val(resp.fecha_cdp ? resp.fecha_cdp.substr(0,10) : '');
      $('#inputFechaVencimiento').val(resp.fecha_venc_cdp ? resp.fecha_venc_cdp.substr(0,10) : '');
      $('#inputFechaRpc').val(resp.fecha_rpc ? resp.fecha_rpc.substr(0,10) : '');
      $('#inputFecha_Venc_RPC').val(resp.fecha_venc_rpc ? resp.fecha_venc_rpc.substr(0,10) : '');

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
      $('#inputCdp, #labelinputCdp, #inputFechaInicio, #labelinputFechaInicio, #inputFechaVencimiento, #labelinputFechaVencimiento, #inputNivel, #labelinputNivel, #inputFecha_Venc_RPC, #labelinputFecha_Venc_RPC')
        .hide();
      $('#btnActualizarCdp').hide();

      //    Luego, si estamos en Solicitud CDP:
      if ( String(resp.estadoContrato).toLowerCase().includes('solicitud cdp') || String(resp.estadoContrato).toLowerCase().includes('en ejecución') ) {
        $('#inputCdp, #labelinputCdp, #inputFechaInicio, #labelinputFechaInicio, #inputFechaVencimiento, #labelinputFechaVencimiento, #inputNivel, #labelinputNivel')
          .show();
        const perfil = Number(resp.userPerfil);
        if (perfil === 4 || perfil === 9 || perfil === 1) {
          $('#btnActualizarCdp').show();
        }
      }

      // 7) Mostrar u ocultar inputs y botón “Actualizar RPC”
      $('#inputRpc, #labelinputRpc, #inputFechaRpc, #labelinputFechaRpc, #inputFecha_Venc_RPC, #labelinputFecha_Venc_RPC, #inputNivel2, #labelinputNivel2')
        .hide();
      $('#btnActualizarRpc').hide();

      if ( String(resp.estadoContrato).toLowerCase().includes('rpc') || String(resp.estadoContrato).toLowerCase().includes('en ejecución') ) {
        $('#inputRpc, #labelinputRpc, #inputFechaRpc, #labelinputFechaRpc, #inputFecha_Venc_RPC, #labelinputFecha_Venc_RPC, #inputNivel2, #labelinputNivel2')
          .show();
        const perfil = Number(resp.userPerfil);
        if (perfil === 4 || perfil === 9 || perfil === 1 ) {
          $('#btnActualizarRpc').show();
        }
      } 
 
      // Buscar el primer PDF disponible con una Ruta válida
      const primerPDF = resp.datos?.find(d => d.Ruta);

        // Buscar primer documento con PDF
        let primerPdf = null;
        $('#tablaDocs').find('tr').each(function () {
          const ruta = $(this).attr('onclick')?.match(/'([^']+\.pdf)'/); // extrae PDF del onclick
          if (ruta && ruta[1]) {
            primerPdf = ruta[1];
            return false; // salir del loop
          }
        });

        // Mostrar o limpiar el visor PDF
        if (primerPdf) {
          $('#pdfEmbed').attr('src', primerPdf).show();
        } else {
          $('#pdfEmbed').attr('src', '').hide();
        }
        // Condición para mostrar botones
 
        const estado = String(resp.estadoContrato).toLowerCase();

        // 1. Seleccionar solo los botones del modal abierto
        const $modal = $('#modalDocUploadCuota');
        const $btnAprobar = $modal.find('.btnAprobar');
        const $btnDevolver = $modal.find('.btnDevolver');
        const $btnAprobarActivo = $modal.find('.btnAprobar');
        

 
    
        if ( (perfil !== 10 && perfil !== 11) || ((perfil === 10) && estado.includes('en ejecución')) ) {
            if ((perfil === 10) && estado.includes('en ejecución')) {
                // Solo mostrar botón Aprobar con cambioEstadoCuenta
                $btnDevolver.hide();

                // Reemplazar el botón Aprobar por uno nuevo
                $btnAprobar.replaceWith(`
                  <a class="btn btnAprobar btn-md btn-success" style="margin-right: 3px">
                    <i class="fa-solid fa-file-circle-check"></i> Aprobar
                  </a>
                `);

                // 🔄 Re-seleccionar el botón recién insertado
                const $btnAprobarNuevo = $modal.find('.btnAprobar');
                $btnAprobarNuevo.off('click').on('click', function () {
                  cambioEstadoCuenta(1, idContrato);
                }).show();

              } else if ((perfil === 13) && estado.includes('en ejecución'))  {
                // Comportamiento estándar con cambioEstadoBuzon
                  $btnDevolver.hide();
                  $btnAprobar.hide();

              }else{
                // Comportamiento estándar con cambioEstadoBuzon
                $btnDevolver.off('click').on('click', function () {
                  cambioEstadoBuzon(0, idContrato);
                }).show();

                $btnAprobar.off('click').on('click', function () {
                  cambioEstadoBuzon(1, idContrato);
                }).show();
              }
        } else {
              $btnDevolver.hide();
              $btnAprobar.hide();
        }
      // 9) Finalmente, abrir el modal
      $('#modalDocUploadCuota').modal('show');
    },

    error() {
      Swal.fire('Error','No se pudieron cargar los datos','error');
    }
  });
}

  // Esto debe ejecutarse una sola vez (por ejemplo, al cargar la página)
  $(document).on('click', '#btnActualizarCdp', function () {
    const idContrato = $('#idContratoModal').val();
    actualizarCDP(idContrato);
  });

function btnAbrirModalVerDocBuzonver(idContrato, idCuota, nombre) {
  $.ajax({
    url: '/verDocBuzon',
    type: 'get',
    data: {
      _token: dataToken,
      idContrato: idContrato,
      idCuota: idCuota
    },
    success: function(data) {
      const $modal = $('#modalDocUploadCuotaver'); // referencia al modal correcto

      // 1) Limpia tabla de documentos
      $modal.find('#tablaDocs').html(data.html || '');

      // 2) Actualiza el título del modal
      $modal.find('#nameContratista').html('<i class="fa fa-fw fa-file-contract"></i> ' + nombre);

      // 3) Guarda el contrato actual
      $modal.find('#idContratoModal').val(idContrato);

      // 4) Elimina selector anterior si existe
      $modal.find('#docSelect').remove();

      // 5) Limpia el visor PDF
      $modal.find('#pdfEmbed').attr('src', '');

      // 6) Crear nuevo selector de documentos
      const $sel = $('<select id="docSelect" class="form-control mb-3"><option disabled selected>📄 Selecciona un documento</option></select>');
      const docsValidos = (data.docs || []).filter(d => d.Ruta);

      docsValidos.forEach(function(d) {
        $sel.append(`<option value="${d.Ruta}">${d.Nombre}</option>`);
      });

      $modal.find('#pdfEmbed').before($sel);

      // 7) Al cambiar de selección, carga el PDF
      $sel.on('change', function() {
        const rutaPDF = this.value;
        $modal.find('#pdfEmbed').attr('src', rutaPDF);
      });

      // 8) Carga por defecto el primero
      if (docsValidos.length > 0) {
        $sel.val(docsValidos[0].Ruta).trigger('change');
      }

      // 9) Asocia botones aprobar/devolver dentro del modal
      $modal.find('.btnDevolver, .btnAprobar')
        .off('click')
        .on('click', function () {
          const estado = $(this).data('estado');
          const contrato = $modal.find('#idContratoModal').val();
          cambioEstadoBuzon(estado, contrato, this); // ← PASAS el botón
        });

      // 10) Muestra el modal
      $modal.modal('show');
    },
    error: function() {
      Swal.fire('Error', '❌ No se pudieron cargar los documentos.', 'error');
    }
  });
}


function actualizarCDP(idContrato) {
  const cdp           = $('#inputCdp').val().trim();
  const fechaInicio   = $('#inputFechaInicio').val();
  const fechaVenc     = $('#inputFechaVencimiento').val(); 
  const nivel         = $('#inputNivel').val().trim();  

 

  if (!cdp || !fechaInicio || !fechaVenc || !nivel) {
    return Swal.fire({
      text: 'Por favor completa todos los campos, incluido el Nivel.',
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
      fecha_cdp: fechaInicio,
      fecha_venc_cdp: fechaVenc,
      nivel: nivel
    },
    success(resp) {
      Swal.fire({
        text: 'Contrato actualizado correctamente.',
        icon: 'success'
      });
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
  const fechaVenc     = document.getElementById('inputFecha_Venc_RPC').value;

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
  const $modal = $('#modalDocUploadCuotaver');

  // Referencia a ambos botones del modal
  const $btnAprobar  = $modal.find('.btnAprobar');
  const $btnDevolver = $modal.find('.btnDevolver');

  // Botón actual según estado
  let $btn = (estado === 0) ? $btnDevolver : $btnAprobar;

  // Guardar texto original para ambos
  const originalTextAprobar  = $btnAprobar.html();
  const originalTextDevolver = $btnDevolver.html();

  // Desactivar ambos botones
  $btnAprobar.prop('disabled', true).addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i> Procesando...');
  $btnDevolver.prop('disabled', true).addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i> Procesando...');

  // Validación especial si estado = 1 (Aprobar)
  if (estado === 1) {
    let filas = document.querySelectorAll('#tablaDocs tbody tr');
    let faltan = false;
    filas.forEach(row => {
      const texto = row.cells[2].textContent.trim().toUpperCase();
      if (texto !== '' && texto !== 'CARGADO' && texto !== 'FIRMADO') {
        faltan = true;
      }
    });
    if (faltan) {
      Swal.fire({
        icon: 'error',
        text: 'No puedes aprobar: primero debes cargar todos los archivos firmados.'
      });
      // Revertir botones
      $btnAprobar.prop('disabled', false).removeClass('disabled').html(originalTextAprobar);
      $btnDevolver.prop('disabled', false).removeClass('disabled').html(originalTextDevolver);
      return;
    }
  }

  // Enviar solicitud AJAX
  $.ajax({
    url: '/cambioEstadoBuzon',
    type: 'get',
    dataType: 'json',
    data: {
      _token: dataToken,
      estado: estado,
      idContrato: idContrato,
      idCuota: 1
    },
    success: function(resp) {
      if (resp.success) {
        Swal.fire({ text: "Estado actualizado correctamente.", icon: "success" });
        $modal.modal('hide');
        setTimeout(() => location.reload(), 2000);
      } else {
        Swal.fire('Error', '❌ No se pudo actualizar el estado.', 'error');
        $btnAprobar.prop('disabled', false).removeClass('disabled').html(originalTextAprobar);
        $btnDevolver.prop('disabled', false).removeClass('disabled').html(originalTextDevolver);
      }
    },
    error: function() {
      Swal.fire('Error', '❌ Ocurrió un error en el servidor.', 'error');
      $btnAprobar.prop('disabled', false).removeClass('disabled').html(originalTextAprobar);
      $btnDevolver.prop('disabled', false).removeClass('disabled').html(originalTextDevolver);
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
     
       // url: '/cambioEstadoContrato', 
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



// function cambioEstadoCuenta(estado, idContrato) {
//   const miTabla = document.getElementById('tablaDocs');
//   const idCuotaInput = document.getElementById('idCuota');

//   if (!miTabla) {
//     return Swal.fire({
//       text: 'No se encontró la tabla de documentos (tablaDocs).',
//       icon: 'error'
//     });
//   }

//   if (!idCuotaInput) {
//     return Swal.fire({
//       text: 'No se encontró el campo oculto de cuota (idCuota).',
//       icon: 'error'
//     });
//   }

//   const idCuota = idCuotaInput.value;

//   if (estado === 1) {
//     let errorDetectado = false;

//     for (let i = 1; i < miTabla.rows.length; i++) {
//       const row = miTabla.rows[i];
//       const estadoCell = row.cells[2]; // Tercera columna: Estado
//       const estadoTexto = estadoCell?.textContent.trim().toLowerCase() || '';

//       if (!estadoTexto || estadoTexto !== 'cargado') {
//         // Marcar la fila con rojo claro
//         row.style.backgroundColor = '#ffe6e6';
//         errorDetectado = true;
//       } else {
//         // Limpiar color si estaba previamente marcado
//         row.style.backgroundColor = '';
//       }
//     }

//     if (errorDetectado) {
//       return Swal.fire({
//         text: 'No puedes aprobar: hay documentos sin cargar o en estado inválido.',
//         icon: 'error'
//       });
//     }
//   }

//   // Si todo está bien, enviar solicitud
//   $.ajax({
//     url: '/cambioEstadoCuenta',
//     type: 'GET',
//     data: {
//       _token: dataToken,
//       estado,
//       idCuota,
//       idContrato
//     },
//     success(data) {
//       let msg = 'Cuenta actualizada.', icon = 'success';
//       if (estado === 0) msg = 'Cuenta devuelta.', icon = 'error';
//       Swal.fire({ text: msg, icon });
//       $('#modalDocUploadCuota').modal('hide');
//       setTimeout(() => location.reload(), 1000);
//     },
//     error() {
//       Swal.fire({
//         text: 'Error al cambiar el estado de la cuenta.',
//         icon: 'error'
//       });
//     }
//   });
// }
let yaProcesandoEstado = false;

function cambioEstadoCuenta(estado, idContrato) {
  if (yaProcesandoEstado) return;
  yaProcesandoEstado = true;

  // Desactivar todos los botones de cambio de estado
  document.querySelectorAll('.btn-warning').forEach(btn => {
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Procesando...';
  });

  const miTabla = document.getElementById('tablaDocs');
  const idCuotaInput = document.getElementById('idCuota');

  if (!miTabla) {
    resetBotonesEstado();
    return Swal.fire({
      text: 'No se encontró la tabla de documentos (tablaDocs).',
      icon: 'error'
    });
  }

  if (!idCuotaInput) {
    resetBotonesEstado();
    return Swal.fire({
      text: 'No se encontró el campo oculto de cuota (idCuota).',
      icon: 'error'
    });
  }

  const idCuota = idCuotaInput.value;

  if (estado === 1) {
    let errorDetectado = false;

    for (let i = 1; i < miTabla.rows.length; i++) {
      const row = miTabla.rows[i];
      const estadoCell = row.cells[2];
      const estadoTexto = estadoCell?.textContent.trim().toLowerCase() || '';

      if (!estadoTexto || estadoTexto !== 'cargado') {
        row.style.backgroundColor = '#ffe6e6';
        errorDetectado = true;
      } else {
        row.style.backgroundColor = '';
      }
    }

    if (errorDetectado) {
      resetBotonesEstado();
      return Swal.fire({
        text: 'No puedes aprobar: hay documentos sin cargar o en estado inválido.',
        icon: 'error'
      });
    }
  }

  // Si todo está bien, enviar
  $.ajax({
    url: '/cambioEstadoCuenta',
    type: 'GET',
    data: {
      _token: dataToken,
      estado,
      idCuota,
      idContrato
    },
    success(data) {
      let msg = 'Cuenta actualizada.', icon = 'success';
      if (estado === 0) msg = 'Cuenta devuelta.', icon = 'error';
      Swal.fire({ text: msg, icon });
      $('#modalDocUploadCuota').modal('hide');
      setTimeout(() => location.reload(), 1000);
    },
    error() {
      resetBotonesEstado();
      Swal.fire({
        text: 'Error al cambiar el estado de la cuenta.',
        icon: 'error'
      });
    }
  });
}

function resetBotonesEstado() {
  document.querySelectorAll('.btn-warning').forEach(btn => {
    btn.disabled = false;
    btn.innerHTML = '<i class="fa fa-rotate-left"></i> Cambiar Estado';
  });
  yaProcesandoEstado = false;
}
 
    function redirigirPorDocumento(documento) {
        if (!documento) return alert('Documento inválido');
        window.location.href = '/base-datos/edit/por-documento/' + documento;
    }
 

     
function AprobarsubidaDocumentos(idLote) {
    let todoCorrecto = true;

    // Buscar la tabla anidada correspondiente al lote
    const tabla = $(`.tr-principal:has(td:contains(${idLote}))`).find('.tabla-anidada');

    tabla.find('tr').not(':first').each(function () {
        const $fila = $(this);

        // Validar Entrada
        const entradaInput = $fila.find('.inputEntrada');
        let entradaValor = '';

        if (entradaInput.length) {
            entradaValor = entradaInput.val()?.trim();
        } else {
            entradaValor = $fila.find('td').eq(8).text().trim(); // 9na columna = Entrada
        }

        if (!entradaValor) {
            if (entradaInput.length) {
                entradaInput.css('border-color', 'red');
            } else {
                $fila.find('td').eq(8).css('background-color', '#f8d7da');
            }
            todoCorrecto = false;
        } else {
            if (entradaInput.length) {
                entradaInput.css('border-color', '');
            } else {
                $fila.find('td').eq(8).css('background-color', '');
            }
        }

        // Validar Estado (si existe columna Estado)
        const estadoCelda = $fila.find('td').eq(9); // 10ma columna = Estado
        if (estadoCelda.length) {
            const estadoTexto = estadoCelda.text().trim().toUpperCase();
            if (estadoTexto !== 'CARGADO') {
                estadoCelda.css('background-color', '#f8d7da');
                todoCorrecto = false;
            } else {
                estadoCelda.css('background-color', '');
            }
        }
    });

    if (!todoCorrecto) {
        Swal.fire({
            icon: 'error',
            title: 'No se puede aprobar el paquete',
            text: 'Hay campos de Entrada vacíos o con estado incorrecto.'
        });
        return;
    }

    aprobarLoteCuotas(idLote);
}

function aprobarLoteCuotas(idLote) {
    fetch('/aprobarLoteCuotas', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ idLote })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            Swal.fire({
                icon: 'success',
                title: 'Aprobado',
                text: 'El paquete fue aprobado correctamente.'
            });
            // Opcional: recargar o actualizar visualmente
            location.reload();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo aprobar el paquete.'
            });
        }
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'Intenta nuevamente más tarde.'
        });
    });
} 


function verBitacoraContrato(idContrato) {
  $.ajax({
    url: '/bitacora/contrato/' + idContrato,
    method: 'GET',
    success: function (html) {
      $('#tablaBitacoraContainer').html(html);
      $('#modalBitacora').modal('show');
    },
    error: function () {
      Swal.fire('Error', 'No se pudo cargar la bitácora', 'error');
    }
  });
}