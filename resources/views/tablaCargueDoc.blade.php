<table id="tablaDocss" class="table table-striped table-hover" name="tablaDocs">
    <thead class="thead2">
        <tr>
            <th>No</th>  
            <th>Nombre del Archivo</th>
            <th>Estado</th>
            <th style="width: 30%; text-align: center;">Observación</th>
            <th style="text-align: center;">Acción</th>
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
                @elseif ($dato->Estado === 'FIRMADO')
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
            <td style="width: 30%">{{ $dato->Observacion }}</td>
            <td> 
                {{-- <form action="{{ route('contratos.destroy', $dato->Id) }}" method="POST">
                    <a class="btn btn-sm btn-light" onclick="selccionarArchivo({{ $dato->Id }}, {{ $dato->idContrato }}, {{ $dato->idCuota }})"><i class="fa-solid fa-paperclip"></i></a>
                    <a class="btn btn-sm btn-danger" onclick="AbrirPDFM2('{{ $dato->Ruta }}')"><i class="fa-solid fa-file-pdf"></i></a>
                    
                    @csrf
                    @method('DELETE')
                </form>                             --}}


                    <a class="btn btn-sm btn-light" onclick="selccionarArchivo({{ $dato->Id }}, {{ $dato->idContrato }}, {{ $dato->idCuota }})"><i class="fa-solid fa-paperclip"></i></a>
                    <a class="btn btn-sm btn-danger" onclick="AbrirPDFM2('{{ $dato->Ruta }}')"><i class="fa-solid fa-file-pdf"></i></a>
                @if (in_array($dato->Id, [34, 37, 1031, 1032, 1033, 1036, 1037]))
                            @php
                                $rutaFirma = DB::table('Base_Datos')->where('Documento', auth()->user()->usuario)->value('firma');
                                $rutaPDF = $dato->Ruta ? asset('storage/' . ltrim($dato->Ruta, '/')) : '';
                                $rutaFirmaCompleta = $rutaFirma ? asset('storage/' . ltrim($rutaFirma, '/')) : '';
                            @endphp 
                            @if (in_array($dato->Id, [0]))       
                                <a href="#" class="btn btn-sm btn-warning"
                                    onclick="abrirModalFirma('{{ $dato->Ruta }}', {{ $dato->idContrato }}, {{ $dato->idCuota }}, '{{ asset('storage/' . $rutaFirma) }}', {{ $dato->Id }})">
                                    <i class="fa-solid fa-pen-nib"></i> Firmar
                                </a>    
                            @endif    
                 @endif  
            </td>
        </tr>

        @endforeach
    </tbody>

</table>

<style>
  #cargandoArchivoOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.7);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
  }
</style>

<div id="cargandoArchivoOverlay">
  <div class="text-center">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    <p class="mt-3 font-weight-bold">Subiendo archivo, por favor espera...</p>
  </div>
</div>


<input type="text" value="{{ $dato->idCuota ?? '' }}" style="display: none" id="idCuota">
<input type="text" value="{{ $dato->idContrato ?? '' }}" style="display: none" id="idContrato">


<!-- MODAL DE FIRMA CON PDF.js --> 
<div class="modal fade" id="modalPosicionarFirma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 75%; margin: 1rem auto; height: 95vh;">
        <div class="modal-content shadow-lg rounded-3" style="height: 100%; overflow: hidden;">
            <!-- HEADER -->
            <div class="modal-header"
                style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                        color: #000; font-family: 'Mallanna'; font-size: 14px;">
                <h5 class="modal-title">📄 Posicionar Firma</h5> 
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar"
                        style="font-size: 1.8rem; color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" style="height: 100vh; overflow: hidden;">
                <iframe id="iframeFirmador"
                src=""
                style="width:100%; height:100%; border:none;"></iframe>
            </div> 
        </div>
    </div>
</div>

<script>
function abrirModalFirma(rutaPDF, idContrato, idCuota, rutaFirma,idCargue) {
    if (!rutaPDF || !idContrato || !idCuota || !rutaFirma) {
        Swal.fire("❌ Datos incompletos para firmar");
        return;
    }

    // Construir URL codificada
    const url = `/firmar-viewer?file=${encodeURIComponent(rutaPDF)}&idContrato=${idContrato}&idCuota=${idCuota}&firma=${encodeURIComponent(rutaFirma)}&idCargue=${idCargue}`;
     
    const iframe = document.getElementById('iframeFirmador');
    iframe.src = url + '&t=' + new Date().getTime(); // evitar caché

    const modal = new bootstrap.Modal(document.getElementById('modalPosicionarFirma'));
    modal.show();
}
</script>