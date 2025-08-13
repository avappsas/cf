@extends('layouts.app')

@section('template_title')
    {{ $contrato->name ?? 'Show Contrato' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
             
                        <div class="float-right">
                            <a class="btn btn-primary" href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Volver</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 150px"><b><i class="fas fa-key"></i> Id:</b></th>
                                            <td>{{ $contrato->Id }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="far fa-file-alt"></i> No Documento:</b></th>
                                            <td>{{ $contrato->No_Documento }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="fas fa-check-circle"></i> Estado:</b></th>
                                            <td>{{ $contrato->Estado }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="fas fa-file-contract"></i> Tipo Contrato:</b></th>
                                            <td>{{ $contrato->Tipo_Contrato }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="fas fa-hashtag"></i> Num Contrato:</b></th>
                                            <td>{{ $contrato->Num_Contrato }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="fas fa-bullseye"></i> Objeto:</b></th>
                                            <td>{{ $contrato->Objeto }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="fas fa-tasks"></i> Actividades:</b></th>
                                            <td>{{ $contrato->Actividades }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="far fa-calendar-alt"></i> Plazo:</b></th>
                                            <td>{{ \Carbon\Carbon::parse($contrato->Plazo)->translatedFormat('d-F-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="fas fa-dollar-sign"></i> Valor Total:</b></th>
                                            <td>${{ number_format($contrato->Valor_Total, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="fas fa-coins"></i> Cuotas:</b></th>
                                            <td>{{ $contrato->Cuotas }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th><b><i class="fas fa-building"></i> Oficina:</b></th>
                                            <td>{{ $contrato->Oficina }}</td>
                                        </tr>
                                     
                                         <tr>
                                            <th><b><i class="fas fa-signal"></i> Nivel:</b></th>
                                            <td>{{ $contrato->Nivel }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 150px"><b><i class="fas fa-file-alt"></i> Cdp:</b></th>
                                            <td>{{ $contrato->CDP }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="far fa-calendar-alt"></i> Fecha Cdp:</b></th>
                                            <td>{{ \Carbon\Carbon::parse($contrato->Fecha_CDP)->translatedFormat('d-F-Y') }}</td> 
                                        </tr>
                                         <tr>
                                            <th><b><i class="far fa-calendar-alt"></i> Fecha Venc Cdp:</b></th>
                                            <td>{{ \Carbon\Carbon::parse($contrato->Fecha_Venc_CDP)->translatedFormat('d-F-Y') }}</td> 
                                        </tr>
                                        <tr>
                                            <th><b><i class="fas fa-money-bill-alt"></i> Apropiacion:</b></th>
                                            <td>{{ $contrato->Apropiacion }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="fas fa-user-tie"></i> Interventor:</b></th>
                                            <td>{{ $contrato->Interventor }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="far fa-calendar-alt"></i> Fecha Estudios:</b></th>
                                            <td>{{ \Carbon\Carbon::parse($contrato->Fecha_Estudios)->translatedFormat('d-F-Y') }}</td> 
                                        </tr>
                                        <tr>
                                            <th><b><i class="far fa-calendar-alt"></i> Fecha Idoneidad:</b></th>
                                            <td>{{ \Carbon\Carbon::parse($contrato->Fecha_Idoneidad)->translatedFormat('d-F-Y') }}</td> 
                                        </tr>
                                        <tr>
                                            <th><b><i class="far fa-calendar-alt"></i> Fecha Notificacion:</b></th>
                                            <td>{{ \Carbon\Carbon::parse($contrato->Fecha_Notificacion)->translatedFormat('d-F-Y') }}</td> 
                                        </tr>
                                        <tr>
                                            <th><b><i class="far fa-calendar-alt"></i> Fecha Suscripcion:</b></th>
                                            <td>{{ \Carbon\Carbon::parse($contrato->Fecha_Suscripcion)->translatedFormat('d-F-Y') }}</td> 
                                        </tr>
                                        <tr>
                                            <th><b><i class="fas fa-user-shield"></i> Rpc:</b></th>
                                            <td>{{ $contrato->RPC }}</td>
                                        </tr>
                                        <tr>
                                            <th><b><i class="far fa-calendar-alt"></i> Fecha Invitacion:</b></th>
                                            <td>{{ \Carbon\Carbon::parse($contrato->Fecha_Invitacion)->translatedFormat('d-F-Y') }}</td> 
                                        </tr>
                                        <tr>
                                            <th><b><i class="fas fa-briefcase"></i> Cargo Interventor:</b></th>
                                            <td>{{ $contrato->Cargo_Interventor }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th><b><i class="fas fa-hand-holding-usd"></i> Valor Mensual:</b></th>
                                              <td>${{ number_format($contrato->Valor_Mensual, 0, ',', '.') }}</td> 
                                        </tr>

                                    </tbody>
                                </table> 
                                        <div class="col-auto d-flex flex-column align-items-center">
                                            <button type="button" class="btn btn-link text-decoration-none" onclick="btnAbrirModalCarguecontrato({{ $contrato->Id }})">
                                                <i class="fa-solid fa-upload fa-2x"></i>
                                                <div>Ver Documentos</div>
                                            </button>
                                        </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



   {{-- modal para cargar documentos cuotas --}}

    <div class="modal fade" id="modalDocUploadCuota" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="max-width: 70%;">
            <div class="modal-content">
    {{-- Botón Cerrar en la parte superior derecha --}} 
                <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                background-repeat: no-repeat;
                                color: white;
                                font-family: 'Mallanna';
                                font-size: 17px;">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar" style="font-size: 1.5rem; color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalDocUploadCuota"><div class="card">
                    <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;"> 
                                <span id="card_title"> 
                                </span> 
                                <div class="float-right">
                                    <i class="fa fa-fw fa-file-contract"></i> 
                                    {{ __('Documentos') }}
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
                                    <div class="table-responsive">
                                        <div class="table table-striped table-hover" id="tablaDocs">

                                        </div>   
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

    {{-- modal para ver documentos cuotas --}}

    <div class="modal fade bd-example-modal-xl" id="modalVerDocCuota" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
    {{-- Botón Cerrar en la parte superior derecha --}} 
                <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                background-repeat: no-repeat;
                                color: white;
                                font-family: 'Mallanna';
                                font-size: 17px;">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar" style="font-size: 1.5rem; color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalVerDocCuota"><div class="card">
                    <div class="row">
                        <embed id="pdfEmbed" src="" type="application/pdf" width="100%" height="800px">
                    </div>
                </div>
                
                <div class="modal-footer"  >
                    
                </div>
            </div>
        </div>
    </div>



@section('js')
<script> 

 const dataToken = document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute('content');


function AbrirPDFM2(Ruta){
    console.log(Ruta)
    document.getElementById('pdfEmbed').src = Ruta;
    $('#modalVerDocCuota').modal('show'); 
}
 
 

function btnAbrirModalCarguecontrato(idContrato){
    
    $.ajax({
        url: ('/cargueContrato'),
        type:'get',
        data: {_token:dataToken, idContrato:idContrato},
        success: function(data) {
            $('#tablaDocs').empty();
            $('#tablaDocs').html(data);
            // console.log(data);
            $('#modalDocUploadCuota').modal('show');
            
        }
    });
}


</script>
@endsection


@endsection

