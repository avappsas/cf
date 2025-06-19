@extends('layouts.app')

@section('template_title')
    Bienes Asociados al Caso ID: {{ $id_Caso ?? 'Todos' }}
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                Bienes Asociados al Caso ID: <strong>{{ $id_Caso ?? 'Todos' }}</strong>
                            </span>
                            <div class="float-right">
                                <a href="{{ route('bienes.create', ['id_caso' => $id_Caso, 'ramo' => $ramo]) }}" class="btn btn-primary">
                                    Anexar bien
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
                                        <th>Objeto</th>
                                        <th>Tipo</th>
                                        <th>Detalles</th>
                                        <th>Valor Cotizado</th>
                                        <th>Valor Aprobado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @empty($biene)
                                        <tr>
                                            <td colspan="7" class="text-center">No hay bienes asociados al caso ID: {{ $id_Caso }}</td>
                                        </tr>
                                    @endempty
                                    @foreach ($biene as $bieneItem)
                                        <tr>
                                            <td>{{ $loop->iteration + ($biene->currentPage() - 1) * $biene->perPage() }}</td>
                                            <td>{{ $bieneItem->descripcion }}</td> 
                                            <td>{{ $bieneItem->tipo_b ?? 'Sin tipo' }}</td>
                                            <td>{{ $bieneItem->detalles }}</td>
                                            <td>{{ $bieneItem->valor_cotizado }}</td>
                                            <td>{{ $bieneItem->valor_aprobado }}</td>
                                            <td>
                                                <form action="{{ route('bienes.destroy', $bieneItem->id_bien) }}" method="POST">
                                                    <a class="btn btn-sm btn-success" href="{{ route('bienes.edit', $bieneItem->id_bien) }}">
                                                        <i class="fa fa-fw fa-edit"></i> Editar
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-fw fa-trash"></i> Eliminar
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
                {!! $biene->links() !!}
            </div>
        </div>
    </div>

@endsection