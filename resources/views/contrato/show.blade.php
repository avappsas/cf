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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
