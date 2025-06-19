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
            url: ('/cf/public/registroCuota'),
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

    var miIdContrato = idContrato;
    var cuota = document.getElementById('Cuota');
    var fecActa = document.getElementById('fecActa');
    var numPlantilla = document.getElementById('numPlantilla');
    var pinPlantilla = document.getElementById('pinPlantilla');
    var Operador = document.getElementById('Operador');
    var fecPago = document.getElementById('fecPago');
    var periodoPlanilla = document.getElementById('periodoPlanilla');
    var Actividades = document.getElementById('Actividades');
    Actividades.value = Actividades.value.replace(/\n/g, '<br>');

    if (!cuota.value || !fecActa.value || !numPlantilla.value || !pinPlantilla.value || !Operador.value || !fecPago.value || !periodoPlanilla.value || !Actividades.value) {

        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Debes llenar todos los campos!',
            footer: ''
        });

    } else {
        Swal.fire({
            title: "Aplicando correcciones",
            text: "Corriguiendo ortografia y generando actividades en primera y tercera persona. ¡Espere por favor!",
            imageUrl: "https://cdn.pixabay.com/animation/2023/05/02/04/29/04-29-06-428_512.gif",
            imageWidth: 70,
            imageHeight: 70,
            imageAlt: "Custom image",
            showConfirmButton: false,  // Oculta el botón "OK"
            didOpen: async () => {
                try {
                    // Utiliza await para esperar la respuesta de la llamada AJAX
                    const response = await $.ajax({
                        url: ('/cf/public/registroCuota'),
                        type: 'POST',
                        data: {
                            _token: dataToken,
                            miIdContrato: miIdContrato,
                            cuota: cuota.value,
                            fecActa: fecActa.value,
                            Actividades: Actividades.value,
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
                    cuota.value = '';
                    fecActa.value = '';
                    numPlantilla.value = '';
                    pinPlantilla.value = '';
                    Operador.value = '';
                    fecPago.value = '';
                    periodoPlanilla.value = '';
                    Actividades.value = '';
        
                    Swal.fire({
                        text: "Datos guardados exitosamente.",
                        icon: "success"
                    });
        
                    $('#modalRegCuota').modal('hide');
                    btnRegistrarCuenta(miIdContrato);
        
                } catch (error) {
                    // Manejo de errores, puedes mostrar un mensaje de error o realizar alguna acción específica.
                    console.error(error);
                    Swal.fire({
                        text: "Hubo un error al procesar la solicitud.",
                        icon: "error"
                    });
                }
            },
            // allowOutsideClick: false
        });
    }
}



function btnRegistrarCuenta(id){
        idContrato = id;
        $.ajax({
            url: ('/cf/public/tablaCuotas'),
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
            url: ('/cf/public/btnMostrarPDF'),
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
        url: ('/cf/public/gpdf'),
        type:'get',
        data: {_token:dataToken, id:idFormato,idCuota:idCuota},
        success: function(data) {
            // Abrir la URL en una nueva pestaña
            var nuevaPestana = window.open('', '_blank');
            
            // Escribir el contenido HTML en el elemento con id 'render' en la nueva pestaña
            nuevaPestana.document.write('<html><head><link rel="icon" href="http://avapp.digital/cf/public/images/logo_CuentaFacil/icon_only/color_with_background.ico"><title>' + nombreFormato + ' | CuentaFacil</title></head><body>');
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
    var fecActa = document.getElementById('fecActa');
    var numPlantilla = document.getElementById('numPlantilla');
    var pinPlantilla = document.getElementById('pinPlantilla');
    var Operador = document.getElementById('Operador');
    var fecPago = document.getElementById('fecPago');
    var periodoPlanilla = document.getElementById('periodoPlanilla');
    var Actividades = document.getElementById('Actividades');
    
    $.ajax({
        url: ('/cf/public/nextCuenta'),
        type:'get',
        data: {_token:dataToken, idContrato:idContrato},
        success: function(data) {
            cuota.value = data[0].cuota;
            fecActa.value = '';
            numPlantilla.value = '';
            pinPlantilla.value = '';
            Operador.value = '';
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
    datos = datos.replace(/	/g, ' ');
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
    // Actividades.value = Actividades.value.replace('<br>',/\n/g);
    
    cuota.value = datos.Cuota
    fecActa.value = datos.Fecha_Acta
    numPlantilla.value = datos.Planilla
    pinPlantilla.value = datos.Pin_planilla
    Operador.value = datos.Operador_planilla
    fecPago.value = datos.Fecha_pago_planilla
    periodoPlanilla.value = datos.Perioro_Planilla
    Actividades.value = datos.Actividades.replace(/<br>/g, '\n')

    $('#modalRegCuota').modal('show');
}



function btnAbrirModalCarguePDF(idContrato,idCuota){
    
    $.ajax({
        url: ('/cf/public/cargueDoc'),
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
            fetch('/cf/public/uploadFile', {
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

function AbrirPDFM(Ruta){
    console.log(Ruta)
    document.getElementById('pdfEmbed').src = Ruta;
    $('#modalVerDocCuota').modal('show');

}

function btnEnvioCuenta(idContrato){
    // Obtener la referencia a la tabla
    var miTabla = document.getElementById('tablaDocss');
    var idCuota = document.getElementById('idCuota').value;
    var idContrato = document.getElementById('idContrato').value;
    console.log(miTabla)
    // Bandera para indicar si todos los registros están cargados
    var todosCargados = true;

    // Iterar sobre las filas de la tabla
    for (var i = 1, row; row = miTabla.rows[i]; i++) {
        // Asegurarse de que hay al menos tres celdas (para evitar errores si algunas filas son más cortas)
        if (row.cells.length >= 2) {
            // Obtener el valor de la segunda celda (índice 1 en base a cero)
            var valorCelda = row.cells[1].innerText;

            // Verificar si el valor no es "Cargado"
            if (valorCelda.trim().toLowerCase() !== "cargado") {
                if (valorCelda.trim().toLowerCase() !== "aprobada") {
                    todosCargados = false;
                    break;  // No es necesario seguir verificando si ya encontramos uno no cargado
                }
            }
        }
    }

    // Mostrar el resultado en la consola (puedes hacer lo que desees con el resultado)
    if (todosCargados) {
        $.ajax({
            url: ('/cf/public/btnEnviarCuota'),
            type:'get',
            data: {_token:dataToken, idCuota:idCuota, idContrato:idContrato},
            success: function(data) {
                $('#tablaCuotas').empty();
                $('#tablaCuotas').html(data);
                $('#modalDocUploadCuota').modal('hide');
                Swal.fire({
                    text: "Cuenta enviada exitosamente.",
                    imageUrl: "https://crearhogares.com/wp-content/uploads/2022/03/74623-email-successfully-sent.gif",
                    imageWidth: 200,
                    imageHeight: 200,
                    imageAlt: "Custom image"
                  });
            }
        });
    } else {
        Swal.fire({
            // title: "The Internet?",
            text: "Al menos un documento no está cargado.",
            icon: "error"
          });
    }

     

    
}