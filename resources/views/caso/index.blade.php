@extends('layouts.app')

@section('template_title')
    Inspecciones pendientes
@endsection

@section('content')
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-sm-12">
               
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Casos') }}
                            </span>
                            <a href="{{ route('casos.create') }}" class="btn btn-primary btn-sm float-right">
                                <i class="fa fa-plus"></i> {{ __('Nuevo Caso') }}
                            </a>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success mt-3">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Ramo</th>
                                        {{-- <th>Reclamo</th> --}}
                                        <th>Reporte</th>
                                        {{-- <th>Póliza</th> --}}
                                        <th>Asegurado</th>
                                        <th>Fecha Siniestro</th>
                                        <th>Fecha Asignación</th>
                                        {{-- <th>Fecha Reporte</th> --}}
                                        <th>Sector</th>
                                        <th>Inspector</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    @foreach ($casos as $caso)
                                        <tr>
                                            <td>{{ ++$i }}</td> 
                                            <td>{{ $caso->ramo ?? 'No asignado' }}</td>
                                            {{-- <td>{{ $caso->Reclamo_Aseguradora }}</td> --}}
                                            <td>{{ $caso->no_reporte }}</td>
                                            {{-- <td>{{ $caso->Poliza_Anexo }}</td> --}}
                                            <td>{{ $caso->nombre_asegurado ?? 'No asignado'}}</td>
                                            <td>{{ $caso->fecha_siniestro }}</td>
                                            <td>{{ $caso->fecha_asignacion }}</td>
                                            {{-- <td>{{ $caso->Fecha_Reporte }}</td> --}}
                                            <td>{{ $caso->sector_evento }}</td>
                                            <td>{{ $caso->inspector ?? '-' }}</td>
                                            <td>{{ $caso->estado }}</td>
                                            <td>
                                                <form action="{{ route('casos.destroy', $caso->id) }}" method="POST">
                                                    <a href="{{ route('casos.edit', $caso->id) }}" class="btn btn-sm btn-success">
                                                        <i class="fa fa-fw fa-edit"></i> Ver
                                                    </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Eliminar</button> --}}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {!! $casos->links() !!}
            </div>
        </div>
    </div>
@endsection
