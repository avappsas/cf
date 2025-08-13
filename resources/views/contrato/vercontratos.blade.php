@extends('layouts.app')

@section('template_title')
    Contrato
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{-- {{ __('Mis Contrato') }} --}}
                            </span>

                             <div class="float-center"> 
                                {{ $nombre ?? $documento }} <i class="fa fa-fw fa-file-contract"></i> 
                                {{ __('Mis Contrato') }} 
                              </div>
                                    {{-- Botón Nuevo Contrato --}}
                                    <a href="{{ route('contratos.create2', ['documento' => $documento]) }}"
                                        class="btn btn-sm btn-success">
                                        <i class="fa fa-plus"></i> Habilitar Documentación
                                    </a>
                                    <a href="{{ route('contratos.create', ['documento' => $documento]) }}"
                                        class="btn btn-sm btn-success">
                                         <i class="fa fa-fw fa-plus"></i> Nuevo Contrato
                                    </a>

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
                                <thead class="thead2">
                                    <tr> 
										<th>Id</th> 
                                        <th>Modalidad</th> 
										<th>Estado</th> 
										<th>Num Contrato</th> 
                                        <th>Fecha Inicio</th>
										<th>Fecha Terminación</th> 
										<th>Cuotas</th> 
										<th>Oficina</th>
                                        <th>Ver</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contratos as $contrato)
                                        <tr>
                                            
											<td>{{ $contrato->Id }}</td>
                                            <td>{{ $contrato->Modalidad }}</td>
											<td>  @if ($contrato->Estado === 'Finalizado')
                                                <span style="color: red; font-weight: bold;">{{ $contrato->Estado }}</span>
                                            @elseif ($contrato->Estado === 'En Ejecución')
                                                <span style="color: green; font-weight: bold;">{{ $contrato->Estado }}</span>
                                            @elseif ($contrato->Estado === 'Documentación')
                                                <span style="color: black; font-weight: bold;">{{ $contrato->Estado }}</span>
                                            @elseif ($contrato->Estado === 'Documentos Devueltos')
                                                <span style="color: orange; font-weight: bold;">{{ $contrato->Estado }}</span>
                                            @elseif ($contrato->Estado === 'Documentos Enviados')
                                                <span style="color: green; font-weight: bold;">{{ $contrato->Estado }}</span>
                                            @else
                                                {{ $contrato->Estado }}
                                            @endif
                                            </td>
											<td>{{ $contrato->Num_Contrato }}</td>
											<td>  {{ $contrato->Fecha_Suscripcion
                                                ? \Carbon\Carbon::parse($contrato->Fecha_Suscripcion)->format('d-m-Y')
                                                : ''
                                            }}</td>
                                            <td>  {{ $contrato->Plazo
                                                ? \Carbon\Carbon::parse($contrato->Plazo)->format('d-m-Y')
                                                : ''
                                            }}</td> 
                                            <td>{{ $contrato->Cuotas }}</td>
											<td>{{ $contrato->N_Oficina }}</td>

                                            <td>
                                                <a href="{{ route('contratos.edit', $contrato->Id) }}"  class="btn btn-sm btn-warning">
                                                <i class="fa fa-fw fa-edit"></i> Editar
                                            </a>
                                                <form action="{{ route('contratos.destroy',$contrato->Id) }}" method="POST">
                                                     @csrf
                                                    @method('DELETE')
                                                    {{-- <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>  --}}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $contratos->links() !!}
            </div>
        </div>
    </div>


@endsection

 



