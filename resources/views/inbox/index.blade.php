@extends('layouts.app')

@section('template_title')
    Inbox
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">

        {{-- Header --}}
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <span id="card_title"></span>
            <div class="float-right">
              <i class="fa-solid fa-inbox"></i> {{ __('Buzón de entrada') }} {{ $perfiUser }}
            </div>
          </div>
        </div>

        @if ($message = Session::get('success'))
          <div class="alert alert-success"><p>{{ $message }}</p></div>
        @endif

        <div class="card-body">
          {{-- Tabs --}}
          <ul class="nav nav-tabs tab-bar2">
            {{-- @if( $perfiUser != 8 && $perfiUser != 9 && $perfiUser != 13)
            <li class="tab wave dark">
              <a class="nav-link active" data-toggle="tab" href="#pendientes" style="font-size:17px">
                <i class="fa fa-envelope" style="color:#007bff"></i> Documentos Recibidos
              </a>
            </li> 
            @endif --}}
            <li class="tab wave dark">
              <a class="nav-link active" data-toggle="tab" href="#aprobadas" style="font-size:17px">
                <i class="fa fa-thumbs-up" style="color:#28a745"></i> Documentos Recibidos
              </a>
            </li>
            <li class="tab wave dark">
              <a class="nav-link" data-toggle="tab" href="#devueltas" style="font-size:17px">
                <i class="fa fa-undo" style="color:#dc3545"></i> Documentos Devueltos
              </a>
            </li>

            <li class="tab wave dark">
              <a class="nav-link" data-toggle="tab" href="#enviadas" style="font-size:17px">
                <i class="fa fa-paper-plane" style="color:#ffc107"></i> En Tramite
              </a>
            </li>
            @if($perfiUser == 10 || $perfiUser == 13)
            <li class="tab wave dark">
              <a class="nav-link" data-toggle="tab" href="#cuentas" style="font-size:17px">
                <i class="fa fa-thumbs-up" style="color:#28a745"></i> Cuentas Pendientes
              </a>
            </li>
            @endif
 
          </ul>

          <div class="tab-content mt-3">
            {{-- Pendientes --}}
            <div id="pendientes" class="tab-pane fade">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead class="thead2">
                    <tr>
                      <th>Contrato</th><th>Documento</th><th>Nombre</th><th>Estado</th><th>Oficina</th><th>CDP</th><th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contratos as $contrato)
                      <tr>
                        <td>{{ !empty($contrato->num_contrato_corto) ? $contrato->num_contrato_corto : $contrato->Id }}</td>
                        <td>{{ $contrato->No_Documento }}</td>
                        <td>{{ $contrato->Nombre }}</td>
                        <td>{{ $contrato->Estado_interno }}</td>
                        <td>{{ $contrato->nombre_oficina }}</td>
                        <td>{{ $contrato->CDP }}</td>
                        <td>
                          @if($contrato->Estado_interno === 'Solicitud CDP-Liberar' || $contrato->Estado_interno === 'Solicitud RPC-A' || $contrato->Estado_interno === 'Solicitud RPC-P' )
                              <a class="btn btn-sm btn-success" onclick="cambioEstadoContrato(1, {{ isset($contrato) ? $contrato->Id : 'null' }})" style="margin-right: 3px" id="btnAprobar">   <i class="fa-solid fa-file-circle-xmark" ></i>_Liberado en SAP</a>
                          @elseif($contrato->Estado_interno === 'Solicitud CDP')
                          <button class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocBuzonver({{ $contrato->Id }}, 1, '{{ $contrato->Nombre }}')"> <i class="fa-solid fa-envelope-open-text"></i> Abrir </button>                     
                           @endif 
                          @if($contrato->Estado_interno === 'Secop-Presidencia')
                              <a class="btn btn-sm btn-success" onclick="cambioEstadoContrato(1, {{ isset($contrato) ? $contrato->Id : 'null' }})" style="margin-right: 3px" id="btnAprobar">   <i class="fa-solid fa-file-circle-xmark" ></i> Ya Firme Secop</a>
                              <a class="btn btn-sm btn-success" onclick="cambioEstadoContrato(1, {{ isset($contrato) ? $contrato->Id : 'null' }})" style="margin-right: 3px" id="btnAprobar">   <i class="fa-solid fa-file-circle-xmark" ></i> Aprobar</a>
                          @else 
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr><td colspan="5" class="text-center">No hay datos disponibles.</td></tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            {{-- Devueltas --}}
            <div id="devueltas" class="tab-pane fade">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead class="thead2">
                    <tr>
                      <th>Contrato</th><th>Documento</th><th>Nombre</th><th>Estado</th><th>Oficina</th><th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contratosC as $contrato)
                      <tr>
                        <td>{{ !empty($contrato->num_contrato_corto) ? $contrato->num_contrato_corto : $contrato->Id }}</td>
                        <td>{{ $contrato->No_Documento }}</td>
                        <td>{{ $contrato->Nombre }}</td>
                        <td>{{ $contrato->Estado_interno }}</td>
                        <td>{{ $contrato->nombre_oficina }}</td>
                        <td>
                          <button class="btn btn-sm btn-info"
                                  onclick="btnAbrirModalVerDocBuzon({{ $contrato->Id }}, 1, '{{ $contrato->Nombre }}')">
                            <i class="fa-solid fa-envelope-open-text"></i> Abrir
                          </button>
                        </td>
                      </tr>
                    @empty
                      <tr><td colspan="5" class="text-center">No hay datos disponibles.</td></tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            {{-- Aprobadas --}}
            <div id="aprobadas" class="tab-pane fade show active">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead class="thead2">
                    <tr>
                      <th>Contrato</th><th>Documento</th><th>Nombre</th><th>Estado</th><th>Oficina</th><th>CDP</th><th>RPC</th><th>Estado</th><th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contratosB as $contrato)
                      <tr>
                        <td>{{ !empty($contrato->num_contrato_corto) ? $contrato->num_contrato_corto : $contrato->Id }}</td>
                        <td>{{ $contrato->No_Documento }}</td>
                        <td>{{ $contrato->Nombre }}</td>
                        <td>{{ $contrato->Estado_interno ?? 'Pendiente' }}</td>
                        <td>{{ $contrato->nombre_oficina }}</td>
                        <td>{{ $contrato->CDP ?? '—' }}</td>
                        <td>{{ $contrato->RPC ?? '—' }}</td>
                        <td>{{ $contrato->Estado ?? '—' }}</td>
                        <td>
                          @if($perfiUser == 10  )
                            <a href="{{ route('contratos.show', $contrato->Id) }}"  class="btn btn-sm btn-warning"> <i class="fa fa-fw fa-eye"></i> Contrato </a>
                            <a href="{{ route('base-datos.edit.documento', $contrato->No_Documento) }}"  class="btn btn-sm btn-warning"  target="_blank"> <i class="fa fa-fw fa-edit"></i> Datos </a>                           
                            <button class="btn btn-sm btn-info" onclick="window.open('{{ url('/ficha/' . $contrato->Id) }}', '_blank')" class="btn btn-info"> Ficha</button>                  
                            <button class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocBuzon({{ $contrato->Id }}, 1, '{{ $contrato->Nombre }}')"> <i class="fa-solid fa-envelope-open-text"></i> Cargar</button>
                          @elseif($perfiUser == 11  )
                            <a href="{{ route('contratos.show', $contrato->Id) }}"  class="btn btn-sm btn-warning"> <i class="fa fa-fw fa-eye"></i> Contrato </a>
                            <button class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocBuzon({{ $contrato->Id }}, 1, '{{ $contrato->Nombre }}')"> <i class="fa-solid fa-envelope-open-text"></i> Abrir</button>
                          @elseif($contrato->Estado_interno === 'Solicitud CDP-Liberar' || $contrato->Estado_interno === 'Solicitud RPC-A' || $contrato->Estado_interno === 'Solicitud RPC-P' )
                              <a class="btn btn-sm btn-success" onclick="cambioEstadoContrato(1, {{ isset($contrato) ? $contrato->Id : 'null' }})" style="margin-right: 3px" id="btnAprobar">   <i class="fa-solid fa-file-circle-xmark" ></i>_Liberado en SAP</a>
                          @elseif($contrato->Estado_interno === 'Firma Secop-Presidencia')
                              <a class="btn btn-sm btn-success" onclick="cambioEstadoContrato(1, {{ isset($contrato) ? $contrato->Id : 'null' }})" style="margin-right: 3px" id="btnAprobar">   <i class="fa-solid fa-file-circle-xmark" ></i> Ya Firme Secop</a>
                              {{-- <a class="btn btn-sm btn-success" onclick="cambioEstadoContrato(1, {{ isset($contrato) ? $contrato->Id : 'null' }})" style="margin-right: 3px" id="btnAprobar">   <i class="fa-solid fa-file-circle-xmark" ></i> Aprobar</a> --}}
                          @elseif($contrato->Estado_interno === 'Solicitud CDP')
                          <button class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocBuzonver({{ $contrato->Id }}, 1, '{{ $contrato->Nombre }}')"> <i class="fa-solid fa-envelope-open-text"></i> Abrir </button>                     
                           @else  
                           <button class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocBuzon({{ $contrato->Id }}, 1, '{{ $contrato->Nombre }}')"> <i class="fa-solid fa-envelope-open-text"></i> Abrir</button>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr><td colspan="6" class="text-center">No hay datos disponibles.</td></tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>


            {{-- todas o enviadas--}}
            <div id="enviadas" class="tab-pane fade">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead class="thead2">
                    <tr>
                      <th>Contrato</th><th>Documento</th><th>Nombre</th><th>Estado</th><th>Oficina</th><th>Acción</th><th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contratosT as $contrato)
                      <tr>
                        <td>{{ !empty($contrato->num_contrato_corto) ? $contrato->num_contrato_corto : $contrato->Id }}</td>
                        <td>{{ $contrato->No_Documento }}</td>
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

              <!-- CUENTAS PENDIENTES  -->
                            @if($perfiUser == 10 || $perfiUser == 13 )
                                <div id="cuentas" class="tab-pane fade"> 
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead2">
                                                <tr> 
                                                    <th colspan="8">Nombre</th> 
                                                    <th colspan="8">Aprobar</th> 
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cuotasE as $cuotaE)
                                                    <tr  class="tr-principal">
                                                        
                                                        <td colspan="8"><i  onclick="mostrarSubTabla(this)"  class="fa-solid fa-circle-chevron-right"></i> {{ $cuotaE->id }} -{{ $cuotaE->nombre }}
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
                                                                        <th>Entrada</th> 
                                                                        <th>Estado</th> 
                                                                        <th> </th>
                                                                    </tr>
                                                                </div>
                                                                @foreach($cuotasP as $cuota)
                                                                @if ($cuotaE->id == $cuota->FUID)
                                                                    <tr  onclick="event.stopPropagation();">
                                                                        <td colspan="3">{{ $cuota->Nombre }}</td>
                                                                        <td>{{ $cuota->Documento }}</td>
                                                                        <td>{{ $cuota->Cuota }}</td>
                                                                        <td>{{ $cuota->Num_Contrato }}</td>
                                                                        <td>{{ $cuota->RPC }}</td>
                                                                        <td>{{ $cuota->consecutivo }}</td>
                                                                        <td>{{ $cuota->Entrada }}</td> 
                                                                        <td>{{ $cuota->estado_cargue}}</td> 
                                                                        <td>
                                                                            <a class="btn btn-sm btn-dark" onclick="descargarZipSap({{$cuota->Id}},{{$cuota->Cuota}},'{{$cuota->Nombre}}')"><i class="fa-regular fa-file-zipper"></i></a>
                                                                            @if($perfiUser == 10)
                                                                              <button class="btn btn-sm btn-info" onclick="window.open('{{ url('/DocEquivalente/' . $cuota->Id) }}', '_blank')" class="btn btn-info"> DocEqui </button>                  
                                                                            @endif
                                                                              <button class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocBuzon({{ $cuota->Contrato }}, {{ $cuota->Id }}, '{{ $cuota->Nombre }}')"> <i class="fa-solid fa-envelope-open-text"></i> Cargar</button>
                                                                        </td>
                                                                         @csrf
                                                                  
                                                                    </tr>
                                                                @endif
                                                                @endforeach
                                                            </table>
                                                        <td>
                                                            <a class="btn btn-sm btn-success" onclick="AprobarsubidaDocumentos({{ $cuotaE->id }})"> <i class="fa-regular fa-circle-check"></i> Aprobar </a>                                                            @csrf
                                                        </td>
                                                        </td> 
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            @endif            

                            <div id="cuentas2" class="tab-pane fade">
                                <!-- Contenido para cuotas contador -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead2">
                                            <tr> 
                                                <th>No.</th> 
                                                <th>Contrato</th> 
                                                <th>Nombre</th>
                                                <th>Nivel</th> 
                                                <th>Cuota</th> 
                                                <th>Parcial</th>
                                                <th> %</th>  
                                                <th>Acción</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cuotasP as $cuota)
                                                <tr> 
                                                    <td>{{ $cuota->consecutivo }}</td>
                                                    <td>{{ $cuota->Num_Contrato }}</td> 
                                                    <td>{{ $cuota->Nombre }}</td>
                                                    <td>{{ $cuota->Nivel }}</td>
                                                    <td>Cuota {{ $cuota->Cuota }}</td>
                                                    <td>{{ $cuota->Parcial }}</td>
                                                    <td>{{ $cuota->Porcentaje }}%</td>  
                                                    <td>
                                                    @if($perfiUser == 10)
                                                        <button class="btn btn-sm btn-info" onclick="window.open('{{ url('/DocEquivalente/' . $cuota->Id) }}', '_blank')" class="btn btn-info"> DocEqui </button>                  
                                                    @endif
                                                        <button class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocBuzon({{ $cuota->Contrato }}, {{ $cuota->Id }}, '{{ $cuota->Nombre }}')"> <i class="fa-solid fa-envelope-open-text"></i> Cargar</button>
                                                    </td>
                                                   @csrf

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
 

          </div>

        </div>

        {!! $contratos->links() !!}
      </div>
    </div>
  </div>
</div>


{{-- modal para cargar documentos cuotas --}}
<div class="modal fade bd-example-modal-xl" id="modalDocUploadCuota" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
    {{-- Botón Cerrar en la parte superior derecha --}} 
                <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                background-repeat: no-repeat;
                                color: white;
                                font-family: 'Mallanna';
                                font-size: 17px;">
                                <small id="infoContrato" class="text-muted" style="font-size: 16px;"></small>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar" style="font-size: 1.5rem; color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
      {{-- Hidden para el contrato --}}
      <input type="hidden" id="idContratoModal" value="">
      <div class="modal-body">
        {{-- Card de CDP y fechas --}}
        <div id="cardCargarDoc" class="card mb-4">
          <div class="card-header bg-light text-center">
            <strong>Cargar Documentos</strong>
          </div>
          <div class="card-body">
            <div class="form-row align-items-end" id="formCdpContainer"> 
            </div>
          </div>
        </div> 
        <div id="cardActualizarDatos" class="card mb-4">
          <div class="card-header bg-light text-center">
            <strong>Actualizar datos</strong>
          </div>
          <div class="card-body">
            <div class="form-row align-items-end" id="formCdpContainer">
              <div class="form-group col-md-3">
                <label for="inputCdp" id="labelinputCdp">CDP</label>
                <input type="text" class="form-control" id="inputCdp" placeholder="Número de CDP">
              </div>
              <div class="form-group col-md-2">
                <label for="inputFechaInicio" id="labelinputFechaInicio">Fecha Inicio</label>
                <input type="date" class="form-control" id="inputFechaInicio">
              </div>
              <div class="form-group col-md-2">
                <label for="inputFechaVencimiento" id="labelinputFechaVencimiento">Fecha Vencimiento</label>
                <input type="date" class="form-control" id="inputFechaVencimiento">
              </div>
              <div class="form-group col-md-3">
 
                  <label for="inputNivel" id="labelinputNivel">Nivel / Perfil</label>
                 <select class="form-control" id="inputNivel" name="nivel" required> 
                    <option value="">Selecciona un nivel</option>
                    <option value="Asistencial">Asistencial</option>
                    <option value="Técnico">Técnico</option>
                    <option value="Profesional">Profesional</option>
                    <option value="Profesional Especializado">Profesional Especializado</option>
                  </select>
              </div>
              <div class="form-group col-md-2">
                <button  id="btnActualizarCdp"  type="button"  class="btn btn-success w-100"  style="display:none" onclick="actualizarCDP($('#idContratoModal').val())"> Actualizar CDP</button>
              </div>
              <div class="form-group col-md-3">
                <label for="inputRpc" id="labelinputRpc">RPC</label>
                <input type="number" class="form-control" id="inputRpc" placeholder="Número de RPC">
              </div>
              <div class="form-group col-md-2">
                <label for="inputFechaRpc" id="labelinputFechaRpc">Fecha Inicio RPC</label>
                <input type="date" class="form-control" id="inputFechaRpc">
              </div>
              <div class="form-group col-md-2">
                <label for="inputFecha_Venc_RPC" id="labelinputFecha_Venc_RPC">Fecha Vencimiento RPC</label>
                <input type="date" class="form-control" id="inputFecha_Venc_RPC">
              </div>
              <div class="form-group col-md-3">
                  <label for="inputNivel2" id="labelinputNivel2">Nivel / Perfil</label>
                  <input type="tex" class="form-control" id="inputNivel2" placeholder="Nivel">
              </div>
              <div class="form-group col-md-2">
                <button  id="btnActualizarRpc"  type="button"  class="btn btn-success w-100"  style="display:none" onclick="actualizarRPC($('#idContratoModal').val())"> Actualizar RPC</button>
              </div>

            </div>
          </div>
        </div> 
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0" id="tablaDocs">
                {{-- Aquí inyectamos resp.html --}}
              </table>
            </div>
      
      </div> 
{{-- hidden para pasar el idContrato desde JS --}}
                    <input type="hidden" id="idContratoModal" value="">

                    <div class="modal-footer">
                      <div class="row w-100">
                        <div class="col text-right">
                              <button type="button" class="btn btn-md btn-danger btnDevolver" data-estado="0"><i class="fa-solid fa-file-circle-xmark"></i> Devolver</button> 
                              <button type="button" class="btnAprobar btn btn-md btn-success" data-estado="1"> <i class="fa-solid fa-file-circle-check"></i> Aprobar </button>
                        </div>
                      </div>
                    </div>

    </div>
  </div>
</div>


 
{{-- Modal para ver documentos ADMINISTRATIVO --}}
<div class="modal fade bd-example-modal-xl" id="modalDocUploadCuotaver" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      {{-- Encabezado --}}
      <div class="modal-header d-flex justify-content-between align-items-center"
           style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                  color: white; font-family: 'Mallanna'; font-size: 17px;">
        <h5 class="mb-0" style="color: black; font-weight: bold;">
          📄 Visor de Documento <span id="nameContratista" class="ml-2 font-weight-normal"></span>
        </h5>

        <div class="d-flex align-items-center">
          <a id="btnDescargarPDFPersonalizado"
             class="btn btn-light mr-2"
             href="#"
             target="_blank"
             download="documento.pdf"
             style="display: none;">
             <i class="fa fa-download"></i> Descargar PDF
          </a>

          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar" style="font-size: 1.5rem; color: white;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>

      {{-- Cuerpo del modal --}}
      <div class="modal-body p-0" style="height: calc(100vh - 180px); overflow: hidden;">
        <iframe 
          id="pdfEmbed" 
          src="" 
          width="100%" 
          height="100%" 
          frameborder="0" 
          style="border: none;">
        </iframe>

        {{-- Hidden input para ID del contrato --}}
        <input type="hidden" id="idContratoModal" value="">
      </div>

      {{-- Pie del modal --}}
      <div class="modal-footer">
        <div class="row w-100">
          <div class="col text-right">
            <button type="button" class="btn btn-md btn-danger btnDevolver" data-estado="0"><i class="fa-solid fa-file-circle-xmark"></i> Devolver</button>
            <button type="button" class="btn btn-md btn-success btnAprobar"  data-estado="2"><i class="fa-solid fa-file-circle-check"></i> Aprobar</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


{{-- Modal para ver Y SUBIR TODOS LOS DOCUMENTOS Y APROBAR --}}
<div class="modal fade bd-example-modal-xl" id="modalVerDocCuota" tabindex="-1" role="dialog" aria-labelledby="modalVerDocCuotaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      {{-- Encabezado --}}
      <div class="modal-header d-flex justify-content-between align-items-center"
           style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                  color: white; font-family: 'Mallanna'; font-size: 17px;">
        
        <h5 class="mb-0">📄 Visor de Documento</h5>

        <div>
          <a id="btnDescargarPDFPersonalizado"
             class="btn btn-primary mr-2"
             href="#"
             target="_blank"
             download="documento.pdf"
             style="display: none">
             <i class="fa fa-download"></i> Descargar PDF
          </a>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar" style="font-size: 1.5rem; color: white;">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>

      {{-- Cuerpo --}}
      <div class="modal-body p-0" style="height: calc(100vh - 160px); overflow: hidden;">
        <div style="height: 100%;">
          <iframe 
            id="pdfViewer" 
            src="" 
            width="100%" 
            height="100%" 
            frameborder="0"
            style="border: none;"
          ></iframe>
        </div>
      </div>

      {{-- Pie --}}
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="$('#modalVerDocCuota').modal('hide')">Cerrar</button>
      </div>

    </div>
  </div>
</div>




      {{-- MODAL BITACORA --}}
 
<div class="modal fade" id="modalBitacora" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                background-repeat: no-repeat;
                                color: white;
                                font-family: 'Mallanna';
                                font-size: 17px;">
        <h5 class="modal-title" style="color:black; font-weight: bold;">Historial del Contrato</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar" style="font-size: 1.5rem; color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
      </div>
       
      <div class="modal-body">
        <div id="tablaBitacoraContainer">Cargando...</div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
  {{ Html::script(asset('js/contrato/Contratista.js')) }}
@endsection
