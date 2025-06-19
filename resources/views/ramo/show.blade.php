@extends('layouts.app')

@section('template_title')
    {{ $ramo->name ?? 'Show Ramo' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Ramo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('ramos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Ramo:</strong>
                            {{ $ramo->ramo }}
                        </div>
                        <div class="form-group">
                            <strong>observacion:</strong>
                            {{ $ramo->observacion }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
