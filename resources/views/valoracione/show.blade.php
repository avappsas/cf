@extends('layouts.app')

@section('template_title')
    {{ $valoracione->name ?? 'Show Valoracione' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Valoracione</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('valoraciones.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Bien:</strong>
                            {{ $valoracione->id_bien }}
                        </div>
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {{ $valoracione->descripcion }}
                        </div>
                        <div class="form-group">
                            <strong>Cant:</strong>
                            {{ $valoracione->Cant }}
                        </div>
                        <div class="form-group">
                            <strong>Valor Cotizado:</strong>
                            {{ $valoracione->Valor_Cotizado }}
                        </div>
                        <div class="form-group">
                            <strong>Valor Aprobado:</strong>
                            {{ $valoracione->Valor_Aprobado }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
