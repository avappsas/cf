@extends('layouts.app')

@section('template_title')
    {{ $aseguradora->name ?? 'Show Aseguradora' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Aseguradora</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('aseguradoras.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Aseguradora:</strong>
                            {{ $aseguradora->aseguradora }}
                        </div>
                        <div class="form-group">
                            <strong>Id Ramo:</strong>
                            {{ $aseguradora->id_ramo }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
