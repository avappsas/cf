@extends('layouts.app')

@section('template_title')
    Aseguradora
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Aseguradora') }}
                            </span>
                             <div class="float-right">
                                <a href="{{ route('aseguradoras.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                <form action="{{ route('aseguradoras.index') }}" method="GET">
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
                                        <th>Aseguradora</th>
                                        <th>Ramo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aseguradoras as $aseguradora)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $aseguradora->aseguradora }}</td>
                                            <!-- Manejo seguro del nombre del ramo -->
                                            <td>{{ $ramos[$aseguradora->id_ramo] ?? 'No especificado' }}</td>
                                            <td>
                                                <form action="{{ route('aseguradoras.destroy',$aseguradora->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('aseguradoras.show',$aseguradora->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> Show
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('aseguradoras.edit',$aseguradora->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> Edit
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-fw fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $aseguradoras->links() !!}
            </div>
        </div>
    </div>
@endsection