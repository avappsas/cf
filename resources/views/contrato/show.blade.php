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
                        <div class="float-left">
                            <span class="card-title">Contrato: {{ $contrato->Num_Contrato }}</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('contratos.index') }}"> Volver</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id:</strong>
                            {{ $contrato->Id }}
                        </div>
                        <div class="form-group">
                            <strong>No Documento:</strong>
                            {{ $contrato->No_Documento }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $contrato->Estado }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo Contrato:</strong>
                            {{ $contrato->Tipo_Contrato }}
                        </div>
                        <div class="form-group">
                            <strong>Num Contrato:</strong>
                            {{ $contrato->Num_Contrato }}
                        </div>
                        <div class="form-group">
                            <strong>Objeto:</strong>
                            {{ $contrato->Objeto }}
                        </div>
                        <div class="form-group">
                            <strong>Actividades:</strong>
                            {{ $contrato->Actividades }}
                        </div>
                        <div class="form-group">
                            <strong>Plazo:</strong>
                            {{ $contrato->Plazo }}
                        </div>
                        <div class="form-group">
                            <strong>Valor Total:</strong>
                            {{ $contrato->Valor_Total }}
                        </div>
                        <div class="form-group">
                            <strong>Cuotas:</strong>
                            {{ $contrato->Cuotas }}
                        </div>
                        <div class="form-group">
                            <strong>Cuotas Letras:</strong>
                            {{ $contrato->Cuotas_Letras }}
                        </div>
                        <div class="form-group">
                            <strong>Oficina:</strong>
                            {{ $contrato->Oficina }}
                        </div>
                        <div class="form-group">
                            <strong>Cdp:</strong>
                            {{ $contrato->CDP }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Cdp:</strong>
                            {{ $contrato->Fecha_CDP }}
                        </div>
                        <div class="form-group">
                            <strong>Apropiacion:</strong>
                            {{ $contrato->Apropiacion }}
                        </div>
                        <div class="form-group">
                            <strong>Interventor:</strong>
                            {{ $contrato->Interventor }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Estudios:</strong>
                            {{ $contrato->Fecha_Estudios }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Idoneidad:</strong>
                            {{ $contrato->Fecha_Idoneidad }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Notificacion:</strong>
                            {{ $contrato->Fecha_Notificacion }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Suscripcion:</strong>
                            {{ $contrato->Fecha_Suscripcion }}
                        </div>
                        <div class="form-group">
                            <strong>Rpc:</strong>
                            {{ $contrato->RPC }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Invitacion:</strong>
                            {{ $contrato->Fecha_Invitacion }}
                        </div>
                        <div class="form-group">
                            <strong>Cargo Interventor:</strong>
                            {{ $contrato->Cargo_Interventor }}
                        </div>
                        <div class="form-group">
                            <strong>Valor Total Letras:</strong>
                            {{ $contrato->Valor_Total_letras }}
                        </div>
                        <div class="form-group">
                            <strong>Valor Mensual:</strong>
                            {{ $contrato->Valor_Mensual }}
                        </div>
                        <div class="form-group">
                            <strong>Valor Mensual Letras:</strong>
                            {{ $contrato->Valor_Mensual_Letras }}
                        </div>
                        <div class="form-group">
                            <strong>N C:</strong>
                            {{ $contrato->N_C }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Venc Cdp:</strong>
                            {{ $contrato->Fecha_Venc_CDP }}
                        </div>
                        <div class="form-group">
                            <strong>Nivel:</strong>
                            {{ $contrato->Nivel }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
