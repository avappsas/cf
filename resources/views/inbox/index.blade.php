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
              <i class="fa-solid fa-inbox"></i> {{ __('Bandeja de entrada') }}
            </div>
          </div>
        </div>

        @if ($message = Session::get('success'))
          <div class="alert alert-success"><p>{{ $message }}</p></div>
        @endif

        <div class="card-body">
          {{-- Tabs --}}
          <ul class="nav nav-tabs tab-bar2">
            <li class="tab wave dark">
              <a class="nav-link active" data-toggle="tab" href="#pendientes" style="font-size:17px">
                <i class="fa fa-envelope" style="color:#007bff"></i> Documentos Recibidos
              </a>
            </li>
            <li class="tab wave dark">
              <a class="nav-link" data-toggle="tab" href="#devueltas" style="font-size:17px">
                <i class="fa fa-undo" style="color:#dc3545"></i> Documentos Devueltos
              </a>
            </li>
            <li class="tab wave dark">
              <a class="nav-link" data-toggle="tab" href="#aprobadas" style="font-size:17px">
                <i class="fa fa-thumbs-up" style="color:#28a745"></i> Documentos Aprobados
              </a>
            </li>
            <li class="tab wave dark">
              <a class="nav-link" data-toggle="tab" href="#enviadas" style="font-size:17px">
                <i class="fa fa-paper-plane" style="color:#ffc107"></i> En Tramite
              </a>
            </li>
          </ul>

          <div class="tab-content mt-3">
            {{-- Pendientes --}}
            <div id="pendientes" class="tab-pane fade show active">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead class="thead2">
                    <tr>
                      <th>iD</th><th>#Contrato</th><th>Documento</th><th>Nombre</th><th>Estado</th><th>Oficina</th><th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contratos as $contrato)
                      <tr>
                        <td>{{ $contrato->Id }}</td>
                        <td>{{ $contrato->Num_Contrato }}</td>
                        <td>{{ $contrato->No_Documento }}</td>
                        <td>{{ $contrato->Nombre }}</td>
                        <td>{{ $contrato->Estado }}</td>
                        <td>{{ $contrato->nombre_oficina }}</td>
                        <td>
                          <button class="btn btn-sm btn-info"
                                  onclick="btnAbrirModalVerDocBuzonver({{ $contrato->Id }}, '{{ $contrato->Nombre }}')">
                            <i class="fa-solid fa-envelope-open-text"></i> Abrir </button>
                          @if($contrato->Estado === 'Secop-Presidencia')
                              <a class="btn btn-sm btn-success" onclick="cambioEstadoContrato(1, {{ isset($contrato) ? $contrato->Id : 'null' }})" style="margin-right: 3px" id="btnAprobar">   <i class="fa-solid fa-file-circle-xmark" ></i> Ya Firme Secop</a>
                          @else 
                              <a class="btn btn-sm btn-success" onclick="cambioEstadoContrato(1, {{ isset($contrato) ? $contrato->Id : 'null' }})" style="margin-right: 3px" id="btnAprobar">   <i class="fa-solid fa-file-circle-xmark" ></i> Aprobar</a>
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
                      <th>iD</th><th>Nombre</th><th>Estado</th><th>Oficina</th><th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contratosC as $contrato)
                      <tr>
                        <td>{{ $contrato->Id }}</td>
                        <td>{{ $contrato->Nombre }}</td>
                        <td>{{ $contrato->Estado }}</td>
                        <td>{{ $contrato->nombre_oficina }}</td>
                        <td>
                          <button class="btn btn-sm btn-info"
                                  onclick="btnAbrirModalVerDocBuzon({{ $contrato->Id }}, '{{ $contrato->Nombre }}')">
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
            <div id="aprobadas" class="tab-pane fade">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead class="thead2">
                    <tr>
                      <th>iD</th><th>Nombre</th><th>Estado</th><th>Oficina</th><th>RPC</th><th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contratosB as $contrato)
                      <tr>
                        <td>{{ $contrato->Id }}</td>
                        <td>{{ $contrato->Nombre }}</td>
                        <td>{{ $contrato->Estado ?? 'Pendiente' }}</td>
                        <td>{{ $contrato->nombre_oficina }}</td>
                        <td>{{ $contrato->RPC ?? '—' }}</td>
                        <td>
                          @if(Auth::user()->id_buzon == 10)
                            <a href="{{ route('contratos.show', $contrato->Id) }}"  class="btn btn-sm btn-warning"> <i class="fa fa-fw fa-eye"></i> Ver </a>
                            <button class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocBuzon({{ $contrato->Id }}, '{{ $contrato->Nombre }}')"> <i class="fa-solid fa-envelope-open-text"></i> Abrir</button>
 
                          @else 
                           <button class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocBuzon({{ $contrato->Id }}, '{{ $contrato->Nombre }}')"> <i class="fa-solid fa-envelope-open-text"></i> Abrir</button>
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


            {{-- todas --}}
            <div id="enviadas" class="tab-pane fade">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead class="thead2">
                    <tr>
                      <th>iD</th><th>Nombre</th><th>Estado</th><th>Oficina</th> <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($contratosT as $contrato)
                      <tr>
                        <td>{{ $contrato->Id }}</td>
                        <td>{{ $contrato->Nombre }}</td>
                        <td>{{ $contrato->Estado ?? 'Pendiente' }}</td>
                        <td>{{ $contrato->nombre_oficina }}</td> 
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

        {!! $contratos->links() !!}
      </div>
    </div>
  </div>
</div>


{{-- modal para cargar documentos cuotas --}}
<div class="modal fade bd-example-modal-xl" id="modalDocUploadCuota" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      {{-- Hidden para el contrato --}}
      <input type="hidden" id="idContratoModal" value="">

      <div class="modal-body">
        {{-- Card de CDP y fechas --}}
        <div class="card mb-4">
          <div class="card-header bg-light text-center">
            <strong>Actualizar datos</strong>
          </div>
          <div class="card-body">
            <div class="form-row align-items-end" id="formCdpContainer">
              <div class="form-group col-md-3">
                <label for="inputCdp" id="labelinputCdp">CDP</label>
                <input type="text" class="form-control" id="inputCdp" placeholder="Número de CDP">
              </div>
              <div class="form-group col-md-3">
                <label for="inputFechaInicio" id="labelinputFechaInicio">Fecha Inicio</label>
                <input type="date" class="form-control" id="inputFechaInicio">
              </div>
              <div class="form-group col-md-3">
                <label for="inputFechaVencimiento" id="labelinputFechaVencimiento">Fecha Vencimiento</label>
                <input type="date" class="form-control" id="inputFechaVencimiento">
              </div>
              <div class="form-group col-md-3">
                <button  id="btnActualizarCdp"  type="button"  class="btn btn-success w-100"  style="display:none" onclick="actualizarCDP($('#idContratoModal').val())"> Actualizar CDP</button>
              </div>
              <div class="form-group col-md-3">
                <label for="inputRpc" id="labelinputRpc">RPC</label>
                <input type="number" class="form-control" id="inputRpc" placeholder="Número de RPC">
              </div>
              <div class="form-group col-md-3">
                <label for="inputFechaRpc" id="labelinputFechaRpc">Fecha RPC</label>
                <input type="date" class="form-control" id="inputFechaRpc">
              </div>
              <div class="form-group col-md-3">
                <label for="inputFechaNotificacion" id="labelinputFechaNotificacion">Fecha Notificación</label>
                <input type="date" class="form-control" id="inputFechaNotificacion">
              </div>
              <div class="form-group col-md-3">
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
                          <button  type="button" id="btnDevolver" data-estado="0" class="btn btn-md btn-danger mr-2" >
                            <i class="fa-solid fa-file-circle-xmark"></i> Devolver </button> 
                          <button type="button" id="btnAprobar" data-estado="1" class="btn btn-md btn-success" >
                            <i class="fa-solid fa-file-circle-check"></i> Aprobar </button>
                        </div>
                      </div>
                    </div>

    </div>
  </div>
</div>


  {{-- modal para ver documentos   --}}

<div class="modal fade bd-example-modal-xl" id="modalDocUploadCuotaver" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
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
                <div class="modal-body" id="modalDocUploadCuota">
                    <div class="card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span id="card_title"></span>
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
                            <div class="form-group">
                                <div class="row">   
                                  <div class="col-md-12"> 
                                      <embed id="pdfEmbed" src="{{ $dato->Ruta ?? '' }}" type="application/pdf" width="100%" height="600px">
                                  </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- hidden para pasar el idContrato desde JS --}}
                    <input type="hidden" id="idContratoModal" value="">

                    <div class="modal-footer">
                      <div class="row w-100">
                        <div class="col text-right">
                          <button
                            type="button"
                            id="btnDevolver"
                            data-estado="0"
                            class="btn btn-md btn-danger mr-2"
                          >
                            <i class="fa-solid fa-file-circle-xmark"></i>
                            Devolver
                          </button>

                          <button
                            type="button"
                            id="btnAprobar"
                            data-estado="2"
                            class="btn btn-md btn-success"
                          >
                            <i class="fa-solid fa-file-circle-check"></i>
                            Aprobar
                          </button>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



{{-- Modal para ver documentos en PDF --}}
<div class="modal fade bd-example-modal-xl" id="modalVerDocCuota" tabindex="-1" role="dialog" aria-labelledby="modalVerDocCuotaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      {{-- Cabecera --}}
      <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%); color: white; font-family: 'Mallanna'; font-size: 17px;">
        <h5 class="modal-title" id="modalVerDocCuotaLabel">Ver Documento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" style="color: white">

          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      {{-- Cuerpo --}}
      <div class="modal-body p-0">
        <div class="card border-0">
          <div class="card-body p-0">
            <object 
              id="pdfViewer" 
              type="application/pdf" 
              data="" 
              width="100%" 
              height="800px"
            >
              <p>Tu navegador no puede mostrar el PDF.  
                 <a id="pdfDownload" href="" target="_blank">
                   Descarga el documento aquí.
                 </a>
              </p>
            </object>
          </div>
        </div>
      </div>

      {{-- Pie --}}
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          Cerrar
        </button>
      </div>

    </div>
  </div>
</div>


@endsection

@section('js')
  {{ Html::script(asset('js/contrato/Contratista.js')) }}
@endsection
