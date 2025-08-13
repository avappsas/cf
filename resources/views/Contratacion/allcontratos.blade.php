@extends('layouts.app')

@section('template_title')
    Todos los Contratos
@endsection

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">🔍 Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('contratos.all') }}" class="form-row align-items-end">
                <div class="col-md-3 mb-2">
                    <input
                        type="text"
                        name="query"
                        value="{{ $query }}"
                        class="form-control"
                        placeholder="Nombre o Cédula"
                    />
                </div>
                <div class="col-md-2 mb-2">
                    {{ Form::select('estado', $estados, $estado, [
                        'class'=>'form-control','placeholder'=>'Estado'
                    ]) }}
                </div>
                <div class="col-md-2 mb-2">
                    {{ Form::select('anio', $anios, $anio, [
                        'class'=>'form-control','placeholder'=>'Año'
                    ]) }}
                </div>
                <div class="col-md-2 mb-2">
                    {{ Form::select('mes', $meses, $mes, ['class'=>'form-control']) }}
                </div>
                <div class="col-md-1 mb-2">
                    <button class="btn btn-primary btn-block" type="submit">
                        Filtrar
                    </button>
                </div>
                <div class="col-md-1 mb-2">
                    <a href="{{ route('contratos.all') }}" class="btn btn-secondary btn-block">
                        Limpiar
                    </a>
                </div>
                <div class="col-md-1 mb-2">
                    <a 
                        href="{{ route('contratos.export', request()->query()) }}" 
                        class="btn btn-success btn-block"
                    >
                        <i class="fa fa-file-excel"></i> Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-center">
            <strong>Listado de Contratos</strong>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-striped mb-0">
                    <thead class="thead-light">
                        <tr> 
                            <th>No.Cont</th>
                            <th>Contrato</th>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Estado</th>  
                            <th>Fin</th>
                            <th>Valor Total</th>
                            <th>Cuotas</th>
                            <th>Oficina</th> 
                            <th>Acción</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contratos as $c)
                        <tr> 
                            <td>{{ $c->N_C}}</td>
                            <td>{{ $c->Num_Contrato}}</td>
                            <td>{{ $c->No_Documento }}</td>
                            <td>{{ $c->Nombre }}</td>
                            <td>
                                                            @if  ($c->Estado === 'En Ejecución') 
                                    <span style="color: green; font-weight: bold;">{{ $c->Estado }}</span> 
                                @elseif ($c->Estado === 'Finalizado')
                                    <span style="color: red; font-weight: bold;">{{ $c->Estado }}</span>
                                @else
                                    <span style="color: rgb(8, 7, 7); font-weight: bold;">{{ $c->Estado }}</span>
                                @endif 
                            </td>  
                            <td>{{ strtolower(\Carbon\Carbon::parse($c->Fecha_Fin)->translatedFormat('j-M-Y')) }}</td>
                            <td>{{ number_format($c->Valor_Total,0,',','.') }}</td>
                            <td class="text-center">{{ $c->Cuotas }}</td>
                            <td>{{ $c->Nombre_Oficina }}</td> 
                            <td><a href="{{ route('contratos.ver', $c->No_Documento) }}"
                                class="btn btn-sm btn-info">
                                 <i class="fa fa-fw fa-file-contract"></i> Contratos
                             </a></td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $contratos->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection


