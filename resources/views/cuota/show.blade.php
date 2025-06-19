@extends('layouts.app')

@section('template_title')
    {{ $cuota->name ?? 'Show Cuota' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Cuota</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('cuotas.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id:</strong>
                            {{ $cuota->Id }}
                        </div>
                        <div class="form-group">
                            <strong>Contrato:</strong>
                            {{ $cuota->Contrato }}
                        </div>
                        <div class="form-group">
                            <strong>Cuota:</strong>
                            {{ $cuota->Cuota }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Acta:</strong>
                            {{ $cuota->Fecha_Acta }}
                        </div>
                        <div class="form-group">
                            <strong>Porcentaje:</strong>
                            {{ $cuota->Porcentaje }}
                        </div>
                        <div class="form-group">
                            <strong>Actividades:</strong>
                            {{ $cuota->Actividades }}
                        </div>
                        <div class="form-group">
                            <strong>Planilla:</strong>
                            {{ $cuota->Planilla }}
                        </div>
                        <div class="form-group">
                            <strong>Perioro Planilla:</strong>
                            {{ $cuota->Perioro_Planilla }}
                        </div>
                        <div class="form-group">
                            <strong>Parcial:</strong>
                            {{ $cuota->Parcial }}
                        </div>
                        <div class="form-group">
                            <strong>Mes Cobro:</strong>
                            {{ $cuota->Mes_cobro }}
                        </div>
                        <div class="form-group">
                            <strong>Oficina:</strong>
                            {{ $cuota->Oficina }}
                        </div>
                        <div class="form-group">
                            <strong>Pin Planilla:</strong>
                            {{ $cuota->Pin_planilla }}
                        </div>
                        <div class="form-group">
                            <strong>Operador Planilla:</strong>
                            {{ $cuota->Operador_planilla }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Pago Planilla:</strong>
                            {{ $cuota->Fecha_pago_planilla }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
