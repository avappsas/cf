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
                                {{-- <a href="{{ route('cuotas.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a> --}}
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
                                <a class="nav-link active " id="tabPendientes" data-toggle="tab" href="#pendientes" style="font-size: 17px"><i class="fa-solid fa-bars" style="color: #FFD43B;"></i> Pendientes</a>
                            </li>
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabAprobadas" data-toggle="tab" href="#aprobadas" style="font-size: 17px"><i class="fa-regular fa-circle-check" style="color: #568c1d;"></i> Aprobadas</a>
                            </li>
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabDevueltas" data-toggle="tab" href="#devueltas" style="font-size: 17px"><i class="fa-solid fa-rotate-left" style="color: #C70039;"></i> Devueltas</a>
                            </li>
                            @if($perfil == 4)
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabEnviadas" data-toggle="tab" href="#enviadas" style="font-size: 17px"><i class="fa-solid fa-file-arrow-up" style="color: #568c1d;"></i> Contabilidad</a>
                            </li>
                            @endif
                        </ul>
                        <p></p>
                        <div class="tab-content">
                            <div id="pendientes" class="tab-pane fade show active">
                                <!-- Contenido para cuotas pendientes -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead2">
                                            <tr>
                                                
                                                <th>Nombre</th>
                                                <th>Cuota</th>
                                                <th>Fecha Acta</th>
                                                <th>Oficina</th>
                                                <th>Parcial</th>
                                                <th> %</th>
                                                <th>Estado</th>
                                                @if ($perfil == 1)
                                                    <th>Asignacion</th>
                                                @endif

                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cuotas as $cuota)
                                                @if (Auth::user()->id == $cuota->id_user || $perfil == 1 || $perfil == 4)
                                                    <tr>
                                                        
                                                        <td>{{ $cuota->Nombre }}</td>
                                                        <td>Cuota {{ $cuota->Cuota }}</td>
                                                        <td>{{ $cuota->Fecha_Acta }}</td>
                                                        <td>{{ $cuota->Oficina }}</td>
                                                        <td>{{ $cuota->Parcial }}</td>
                                                        <td>{{ $cuota->Porcentaje }}%</td>
                                                        <td>{{ $cuota->Estado_juridica }}</td>
                                                        @if ($perfil == 1)
                                                            <td>
                                                                <div class="input-group mb-3">
                                                                    {{ Form::select('userAsignado', $listaAsignacionFormateada, $cuota->id_user, ['class' => 'form-control form-control-sm' . ($errors->has('userAsignado') ? ' is-invalid' : ''), 'placeholder' => 'Asignar','id' => 'asignacion_' .$cuota->Id]) }}
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-outline-success btn-sm" type="button" onclick="asignarUser({{$cuota->Id}})">Asignar</button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        
                                                        <td>
                                                                <a class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocCuotas({{$cuota->Contrato}},{{$cuota->Id}},'{{$cuota->Nombre}}')"><i class="fa-solid fa-envelope-open-text"></i> Abrir</a>
                                                                @csrf
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="aprobadas" class="tab-pane fade">
                                <!-- Contenido para cuotas aprobadas -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead2">
                                            <tr>
                                                
                                                <th>Nombre</th>
                                                <th>Cuota</th>
                                                <th>Fecha Acta</th>
                                                {{-- <th>Mes Cobro</th> --}}
                                                <th>Oficina</th>
                                                <th>Parcial</th>
                                                <th> %</th>
                                                <th>Estado</th>
                                                <th>Responsable</th>

                                                {{-- <th></th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cuotasA as $cuotaA)
                                                <tr>
                                                    
                                                    <td>{{ $cuotaA->Nombre }}</td>
                                                    <td>Cuota {{ $cuotaA->Cuota }}</td>
                                                    <td>{{ $cuotaA->Fecha_Acta }}</td>
                                                    {{-- <td>{{ $cuotaA->Mes_cobro }}</td> --}}
                                                    <td>{{ $cuotaA->Oficina }}</td>
                                                    <td>{{ $cuotaA->Parcial }}</td>
                                                    <td>{{ $cuotaA->Porcentaje }}%</td>
                                                    <td>{{ $cuotaA->Estado_juridica }}</td>
                                                    <td>{{ $cuotaA->nameUser }}</td>

                                                    {{-- <td> --}}
                                                        {{-- <form action="{{ route('cuotas.destroy',$cuotaA->Id) }}" method="POST"> --}}
                                                            {{-- <a class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocCuotas({{$cuotaA->Contrato}},{{$cuotaA->Id}},'{{$cuotaA->Nombre}}')"><i class="fa-solid fa-envelope-open-text"></i> Abrir</a> --}}
                                                            {{-- <a class="btn btn-sm btn-success" href="{{ route('cuotas.edit',$cuota->Id) }}"><i class="fa-solid fa-file-circle-check"></i> Aprovar</a>
                                                            <a class="btn btn-sm btn-danger " href="{{ route('cuotas.show',$cuota->Id) }}"><i class="fa-solid fa-file-circle-xmark"></i> Devolver</a> --}}
                                                            @csrf
                                                    {{-- </td> --}}
                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- <a href="generarZip" class="btn btn-light btn-sm float-right"><i class="fa-solid fa-file-zipper"></i> Descargar Zip</a> --}}
                                    @if($perfil == 4)
                                        <a onclick="enviarLote()" class="btn btn-light btn-sm float-right"><i class="fa-solid fa-file-zipper"></i> Generar Lote</a>
                                    @endif    
                                </div>
                            </div>


                            <div id="devueltas" class="tab-pane fade">
                                <!-- Contenido para cuotas DEVUELTAS -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead2">
                                            <tr>
                                                
                                                <th>Nombre</th>
                                                <th>Cuota</th>
                                                <th>Fecha Acta</th>
                                                {{-- <th>Mes Cobro</th> --}}
                                                <th>Oficina</th>
                                                <th>Parcial</th>
                                                <th> %</th>
                                                <th>Estado</th>
                                                <th>Responsable</th>

                                                {{-- <th></th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cuotasD as $cuotaD)
                                                <tr>
                                                    
                                                    <td>{{ $cuotaD->Nombre }}</td>
                                                    <td>Cuota {{ $cuotaD->Cuota }}</td>
                                                    <td>{{ $cuotaD->Fecha_Acta }}</td>
                                                    {{-- <td>{{ $cuotaD->Mes_cobro }}</td> --}}
                                                    <td>{{ $cuotaD->Oficina }}</td>
                                                    <td>{{ $cuotaD->Parcial }}</td>
                                                    <td>{{ $cuotaD->Porcentaje }}%</td>
                                                    <td>{{ $cuotaD->Estado_juridica }}</td>
                                                    <td>{{ $cuotaD->nameUser }}</td>

                                                   @csrf

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            
                            @if($perfil == 4)
                                <div id="enviadas" class="tab-pane fade">
                                    <!-- Contenido para cuotas aprobadas -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead2">
                                                <tr>
                                                    
                                                    <th colspan="8">Nombre</th>
                                                    <th>Fecha</th>
                                                    {{-- <th>Estado</th> --}}
                                                    <th>Responsable</th>
        
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cuotasE as $cuotaE)
                                                    <tr  class="tr-principal">
                                                        
                                                        <td colspan="8"><i  onclick="mostrarSubTabla(this)"  class="fa-solid fa-circle-chevron-right"></i> {{ $cuotaE->nombre }}
                                                            <!-- Contenido de la celda <i   onclick="mostrarSubTabla(this)" class="fa-solid fa-circle-chevron-down"></i>  -->
                                                            <table class="table table-striped table-hover tabla-anidada" style="display: none">
                                                                <div class="thead">
                                                                    <tr onclick="event.stopPropagation();">
                                                        
                                                                        <th colspan="3">Nombre</th>
                                                                        <th>Documento</th>
                                                                        <th>Cuota</th>
                                                                        <th>No. Contrato</th>
                                                                        <th>RPC</th>
                                                                        <th>Consecutivo</th>
                                                                        {{-- <th colspan="3">Responsable</th> --}}
                                                                        <th> </th>
                                                                    </tr>
                                                                </div>
                                                                @foreach($cuotasE2 as $cuotasE20)
                                                                @if ($cuotaE->id == $cuotasE20->FUID)
                                                                    <tr  onclick="event.stopPropagation();">
                                                                        <td colspan="3">{{ $cuotasE20->Nombre }}</td>
                                                                        <td>{{ $cuotasE20->documento }}</td>
                                                                        <td>{{ $cuotasE20->Cuota }}</td>
                                                                        <td>{{ $cuotasE20->Num_Contrato }}</td>
                                                                        <td>{{ $cuotasE20->rpc }}</td>
                                                                        <td>{{ $cuotasE20->consecutivo }}</td>
                                                                        {{-- <td colspan="3">{{ $cuotasE20->nameUser }}</td> --}}
                                                                        <td>
                                                                            <a class="btn btn-sm btn-dark" onclick="descargarZipSap({{$cuotasE20->Id}},{{$cuotasE20->Cuota}},'{{$cuotasE20->Nombre}}')"><i class="fa-regular fa-file-zipper"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                @endforeach
                                                            </table>
                                                        </td>
                                                        <td>{{ $cuotaE->created_at }}</td>
                                                        {{-- <td>{{ $cuotaE->estado }}</td> --}}
                                                        {{-- <td>{{ $cuotaA->nameUser }}</td> --}}
                                                        <td>{{$cuotaE->nameUser}}</td>
        
                                                        <td>
                                                            {{-- <form action="{{ route('cuotas.destroy',$cuotaA->Id) }}" method="POST"> --}}
                                                                <a class="btn btn-sm btn-success" onclick="contabilizar()"><i class="fa-regular fa-circle-check"></i> Aprobar Paquete</a>
                                                                {{-- <a class="btn btn-sm btn-success" href="{{ route('cuotas.edit',$cuota->Id) }}"><i class="fa-solid fa-file-circle-check"></i> Aprovar</a>
                                                                <a class="btn btn-sm btn-danger " href="{{ route('cuotas.show',$cuota->Id) }}"><i class="fa-solid fa-file-circle-xmark"></i> Devolver</a> --}}
                                                                @csrf
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- <a href="generarZip" class="btn btn-light btn-sm float-right"><i class="fa-solid fa-file-zipper"></i> Descargar Zip</a> --}}
                                        {{-- <a onclick="enviarLote()" class="btn btn-light btn-sm float-right"><i class="fa-solid fa-file-zipper"></i> Descargar Zip</a> --}}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {!! $cuotas->links() !!}
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
                                        <embed id="pdfEmbed" src="http://avapp.digital/cf/public/storage/doc_cuenta/predeterminado.pdf" type="application/pdf" width="100%" height="100%">
                                    </div>
                                    
                                </div>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <div class="row">
                        <a class="btn btn-md btn-danger" onclick="cambioEstadoCuenta(0)" style="margin-right: 3px"><i class="fa-solid fa-file-circle-xmark"></i> Devolver</a>
                        <a class="btn btn-md btn-success" onclick="cambioEstadoCuenta(1)" style="margin-right: 3px"><i class="fa-solid fa-file-circle-check"></i> Aprobar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{Html::script(asset('js/juridica/juridica.js'))}}
@endsection