<table class="table table-striped table-hover">
    <thead class="thead2">
        <tr>
            <th>Cuenta</th>
            <th>Estado</th>
            <th>Fecha de actualización</th>
            {{-- <th style="width: 30%">Observacion</th> --}}
            <th ></th>
        </tr>
    </thead>
    <tbody>
        @foreach($datos as $dato)
        <tr  class="tr-principal">
            <td style="color: black; font-weight: bold;">Cuota {{ $dato->Cuota }}</td>
            <td>            
            @if ($dato->Estado === 'CREADA')
                        <span style="color: rgb(32, 8, 248); font-weight: bold;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ $dato->Estado }}</span>
            @elseif ($dato->Estado === 'APROBADA')
                <span style="color: rgb(0, 10, 0); font-weight: bold;">{{ $dato->Estado }}</span>   
            @elseif ($dato->Estado === 'DEVUELTA')
                <span style="color: red; font-weight: bold;"><i class="fa fa-undo" aria-hidden="true"></i> {{ $dato->Estado }}</span>
            @else
                {{ $dato->Estado }}
            @endif</td>
            <td>{{ $dato->updated_at }}</td>
            {{-- <td style="width: 30%">{{ $dato->Observacion }}</td> --}}
            <td >
                <form action="{{ route('contratos.destroy', $dato->Id) }}" method="POST">
                    <a class="btn btn-sm btn-info" onclick="mostrarSubTabla(this)"><i class="fa-solid fa-file-pdf"></i> Ver documentos</a>
                    @if($dato->Estado  == 'CREADA' || $dato->Estado == 'DEVUELTA')
                        <a class="btn btn-sm btn-warning" onclick="btnModCuota({{$dato->Id}},'{{$dato}}',2)"><i class="fa-regular fa-pen-to-square"></i> Modificar</a>
                        <a class="btn btn-sm btn-success" onclick="btnAbrirModalCarguePDF({{$dato->Contrato}},{{$dato->Id}})"><i class="fa-solid fa-upload"></i> Cargar Documentos</a>
                    @endif
                    @csrf
                    @method('DELETE')
                </form>

                <!-- Contenido de la celda -->
                <table class="table table-striped table-hover tabla-anidada" style="display: none">
                    <div class="thead">
                        <tr onclick="event.stopPropagation();">
                            <th>Formato</th>
                            <th>Archivo</th>
                        </tr>
                    </div>
                    @foreach($format as $formato)
                    @if ($dato->Id == $formato->idCuota)
                        <tr  onclick="event.stopPropagation();">
                            <td>{{ $formato->Nombre}}</td>
                            <td>
                                <a class="btn btn-sm btn-danger" onclick="traerPDF({{$dato->Id}},{{$formato->Id}},'{{$formato->Nombre}}')"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                                        <a class="btn btn-sm btn-primary" href="https://apicontrato-production.up.railway.app/generarZip/{{$num_contrato}}/{{$formato->plantilla}}/{{$dato->Id}}" target="_blank"><i class="fa-solid fa-file-word"></i> Word</a>
 
                                {{-- <a class="btn btn-sm btn-success" href="{{ route('dpdf', ['idCuota' => $dato->Id, 'id' => $formato->Id]) }}"><i class="fa fa-fw fa-download"></i> Descargar</a> --}}
                                {{-- <a class="btn btn-sm btn-success" href="{{route('dpdf',{{$dato->Id}},{{$formato->Id}})}}"><i class="fa-solid fa-download"></i> Descargar</a> --}}
                            </td>
                        </tr>
                    @endif
                    @endforeach
                </table>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>