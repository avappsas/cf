let slcchange = 0;
let dataToken = $('meta[name="csrf-token"]').attr('content');
let idContrato = 0

let accionEjecucion = 0;
let idCuotaPro = 0;


function btnAbrirModalVerDocCuotas(idContrato,idCuota,nombre){
    
    $.ajax({
        url: ('/cf/public/verDocJuridica'),
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

function AbrirPDFM(Ruta){
    
    if (Ruta !=''){
        document.getElementById('pdfEmbed').src = Ruta;
    }else{
        document.getElementById('pdfEmbed').src = 'http://cf.avapp.digital/cf/public/storage/doc_cuenta/predeterminado.pdf';
    }
    // $('#modalVerDocCuota').modal('show');

}


function cambioEstado(idArchivo,estado,idCuota,idContrato){
    
    var observacion = document.getElementById('obs_' + idArchivo).value;
    if(observacion == '' && estado == 'DEVUELTA'){
        Swal.fire({
            // title: "The Internet?",
            text: "Debe registrar el motivo u observacion de rechazo del documento.",
            icon: "error"
          });
    }else{
        $.ajax({
            url: ('/cf/public/cambioEstadoFile'),
            type:'get',
            data: {_token:dataToken, idArchivo:idArchivo,estado:estado,observacion: observacion,idCuota:idCuota,idContrato:idContrato},
            success: function(data) {
                if(estado == 'DEVUELTA'){
                    Swal.fire({
                        // title: "The Internet?",
                        text: "Documento rechazado.",
                        icon: "error"
                      });
                }else{
                    Swal.fire({
                        // title: "The Internet?",
                        text: "Documento aprobado.",
                        icon: "success"
                      });
                }
                
                    // Actualizar el contenido del modal con la nueva vista
                    $('#tablaDocs').html(data);
            }
        });
    }
}


function cambioEstadoCuenta(estado){
    
    
    var idCuota = document.getElementById('idCuota').value;
    $.ajax({
        url: ('/cf/public/cambioEstadoCuenta'),
        type:'get',
        data: {_token:dataToken, estado:estado,idCuota:idCuota},
        success: function(data) {
            if(estado == 0){
                Swal.fire({
                    // title: "The Internet?",
                    text: "Cuenta rechazada.",
                    icon: "error"
                  });
                
                $('#modalDocUploadCuota').modal('hide');  
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }else{
                Swal.fire({
                    // title: "The Internet?",
                    text: "Cuenta aprobada.",
                    icon: "success"
                  });
                  $('#modalDocUploadCuota').modal('hide');   
                  setTimeout(function() {
                      location.reload();
                  }, 1000);
            }
            
                // Actualizar el contenido del modal con la nueva vista
                $('#tablaDocs').html(data);
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
            //   const response = await fetch(`/cf/public/generarZip?idLotes=${idLote}&_token=${dataToken}`);
          
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
              const response = await fetch(`/cf/public/enviarAdmin?_token=${dataToken}`);
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
                const response = await fetch(`/cf/public/generarZipSap?idCuota=${idCuota}&_token=${dataToken}`);
                
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
//                   const response = await fetch(`/cf/public/validarDocumento?documento=${documento}&_token=${dataToken}`);
              
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
                const response = await fetch(`/cf/public/validarDocumento?documento=${documento}&_token=${dataToken}`);
                if (response.ok) {
                    const data = await response.json();
                    const val = data.val;
                    console.log(val)
                    if (data != 0) {
                        // Si val es igual a 0, abrir vista correspondiente
                        window.location.href = '/cf/public/contratos/create';
                    } else {
                        // Si val no es igual a 0, mostrar advertencia
                        Swal.fire({
                            title: "Advertencia",
                            text: "El contratista no tiene usuario",
                            icon: "warning",
                            confirmButtonText: "OK",
                            preConfirm: () => {
                                window.location.href = '/cf/public/base-datos/create';
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
            window.location.href = '/cf/public/base-datos/create';
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
      const response = await fetch(`/cf/public/asignarUser?idCuota=${e}&idUser=${seleccionado}&_token=${dataToken}`);
  
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