@extends('layouts.app')

@section('template_title')
    Causa
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Causa') }}
                            </span>
                            <div class="float-right">
                                <a href="{{ route('causas.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                    {{ __('Create New') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <!-- Filtro mejorado con manejo de valores nulos -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <form action="{{ route('causas.index') }}" method="GET">
                                    <div class="input-group">
                                        <select name="id_ramo" class="form-control">
                                            <option value="">Seleccione un Ramo</option>
                                            @foreach($ramos as $id => $nombre)
                                                <option value="{{ $id }}" {{ request('id_ramo') == $id ? 'selected' : '' }}>
                                                    {{ $nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-filter"></i> Filtrar
                                            </button>
                                            <a href="{{ route('aseguradoras.index') }}" class="btn btn-secondary">
                                                <i class="fa fa-undo"></i> Limpiar
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

  
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th> 
                                        <th>Ramos</th>
                                        <th>Causa</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($causas as $causa)
                                        <tr> 
                                            <td>{{ $causa->id }}</td>
                                            <td>{{ $causa->id_ramo }}</td>
                                            <td>{{ $causa->causa }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('causas.show', $causa->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> Ver
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('causas.edit', $causa->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> Editar
                                                    </a>
                                                    <form action="{{ route('causas.destroy', $causa->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('¿Está seguro que desea eliminar esta causa?')">
                                                            <i class="fa fa-fw fa-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $causas->links() !!}
            </div>
        </div>
    </div>
@endsection