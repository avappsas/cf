@extends('layouts.app')

@section('template_title')
    Detalle Tipo Bien
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Ver Tipo Bien</div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $tipoBiene->id }}</p>
            <p><strong>ID Bien:</strong> {{ $tipoBiene->id_bien }}</p>
            <p><strong>Tipo:</strong> {{ $tipoBiene->tipo }}</p>
            <a class="btn btn-primary" href="{{ route('tipo_bienes.index') }}">Volver</a>
        </div>
    </div>
</div>
@endsection