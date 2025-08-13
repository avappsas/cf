<table class="table table-bordered table-sm table-hover">
  <thead class="thead-dark">
    <tr>
      <th>Usuario</th>
      <th>Acción</th>
      <th>Fecha</th>
      <th>Estado Enviado</th> 
      <th>Tiempo desde anterior</th>
    </tr>
  </thead>
  <tbody>
  @foreach ($datosProcesados as $fila)
  <tr @if($fila['alerta']) style="background-color: #ffe29a;" @endif>
      <td>{{ \Illuminate\Support\Str::title($fila['nombre_usuario']) }}</td>
      <td>{{ $fila['accion'] }}</td>
      <td>{{ $fila['fecha'] }}</td>
      <td>{{ $fila['estado_interno'] }}</td> 
      <td>{{ $fila['diferencia'] }}</td>
  </tr>
  @endforeach
  </tbody>
</table>
@if($tiempoDesdeUltimo !== '—')
    <div class="mt-3 p-3 rounded font-weight-bold"
         style="background-color: {{ $resaltarUltimo ? '#F4A300' : '#e9ecef' }}; color: black;">
        ⏱️ <strong>Tiempo desde el último estado hasta ahora:</strong>
        {{ $tiempoDesdeUltimo }}
    </div>
@endif