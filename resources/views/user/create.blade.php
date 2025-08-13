@extends('layouts.app')

@section('template_title')
    Crear Usuario
@endsection

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            @includeIf('partials.errors')

            <div class="card card-default">
                <div class="card-header bg-primary text-white text-center">
                      <strong>Nuevo Usuario</strong>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf

                        @include('user.form')

                        {{-- Mostrar asignación de perfiles si está autorizado --}}
                        @if(isset($puedeEditarPerfiles) && $puedeEditarPerfiles)
                            <div class="card border-primary mt-4">
                                <div class="card-header bg-primary text-white text-center">
                                    <strong>Asignar Perfiles</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @forelse($perfilesDisponibles as $id => $nombre)
                                            <div class="col-md-6 col-lg-4 mb-2">
                                                <div class="form-check">
                                                    <input type="checkbox" name="perfiles[]" value="{{ $id }}" id="perfil_{{ $id }}"
                                                        class="form-check-input"
                                                        {{ in_array($id, old('perfiles', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perfil_{{ $id }}">
                                                        {{ $nombre }}
                                                    </label>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <p class="text-muted">No hay perfiles disponibles.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection