<table id="tablaDocss" class="table table-striped table-hover" name="tablaDocs">
    <thead class="thead2">
        <tr>
            <th>No</th> <!-- columna de numeración -->
            <th>Nombre del Archivo</th>
            <th>Estado</th> 
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datos as $dato)
        <tr class="tr-principal">
            <td>{{ $loop->iteration }}</td> <!-- número automático -->
            <td>{{ $dato->Nombre }}</td>
            <td>
                @if ($dato->Estado === 'OPCIONAL')
                    <span style="color: blue; font-weight: bold;">{{ $dato->Estado }}</span>
                @elseif ($dato->Estado === 'CARGADO')
                    <span style="color: green; font-weight: bold;">{{ $dato->Estado }}</span>
                @elseif ($dato->Estado === 'APROBADA')
                    <span style="color: green; font-weight: bold;">{{ $dato->Estado }}</span>
                @elseif ($dato->Estado === 'DEVUELTA')
                    <span style="color: red; font-weight: bold;">{{ $dato->Estado }}</span>
                @elseif ($dato->Estado === '(SI APLICA)')
                    <span style="color: blue; font-weight: bold;">{{ $dato->Estado }}</span>
                @else
                    {{ $dato->Estado }} 
                @endif 
            </td> 
            <td>
                <form action="{{ route('contratos.destroy', $dato->Id) }}" method="POST">
                     <a class="btn btn-sm btn-danger" onclick="AbrirPDFM2('{{ $dato->Ruta }}')"><i class="fa-solid fa-file-pdf"></i></a>
                    <a class="btn btn-sm btn-light"
                                onclick="selccionarArchivo({{ $dato->Id }}, {{ $dato->idContrato }}, {{ $dato->idCuota }})">
                                <i class="fa-solid fa-paperclip"></i>
                    </a> 
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
                  
                       
        @endforeach
    </tbody>

</table>
@if( strtoupper(trim($estadoContrato)) === 'RPC - APROBADO' )
<div class="modal-footer">
    <a class="btn btn-md btn-success" onclick="cambioEstadoContrato(1, {{ isset($dato) ? $dato->idContrato : 'null' }})" style="margin-right: 3px" id="btnAprobar">   
        <i class="fa-solid fa-file-circle-check" ></i> Poner en Ejecución </a>
</div>
 @endif
<div class="modal-footer">
    {{-- Botón 1: Anexos (descarga = 1) --}}
    <a href="{{ route('descargar.zip.documentos', ['idContrato' => $dato->idContrato ?? 0, 'idCuota' => $dato->idCuota ?? 1, 'tipo' => 1]) }}"
       class="btn btn-md btn-info" style="margin-right: 3px">
        <i class="fa-solid fa-file-zipper"></i> Anexos Contratista
    </a>

    {{-- Botón 2: Documentos (descarga = 2) --}}
    <a href="{{ route('descargar.zip.documentos', ['idContrato' => $dato->idContrato ?? 0, 'idCuota' => $dato->idCuota ?? 1, 'tipo' => 2]) }}"
       class="btn btn-md btn-primary" style="margin-right: 3px">
        <i class="fa-solid fa-file-zipper"></i> Documentos Contratista
    </a>

    {{-- Botón 3: Minutas (descarga = 3) --}}
    <a href="{{ route('descargar.zip.documentos', ['idContrato' => $dato->idContrato ?? 0, 'idCuota' => $dato->idCuota ?? 1, 'tipo' => 3]) }}"
       class="btn btn-md btn-secondary">
        <i class="fa-solid fa-file-zipper"></i> Minutas Contratista
    </a>
</div>

<input type="text" value="{{ $dato->idCuota ?? '' }}" style="display: none" id="idCuota">
<input type="text" value="{{ $dato->idContrato ?? '' }}" style="display: none" id="idContrato">



<script>

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

        fetch('/uploadFile3', {
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

              // Reemplazar contenido de la tabla
              $('#tablaDocss').html(data);

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
</script>