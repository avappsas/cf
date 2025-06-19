let slcchange = 0;
let dataToken = $('meta[name="csrf-token"]').attr('content');
let idContrato = 0

let accionEjecucion = 0;
let idCuotaPro = 0;


function btnAbrirModalVerDocCuotas(idContrato,idCuota,nombre){
 
    $.ajax({
        url: ('/verDocJuridica'),
        type:'get',
        data: {_token:dataToken, idContrato:idContrato,idCuota:idCuota},
        success: function(data) {
            $('#tablaDocs').empty();
            $('#tablaDocs').html(data);
            $('#nameContratista').html('<i class="fa fa-fw fa-file-contract"></i> ' + nombre);
            // console.log(data);
            $('#modalDocUploadCuota').modal('show');
        }
    });
}

function btnAbrirModalVerDocContratos(idContrato,nombre){
 
        // 2) Ajustar dinámicamente los onclick de los botones Devolver / Aprobar
        $('#btnDevolver').attr('onclick', 'cambioEstadoCuenta(0, ' + idContrato + ')');
        $('#btnAprobar').attr('onclick', 'cambioEstadoCuenta(1, ' + idContrato + ')');
        $('#btnDevolverHV').attr('onclick', 'cambioEstadoCuenta(2, ' + idContrato + ')');
        $('#btnAprobar3').attr('onclick', 'cambioEstadoCuenta(3, ' + idContrato + ')');
        
    $.ajax({
        url: ('/verDoccontratos'),
        type:'get',
        data: {_token:dataToken, idContrato:idContrato},
        success: function(data) {
            $('#tablaDocs').empty();
            $('#tablaDocs').html(data);
            $('#nameContratista').html('<i class="fa fa-fw fa-file-contract"></i> ' + nombre);
            // console.log(data);
            $('#modalDocUploadCuota').modal('show');
        }
    });
}

 
function solicitarCDP(id) {
  $.ajax({
    url: '/solicitud-cdp',      // coincide con tu Route::post('solicitud-cdp',…)
    type: 'POST',
    data: { id: id, _token: dataToken },
      success: function(response) {
      const msg = response.success
        ? 'Solicitud de CDP enviada.'
        : 'No se pudo enviar la solicitud.';
      Swal.fire({
        title: msg,
        icon: response.success ? 'success' : 'error',
        confirmButtonText: 'Ok'
      }).then(() => {
        location.reload();
      });
    },
      error: function() {
      Swal.fire({
        title: 'Error de comunicación.',
        icon: 'error',
        confirmButtonText: 'Ok'
      }).then(() => {
        location.reload();
  });
}
  });
}


function AbrirPDFM(Ruta){
    
    if (Ruta !=''){
        document.getElementById('pdfEmbed').src = Ruta;
    }else{
        document.getElementById('pdfEmbed').src = 'https://cuentafacil.co/storage/doc_cuenta/predeterminado.pdf';
    }
    // $('#modalVerDocCuota').modal('show');

}


function cambioEstado(idArchivo, estado, idCuota, idContrato) {
  const observacion = document
    .getElementById('obs_' + idArchivo)
    .value
    .trim();

  // Estados que requieren motivo u observación
  const requiereMotivo = ['DEVUELTA', 'Firma Hoja de Vida'];

  if (requiereMotivo.includes(estado) && observacion === '') {
    return Swal.fire({
      text: 'Debe registrar el motivo u observación del documento.',
      icon: 'error'
    });
  }

  // Si ya pasó la validación, enviamos el cambio
  $.ajax({
    url: '/cambioEstadoFile',
    type: 'GET',
    data: {
      _token: dataToken,
      idArchivo,
      estado,
      observacion,
      idCuota,
      idContrato
    },
    success: function(data) {
      let texto, icon;
      if (estado === 'DEVUELTA') {
        texto = 'Documento Devuelto.';
        icon = 'error';
      } else if (estado === 'Firma Hoja de Vida') {
        texto = 'Hoja de vida para firma.';
        icon = 'info';
      } else {
        texto = 'Documento Avanzando.';
        icon = 'success';
      }

      Swal.fire({ text: texto, icon });
      $('#tablaDocs').html(data);
    }
  });
}


function cambioEstadoCuenta(estado, idContrato) {
  const miTabla = document.getElementById('tablaDocss');
  const idCuota = document.getElementById('idCuota').value;

  if (estado === 1) {
    // --- APROBAR: todas las filas con documento deben estar en 'aprobada' ---
    for (let i = 1; i < miTabla.rows.length; i++) {
      const row = miTabla.rows[i];
      const estadoCell = row.cells[0].dataset.estado?.trim().toLowerCase() || '';
      // Saltamos filas sin estado (sin documento)
      if (!estadoCell) continue;
      if (estadoCell !== 'aprobada') {
        return Swal.fire({
          text: 'No puedes aprobar: hay al menos un documento pendiente o devuelto.',
          icon: 'error'
        });
      }
    }
  }
  else if (estado === 0) {
    // --- DEVOLVER: basta con que haya al menos un 'devuelta' ---
    let alguna = false;
    for (let i = 1; i < miTabla.rows.length; i++) {
      const row = miTabla.rows[i];
      const estadoCell = row.cells[0].dataset.estado?.trim().toLowerCase() || '';
      if (estadoCell === 'devuelta') {
        alguna = true;
        break;
      }
    }
    if (!alguna) {
      return Swal.fire({
        text: 'Para devolver debe haber al menos un documento marcado como DEVUELTA.',
        icon: 'error'
      });
    }
  }

else if (estado === 2) {
    // validación de Hoja de Vida (Firmada)
    const filas = Array.from(miTabla.rows).slice(1);
    const hvRow = filas.find(row => 
      row.cells[1].textContent.trim().toLowerCase() === 'hoja de vida (firmada)'
    );
    if (!hvRow) {
      return Swal.fire({
        text: 'Debe existir el campo "Hoja de vida (Firmada)".',
        icon: 'error'
      });
    }
    const estadoHv = hvRow.cells[0].dataset.estado.trim().toLowerCase();
    if (!['cargado','aprobada'].includes(estadoHv)) {
      return Swal.fire({
        text: 'La "Hoja de vida (Firmada)" debe estar en estado CARGADO o APROBADA.',
        icon: 'error'
      });
    }
  }
 
  if (estado === 3) {
    // Confirmación de supervisor
    return Swal.fire({
      title: 'Confirmación de Supervisor',
      text: 'Confirma que sus documentos ya están revisados y firmados por ti como Supervisor?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, confirmo',
      cancelButtonText: 'No, cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({
            url: '/cambioEstadoCuenta',
            type: 'GET',
            data: { _token: dataToken, estado, idCuota, idContrato },
            success(data) {
              let msg = 'Cuenta actualizada.', icon = 'success';
              if (estado === 0)      { msg = 'Cuenta Devuelta.';      icon = 'error'; }
              else if (estado === 2) { msg = 'Hoja de vida enviada para firmar.'; icon = 'info';  }
              else if (estado === 3) { msg = 'Cuenta enviada para revisión.'; icon = 'info';  }
              Swal.fire({ text: msg, icon });
              $('#modalDocUploadCuota').modal('hide');
              setTimeout(() => location.reload(), 1000);
            }
          });  // sólo si confirma
      }
      // si cancela, no hace nada
    });
  }
  
  // Si llegó aquí, pasa la validación → enviamos la petición
  $.ajax({
    url: '/cambioEstadoCuenta',
    type: 'GET',
    data: { _token: dataToken, estado, idCuota, idContrato },
    success(data) {
      let msg = 'Cuenta actualizada.', icon = 'success';
      if (estado === 0)      { msg = 'Cuenta Devuelta.';      icon = 'error'; }
      else if (estado === 2) { msg = 'Hoja de vida enviada para firmar.'; icon = 'info';  }
      else if (estado === 3) { msg = 'Cuenta enviada para revisión.'; icon = 'info';  }
      Swal.fire({ text: msg, icon });
      $('#modalDocUploadCuota').modal('hide');
      setTimeout(() => location.reload(), 1000);
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

    
function mostrarSubTabla(e){
    
    var trPrincipal = $(e).closest('.tr-principal');
    var tablaAnidada = trPrincipal.find('.tabla-anidada');
    if (e.classList.contains('fa-circle-chevron-right')) {
        e.classList.remove('fa-circle-chevron-right');
        e.classList.add('fa-circle-chevron-down');
    } else {
        e.classList.remove('fa-circle-chevron-down');
        e.classList.add('fa-circle-chevron-right');
    }
    tablaAnidada.toggle();
}

function contabilizar(){
    Swal.fire({
        title: "Numero de radicado",
        input: "number",
        inputAttributes: {
          autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "Aprobar",
        showLoaderOnConfirm: true,
        preConfirm: async (idLote) => {
            try {
            //   const response = await fetch(`/generarZip?idLotes=${idLote}&_token=${dataToken}`);
          
              if (!response.ok) {
                throw new Error('Error creating lot');
              }
          
            } catch (error) {
              Swal.showValidationMessage(`Error: ${error}`);
            }
          },
        allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: `Lote ${result.value} guardado`,
            imageUrl: "https://crearhogares.com/wp-content/uploads/2022/03/74623-email-successfully-sent.gif",
            imageWidth: 100,
            imageHeight: 100,
            imageAlt: "Custom image",
            confirmButtonText: "Ok",
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                location.reload();
            }
          });
        }
      });
}


function enviarLote(){
  Swal.fire({
      title: "Enviando paquete...",
      allowOutsideClick: () => !Swal.isLoading(),
      allowEscapeKey: false,
      showCancelButton: false,
      showConfirmButton: false,
      imageUrl: "https://cdn3.emoji.gg/emojis/3339_loading.gif",
      imageWidth: 60,
      imageHeight: 60,
      // imageAlt: "Custom image",
      didOpen: async () => {
          try {
              const response = await fetch(`/enviarAdmin?_token=${dataToken}`);
              if (!response.ok) {
                  throw new Error('Error al enviar el paquete');
              }
              setTimeout(() => {
                  Swal.close();
                  Swal.fire({
                      title: "Paquete enviado",
                      icon: "success",
                      showConfirmButton: true
                  });
                  setTimeout(() =>{
                    location.reload();
                  }, 2500);
              }, 3000);
          } catch (error) {
              Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: `Hubo un error al enviar el paquete: ${error}`,
                  showConfirmButton: true
              });
          }
      }
  });
}

  function descargarZipSap(idCuota,cuota,nombre){
    Swal.fire({
        title: "Generando zip...",
        showConfirmButton: false,
        showCancelButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        imageUrl: "https://cdn3.emoji.gg/emojis/3339_loading.gif",
        imageWidth: 60,
        imageHeight: 60,
        didOpen: async () => {
            try {
                const response = await fetch(`/generarZipSap?idCuota=${idCuota}&_token=${dataToken}`);
                
                if (!response.ok) {
                    throw new Error('Error al crear lote');
                }
                
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'Cuota_' + cuota + '_' + nombre + '.zip';
                a.click();
                Swal.close();
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `Error al generar zip: ${error}`,
                }).then(() => {
                    
                });
            }
        }
    });
}

// function validarDocumento(){
//         Swal.fire({
//             title: "Numero de documento",
//             input: "number",
//             inputAttributes: {
//               autocapitalize: "off"
//             },
//             showCancelButton: true,
//             confirmButtonText: "Consultar",
//             showLoaderOnConfirm: true,
//             preConfirm: async (documento) => {
//                 try {
//                   const response = await fetch(`/validarDocumento?documento=${documento}&_token=${dataToken}`);
              
//                   if (response.ok) {
//                     console.log(response.value)
//                     // datos = JSON.parse(response)
//                     // let resVal = datos.val;
//                     // console.log(resVal)
//                   }
//                 } catch (error) {
//                   Swal.showValidationMessage(`Request failed: ${error}`);
//                 }
//               },
//             allowOutsideClick: () => !Swal.isLoading()
//           });
// }

function validarDocumento() {
    Swal.fire({
        title: "Numero de documento",
        input: "number",
        inputAttributes: {
            autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "Consultar",
        showLoaderOnConfirm: true,
        preConfirm: async (documento) => {
            try {
                const response = await fetch(`/validarDocumento?documento=${documento}&_token=${dataToken}`);
                if (response.ok) {
                    const data = await response.json();
                    const val = data.val;
                    console.log(val)
                    if (data != 0) {
                        // Si val es igual a 0, abrir vista correspondiente
                        window.location.href = '/contratos/create';
                    } else {
                        // Si val no es igual a 0, mostrar advertencia
                        Swal.fire({
                            title: "Advertencia",
                            text: "El contratista no tiene usuario",
                            icon: "warning",
                            confirmButtonText: "OK",
                            preConfirm: () => {
                                window.location.href = '/base-datos/create';
                            }    
                        });

                    }
                } else {
                    throw new Error('Response not OK');
                }
            } catch (error) {
                Swal.showValidationMessage(`Request failed: ${error}`);
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        // Si el usuario cierra la advertencia, redirigir a otra vista
        if (result.dismiss === Swal.DismissReason.close) {
            window.location.href = '/base-datos/create';
        }
    });
}



async function asignarUser(e) {
    let select = 'asignacion_' + e;
    var seleccionado = document.getElementById(select).value;
  
    // Validar que el valor seleccionado no esté vacío
    if (!seleccionado) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Por favor, selecciona un usuario antes de continuar.',
      });
      return; // Detener la ejecución de la función si no se ha seleccionado nada
    }
  
    try {
      const response = await fetch(`/asignarUser?idCuota=${e}&idUser=${seleccionado}&_token=${dataToken}`);
  
      if (response.ok) {
        const data = await response.json(); // Si la respuesta es JSON
        console.log(data); // Usar la respuesta del servidor
  
        // Mostrar una alerta de Swal
        Swal.fire({
          icon: 'success',
          title: 'Éxito',
          text: 'La asignación se ha completado correctamente.',
        });
      }
    } catch (error) {
      console.error('Error:', error);
      Swal.showValidationMessage(`Request failed: ${error}`);
    }
  }