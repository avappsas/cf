@if($historial->isEmpty())
    <p>No hay documentos aprobados o anulados con observación.</p>
@else
 
    <table class="table table-bordered">
        <thead class="thead2">
            <tr>
                <th>Formato</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Observación</th>
                <th>Fecha Creación</th>
                <th>Fecha Actualización</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historial as $doc)
                <tr>
                    <td>{{ $doc->Id_formato }}</td>
                    <td>{{ $doc->Nombre }}</td>
                    <td>{{ $doc->Estado }}</td>
                    <td>{{ $doc->Observacion ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($doc->Fecha_creacion)->format('Y-m-d H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($doc->Fecha_actualizacion)->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif