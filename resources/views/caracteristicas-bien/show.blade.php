@extends('layouts.app')

@section('template_title')
    {{ $caracteristicasBien->name ?? 'Show Caracteristicas Bien' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Caracteristicas Bien</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('caracteristicas-biens.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Bien:</strong>
                            {{ $caracteristicasBien->id_bien }}
                        </div>
                        <div class="form-group">
                            <strong>Caracteristica:</strong>
                            {{ $caracteristicasBien->caracteristica }}
                        </div>
                        <div class="form-group">
                            <strong>Valor:</strong>
                            {{ $caracteristicasBien->valor }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
