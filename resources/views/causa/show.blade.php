@extends('layouts.app')

@section('template_title')
    {{ $causa->name ?? 'Show Causa' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Causa</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('causas.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id:</strong>
                            {{ $causa->Id }}
                        </div>
                        <div class="form-group">
                            <strong>Id Ramo:</strong>
                            {{ $causa->id_ramo }}
                        </div>
                        <div class="form-group">
                            <strong>Causa:</strong>
                            {{ $causa->Causa }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
