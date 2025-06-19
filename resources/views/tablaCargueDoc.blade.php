<table id="tablaDocss" class="table table-striped table-hover" name="tablaDocs">
    <thead class="thead2">
        <tr>
            <th>Nombre del Archivo</th>
            <th>Estado</th>
            <th style="width: 30%">Observacion</th>
            <th ></th>
        </tr>
    </thead>
    <tbody>
        <div class="row">
            @foreach($datos as $dato)
            <tr  class="tr-principal">
                <td>{{ $dato->Nombre }}</td>
                <td>{{ $dato->Estado }}</td>
                <td style="width: 30%">{{ $dato->Observacion }}</td>
                <td >
                    <form action="{{ route('contratos.destroy', $dato->Id) }}" method="POST">
                            <a class="btn btn-sm btn-light" onclick="selccionarArchivo({{$dato->Id}},{{$dato->idContrato}},{{$dato->idCuota}})"><i class="fa-solid fa-paperclip"></i></a>
                            <a class="btn btn-sm btn-danger" onclick="AbrirPDFM('{{$dato->Ruta}}')"><i class="fa-solid fa-file-pdf"></i></a>
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