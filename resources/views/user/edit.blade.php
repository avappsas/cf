@extends('layouts.app')

@section('template_title')
    Actualizar datos
@endsection

@section('content')
<section class="content container-fluid">
    <div class="col-md-12">
        @includeIf('partials.errors')

        {{-- FORMULARIO DE EDICIÓN --}}
        {!! Form::model($user, [
            'route'     => ['usuarios.update', $user->id],
            'method'    => 'PATCH',
            'files'     => true,
        ]) !!}

            @include('user.form')

            <div class="text-center mt-3">
                {!! Form::submit('Guardar Cambios', ['class'=>'btn btn-primary btn-sm']) !!}
              @if($puedeEditarPerfiles)  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPerfiles"> Editar Perfiles  </button>  @endif

            </div>


            {{-- MODAL DENTRO DEL FORMULARIO --}}
            @if($puedeEditarPerfiles)
            <!-- MODAL DE PERFILES -->
            <div class="modal fade" id="modalPerfiles" tabindex="-1" aria-labelledby="modalPerfilesLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Asignar Perfiles</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar" style="font-size: 1.5rem;">
    <span aria-hidden="true">&times;</span>
</button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      @foreach($perfilesDisponibles as $id => $nombre)
                        <div class="col-md-6 mb-2">
                          <div class="form-check">
                            {!! Form::checkbox('perfiles[]', $id, in_array($id, $perfilesUsuario), [
                                'class' => 'form-check-input',
                                'id'    => 'perfil_'.$id
                            ]) !!}
                            {!! Form::label('perfil_'.$id, $nombre, ['class' => 'form-check-label']) !!}
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    {{-- Este botón guarda TODO el formulario --}}
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                  </div>
                </div>
              </div>
            </div>
            @endif

        {!! Form::close() !!}
    </div>
</section>
@endsection