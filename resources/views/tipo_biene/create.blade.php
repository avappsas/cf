@extends('layouts.app')

@section('template_title')
    Crear Tipo Bien
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Nuevo Tipo Bien</div>
        <div class="card-body">
            <form method="POST" action="{{ route('tipo_bienes.store') }}">
                @csrf
                @include('tipo_biene.form')
            </form>
        </div>
    </div>
</div>
@endsection