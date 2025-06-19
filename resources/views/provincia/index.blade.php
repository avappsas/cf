@extends('layouts.app')

@section('template_title')
    Provincia
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Provincia') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('provincias.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Id</th>
										<th>Provincia</th>
										<th>Pais</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($provincias as $provincia)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $provincia->id }}</td>
											<td>{{ $provincia->provincia }}</td>
											<td>{{ $provincia->pais }}</td>

                                            <td> 
                                                <div class="btn-group" role="group">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('provincias.show', $provincia->id) }}">
                                                        <i class="fa fa-fw fa-eye"></i> Ver
                                                    </a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('provincias.edit', $provincia->id) }}">
                                                        <i class="fa fa-fw fa-edit"></i> Editar
                                                    </a>
                                                    <form action="{{ route('provincias.destroy', $provincia->id) }}" method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('¿Está seguro que desea eliminar esta provincia?')">
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
                {!! $provincias->links() !!}
            </div>
        </div>
    </div>
@endsection
