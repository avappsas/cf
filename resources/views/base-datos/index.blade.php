{{-- resources/views/base-datos/index.blade.php (Buscar Persona) --}}
@extends('layouts.app')

@section('template_title')
    Buscar Persona
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span id="card_title" class="d-block">
                            <i class="fa fa-fw fa-search"></i> {{ __('Buscar Persona') }}   
                        </span>
                        <a href="{{ route('base-datos.create') }}"
                           class="btn btn-sm btn-success">
                            <i class="fa fa-fw fa-plus"></i> Nuevo Registro
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="GET" action="{{ route('base-datos.index') }}" class="mb-4">
                        <div class="input-group">
                            <input
                                type="text"
                                name="query"
                                class="form-control"
                                placeholder="Ingrese nombre o cédula"
                                value="{{ old('query', $query) }}"
                            >
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-fw fa-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($baseDatos->count())
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead2">
                                    <tr>
                                        <th>Tipo Doc</th>
                                        <th>Documento</th>
                                        <th>Nombre</th>
                                        <th>Celular</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($baseDatos as $dato)
                                        <tr>
                                            <td>{{ $dato->Tipo_Doc }}</td>
                                            <td>{{ $dato->Documento }}</td>
                                            <td>{{ $dato->Nombre }}</td>
                                            <td>{{ $dato->Celular }}</td>
                                            <td>
                                                <a href="{{ route('base-datos.edit', $dato->id) }}"
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                <a href="{{ route('contratos.ver', $dato->Documento) }}"
                                                   class="btn btn-sm btn-info">
                                                    <i class="fa fa-fw fa-file-contract"></i> Contratos
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {!! $baseDatos->appends(['query' => $query])->links() !!}
                        </div>
                    @elseif($query)
                        <div class="text-center text-danger font-weight-semibold">
                            No se encontraron resultados para “{{ $query }}”.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
