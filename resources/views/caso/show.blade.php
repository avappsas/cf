@extends('layouts.app')

@section('template_title')
    {{ $caso->name ?? 'Show Caso' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Caso</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('casos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Cfr:</strong>
                            {{ $caso->id_CFR }}
                        </div>
                        <div class="form-group">
                            <strong>Aseguradora:</strong>
                            {{ $caso->Aseguradora }}
                        </div>
                        <div class="form-group">
                            <strong>Ramo:</strong>
                            {{ $caso->Ramo }}
                        </div>
                        <div class="form-group">
                            <strong>Broker:</strong>
                            {{ $caso->Broker }}
                        </div>
                        <div class="form-group">
                            <strong>Reclamo Aseguradora:</strong>
                            {{ $caso->Reclamo_Aseguradora }}
                        </div>
                        <div class="form-group">
                            <strong>No Reporte:</strong>
                            {{ $caso->No_Reporte }}
                        </div>
                        <div class="form-group">
                            <strong>Asegurado:</strong>
                            {{ $caso->Asegurado }}
                        </div>
                        <div class="form-group">
                            <strong>Poliza Anexo:</strong>
                            {{ $caso->Poliza_Anexo }}
                        </div>
                        <div class="form-group">
                            <strong>Inicio Poliza:</strong>
                            {{ $caso->Inicio_Poliza }}
                        </div>
                        <div class="form-group">
                            <strong>Fin Poliza:</strong>
                            {{ $caso->Fin_Poliza }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Siniestro:</strong>
                            {{ $caso->Fecha_Siniestro }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Asignación:</strong>
                            {{ $caso->Fecha_Asignación }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Reporte:</strong>
                            {{ $caso->Fecha_Reporte }}
                        </div>
                        <div class="form-group">
                            <strong>Lugar Siniestro:</strong>
                            {{ $caso->Lugar_Siniestro }}
                        </div>
                        <div class="form-group">
                            <strong>Sector Evento:</strong>
                            {{ $caso->Sector_Evento }}
                        </div>
                        <div class="form-group">
                            <strong>Hora Siniestro:</strong>
                            {{ $caso->Hora_Siniestro }}
                        </div>
                        <div class="form-group">
                            <strong>Seguro Afectado:</strong>
                            {{ $caso->Seguro_Afectado }}
                        </div>
                        <div class="form-group">
                            <strong>Circunstancias:</strong>
                            {{ $caso->Circunstancias }}
                        </div>
                        <div class="form-group">
                            <strong>Causa:</strong>
                            {{ $caso->Causa }}
                        </div>
                        <div class="form-group">
                            <strong>Observaciones:</strong>
                            {{ $caso->Observaciones }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $caso->Nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Ci:</strong>
                            {{ $caso->CI }}
                        </div>
                        <div class="form-group">
                            <strong>Parentezo:</strong>
                            {{ $caso->Parentezo }}
                        </div>
                        <div class="form-group">
                            <strong>Ocupacion:</strong>
                            {{ $caso->Ocupacion }}
                        </div>
                        <div class="form-group">
                            <strong>Telefonos:</strong>
                            {{ $caso->Telefonos }}
                        </div>
                        <div class="form-group">
                            <strong>Cobertura:</strong>
                            {{ $caso->Cobertura }}
                        </div>
                        <div class="form-group">
                            <strong>Compañía De Seguros:</strong>
                            {{ $caso->Compañía_de_Seguros }}
                        </div>
                        <div class="form-group">
                            <strong>Ejercicio:</strong>
                            {{ $caso->Ejercicio }}
                        </div>
                        <div class="form-group">
                            <strong>Ejecutivo:</strong>
                            {{ $caso->Ejecutivo }}
                        </div>
                        <div class="form-group">
                            <strong>Valor De La Reserva:</strong>
                            {{ $caso->Valor_de_la_Reserva }}
                        </div>
                        <div class="form-group">
                            <strong>Requerimientos:</strong>
                            {{ $caso->Requerimientos }}
                        </div>
                        <div class="form-group">
                            <strong>Subrogación:</strong>
                            {{ $caso->Subrogación }}
                        </div>
                        <div class="form-group">
                            <strong>Salvamento:</strong>
                            {{ $caso->Salvamento }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $caso->Estado }}
                        </div>
                        <div class="form-group">
                            <strong>Ejecutivo2:</strong>
                            {{ $caso->Ejecutivo2 }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
