@extends('layouts.app')

@section('template_title')
    {{ $objeto->name ?? 'Show Objeto' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Objeto</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('objetos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id Ramo:</strong>
                            {{ $objeto->id_ramo }}
                        </div>
                        <div class="form-group">
                            <strong>Descripcion:</strong>
                            {{ $objeto->descripcion }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
