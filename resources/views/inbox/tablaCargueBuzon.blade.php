<table id="tablaDocss" class="table table-striped table-hover" name="tablaDocs">
    <thead class="thead2">
        <tr>
            <th>No</th> <!-- columna de numeración -->
            <th>Nombre del Archivo</th>
            <th>Estado</th>
            <th style="width: 30%">Observación</th>
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
            <td style="width: 30%">{{ $dato->Observacion }}</td>
            <td>
                <form action="{{ route('contratos.destroy', $dato->Id) }}" method="POST">
                    <a class="btn btn-sm btn-light" onclick="selccionarArchivo({{ $dato->Id }}, {{ $dato->idContrato }}, {{ $dato->idCuota }})"><i class="fa-solid fa-paperclip"></i></a>
                    <a class="btn btn-sm btn-danger" onclick="AbrirPDFM('{{ $dato->Ruta }}')"><i class="fa-solid fa-file-pdf"></i></a>
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>

        @endforeach
    </tbody>

</table>

<input type="text" value="{{ $dato->idCuota ?? '' }}" style="display: none" id="idCuota">
<input type="text" value="{{ $dato->idContrato ?? '' }}" style="display: none" id="idContrato">
