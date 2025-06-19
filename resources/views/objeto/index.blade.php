@extends('layouts.app')

@section('template_title')
    Objeto
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Objeto') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('objetos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                <form action="{{ route('objetos.index') }}" method="GET">
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
                                        
										<th>Id Ramo</th>
										<th>Descripcion</th>
                                        <th>Observación</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($objetos as $objeto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $objeto->id_ramo }}</td>
											<td>{{ $objeto->descripcion }}</td>
                                            <td>{{ $objeto->observacion }}</td>
                                            <td>
                                                <form action="{{ route('objetos.destroy',$objeto->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('objetos.show',$objeto->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('objetos.edit',$objeto->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $objetos->links() !!}
            </div>
        </div>
    </div>
@endsection
