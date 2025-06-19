@extends('layouts.app')

@section('template_title')
    {{ $provincia->name ?? 'Show Provincia' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Provincia</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('provincias.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Id:</strong>
                            {{ $provincia->id }}
                        </div>
                        <div class="form-group">
                            <strong>Provincia:</strong>
                            {{ $provincia->provincia }}
                        </div>
                        <div class="form-group">
                            <strong>Pais:</strong>
                            {{ $provincia->pais }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
