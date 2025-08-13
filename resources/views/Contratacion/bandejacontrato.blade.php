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
                                    <form method="GET" action="{{ url()->current() }}" class="d-flex" style="max-width: 300px;">
                                        <input type="text" name="buscar" class="form-control form-control-sm me-2"
                                            placeholder="Buscar por nombre o cédula..." value="{{ request('buscar') }}">
                                        <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                    </form>
                            </span>
                            <div class="float-right">
                                    <i class="fa-solid fa-inbox"></i>{{ __(' Bandeja de entrada') }}

                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($tabDestino)
                        <script>
                            localStorage.setItem('ultimaTabActiva', '#{{ $tabDestino }}');
                        </script>
                    @endif
                    <div class="card-body">
                        <ul class="nav nav-tabs tab-bar2">
                            <li class="tab wave dark">
                                <a class="nav-link active" id="tabPendientes" data-bs-toggle="tab" href="#pendientes" style="font-size: 17px">
                                    <i class="fa-solid fa-paper-plane" style="color: #007bff;"></i> Documentos Recibidos
                                </a>   
                            </li>
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabAprobadas" data-bs-toggle="tab" href="#aprobadas" style="font-size: 17px">
                                    <i class="fa-solid fa-rotate-left" style="color: #C70039;"></i> Documentos Devueltos
                                </a>
                            </li>
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabDevueltas" data-bs-toggle="tab" href="#devueltas" style="font-size: 17px">
                                    <i class="fa-solid fa-triangle-exclamation" style="color: #FFC107;"></i> Habilitados Sin Envío
                                </a>
                            </li>
                            <li class="tab wave dark"> 
                                <a class="nav-link" id="tabAprobados" data-bs-toggle="tab" href="#enviadas" style="font-size: 17px">
                                    <i class="fa-solid fa-check-circle" style="color: #28a745;"></i> Documentos Aprobados
                                </a>
                            </li>
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabContratacion" data-bs-toggle="tab" href="#contratacion" style="font-size: 17px">
                                    <i class="fa-solid fa-briefcase" style="color: #050505;"></i> Para Contratación
                                </a>
                            </li>
                            <li class="tab wave dark">
                                <a class="nav-link" data-bs-toggle="tab" href="#todas" style="font-size:17px">
                                    <i class="fa fa-paper-plane" style="color:#ffc107"></i> En Tramite
                                </a>
                            </li>
                        </ul>
                        <p></p>
                        <div class="tab-content">

                    {{-- RECIBIDOS--}}
                            <div id="pendientes" class="tab-pane fade show active">
                                <!-- Contenido para cuotas pendientes -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead2">
                                            <tr>
                                                <th>Contrato</th>
                                                <th>Cedula</th>
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
                                                        <td>{{ !empty($contrato->num_contrato_corto) ? $contrato->num_contrato_corto : $contrato->Id }}</td>
                                                        <td>{{ $contrato->Documento }}</td>  
                                                        <td>{{ $contrato->Nombre }}</td>  
                                                        <td>{{ $contrato->Estado_interno }}</td>
                                                        <td>{{ $contrato->nombre_oficina }}</td>
                                                        <td>
                                                                <a class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocContratos({{$contrato->Id}},'{{$contrato->Nombre}}',{{$contrato->Documento}} )"><i class="fa-solid fa-envelope-open-text"></i> Abrir</a>
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


                    {{-- DEVUELTOS--}}
                            <div id="aprobadas" class="tab-pane fade">
                                <!-- Contenido para cuotas pendientes -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead2">
                                            <tr>
                                                <th>Contrato</th>
                                                <th>Cedula</th>
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
                                                        <td>{{ !empty($contrato->num_contrato_corto) ? $contrato->num_contrato_corto : $contrato->Id }}</td>
                                                        <td>{{ $contrato->Documento }}</td> 
                                                        <td>{{ $contrato->Nombre }}</td>  
                                                        <td>{{ $contrato->Estado_interno }}</td>
                                                        <td>{{ $contrato->nombre_oficina }}</td>
                                                        <td>
                                                                <a class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocContratos({{$contrato->Id}},'{{$contrato->Nombre}}',{{$contrato->Documento}})"><i class="fa-solid fa-envelope-open-text"></i> Abrir</a>
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

                    {{-- HABILITADOS SIN EVNIO--}}
                            <div id="devueltas" class="tab-pane fade">
                                <!-- Contenido para cuotas pendientes -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead2">
                                            <tr>
                                                <th>Contrato</th>
                                                <th>Cedula</th>
                                                <th>Celular</th>
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
                                                        <td>{{ !empty($contrato->num_contrato_corto) ? $contrato->num_contrato_corto : $contrato->Id }}</td>
                                                        <td>{{ $contrato->Documento }}</td> 
                                                        <td>{{ $contrato->Nombre }}</td>  
                                                        <td>{{ $contrato->Celular }}</td>  
                                                        <td>{{ $contrato->Estado_interno }}</td>
                                                        <td>{{ $contrato->nombre_oficina }}</td>
                                                        <td>
                                                           @if (!in_array($contrato->Id, $recordatoriosHoy))
                                                                <form action="{{ route('contratos.recordatorio', $contrato->Id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    <button class="btn btn-outline-success btn-sm" type="submit" title="Reenviar recordatorio">
                                                                        <i class="fa-solid fa-paper-plane"></i> Reenviar
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <span class="text-muted" title="Ya se envió hoy">
                                                                    📤 Notificado hoy
                                                                </span>
                                                            @endif
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
    {{-- APROBADAS --}}
            <div id="enviadas" class="tab-pane fade">
                <!-- Contenido para cuotas pendientes -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead2">
                            <tr>
                                <th>Contrato</th>
                                <th>Cedula</th>
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
                                        <td>{{ !empty($contrato->num_contrato_corto) ? $contrato->num_contrato_corto : $contrato->Id }}</td>
                                        <td>{{ $contrato->Documento }}</td>
                                        <td>{{ $contrato->Nombre }}</td>  
                                        <td>{{ $contrato->Estado_interno }}</td>
                                        <td>{{ $contrato->nombre_oficina }}</td> 
                                        <td>
                                                <a class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocContratos({{$contrato->Id}},'{{$contrato->Nombre}}',{{$contrato->Documento}})"><i class="fa-solid fa-envelope-open-text"></i> Abrir</a>
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
{{-- PARA CONTRATACION  --}}
            <div id="contratacion" class="tab-pane fade">
                <!-- Contenido para cuotas pendientes -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead2">
                            <tr>
                                <th>Contrato</th>
                                <th>Cedula</th>
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
                                        <td>{{ !empty($contrato->num_contrato_corto) ? $contrato->num_contrato_corto : $contrato->Id }}</td>
                                        <td>{{ $contrato->Documento }}</td>
                                        <td>{{ $contrato->Nombre }}</td>  
                                        <td>{{ $contrato->Estado_interno }}</td>
                                        <td>{{ $contrato->nombre_oficina }}</td>
                                        <td>
                                        <a href="{{ route('contratos.edit', $contrato->Id) }}"  class="btn btn-sm btn-warning">
                                                <i class="fa fa-fw fa-edit"></i> Editar
                                        </a> <button class="btn btn-info btn-sm" onclick="verBitacoraContrato({{ $contrato->Id }})">
                                            <i class="fa fa-clock"></i> Ver bitácora
                                        </button> @csrf
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



            {{-- todas  EN TRAMITES --}}
            <div id="todas" class="tab-pane fade">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead class="thead2">
                    <tr>
                      <th>Contrato</th><th>Cedula</th><th>Nombre</th><th>Estado</th><th>Oficina</th><th>Acción</th> <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contratosT as $contrato)
                      <tr>
                        <td>{{ !empty($contrato->num_contrato_corto) ? $contrato->num_contrato_corto : $contrato->Id }}</td>
                        <td>{{ $contrato->Documento }}</td>
                        <td>{{ $contrato->Nombre }}</td> 
                        <td>{{ $contrato->Estado_interno ?? 'Pendiente' }}</td>
                        <td>{{ $contrato->nombre_oficina }}</td> 
                         <td><button class="btn btn-info btn-sm" onclick="verBitacoraContrato({{ $contrato->Id }})">
                            <i class="fa fa-clock"></i> Ver bitácora
                        </button></td>
                      </tr>
                    @empty
                      <tr><td colspan="6" class="text-center">No hay datos disponibles.</td></tr>
                    @endforelse
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
<!-- Estilo personalizado para letra más pequeña -->
<style>
    #tablaDocs td,
    #tablaDocs th {
        font-size: 14px !important;
    }

    #tablaDocs textarea {
        font-size: 12px !important;
    }
</style>

<!-- MODAL DE DOCUMENTOS -->
<div class="modal fade" id="modalDocUploadCuota" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 95%; margin: 1rem auto; height: 95vh;">        
        <div class="modal-content shadow-lg rounded-3" style="height: 100%; overflow: hidden;">
            <!-- HEADER -->
            <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                background-repeat: no-repeat;
                                color: rgb(6, 6, 6);
                                font-family: 'Mallanna';
                                font-size: 14px;">
                <h5 class="modal-title"><div class="float-right" id="nameContratista"><b></b></div></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar" style="font-size: 1.8rem; color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>  
            </div>

            <!-- BODY -->
            <div class="modal-body p-0" style="height: 100%; overflow: hidden;">
                <div class="row h-100 m-0 flex-column flex-md-row">
                    <!-- TABLA - -->
                    <div class="col-md-6 p-2 overflow-auto border-end" style="max-height: 100%;">
                        <div class="table-responsive">
                            <table id="tablaDocs" class="table table-sm table-striped table-hover align-middle text-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Est</th>
                                        <th>Nombre del Archivo</th>
                                        <th>Observación</th>
                                        <th colspan="2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Aquí Laravel renderiza los <tr> con los documentos --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- PDF -->
                    <div class="col-md-6 p-2">
                        <embed id="pdfEmbed"
                            src="https://cuentafacil.co/storage/doc_cuenta/predeterminado1.pdf"
                            type="application/pdf"
                            style="width: 100%; height: 100%; border: none;" />
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>


      {{-- MODAL BITACORA --}}
<div class="modal fade" id="modalBitacora" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 90%; margin: 1rem auto; height: 95vh;">
        <div class="modal-content shadow-lg rounded-3" style="height: 90%; overflow: hidden;">

            <!-- HEADER -->
            <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                color: white; font-family: 'Mallanna'; font-size: 17px;">
                <h5 class="modal-title text-dark fw-bold">📜 Historial del Contrato</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar"
                        style="font-size: 1.5rem; color: white">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body p-2 overflow-auto" style="height: calc(100vh - 56px);">
                <div id="tablaBitacoraContainer">
                    Cargando...
                </div> 
            </div> 

        </div>
    </div>
</div>
 
@endsection

@section('js')

    {{Html::script(asset('js/juridica/juridica.js'))}}
@endsection

