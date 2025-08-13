 
 
<table id="tablaDocss" class="table table-striped table-hover" name="tablaDocs">
    <thead class="thead2">
        <tr>
            <th style="text-align: center;">Est</th>
            <th>Nombre del Archivo</th> 
            <th>Observacion</th>
            <th colspan="3"></th>
        </tr>
    </thead>
    <tbody>
         
            @foreach($datos as $dato)
            <tr class="tr-principal" @if($dato->Ruta) onclick="AbrirPDFM3('{{$dato->Ruta}}')" @endif> 
                <td class="align-middle" data-estado="{{ strtolower($dato->Estado) }}" style="width:50px; text-align:center" >
                        @if($dato->Ruta)
                            @if($dato->Estado == 'DEVUELTA')
                            <i class="fa-regular fa-circle-xmark fa-2x" style="color:#f00"></i>
                            @elseif($dato->Estado == 'APROBADA')
                            <i class="fa-regular fa-circle-check fa-2x" style="color:#568c1d"></i>
                            @else
                            <i class="fa-regular fa-file fa-2x" style="color:#FFD43B"></i>
                            @endif
                        @endif
                </td>
                <td class="align-middle" style="font-size: 13px">
                    {{ $dato->Nombre }}
                </td> 
                <td class="align-middle"> 
                    {!! Form::textarea('observacion', $dato->Observacion,["style" => "height: 30px;width: 90%;max-height: 90px;min-height: 30px", 'id' => 'obs_' .$dato->Id_cargue_archivo]) !!}
                </td>
                <td colspan="3" style="padding-left: 2px; padding-right: 2px; min-width: 100px;"> 
                    
                    @if($perfil == 12 )                             
                        {{-- BOTONES DEVOLVER Y ADJUNTAR --}}
                        <a href="#" class="btn btn-sm btn-danger"
                            onclick="event.preventDefault(); event.stopImmediatePropagation(); cambioEstado({{ $dato->Id_cargue_archivo }}, 'DEVUELTA', {{ $dato->idCuota }}, {{ $dato->idContrato }})">
                            <i class="fa-regular fa-circle-xmark"></i>
                        </a>

                        <a href="#" class="btn btn-sm btn-light"
                            onclick="event.preventDefault(); event.stopImmediatePropagation(); selccionarArchivo1({{ $dato->Id }}, {{ $dato->idContrato }}, {{ $dato->idCuota }})">
                            <i class="fa-solid fa-paperclip"></i>
                        </a>
                        
                            @php
                                $rutaFirma = DB::table('Base_Datos')->where('Documento', auth()->user()->usuario)->value('firma');
                                $rutaPDF = $dato->Ruta ? asset('storage/' . ltrim($dato->Ruta, '/')) : '';
                                $rutaFirmaCompleta = $rutaFirma ? asset('storage/' . ltrim($rutaFirma, '/')) : '';
                            @endphp
                        
                          @if (in_array($dato->Id, [2,7,37]))
                            <a href="#" class="btn btn-sm btn-warning"
                                onclick="abrirModalFirma('{{ $dato->Ruta }}', {{ $dato->idContrato }}, {{ $dato->idCuota }}, '{{ asset('storage/' . $rutaFirma) }}', {{ $dato->Id }})">
                                <i class="fa-solid fa-pen-nib"></i> Firmar
                            </a>
                          @endif
                         
                        {{-- FORMULARIO DE ELIMINACIÓN (SIN BOTONES DENTRO) --}}
                        <form action="{{ route('contratos.destroy', $dato->Id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                        </form> 
                    @else
                        @if($dato->Ruta)
                            <a href="#" class="btn btn-sm btn-danger"
                                onclick="event.preventDefault(); event.stopImmediatePropagation(); cambioEstado({{ $dato->Id_cargue_archivo }}, 'DEVUELTA', {{ $dato->idCuota }}, {{ $dato->idContrato }})">
                                <i class="fa-regular fa-circle-xmark"></i>
                            </a>

                            <a href="#" class="btn btn-sm btn-success"
                                onclick="event.preventDefault(); event.stopImmediatePropagation(); cambioEstado({{ $dato->Id_cargue_archivo }}, 'APROBADA', {{ $dato->idCuota }}, {{ $dato->idContrato }})">
                                <i class="fa-solid fa-check"></i>
                            </a>
                            
                            {{-- FORMULARIO DE ELIMINACIÓN --}}
                            <form action="{{ route('contratos.destroy', $dato->Id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif

                        @if($dato->Id == '37')
                            <a href="#" class="btn btn-sm btn-light"
                                onclick="event.preventDefault(); event.stopImmediatePropagation(); selccionarArchivo1({{ $dato->Id }}, {{ $dato->idContrato }}, {{ $dato->idCuota }})">
                                <i class="fa-solid fa-paperclip"></i>
                            </a>
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
       

    </tbody>

</table>
@if($perfil == 12)
<div class="modal-footer">
    <a class="btn btn-md btn-danger btn-devolver"
       onclick="cambioEstadoCuenta(event, 0, {{ $dato->idContrato ?? 'null' }})"
       style="margin-right: 3px">
       <i class="fa-solid fa-file-circle-xmark"></i> Devolver
    </a>

    <a class="btn btn-md btn-success btn-aprobar"
       onclick="cambioEstadoCuenta(event, 3, {{ $dato->idContrato ?? 'null' }})"
       style="margin-right: 3px">
       <i class="fa-solid fa-file-circle-check"></i> Enviar Cuenta
    </a>
</div>
@else
    @if($estadoContrato == 'En Ejecución')
    <div class="modal-footer">
        <a class="btn btn-md btn-danger btn-devolver"
           onclick="cambioEstadoCuenta(event, 0, {{ $dato->idContrato ?? 'null' }})"
           style="margin-right: 3px">
           <i class="fa-solid fa-file-circle-xmark"></i> Devolver
        </a>

        <a class="btn btn-md btn-success btn-aprobar"
           onclick="cambioEstadoCuenta(event, 1, {{ $dato->idContrato ?? 'null' }})"
           style="margin-right: 3px">
           <i class="fa-solid fa-file-circle-check"></i> Aprobar
        </a>
    </div>
    @else
    <div class="modal-footer">
        @if($estadoContrato == 'Documentos Aprobados')
        <a class="btn btn-md btn-warning btn-firmar"
           onclick="cambioEstadoCuenta(event, 2, {{ $dato->idContrato ?? 'null' }})"
           style="margin-right: 3px">
           <i class="fa-solid fa-file-circle-check"></i> Devolver Para Firmar
        </a>
        @else
        <a class="btn btn-md btn-danger btn-devolver"
           onclick="cambioEstadoCuenta(event, 0, {{ $dato->idContrato ?? 'null' }})"
           style="margin-right: 3px">
           <i class="fa-solid fa-file-circle-xmark"></i> Devolver
        </a>

        <a class="btn btn-md btn-success btn-aprobar"
           onclick="cambioEstadoCuenta(event, 1, {{ $dato->idContrato ?? 'null' }})"
           style="margin-right: 3px">
           <i class="fa-solid fa-file-circle-check"></i> Aprobar
        </a>
        @endif
    </div>
    @endif
@endif

@if($estadoContrato == 'En Ejecución')
@else
<button type="button" class="btn btn-secondary btnHistorialDoc" data-id="{{ $dato->idContrato ?? 'null' }}">Historial de Documentos</button>
@endif 
<input type="text" value="{{$dato->idCuota}}" style="display: none" id="idCuota">
<input type="text" value="{{$dato->idContrato}}" style="display: none" id="idContrato">
<input type="text" value="{{$estadoContrato}}" style="display: none" id="estadoContrato">

 
{{-- MODAL BITACORA --}}
<div class="modal fade" id="modal2" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 85%; margin: 1rem auto; height: 95vh;">
        <div class="modal-content shadow-lg rounded-3" style="height: 90%; overflow: hidden;">

            <!-- HEADER -->
            <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                color: white; font-family: 'Mallanna'; font-size: 17px;">
                <h5 class="modal-title text-dark fw-bold">📜 Historial del Contrato </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar"
                        style="font-size: 1.5rem; color: white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body p-2 overflow-auto" style="height: calc(100vh - 56px);">
                <div id="modal2Body">
                    Cargando...
                </div> 
            </div> 

        </div>
    </div>
</div>

<script>
 
        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('btnHistorialDoc')) {
                const idContrato = e.target.getAttribute('data-id');
                const modal = new bootstrap.Modal(document.getElementById('modal2'));
                modal.show();

                fetch(`/contratos/${idContrato}/historial-documentos`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('modal2Body').innerHTML = html;
                    })
                    .catch(error => {
                        document.getElementById('modal2Body').innerHTML =
                            `<div class="alert alert-danger">Error al cargar historial.</div>`;
                        console.error(error);
                    });
            }
            if (e.target.closest('.btn-firmar')) {
                    e.stopImmediatePropagation();
                    e.preventDefault();
                const btn = e.target.closest('.btn-firmar');
                const ruta = btn.dataset.ruta;
                const idContrato = btn.dataset.contrato;
                const idCuota = btn.dataset.cuota;

                console.log("✅ iniciarFirma", ruta, idContrato, idCuota);
                iniciarFirma(ruta, idContrato, idCuota);
            }

        });

        function selccionarArchivo1(idFormato, idContrato, idCuota) {
            // Crear un input de tipo file en memoria y hacer clic en él
            var inputPDF = document.createElement('input');
            inputPDF.type = 'file';
            inputPDF.accept = '.pdf';
            inputPDF.style.display = 'none';

            inputPDF.addEventListener('change', function() {
                // Archivo seleccionado
                var archivoSeleccionado = this.files[0];
                
                if (!archivoSeleccionado) {
                    // No se seleccionó ningún archivo, no hacemos nada.
                    return; 
                }

                // 1. Mostrar mensaje de "Cargando..."
                Swal.fire({
                    title: 'Cargando archivo',
                    text: 'Por favor, espere mientras se sube el documento...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Enviar el formulario con el archivo seleccionado
                var formulario = new FormData();
                formulario.append('archivo_pdf', archivoSeleccionado);
                formulario.append('idFormato', idFormato);
                formulario.append('idContrato', idContrato);
                formulario.append('estadoContrato', estadoContrato);
                formulario.append('idCuota', idCuota);
                formulario.append('_token', dataToken); // Asegúrate que 'dataToken' esté disponible

                fetch('/uploadHV', {
                    method: 'POST',
                    body: formulario
                })
                .then(response => {
                    if (!response.ok) {
                        // Si la respuesta del servidor no es exitosa, lanzamos un error
                        throw new Error('Error del servidor: ' + response.status);
                    }
                    return response.text(); // Esperamos HTML como respuesta
                })
                .then(html => {
                    $('#tablaDocs').html(html);

                    Swal.fire({
                        icon: 'success',
                        title: '¡Archivo Cargado!',
                        text: 'El documento se ha cargado correctamente.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // ✅ Buscar el nuevo PDF en la tabla actualizada
                    setTimeout(() => {
                        const primerBoton = document.querySelector('tr.tr-principal[data-pdf]');
                        if (primerBoton) {
                            const rutaPDF = primerBoton.getAttribute('data-pdf');
                            AbrirPDFM(rutaPDF);
                        }
                    }, 500);
                })
                .catch(error => {
                    console.error('Error:', error);
                    // 4. Mostrar mensaje de error si algo sale mal
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al cargar',
                        text: 'Hubo un problema al subir el archivo. Por favor, inténtelo de nuevo.'
                    });
                });
            });

            document.body.appendChild(inputPDF);
            inputPDF.click();
            document.body.removeChild(inputPDF);
        }
  
</script>

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
  
    {{Html::script(asset('js/juridica/juridica.js'))}}
@endsection
