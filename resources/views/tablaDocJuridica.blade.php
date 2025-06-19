<table id="tablaDocss" class="table table-striped table-hover" name="tablaDocs">
    <thead class="thead2">
        <tr>
            <th>Nombre del Archivo</th>
            {{-- <th>Estado</th> --}}
            <th>Observacion</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        <div class="row">
            @foreach($datos as $dato)
            <tr  class="tr-principal" onclick="AbrirPDFM('{{$dato->Ruta}}')">
                <td style="font-size: 14px" >
                    @if($dato->Estado == 'DEVUELTA')
                        <i class="fa-regular fa-circle-xmark" style="color: #ff0000;"></i>
                    @elseif($dato->Estado == 'APROBADA')
                        <i class="fa-regular fa-circle-check" style="color: #568c1d;"></i>
                    @else
                        <i class="fa-solid fa-bars" style="color: #FFD43B;"></i>  
                    @endif
                    {{ $dato->Nombre }}
                </td>
                {{-- <td>{{ $dato->Estado }}</td> --}}
                <td>
                    {{-- <input type="areatext" value="{{ $dato->Observacion }}"> --}}
                    {!! Form::textarea('observacion', $dato->Observacion,["style" => "height: 30px;width: 90%;max-height: 90px;min-height: 30px", 'id' => 'obs_' .$dato->Id_cargue_archivo]) !!}
                </td>
                <td colspan="2" style="padding-left: 2px; padding-right: 2px; min-width: 100px;">
                    <form action="{{ route('contratos.destroy', $dato->Id) }}" method="POST">
                            {{-- <a class="btn btn-sm btn-light" onclick="selccionarArchivo({{$dato->Id}},{{$dato->idContrato}},{{$dato->idCuota}})"><i class="fa-solid fa-paperclip"></i></a> --}}
                            {{-- <a class="btn btn-sm btn-info" onclick="AbrirPDFM('{{$dato->Ruta}}')"><i class="fa-solid fa-file-pdf"></i></a> --}}
                            <a class="btn btn-sm btn-danger" onclick="cambioEstado({{$dato->Id_cargue_archivo}},'DEVUELTA',{{$dato->idCuota}},{{$dato->idContrato}})"><i class="fa-regular fa-circle-xmark"></i></a>
                            <a class="btn btn-sm btn-success" onclick="cambioEstado({{$dato->Id_cargue_archivo}},'APROBADA',{{$dato->idCuota}},{{$dato->idContrato}})"><i class="fa-solid fa-check"></i></a>
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
        </div>
    </tbody>
</table>
<input type="text" value="{{$dato->idCuota}}" style="display: none" id="idCuota">
<input type="text" value="{{$dato->idContrato}}" style="display: none" id="idContrato">