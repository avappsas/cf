@extends('layouts.app')

@section('template_title')
    {{ $fechaCuentum->name ?? 'Show Fecha Cuentum' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Fecha Cuentum</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('fecha_cuenta') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Dp:</strong>
                            {{ $fechaCuentum->id_dp }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Max:</strong>
                            {{ $fechaCuentum->Fecha_max }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Cuenta:</strong>
                            {{ $fechaCuentum->fecha_cuenta }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
