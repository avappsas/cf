@extends('layouts.app')

@section('content')
<form method="POST"
      action="{{ isset($biene->id_bien) ? route('bienes.update',$biene->id_bien)
                                        : route('bienes.store') }}">
    @csrf
    @isset($biene->id_bien) @method('PATCH') @endisset
 

    <div class="box box-info padding-1">
        <div class="box-body">
        <div class="card-body">

            {{-- ========== CARD: Detalles ========== --}}

            <div class="card card-default mb-4">
                <div class="card-header">Detalles del Bien Asegurado</div> 
                <input type="hidden" name="id_caso" value="{{ $biene->id_caso ?? $id_Caso }}">

                <div class="card-body">
             
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                {{ Form::label('objeto','Objeto') }}
                                {!! Form::select('objeto',$Objeto,$biene->objeto??'',[
                                    'id'=>'objeto',
                                    'class'=>'form-control'.($errors->has('objeto')?' is-invalid':''),
                                    'placeholder'=>'Seleccione un objeto',
                                    'onchange'=>'objetoSeleccionado(this)'
                                ]) !!}
                                {!! $errors->first('objeto','<div class="invalid-feedback">:message</div>') !!}
                                
                            </div>

                            <div class="col-md-4">
                                {{ Form::label('tipo','Tipo') }}
                                {!! Form::select('tipo',$TipoB,$biene->tipo??'',[
                                    'id'=>'tipo',
                                    'class'=>'form-control'.($errors->has('tipo')?' is-invalid':''),
                                    'placeholder'=>'Seleccione el Tipo',
                                    'onchange'=>'cargarCaracteristicas(this)'
                                ]) !!}
                                {!! $errors->first('tipo','<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="col-md-4">
                                {{ Form::label('bien_asegurado','Nombre del Bien Asegurado') }}
                                {!! Form::text('bien_asegurado',$biene->bien_asegurado??'',[
                                    'class'=>'form-control'.($errors->has('bien_asegurado')?' is-invalid':''),
                                    'placeholder'=>'Bien asegurado'
                                ]) !!}
                                {!! $errors->first('bien_asegurado','<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>

                        {{-- ========== CARD: Características ========== --}}
                        <div class="card card-default mb-4" id="caracteristicasCard">
                            <div class="card-header">Características Específicas</div>
                            <div class="card-body" id="caracteristicasContainer"> 
                                <p class="text-muted mb-0">Seleccione un tipo para ver sus características…</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            {{ Form::label('detalles','Detalles') }}
                            {!! Form::textarea('detalles',$biene->detalles??'',[
                                'class'=>'form-control'.($errors->has('detalles')?' is-invalid':''),
                                'rows'=>4]) !!}
                            {!! $errors->first('detalles','<div class="invalid-feedback">:message</div>') !!}
                        </div> 
                     
                        {{-- ========== CARD: Valoraciones ========== --}}
                        <div class="card card-default mb-4">
                            <div class="card-header">Valoraciones de Costos</div>
                            <div class="card-body p-0">
                                <table class="table mb-0" id="valoracionesTable">
                                    <thead class="table-light">
                                        <tr><th>#</th><th>Descripción</th><th>Cant</th><th>Cotizado</th><th>Aprobado</th><th></th></tr>
                                    </thead>
                                    <tbody>
                                        @foreach($valoraciones as $i=>$v)
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td><input class="form-control form-control-sm"
                                                    name="valoraciones[{{ $v->id }}][descripcion]"
                                                    value="{{ $v->descripcion }}"></td>
                                            <td><input type="number" class="form-control form-control-sm"
                                                    name="valoraciones[{{ $v->id }}][cant]"
                                                    value="{{ $v->cant }}"></td>
                                            <td><input type="number" class="form-control form-control-sm"
                                                    name="valoraciones[{{ $v->id }}][valor_cotizado]"
                                                    value="{{ $v->valor_cotizado }}"></td>
                                            <td><input type="number" class="form-control form-control-sm"
                                                    name="valoraciones[{{ $v->id }}][valor_aprobado]"
                                                    value="{{ $v->valor_aprobado }}"></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="eliminarExistente(this,'{{ $v->id }}')">🗑️</button>
                                            </td>
                                        </tr>
                                        @endforeach

                                        <tr id="nuevaValoracionRow">
                                            <td>+</td>
                                            <td><input class="form-control form-control-sm"
                                                    name="valoraciones[new][descripcion]"></td>
                                            <td><input type="number" class="form-control form-control-sm"
                                                    name="valoraciones[new][cant]"></td>
                                            <td><input type="number" class="form-control form-control-sm"
                                                    name="valoraciones[new][valor_cotizado]"></td>
                                            <td><input type="number" class="form-control form-control-sm"
                                                    name="valoraciones[new][valor_aprobado]"></td>
                                            <td><button type="button" class="btn btn-sm btn-success"
                                                        onclick="addValoracion()">＋</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" id="eliminar_valoraciones" name="eliminar_valoraciones">
                            </div>
                        </div>
 
                </div> {{-- card-body Detalles --}}
            </div>     {{-- card Detalles --}}


            {{-- ========== CARD: Imágenes (oculta) ========== --}}
            <div class="card card-default mb-4 d-none" id="imagenesCard">
                <div class="card-header">Imágenes del Bien</div>
                <div class="card-body">
                    <div class="row g-3">
                        @forelse($imagenes as $img)
                            <div class="col-md-3 text-center">
                                <img src="{{ asset('storage/imagenes/'.$img->file_path) }}"
                                     class="img-thumbnail"
                                     style="height:180px;object-fit:cover;cursor:pointer"
                                     onclick="verImagen('{{ asset('storage/imagenes/'.$img->file_path) }}')">
                                <small class="d-block mt-1">{{ $img->description }}</small>
                            </div>
                        @empty
                            @for($i=0;$i<4;$i++)
                                <div class="col-md-3 text-center">
                                    <div class="bg-light" style="height:180px"></div>
                                    <small class="d-block mt-1 text-muted">Sin imagen</small>
                                </div>
                            @endfor
                        @endforelse
                    </div>
                </div>
            </div>

                        {{-- ========== Botón Guardar ========== --}}
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>

            {{-- ========== Botón Mostrar Imágenes ========== --}}
            <button type="button" class="btn btn-link mb-2" id="btnToggleImg">
                📷 Ver imágenes
            </button>
        </div> {{-- box-body --}}
        </div> {{-- box-body --}}
    </div>    {{-- box --}}
</form>

{{-- Modal imagen --}}
<div class="modal fade" id="imgModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-transparent border-0 p-0">
      <img id="imgModalSrc" class="img-fluid rounded" />
    </div>
  </div>
</div>
@endsection

@push('scripts')

    {{--  ▼  objeto {caracteristica: valor} disponible en JS  --}}
    <script>
        const caracExistentes = @json(
            $caracteristicas->pluck('valor','caracteristica')
        );
    </script>

    <script src="{{ asset('js/bienes.js') }}"></script>

    {{-- Mostrar/ocultar tarjeta Imágenes --}}
    <script>
        document.getElementById('btnToggleImg')
                .addEventListener('click', () =>
                    document.getElementById('imagenesCard')
                            .classList.toggle('d-none'));
    </script>
@endpush
