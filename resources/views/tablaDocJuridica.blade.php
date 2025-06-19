<table id="tablaDocss" class="table table-striped table-hover" name="tablaDocs">
    <thead class="thead2">
        <tr>
            <th>Est</th>
            <th>Nombre del Archivo</th>
            {{-- <th>Estado</th> --}}
            <th>Observacion</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        <div class="row">
            @foreach($datos as $dato)
            <tr  class="tr-principal" @if($dato->Ruta) onclick="AbrirPDFM('{{$dato->Ruta}}')" @endif>
                <td  data-estado="{{ strtolower($dato->Estado) }}" style="width:50px; text-align:center" >
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
                <td style="font-size: 14px" > 
                    {{ $dato->Nombre }}
                </td> 
                <td> 
                    {!! Form::textarea('observacion', $dato->Observacion,["style" => "height: 30px;width: 90%;max-height: 90px;min-height: 30px", 'id' => 'obs_' .$dato->Id_cargue_archivo]) !!}
                </td>
                <td colspan="2" style="padding-left: 2px; padding-right: 2px; min-width: 100px;">
                    @if($perfil == 12) 
                        <form action="{{ route('contratos.destroy', $dato->Id) }}" method="POST"> 
                                    <a class="btn btn-sm btn-danger" onclick="event.stopPropagation(); cambioEstado({{$dato->Id_cargue_archivo}}, 'DEVUELTA', {{$dato->idCuota}}, {{$dato->idContrato}})"><i class="fa-regular fa-circle-xmark"></i></a>                                
                                    <a class="btn btn-sm btn-light" onclick="selccionarArchivo1({{ $dato->Id }}, {{ $dato->idContrato }}, {{ $dato->idCuota }})"><i class="fa-solid fa-paperclip"></i></a>
                                @csrf
                            @method('DELETE')
                        </form> 
                    @else
                    @if($dato->Ruta)
                        <form action="{{ route('contratos.destroy', $dato->Id) }}" method="POST"> 
                                <a class="btn btn-sm btn-danger" onclick="cambioEstado({{$dato->Id_cargue_archivo}},'DEVUELTA',{{$dato->idCuota}},{{$dato->idContrato}})"><i class="fa-regular fa-circle-xmark"></i></a>
                                <a class="btn btn-sm btn-success" onclick="cambioEstado({{$dato->Id_cargue_archivo}},'APROBADA',{{$dato->idCuota}},{{$dato->idContrato}})"><i class="fa-solid fa-check"></i></a>
 
                                @csrf
                            @method('DELETE')
                        </form>
                    @endif
                    @if($dato->Id == '37')
                            <a class="btn btn-sm btn-light" onclick="selccionarArchivo1({{ $dato->Id }}, {{ $dato->idContrato }}, {{ $dato->idCuota }})"><i class="fa-solid fa-paperclip"></i></a>
                    @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </div>

    </tbody>

</table>
 @if($perfil == 12) 
<div class="modal-footer">
    <a class="btn btn-md btn-danger" onclick="cambioEstadoCuenta(0, {{ isset($dato) ? $dato->idContrato : 'null' }})" style="margin-right: 3px" id="btnDevolver">   <i class="fa-solid fa-file-circle-xmark" ></i> Devolver</a>
    <a class="btn btn-md btn-success" onclick="cambioEstadoCuenta(3, {{ isset($dato) ? $dato->idContrato : 'null' }})" style="margin-right: 3px" id="btnAprobar3">   <i class="fa-solid fa-file-circle-check" ></i> Enviar Cuenta</a>
</div>                         
 @else
        @if($estadoContrato == 'Vigente') 
        <div class="modal-footer">
            <a class="btn btn-md btn-danger" onclick="cambioEstadoCuenta(0, {{ isset($dato) ? $dato->idContrato : 'null' }})" style="margin-right: 3px" id="btnDevolver">   <i class="fa-solid fa-file-circle-xmark" ></i> Devolver</a>
            <a class="btn btn-md btn-success" onclick="cambioEstadoCuenta(1, {{ isset($dato) ? $dato->idContrato : 'null' }})" style="margin-right: 3px" id="btnAprobar">   <i class="fa-solid fa-file-circle-check" ></i> Aprobar</a>
        </div>     
        @else
            <div class="modal-footer">
                
                                @if($estadoContrato == 'Documentos Aprobados')
                                <a class="btn btn-md btn-warning" onclick="cambioEstadoCuenta(2, {{ isset($dato) ? $dato->idContrato : 'null' }})" style="margin-right: 3px" id="btnDevolverHV"><i class="fa-solid fa-file-circle-check" ></i> Devolver Para Firmar</a>
                                @else
                                <a class="btn btn-md btn-danger" onclick="cambioEstadoCuenta(0, {{ isset($dato) ? $dato->idContrato : 'null' }})" style="margin-right: 3px" id="btnDevolver">   <i class="fa-solid fa-file-circle-xmark" ></i> Devolver</a>
                                <a class="btn btn-md btn-success" onclick="cambioEstadoCuenta(1, {{ isset($dato) ? $dato->idContrato : 'null' }})" style="margin-right: 3px" id="btnAprobar">   <i class="fa-solid fa-file-circle-check" ></i> Aprobar</a>
                                @endif
        
            </div>
        @endif     
@endif   
<input type="text" value="{{$dato->idCuota}}" style="display: none" id="idCuota">
<input type="text" value="{{$dato->idContrato}}" style="display: none" id="idContrato">
<input type="text" value="{{$estadoContrato}}" style="display: none" id="estadoContrato">

<script>

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
            // 2. Actualizar el contenido de la tabla
            // Usamos el selector #tablaDocs que indicaste en tu nuevo script.
            $('#tablaDocs').html(html);

            // 3. Mostrar mensaje de éxito que se cierra solo
            Swal.fire({
                icon: 'success',
                title: '¡Archivo Cargado!',
                text: 'El documento se ha cargado correctamente.',
                timer: 2000, // El mensaje se cierra después de 2 segundos
                showConfirmButton: false
            });
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
    {{Html::script(asset('js/juridica/juridica.js'))}}
@endsection