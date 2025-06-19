@extends('layouts.app')

@section('template_title')
    {{ $seguro->name ?? 'Show Seguro' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Seguro</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('seguros.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Seguro:</strong>
                            {{ $seguro->seguro }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
