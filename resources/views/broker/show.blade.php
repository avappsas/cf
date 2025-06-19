@extends('layouts.app')

@section('template_title')
    {{ $broker->name ?? 'Show Broker' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Broker</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('brokers.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Broker:</strong>
                            {{ $broker->Broker }}
                        </div>
                        <div class="form-group">
                            <strong>Campo1:</strong>
                            {{ $broker->campo1 }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
