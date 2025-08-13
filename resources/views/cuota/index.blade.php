@extends('layouts.app')

@section('template_title')
    Cuota
@endsection

@section('content')
<style>
#firma-wrapper {
    position: absolute;
    z-index: 20;
    display: none;
    transform-origin: top left;
    cursor: move;
}

#firma-handle {
    background: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 2px 6px;
    font-size: 12px;
    cursor: move;
    user-select: none;
    text-align: center;
 
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                                {{ __('Bandeja de entrada de las cuentas') }}
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
                            @if($perfil == 14)
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabEnviadas" data-toggle="tab" href="#enviadas" style="font-size: 17px"><i class="fa-solid fa-file-arrow-up" style="color: #568c1d;"></i> Radicar al SAP</a>
                            </li>
                            @endif
                            @if($perfil == 4)
                            <li class="tab wave dark">
                                <a class="nav-link" id="tabEntrada" data-toggle="tab" href="#entradas" style="font-size: 17px"><i class="fa-solid fa-file-arrow-up" style="color: #568c1d;"></i> Entradas SAP</a>
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
                                                <th >Nombre</th>
                                                <th class="text-center">Cuota</th>
                                                <th class="text-center">Fecha Acta</th>
                                                <th class="text-center">Parcial</th>
                                                <th class="text-center">%</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Asignado</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cuotas as $cuota)
                                                
                                                    <tr> 
                                                        <td>{{ $cuota->Nombre }}</td>
                                                        <td class="text-center">Cuota {{ $cuota->Cuota }}</td>
                                                        <td class="text-center">{{ \Carbon\Carbon::parse($cuota->Fecha_Acta)->format('d-M-y') }}</td>
                                                        <td class="text-center">{{ $cuota->Parcial }}</td>
                                                        <td class="text-center">{{ $cuota->Porcentaje }}%</td>
                                                        <td class="text-center">{{ $cuota->Estado_juridica }}</td>
                                                        
                                                        @if ($perfil == 3 )
                                                            <td class="text-center">
                                                                <div class="input-group mb-3">
                                                                    {{ Form::select('userAsignado', $listaAsignacionFormateada, $cuota->id_user, ['class' => 'form-control form-control-sm' . ($errors->has('userAsignado') ? ' is-invalid' : ''), 'placeholder' => 'Asignar','id' => 'asignacion_' .$cuota->Id, 'disabled' => 'disabled']) }}
                                                                    <div class="input-group-append">
                                                                    </div> 
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if ($perfil == 1 || $perfil == 7 )
                                                            <td>
                                                                <div class="input-group mb-3">
                                                                    {{ Form::select('userAsignado', $listaAsignacionFormateada, $cuota->id_user, ['class' => 'form-control form-control-sm' . ($errors->has('userAsignado') ? ' is-invalid' : ''), 'placeholder' => 'Sin Asignar','id' => 'asignacion_' .$cuota->Id]) }}
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-outline-success btn-sm" type="button" onclick="asignarUser({{$cuota->Id}})">Asignar</button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endif

                                                        <td>
                                                            <a class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocCuotas({{$cuota->Contrato}},{{$cuota->Id}},'{{$cuota->Nombre}}')"><i class="fa-solid fa-envelope-open-text"></i> Abrir</a>
 
                                                        </td>
                                                        @csrf
                                                    </tr>
                                              
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
                                                    <td>{{ \Carbon\Carbon::parse($cuotaA->Fecha_Acta)->format('d-M-y') }}</td> 
                                                    <td>{{ $cuotaA->Parcial }}</td>
                                                    <td>{{ $cuotaA->Porcentaje }}%</td>
                                                    <td>{{ $cuotaA->Estado_juridica }}</td>
                                                    <td>{{ $cuotaA->nameUser }}</td>
 
                                             @csrf
                                                     
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- <a href="generarZip" class="btn btn-light btn-sm float-right"><i class="fa-solid fa-file-zipper"></i> Descargar Zip</a> --}}
                                    @if($perfil == 14)
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
                                                <th>Parcial</th>
                                                <th> %</th>
                                                <th>Estado</th>
                                                <th>Responsable</th>
                                                <th>Acción</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cuotasD as $cuotaD)
                                                <tr>  
                                                    <td>{{ $cuotaD->Nombre }}</td>
                                                    <td>Cuota {{ $cuotaD->Cuota }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($cuotaD->Fecha_Acta)->format('d-M-y') }}</td> 
                                                    <td>{{ $cuotaD->Parcial }}</td>
                                                    <td>{{ $cuotaD->Porcentaje }}%</td>
                                                    <td>{{ $cuotaD->Estado_juridica }}</td>
                                                    <td>{{ $cuotaD->nameUser }}</td>
                                                    <td><a class="btn btn-sm btn-info" onclick="btnAbrirModalVerDocCuotas({{$cuotaD->Contrato}},{{$cuotaD->Id}},'{{$cuotaD->Nombre}}')"><i class="fa-solid fa-envelope-open-text"></i> Abrir</a></td>

                                                   @csrf

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- Entradas SAP --}}
                            @if($perfil == 4)
                                <div id="entradas" class="tab-pane fade"> 
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead2">
                                                <tr> 
                                                    <th colspan="8">Nombre</th> 
                                                    <th colspan="8">Acción</th> 
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
                                                                        <th> </th>
                                                                    </tr>
                                                                </div>
                                                                @foreach($cuotasE2 as $cuotasE20)
                                                                @if ($cuotaE->id == $cuotasE20->FUID)
                                                                    <tr  onclick="event.stopPropagation();">
                                                                        <td colspan="3">{{ $cuotasE20->Nombre }}</td>
                                                                        <td>{{ $cuotasE20->Documento }}</td>
                                                                        <td>{{ $cuotasE20->Cuota }}</td>
                                                                        <td>{{ $cuotasE20->Num_Contrato }}</td>
                                                                        <td>{{ $cuotasE20->RPC }}</td>
                                                                        <td>{{ $cuotasE20->consecutivo }}</td>
                                                                        <td> <input type="number" 
                                                                            class="form-control form-control-sm inputEntrada" 
                                                                            data-id="{{ $cuotasE20->Id }}" 
                                                                            value="{{ $cuotasE20->Entrada ?? '' }}" 
                                                                            style="width: 120px;" />
                                                                        </td>
                                                                        <td>
                                                                            <a class="btn btn-sm btn-dark" onclick="descargarZipSap({{$cuotasE20->Id}},{{$cuotasE20->Cuota}},'{{$cuotasE20->Nombre}}')"><i class="fa-regular fa-file-zipper"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                @endforeach
                                                            </table>
                                                        <td>
                                                            <a class="btn btn-sm btn-success" onclick="EntradasRadicadas({{ $cuotaE->id }})"> <i class="fa-regular fa-circle-check"></i> EntradasRadicadas </a>                                                            @csrf
                                                        </td>
                                                        </td> 
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            @endif

                             {{--  //RADICAR AL SAP --}} 
                            @if($perfil == 14)
                                <div id="enviadas" class="tab-pane fade">
                                    <!-- Contenido para cuotas aprobadas -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead2">
                                                <tr>
                                                    
                                                    <th colspan="8">Nombre</th>
                                                    <th>Fecha</th>
                                                    <th>Estado</th>  
                                                    <th>Responsable</th>
        
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
                                                                        {{-- <th colspan="3">Responsable</th> --}}
                                                                        <th> </th>
                                                                    </tr>
                                                                </div>
                                                                @foreach($cuotasE2 as $cuotasE20)
                                                                @if ($cuotaE->id == $cuotasE20->FUID)
                                                                    <tr  onclick="event.stopPropagation();">
                                                                        <td colspan="3">{{ $cuotasE20->Nombre }}</td>
                                                                        <td>{{ $cuotasE20->Documento }}</td>
                                                                        <td>{{ $cuotasE20->Cuota }}</td>
                                                                        <td>{{ $cuotasE20->Num_Contrato }}</td>
                                                                        <td>{{ $cuotasE20->RPC }}</td>
                                                                        <td>{{ $cuotasE20->consecutivo }}</td> 
                                                                        <td>{{ $cuotasE20->Entrada }}</td> 
                                                                        <td>
                                                                            <a class="btn btn-sm btn-dark" onclick="descargarZipSap({{$cuotasE20->Id}},{{$cuotasE20->Cuota}},'{{$cuotasE20->Nombre}}')"><i class="fa-regular fa-file-zipper"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                @endforeach
                                                            </table>
                                                        </td>
                                                        <td>{{ $cuotaE->created_at }}</td>
                                                        <td>{{$cuotaE->estado}}</td>  
                                                        <td>{{$cuotaE->nameUser}}</td> 
                                                        <td>
                                                            @if ($cuotaE->estado == 'Pendiente Z-Control')
                                                                <a class="btn btn-sm btn-success" onclick="contabilizar({{ $cuotaE->id }})"> <i class="fa-regular fa-circle-check"></i> Aprobar </a>                                                                
                                                                @csrf
                                                            @else
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

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

    
 
<!-- MODAL DE DOCUMENTOS -->
<div class="modal fade" id="modalDocUploadCuota" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 95%; margin: 1rem auto; height: 95vh;">
        <div class="modal-content shadow-lg rounded-3" style="height: 100%; overflow: hidden;">
            <!-- HEADER -->
            <div class="modal-header"
                style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                        color: #000; font-family: 'Mallanna'; font-size: 14px;">
                <h5 class="modal-title d-flex justify-content-between w-100 align-items-center">
                    <span id="nameContratista"><b>{{ $nombreContratista ?? 'Nombre Contratista' }}</b></span>  
                </h5>

                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar"
                        style="font-size: 1.8rem; color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body p-0" style="height: calc(100vh - 56px); overflow: hidden;">
                <div class="row h-100 m-0 flex-column flex-md-row">

                    <!-- TABLA -->
                    <div class="col-md-6 p-2 overflow-auto border-end d-flex justify-content-center align-items-center"
                         style="max-height: 100%;">
                        <div class="table-responsive">
                            <table id="tablaDocs"
                                   class="table table-sm table-striped table-hover align-middle text-sm">
                                {{-- Aquí se inyecta la tabla --}}
                            </table>
                        </div>
                    </div>

                    <!-- PDF + Firma -->
                    <div class="col-md-6 p-2" style="position: relative; height: 100%;">
                        
                        <!-- Contenedor con scroll vertical -->
                         <div id="pdfContainer" style="position: relative; width: 100%; height: 100%; overflow: auto;">
                            <!-- PDF incrustado con altura extendida -->
                            <embed id="pdfEmbed"
                                data-src-base="{{ asset('storage/doc_cuenta/predeterminado1.pdf') }}"
                                src=""
                                type="application/pdf"
                                style="width: 100%; height: 100%; border: none; display: block; margin: 0 auto;" />
                             <!-- Firma flotante posicionable -->
                            <div id="firma-wrapper" style="position: absolute; display: none; z-index: 20;">
                                <button id="btnMoverFirma"
                                    style="cursor: grab; font-size: 12px; background: rgba(0,0,0,0.6); color: white; border: none; padding: 3px 8px;">
                                    🖐️ Arrastrar Firma
                                </button>
                                <img id="firmaFlotante" src="{{ asset('storage/' . $rutaFirma) }}" style="width: 120px; display: block;" />
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>



<!-- MODAL DE FIRMA CON PDF.js --> 
<div class="modal fade" id="modalPosicionarFirma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 75%; margin: 1rem auto; height: 95vh;">
        <div class="modal-content shadow-lg rounded-3" style="height: 100%; overflow: hidden;">
            <!-- HEADER -->
            <div class="modal-header"
                style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                        color: #000; font-family: 'Mallanna'; font-size: 14px;">
                <h5 class="modal-title">📄 Posicionar Firma</h5> 
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar"
                        style="font-size: 1.8rem; color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" style="height: 100vh; overflow: hidden;">
                <iframe id="iframeFirmador"
                src=""
                style="width:100%; height:100%; border:none;"></iframe>
            </div> 
        </div>
    </div>
</div>



@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const entradas = document.querySelectorAll('.inputEntrada');

  entradas.forEach((input, idx, arr) => {
    input.addEventListener('dblclick', function () {
      if (this.value.trim() !== '') return;

      // Buscar valor anterior
      let anterior = null;
      for (let i = idx - 1; i >= 0; i--) {
        const anteriorValor = arr[i].value.trim();
        if (anteriorValor !== '' && !isNaN(anteriorValor)) {
          anterior = parseInt(anteriorValor);
          break;
        }
      }

      if (anterior !== null) {
        this.value = anterior + 1;
        this.style.border = '2px solid green';
        this.style.fontWeight = 'bold';

        // 🔁 Forzar evento change
        this.dispatchEvent(new Event('change', { bubbles: true }));
        // o también puedes disparar blur manualmente si tu lógica depende de blur:
        this.dispatchEvent(new Event('blur', { bubbles: true }));
      }
    });
 
  });
});
</script>
    {{Html::script(asset('js/juridica/juridica.js'))}}
@endsection

