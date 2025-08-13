
// Hacerla global
window.currentTransform = { x: 0, y: 0, scale: 1, rotation: 0 };
let slcchange = 0;
let dataToken = $('meta[name="csrf-token"]').attr('content');
let idContrato = 0

let accionEjecucion = 0;
let idCuotaPro = 0;
function btnAbrirModalVerDocCuotas(idContrato, idCuota, nombre) {
    $.ajax({
        url: '/verDocJuridica',
        type: 'get',
        data: {
            _token: dataToken,
            idContrato: idContrato,
            idCuota: idCuota
        },
        success: function(data) {
            $('#tablaDocs').empty().html(data);
            $('#nameContratista').html('<i class="fa fa-fw fa-file-contract"></i> ' + nombre);

            // Forzar recarga del PDF (NO usar cache)
            let pdf = document.getElementById('pdfEmbed');
            let srcBase = pdf.getAttribute('data-src-base') || pdf.getAttribute('src');
            srcBase = srcBase.split('?')[0]; // quitar timestamp anterior si ya existe

            pdf.setAttribute('src', srcBase + '?t=' + new Date().getTime());

            $('#modalDocUploadCuota').modal('show');
        }
    });
}

function btnAbrirModalVerDocContratos(idContrato,nombre,Documento){
 
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
            $('#nameContratista').html('<i class="fa fa-fw fa-file-contract"></i> ' + nombre +' - '+ Documento);
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

function AbrirPDFM3(Ruta) {
    const embed = document.getElementById('pdfEmbed');
    if (!embed) return;

    const timestamp = Date.now();
    const randomStr = Math.random().toString(36).substring(2, 8);
    const rutaFinal = (Ruta && Ruta !== '')
        ? `${Ruta}?nocache=${timestamp}&r=${randomStr}`
        : `https://cuentafacil.co/storage/doc_cuenta/predeterminado.pdf?nocache=${timestamp}&r=${randomStr}`;

    embed.src = rutaFinal;

    // Si deseas mostrar el modal desde aquí, descomenta esta línea:
    // $('#modalVerDocCuota').modal('show');
}


function AbrirPDFM(ruta) {
    const contenedor = document.getElementById('pdfContainer');
    if (!contenedor) {
        console.warn("Contenedor PDF no encontrado: #pdfContainer");
        return;
    }

    // Forzar recarga con URL única para evitar caché
    const timestamp = Date.now();
    const randomStr = Math.random().toString(36).substring(2, 8);
    const srcFinal = `${ruta}?nocache=${timestamp}&r=${randomStr}`;

    // Si ya existe un <embed>, actualiza su src en lugar de eliminarlo (más fluido)
    let embed = document.getElementById('pdfEmbed');
    if (embed) {
        embed.setAttribute('src', srcFinal);
    } else {
        // Si no existe, crear uno nuevo
        embed = document.createElement('embed');
        embed.setAttribute('id', 'pdfEmbed');
        embed.setAttribute('type', 'application/pdf');
        embed.setAttribute('src', srcFinal);
        embed.setAttribute('style', 'width: 120%; height: 1600px; border: none;');
        contenedor.appendChild(embed);
    }
}
function AbrirPDFM2(Ruta){ 
    const rutaConCacheBuster = Ruta + '?t=' + new Date().getTime();
    document.getElementById('pdfEmbed').src = rutaConCacheBuster;
    $('#modalVerDocCuota').modal('show'); 
}

// function AbrirPDFM2(Ruta){ 
//     const rutaConCacheBuster = Ruta + '?t=' + new Date().getTime();
//     document.getElementById('pdfEmbed').src = rutaConCacheBuster;
//     $('#modalVerDocCuota').modal('show'); 
// }

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

function cambioEstadoCuenta(event, estado, idContrato) {
  const btn = event.currentTarget;
  if (btn.dataset.processing === "true") return;

  btn.dataset.processing = "true";
  const originalText = btn.innerHTML;

  // Mostrar spinner según estado
  if ([1, 3].includes(estado)) {
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Enviando...';
  } else if (estado === 0) {
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Devolviendo...';
  } else if (estado === 2) {
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Procesando...';
  }

  const miTabla = document.getElementById('tablaDocss');
  const idCuota = document.getElementById('idCuota')?.value;

  if (!miTabla || !idCuota) {
    resetBoton(btn, originalText);
    return Swal.fire({
      text: 'No se encontró la tabla o el campo de cuota.',
      icon: 'error'
    });
  }

  // -------- Validación Estado 1: Aprobar --------
  if (estado === 1) {
    for (let i = 1; i < miTabla.rows.length; i++) {
      const row = miTabla.rows[i];
      const estadoCell = row.cells[0]?.dataset.estado?.trim().toLowerCase() || '';
      if (!estadoCell) continue; // sin documento
      if (estadoCell !== 'aprobada') {
        resetBoton(btn, originalText);
        return Swal.fire({
          text: 'No puedes aprobar: hay al menos un documento pendiente o devuelto.',
          icon: 'error'
        });
      }
    }
  }

  // -------- Validación Estado 0: Devolver --------
  if (estado === 0) {
    let alguna = false;
    for (let i = 1; i < miTabla.rows.length; i++) {
      const estadoCell = miTabla.rows[i].cells[0]?.dataset.estado?.trim().toLowerCase() || '';
      if (estadoCell === 'devuelta') {
        alguna = true;
        break;
      }
    }
    if (!alguna) {
      resetBoton(btn, originalText);
      return Swal.fire({
        text: 'Para devolver debe haber al menos un documento marcado como DEVUELTA.',
        icon: 'error'
      });
    }
  }

  // -------- Validación Estado 2: Hoja de vida firmada --------
  if (estado === 2) {
    const filas = Array.from(miTabla.rows).slice(1);
    const hvRow = filas.find(row => row.cells[1].textContent.trim().toLowerCase() === 'hoja de vida (firmada)');
    if (!hvRow) {
      resetBoton(btn, originalText);
      return Swal.fire({
        text: 'Debe existir el campo "Hoja de vida (Firmada)".',
        icon: 'error'
      });
    }
    const estadoHv = hvRow.cells[0].dataset.estado.trim().toLowerCase();
    if (!['cargado', 'aprobada'].includes(estadoHv)) {
      resetBoton(btn, originalText);
      return Swal.fire({
        text: 'La "Hoja de vida (Firmada)" debe estar en estado CARGADO o APROBADA.',
        icon: 'error'
      });
    }
  }

  // -------- Confirmación Estado 3: Supervisor --------
  if (estado === 3) {
    return Swal.fire({
      title: 'Confirmación de Supervisor',
      text: 'Confirma que sus documentos ya están revisados y firmados por ti como Supervisor?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí, confirmo',
      cancelButtonText: 'No, cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        enviarCambioEstadoCuenta(estado, idCuota, idContrato, btn, originalText);
      } else {
        resetBoton(btn, originalText);
      }
    });
  }

  // -------- Enviar si no era estado 3 --------
  enviarCambioEstadoCuenta(estado, idCuota, idContrato, btn, originalText);
}

function enviarCambioEstadoCuenta(estado, idCuota, idContrato, btn, originalText) {
  $.ajax({
    url: '/cambioEstadoCuenta',
    type: 'GET',
    data: { _token: dataToken, estado, idCuota, idContrato },
    success() {
      let msg = 'Cuenta actualizada.', icon = 'success';
      if (estado === 0)      { msg = 'Cuenta devuelta.'; icon = 'error'; }
      else if (estado === 2) { msg = 'Hoja de vida enviada para firma.'; icon = 'info'; }
      else if (estado === 3) { msg = 'Cuenta enviada para revisión.'; icon = 'info'; }

      Swal.fire({ text: msg, icon });
      $('#modalDocUploadCuota').modal('hide');
      setTimeout(() => location.reload(), 1000);
    },
    error() {
      resetBoton(btn, originalText);
      Swal.fire({ text: 'Error al cambiar el estado.', icon: 'error' });
    }
  });
}

function resetBoton(btn, originalText) {
  btn.disabled = false;
  btn.innerHTML = originalText;
  btn.dataset.processing = "false";
}
 

$(document).ready(function () {
    $('#tabAprobadas').on('click', function () {
        $('#pendientes').removeClass('show active');
        $('#enviadas').removeClass('show active');
        $('#aprobadas').addClass('show active');
        $('#devueltas').removeClass('show active');
        $('#contratacion').removeClass('show active'); 
        $('#entradas').removeClass('show active'); 
        $('#todas').removeClass('show active'); 
    });

    $('#tabPendientes').on('click', function () {
        $('#aprobadas').removeClass('show active');
        $('#pendientes').addClass('show active');
        $('#devueltas').removeClass('show active');
        $('#enviadas').removeClass('show active');
        $('#contratacion').removeClass('show active');
        $('#entradas').removeClass('show active');
        $('#todas').removeClass('show active');   
    });

    $('#tabDevueltas').on('click', function () {
        $('#aprobadas').removeClass('show active');
        $('#pendientes').removeClass('show active');
        $('#devueltas').addClass('show active');
        $('#enviadas').removeClass('show active');
        $('#contratacion').removeClass('show active'); 
        $('#entradas').removeClass('show active'); 
        $('#todas').removeClass('show active');
    });

    $('#tabEnviadas').on('click', function () {
        $('#aprobadas').removeClass('show active');
        $('#pendientes').removeClass('show active');
        $('#enviadas').addClass('show active');
        $('#devueltas').removeClass('show active');
        $('#contratacion').removeClass('show active'); 
        $('#entradas').removeClass('show active'); 
        $('#todas').removeClass('show active');
    });

    $('#tabContratacion').on('click', function () {
        $('#aprobadas').removeClass('show active');
        $('#pendientes').removeClass('show active');
        $('#enviadas').removeClass('show active');
        $('#devueltas').removeClass('show active');
        $('#contratacion').addClass('show active'); 
        $('#entradas').removeClass('show active'); 
        $('#todas').removeClass('show active');        
    });

    $('#tabEntrada').on('click', function () {
        $('#aprobadas').removeClass('show active');
        $('#pendientes').removeClass('show active');
        $('#enviadas').removeClass('show active');
        $('#devueltas').removeClass('show active');
        $('#contratacion').removeClass('show active'); 
        $('#entradas').addClass('show active'); 
        $('#todas').removeClass('show active');
    });

    $('#todas').on('click', function () {
        $('#aprobadas').removeClass('show active');
        $('#pendientes').removeClass('show active');
        $('#enviadas').removeClass('show active');
        $('#devueltas').removeClass('show active');
        $('#contratacion').removeClass('show active'); 
        $('#entradas').removeClass('show active'); 
        $('#todas').addClass('show active');
    });

    
});

    // Guardar la última pestaña activa
document.addEventListener('DOMContentLoaded', function () {
    // Restaurar pestaña activa desde localStorage
    const lastTab = localStorage.getItem('ultimaTabActiva');
    if (lastTab) {
        const triggerEl = document.querySelector(`a[href="${lastTab}"]`);
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }

    // Guardar pestaña activa al cambiar
    document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {
            localStorage.setItem('ultimaTabActiva', e.target.getAttribute('href'));
        });
    });
});

$(document).on('change', '.inputEntrada', function () {
    const input = $(this);
    const idCuota = input.data('id');
    const nuevoValor = input.val();

    fetch('/actualizarEntrada', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            idCuota: idCuota,
            entrada: nuevoValor
        })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            input.css('border-color', 'green');

            Swal.fire({
                icon: 'success',
                title: 'Entrada actualizada',
                text: 'La entrada fue guardada correctamente.',
                timer: 1500,
                showConfirmButton: false
            });

        } else {
            input.css('border-color', 'red');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo guardar la entrada.'
            });
        }
    })
    .catch(() => {
        input.css('border-color', 'red');
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'Ocurrió un problema al conectar con el servidor.'
        });
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


function EntradasRadicadas(idLote) {
    let todoCorrecto = true;

    // Buscar la tabla anidada correspondiente al lote
    const tabla = $(`.tr-principal:has(td:contains(${idLote}))`).find('.tabla-anidada');

    // Recorrer todas las filas de la tabla anidada (excepto la cabecera)
    tabla.find('tr').not(':first').each(function () {
        const entradaInput = $(this).find('.inputEntrada');
        const valor = entradaInput.val()?.trim();

        if (!valor) {
            entradaInput.css('border-color', 'red');
            todoCorrecto = false;
        } else {
            entradaInput.css('border-color', '');
        }
    });

    if (!todoCorrecto) {
        Swal.fire({
            icon: 'error',
            title: 'Entradas incompletas',
            text: 'Debes llenar todos los campos de Entrada antes de aprobar el paquete.'
        });
        return;
    }

    // Si todo está correcto, llamar a tu función de aprobación
    aprobarLoteCuotas(idLote); // o el nombre que tengas para procesar el cambio de estado
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


 
function contabilizar(idFuid) {
    Swal.fire({
        title: "Número de radicado Z-Control",
        input: "text",
        inputAttributes: {
            inputmode: "numeric", // Muestra teclado numérico en móviles
            pattern: "[0-9]*",
            maxlength: 30 // Permite hasta 30 dígitos, puedes ajustar
        },
        showCancelButton: true,
        confirmButtonText: "Aprobar",
        showLoaderOnConfirm: true,
        preConfirm: async (numeroRadicado) => {
            if (!numeroRadicado || !/^\d+$/.test(numeroRadicado)) {
                throw new Error("Debes ingresar solo números.");
            }

            try {
                const response = await fetch('/actualizar_radicado_sap', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        radicado: numeroRadicado,
                        idFuid: idFuid
                    })
                });

                if (!response.ok) {
                    const errorText = await response.text(); // Evita error al parsear HTML
                    throw new Error("Error en servidor: " + errorText);
                }

                const data = await response.json();

                if (data.status !== 'ok') {
                    throw new Error(data.message || 'Error en la actualización');
                }

                return numeroRadicado;

            } catch (error) {
                Swal.showValidationMessage(`Error: ${error.message}`);
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: `Radicado ${result.value} actualizado`,
                imageUrl: "https://crearhogares.com/wp-content/uploads/2022/03/74623-email-successfully-sent.gif",
                imageWidth: 100,
                imageHeight: 100,
                confirmButtonText: "Ok"
            }).then((r) => {
                if (r.isConfirmed) {
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

$(document).ready(function () {
        $('#tablaDocs').DataTable({
            pageLength: 5,
            lengthChange: false,
            ordering: false,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });


    document.addEventListener('DOMContentLoaded', () => {
    const firmaWrapper = document.getElementById("firma-wrapper");
    const firma = document.getElementById("firmaFlotante");
    const btnFirma = document.getElementById("btnGuardarFirma");
    const btnMoverFirma = document.getElementById("btnMoverFirma");
    const pdfFrame = document.getElementById("pdfEmbed");
    const pdfContainer = document.getElementById("pdfContainer");

    let currentRutaPDF = '';
    let currentContrato = '';
    let currentCuota = '';

    // Iniciar firma desde modal
    window.iniciarFirma = function (ruta, idContrato, idCuota) {
        currentRutaPDF = ruta;
        currentContrato = idContrato;
        currentCuota = idCuota;

        pdfFrame.src = ruta.split('?')[0] + '?t=' + new Date().getTime();

        const visibleTop = pdfContainer.scrollTop;
        const visibleHeight = pdfContainer.clientHeight;

        firmaWrapper.style.top = `${visibleTop + visibleHeight / 2}px`;
        firmaWrapper.style.left = `50px`;
        firmaWrapper.style.display = 'block';
        btnFirma.style.display = 'inline-block';
    };

    // Drag con botón
    let isDraggingFirma = false;

    btnMoverFirma.addEventListener('mousedown', function (e) {
        e.preventDefault();
        isDraggingFirma = true;
        document.addEventListener('mousemove', moverFirma);
        document.addEventListener('mouseup', soltarFirma);
    });

    function moverFirma(e) {
        if (!isDraggingFirma) return;
        const containerRect = pdfContainer.getBoundingClientRect();
        const scrollX = pdfContainer.scrollLeft;
        const scrollY = pdfContainer.scrollTop;

        let x = e.clientX - containerRect.left + scrollX - firmaWrapper.offsetWidth / 2;
        let y = e.clientY - containerRect.top + scrollY - btnMoverFirma.offsetHeight / 2;

        firmaWrapper.style.left = `${Math.max(0, x)}px`;
        firmaWrapper.style.top = `${Math.max(0, y)}px`;
    }

    function soltarFirma() {
        isDraggingFirma = false;
        document.removeEventListener('mousemove', moverFirma);
        document.removeEventListener('mouseup', soltarFirma);
    }

    // Guardar firma (posición relativa)
    btnFirma.onclick = function () {
        const embed = document.getElementById('pdfEmbed');
        const embedRect = embed.getBoundingClientRect();
        const containerRect = pdfContainer.getBoundingClientRect();
        const wrapperRect = firmaWrapper.getBoundingClientRect();

        // Relativo al PDF visualizado
        const relX = (wrapperRect.left - containerRect.left + pdfContainer.scrollLeft) / embed.offsetWidth;
        const relY = (wrapperRect.top - containerRect.top + pdfContainer.scrollTop) / embed.offsetHeight;
        const relW = firmaWrapper.offsetWidth / embed.offsetWidth;
        const relH = firmaWrapper.offsetHeight / embed.offsetHeight;

        console.log(`📐 Firma relativa: x=${relX}, y=${relY}, w=${relW}, h=${relH}`);

        fetch('/firmar-pdf-embed', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
          body: JSON.stringify({
              ruta: currentRutaPDF,
              idContrato: currentContrato,
              idCuota: currentCuota,
              x: x,
              y: y,
              ancho: ancho,
              alto: alto,
              pagina: currentPaginaSeleccionada // 👈 Asegúrate de tener este valor
          })
        })
        .then(async res => {
            const text = await res.text();
            try {
                const json = JSON.parse(text);
                if (json.success) {
                    Swal.fire('✅ Firma aplicada');
                    pdfFrame.src = currentRutaPDF.split('?')[0] + '?t=' + new Date().getTime();
                } else {
                    Swal.fire('❌ Error al guardar', text);
                }
            } catch (e) {
                console.error('❌ JSON inválido:', text);
                Swal.fire('❌ Error inesperado', text);
            }
        })
        .catch(err => {
            console.error('❌ Error fetch:', err);
            Swal.fire('❌ Error inesperado', err.message);
        });
    };
});

// Función externa por si se desea usar desde fuera
function iniciarFirmaDesdeSeleccion() {
    const ruta = document.getElementById('pdfEmbed')?.getAttribute('src');
    const idContrato = document.getElementById('idContrato')?.value;
    const idCuota = document.getElementById('idCuota')?.value;

    if (!ruta || !idContrato || !idCuota) {
        Swal.fire('❌ No hay documento cargado');
        return;
    }

    iniciarFirma(ruta, idContrato, idCuota);
}

    function cargarPDFActualizado(rutaPDF) {
        fetch(rutaPDF.split('?')[0] + '?t=' + new Date().getTime())
            .then(res => res.blob())
            .then(blob => {
                const url = URL.createObjectURL(blob);
                document.getElementById('pdfEmbed').src = url;
            });
    } 

let isDragging = false;
let offsetX, offsetY;
let canvasPDF, firmaWrapper;

// function abrirModalFirma() {
//   const modal = new bootstrap.Modal(document.getElementById('modalCanvasFirma'));
//   modal.show();

//   canvasPDF = document.getElementById('canvasPDF');
//   firmaWrapper = document.getElementById('firmaCanvasWrapper');

//   // Inicializa posición de firma
//   firmaWrapper.style.display = 'block';
//   firmaWrapper.style.left = '50px';
//   firmaWrapper.style.top = '100px';

//   cargarImagenEnCanvas('/storage/pdfs/firmado.pdf'); // o tu ruta
// }

function cargarImagenEnCanvas(rutaPDFConvertidoEnImagen) {
  const ctx = canvasPDF.getContext('2d');
  const img = new Image();
  img.src = rutaPDFConvertidoEnImagen;
  img.onload = () => {
    canvasPDF.width = img.width;
    canvasPDF.height = img.height;
    ctx.drawImage(img, 0, 0);
  };
}

// Mover firma
firmaWrapper.addEventListener('mousedown', e => {
  isDragging = true;
  offsetX = e.offsetX;
  offsetY = e.offsetY;
});

document.addEventListener('mouseup', () => isDragging = false);

document.addEventListener('mousemove', e => {
  if (!isDragging) return;
  firmaWrapper.style.left = `${e.pageX - offsetX}px`;
  firmaWrapper.style.top = `${e.pageY - offsetY - 50}px`; // ajusta el -50px por el header
});

// Guardar posición
function guardarFirmaDesdeCanvas() {
  const canvasRect = canvasPDF.getBoundingClientRect();
  const firmaRect = firmaWrapper.getBoundingClientRect();

  const relX = (firmaRect.left - canvasRect.left) / canvasRect.width;
  const relY = (firmaRect.top - canvasRect.top) / canvasRect.height;
  const relW = firmaWrapper.offsetWidth / canvasRect.width;
  const relH = firmaWrapper.offsetHeight / canvasRect.height;

  console.log('✅ Posición de firma desde canvas:', { relX, relY, relW, relH });

  // Aquí haces fetch('/firmar-pdf-embed', { body: JSON.stringify(...) }) con los datos
  // o cierras el modal y pasas las coordenadas a la vista original
}

 
function abrirModalFirma(rutaPDF, idContrato, idCuota, rutaFirma, idCargue) {
    if (!rutaPDF || !idContrato || !idCuota || !rutaFirma) {
        Swal.fire("❌ Datos incompletos para firmar"); 
        return;
    }

    const iframe = document.getElementById('iframeFirmador');
    if (!iframe) {
        Swal.fire("❌ No se encontró el visor de firma");
        return;
    }

    const params = new URLSearchParams({
        file: rutaPDF,
        idContrato,
        idCuota,
        idCargue,
        firma: rutaFirma,
        t: Date.now(),
        r: Math.random().toString(36).substring(2, 8)
    });

    iframe.src = `/firmar-viewer?${params.toString()}`;
    $('#modalPosicionarFirma').modal('show');
}

 