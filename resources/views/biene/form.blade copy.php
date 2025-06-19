<form method="POST" action="{{ isset($biene->id_bien) ? route('bienes.update', $biene->id_bien) : route('bienes.store') }}"> 

    @csrf
    @if(isset($biene->id_bien))
        @method('PATCH')
    @endif

    <div class="box box-info padding-1">
        <div class="box-body">
            <!-- Detalles del Bien Asegurado -->
            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Detalles del Bien Asegurado</span>
                </div>
                <input type="hidden" name="id_Caso" value="{{ $biene->id_caso ?? $id_Caso }}">
                <div class="card-body">
                    <div class="form-group row">  
 
                        <div class="col-md-4">
                            {{ Form::label('Objeto', 'Objeto') }}
                            {!! Form::select('objeto', $Objeto, $biene->objeto ?? '', ['class' => 'form-control' . ($errors->has('objeto') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione un objeto', 'id' => 'objeto', 'onchange' => 'objetoSeleccionado(this)']) !!}
                            {!! $errors->first('objeto', '<div class="invalid-feedback">:message</div>') !!}
                        </div>                      
                        <div class="col-md-4">
                            {{ Form::label('Tipo', 'Tipo') }}
                            {!! Form::select('tipo', $TipoB, $biene->tipo ?? '', ['class' => 'form-control' . ($errors->has('tipo') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione el Tipo', 'id' => 'tipo', 'onchange' => 'tipoSeleccionado(this)']) !!}
                            {!! $errors->first('tipo', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        <div class="col-md-4">
                            {{ Form::label('Bien_Asegurado', 'Nombre del Bien Asegurado') }}
                            {{ Form::text('bien_asegurado', $biene->bien_asegurado ?? '', ['class' => 'form-control' . ($errors->has('bien_asegurado') ? ' is-invalid' : ''), 'placeholder' => 'bien asegurado']) }}
                            {!! $errors->first('bien_asegurado', '<div class="invalid-feedback">:message</div>') !!}
                        </div>  
                    </div>
                        
                        <div class="col-md-6">
                            {{ Form::label('detalles', 'Detalles') }}
                            {!! Form::textarea('detalles', $biene->detalles ?? '', [
                                'class'       => 'form-control' . ($errors->has('detalles') ? ' is-invalid' : ''),
                                'placeholder' => 'Detalles',
                                'id'          => 'detalles',
                                'rows'        => 5
                            ]) !!}
                            {!! $errors->first('detalles', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                                        {{-- CARD: Características --}}
                    <div class="card card-default mt-4" id="caracteristicasCard" style="display: none;">
                        <div class="card-header">
                        <span class="card-title">Características Específicas</span>
                        </div>
                        <div class="card-body" id="caracteristicasContainer">
                        {{-- Aquí inyectaremos dinámicamente los campos --}}
                        </div>
                    </div>    
                </div>
            </div>

            <!-- Imágenes -->
            <div class="card card-default mt-4">
                <div class="card-header">
                    <span class="card-title">Imágenes del Bien</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(!empty($imagenes) && $imagenes->isNotEmpty())
                            @foreach($imagenes as $imagen)
                                <div class="col-md-3 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/imagenes/' . $imagen->file_path) }}" 
                                            class="card-img-top img-thumbnail" 
                                            alt="Imagen" 
                                            style="cursor: pointer; height: 200px; object-fit: cover;" 
                                            onclick="openImageModal('{{ asset('storage/imagenes/' . $imagen->file_path) }}')">
                                        <div class="card-body text-center">
                                            <p class="card-text">{{ $imagen->description }}</p>
 
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Mostrar cuadros vacíos si no hay imágenes -->
                            @for ($i = 0; $i < 4; $i++)
                                <div class="col-md-3 mb-4">
                                    <div class="card h-100">
                                        <div class="card-img-top img-thumbnail" 
                                            style="height: 200px; object-fit: cover; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                                            <span style="color: #ccc;">Sin Imagen</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <p class="card-text">Sin descripción</p>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
            
                </div>
            </div>
            

            <!-- Valoraciones -->
            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">Valoraciones de Costos</span>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Valor Cotizado</th>
                                <th>Valor Aprobado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="valoracionesTable">
                            @foreach ($valoraciones as $index => $valoracion)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><input type="text" name="valoraciones[{{ $valoracion->id }}][descripcion]" value="{{ $valoracion->descripcion }}" class="form-control"></td>
                                <td><input type="number" name="valoraciones[{{ $valoracion->id }}][cant]" value="{{ $valoracion->cant }}" class="form-control"></td>
                                <td><input type="number" name="valoraciones[{{ $valoracion->id }}][valor_cotizado]" value="{{ $valoracion->valor_cotizado }}" class="form-control"></td>
                                <td><input type="number" name="valoraciones[{{ $valoracion->id }}][valor_aprobado]" value="{{ $valoracion->valor_aprobado }}" class="form-control"></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeExistingRow(this, '{{ $valoracion->id }}')">Eliminar</button>
                                    <td> 
                                        <input type="file" name="valoraciones[{{ $valoracion->id }}][pdf]" accept=".pdf" class="form-control" style="display: none;" id="pdfFile_{{ $valoracion->id }}">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="triggerFileInput('{{ $valoracion->id }}')">Subir PDF</button>
                                    </td>
                                </td>
                            </tr>
                            @endforeach
                            <!-- Nueva valoración -->
                            <tr id="newRow">
                                <td>Nueva</td>
                                <td><input type="text" name="valoraciones[new][descripcion]" class="form-control" placeholder="Descripción"></td>
                                <td><input type="number" name="valoraciones[new][cant]" class="form-control" placeholder="Cantidad"></td>
                                <td><input type="number" name="valoraciones[new][valor_cotizado]" class="form-control" placeholder="Valor Cotizado"></td>
                                <td><input type="number" name="valoraciones[new][valor_aprobado]" class="form-control" placeholder="Valor Aprobado"></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" onclick="addNewRow()">Agregar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="eliminar_valoraciones" id="eliminar_valoraciones" value="">
                </div>
            </div>

            <div class="form-group row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Guardar Bienes y Valoraciones</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function addNewRow() {
    const tableBody = document.getElementById("valoracionesTable");
    const timestamp = Date.now(); // ID único basado en tiempo
    const newRow = document.createElement("tr");

    newRow.innerHTML = `
        <td>Nueva</td>
        <td><input type="text" name="valoraciones[${timestamp}][descripcion]" class="form-control" placeholder="Descripción"></td>
        <td><input type="number" name="valoraciones[${timestamp}][cant]" class="form-control" placeholder="Cantidad"></td>
        <td><input type="number" name="valoraciones[${timestamp}][valor_cotizado]" class="form-control" placeholder="Valor Cotizado"></td>
        <td><input type="number" name="valoraciones[${timestamp}][valor_aprobado]" class="form-control" placeholder="Valor Aprobado"></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Eliminar</button></td>
    `;
    tableBody.appendChild(newRow);
}

function removeRow(button) {
    const row = button.closest('tr');
    row.remove();
}

function removeExistingRow(button, id) {
    const input = document.getElementById('eliminar_valoraciones');
    let ids = input.value ? input.value.split(',') : [];
    ids.push(id);
    input.value = ids.join(',');
    removeRow(button);
}

function openImageModal(imageUrl) {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = imageUrl;
    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
}

function triggerFileInput(valoracionId) {
    // Acceder al campo de archivo oculto usando su ID
    document.getElementById('pdfFile_' + valoracionId).click();
}


</script>
