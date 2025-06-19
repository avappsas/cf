@extends('layouts.app')

@section('template_title')
    Editar Tipo Bien
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Editar Tipo Bien</div>
        <div class="card-body">
            <form method="POST" action="{{ route('tipo_bienes.update', $tipoBiene->id) }}">
                @csrf
                @method('PUT')
                @include('tipo_biene.form')
            </form>
        </div>
    </div>
</div>
@endsection