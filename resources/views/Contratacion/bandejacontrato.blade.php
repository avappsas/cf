@extends('layouts.app')

@section('template_title')
    Cuota
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                            </span>

                             <div class="float-right">
                          
                                <i class="fa-solid fa-inbox"></i>
                                {{ __('Bandeja de entrada') }}
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <ul class="nav nav-tabs tab-bar2">
                            <li class="tab wave dark">
                                <a class="nav-link active" id="tabPendientes" data-toggle="tab" href="#pendientes" style="font-size: 17px">
                                    <i class="fa-solid fa-paper-plane" style="color: #007bff;"></i> Documentos Recibidos
                                </a>   
                            </li>
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabAprobadas" data-toggle="tab" href="#aprobadas" style="font-size: 17px">
                                    <i class="fa-solid fa-rotate-left" style="color: #C70039;"></i> Documentos Devueltos
                                </a>
                            </li>
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabDevueltas" data-toggle="tab" href="#devueltas" style="font-size: 17px">
                                    <i class="fa-solid fa-triangle-exclamation" style="color: #FFC107;"></i> Pendientes Sin Envío
                                </a>
                            </li>
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabAprobados" data-toggle="tab" href="#enviadas" style="font-size: 17px">
                                    <i class="fa-solid fa-check-circle" style="color: #28a745;"></i> Documentos Aprobados
                                </a>
                            </li>
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabContratacion" data-toggle="tab" href="#contratacion" style="font-size: 17px">
                                    <i class="fa-solid fa-briefcase" style="color: #28a745;"></i> Para Contratación
                                </a>
                            </li>
                        </ul>
                        <p></p>
                        <div class="tab-content">
                            <div id="pendientes" class="tab-pane fade show active">
                                <!-- Contenido para cuotas pendientes -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead2">
                                            <tr>
                                                <th>iD</th>
                                                <th>Nombre</th>  
                                                <th>Estado</th>
                                                <th>Oficina</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($contratos) > 0)
                                                @foreach ($contratos as $contrato)
                                                    <tr>
                                                        <td>{{ $contrato->Id }}</td>
                                                        <td>{{ $contrato->Nombre }}</td>  
                                                        <td>{{ $contrato->Estado }}</td>
                                                        <td>{{ $contrato->nombre_oficina }}</td>
                                                        <td>
                                                                <a class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocContratos({{$contrato->Id}},'{{$contrato->Nombre}}')"><i class="fa-solid fa-envelope-open-text"></i> Abrir</a>
                                                                @csrf
                                                        </td>
                                                    </tr>
                                            @endforeach
                                            @else
                                                <tr><td colspan="8">No hay datos disponibles.</td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>



                            <div id="aprobadas" class="tab-pane fade">
                                <!-- Contenido para cuotas pendientes -->
                                        <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead2">
                                            <tr>
                                                <th>iD</th>
                                                <th>Nombre</th>  
                                                <th>Estado</th>
                                                <th>Oficina</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($contratosB) > 0)
                                                @foreach ($contratosB as $contrato)

                                                    <tr>
                                                        <td>{{ $contrato->Id }}</td>
                                                        <td>{{ $contrato->Nombre }}</td>  
                                                        <td>{{ $contrato->Estado }}</td>
                                                        <td>{{ $contrato->nombre_oficina }}</td>
                                                        <td>
                                                                <a class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocContratos({{$contrato->Id}},'{{$contrato->Nombre}}')"><i class="fa-solid fa-envelope-open-text"></i> Abrir</a>
                                                                @csrf
                                                        </td>
                                                    </tr>

                                                @endforeach
                                            @else
                                                <tr><td colspan="8">No hay datos disponibles.</td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                </div>
    </div>

                            <div id="devueltas" class="tab-pane fade">
                                <!-- Contenido para cuotas pendientes -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead2">
                                            <tr>
                                                <th>iD</th>
                                                <th>Nombre</th>  
                                                <th>Estado</th>
                                                <th>Oficina</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($contratosC) > 0)
                                                @foreach ($contratosC as $contrato)

                                                    <tr>
                                                       <td>{{ $contrato->Id }}</td>
                                                        <td>{{ $contrato->Nombre }}</td>  
                                                        <td>{{ $contrato->Estado }}</td>
                                                        <td>{{ $contrato->nombre_oficina }}</td>
                                                        <td>
                                                                <a class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocContratos({{$contrato->Id}},'{{$contrato->Nombre}}')"><i class="fa-solid fa-envelope-open-text"></i> Abrir</a>
                                                                @csrf
                                                        </td>
                                                    </tr>

                                                @endforeach
                                            @else
                                                <tr><td colspan="8">No hay datos disponibles.</td></tr>
                                            @endif
                                        </tbody>
                                    </table>
                </div>
            </div>
            <div id="enviadas" class="tab-pane fade">
                <!-- Contenido para cuotas pendientes -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead2">
                            <tr>
                                <th>iD</th>
                                <th>Nombre</th>  
                                <th>Estado</th>
                                <th>Oficina</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($contratosD) > 0)
                                @foreach ($contratosD as $contrato)

                                    <tr>
                                        <td>{{ $contrato->Id }}</td>
                                        <td>{{ $contrato->Nombre }}</td>  
                                        <td>{{ $contrato->Estado }}</td>
                                        <td>{{ $contrato->nombre_oficina }}</td> 
                                        <td>
                                                <a class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocContratos({{$contrato->Id}},'{{$contrato->Nombre}}')"><i class="fa-solid fa-envelope-open-text"></i> Abrir</a>
                                                @if($contrato->Estado == 'Hoja de Vida Aprobada')
                                                    <a class="btn btn-sm btn-warning" onclick="solicitarCDP({{ $contrato->Id }})">
                                                    <i class="fa fa-refresh"></i> solicitarCDP </a>                                                
                                                @endif

                                                @csrf
                                        </td>
                                    </tr>

                                @endforeach
                            @else
                                <tr><td colspan="8">No hay datos disponibles.</td></tr>
                            @endif
                            <div class="modal fade" id="solicitudCdpModal" tabindex="-1" aria-labelledby="solicitudCdpModalLabel" aria-hidden="true">
                                <div class="modal fade" id="solicitudCdpModal" tabindex="-1" aria-labelledby="solicitudCdpModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="solicitudCdpModalLabel">Información</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="contratacion" class="tab-pane fade">
                <!-- Contenido para cuotas pendientes -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead2">
                            <tr>
                                <th>iD</th>
                                <th>Nombre</th>  
                                <th>Estado</th>
                                <th>Oficina</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($contratosF) > 0)
                                @foreach ($contratosF as $contrato)

                                    <tr>
                                        <td>{{ $contrato->Id }}</td>
                                        <td>{{ $contrato->Nombre }}</td>  
                                        <td>{{ $contrato->Estado }}</td>
                                        <td>{{ $contrato->nombre_oficina }}</td>
                                        <td>
                                        <a href="{{ route('contratos.edit', $contrato->Id) }}"  class="btn btn-sm btn-warning">
                                                <i class="fa fa-fw fa-edit"></i> Editar
                                        </a>

                                                @csrf
                                        </td>
                                    </tr>

                                @endforeach
                            @else
                                <tr><td colspan="8">No hay datos disponibles.</td></tr>
                            @endif
                            <div class="modal fade" id="solicitudCdpModal" tabindex="-1" aria-labelledby="solicitudCdpModalLabel" aria-hidden="true">
                                <div class="modal fade" id="solicitudCdpModal" tabindex="-1" aria-labelledby="solicitudCdpModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="solicitudCdpModalLabel">Información</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
                </div>
                {!! $contratos->links() !!}
            </div>
        </div>
    </div>

    {{-- modal para cargar documentos cuotas --}}

    <div class="modal fade bd-example-modal-xl" id="modalDocUploadCuota" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                background-repeat: no-repeat;
                                color: white;
                                font-family: 'Mallanna';
                                font-size: 17px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalDocUploadCuota"><div class="card">
                    <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">

                                <span id="card_title">

                                </span>

                                <div class="float-right" id="nameContratista">
                                    {{-- {{ __('Documentos') }} --}}
                                </div>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <div class="card-body">
                            <div class="form-group" >
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <div class="table table-striped table-hover" id="tablaDocs">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <embed id="pdfEmbed" src="https://cuentafacil.co/storage/doc_cuenta/predeterminado.pdf" type="application/pdf" width="100%" height="100%">
                                    </div> 
                                </div>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
 
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{Html::script(asset('js/juridica/juridica.js'))}}
@endsection