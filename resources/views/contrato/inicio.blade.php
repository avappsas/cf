@extends('layouts.app')

@section('template_title')
    {{ isset($contrato) && $contrato->Id ? 'Editar Contrato' : 'Crear Contrato' }}
@endsection 

@section('content')
<div class="container-fluid">
    @php
        $isEdit = isset($contrato) && $contrato->Id;
        $formAction = $isEdit
            ? route('contratos.update', $contrato->Id)
            : route('contratos.store');
    @endphp

    <form action="{{ $formAction }}" method="POST" id="contratoForm">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif
        @php
            $isCreate = empty($contrato->Id);
            $hoy = \Carbon\Carbon::now();
        @endphp
        
        {{-- Solo en Create prellenamos estos valores --}}
        @if($isCreate)
            {{ Form::hidden('Año', old('Año', $hoy->year)) }}
            {{ Form::hidden('Estado', old('Estado', 'Documentación')) }}
            {{ Form::hidden('Id_Dp', old('Id_Dp', auth()->user()->id_dp)) }}
            {{ Form::hidden('id_user', old('id_user', auth()->id())) }}
            {{ Form::hidden('Iva', old('Iva', 'No')) }}
            {{ Form::hidden('Modalidad', old('Modalidad', 'Contrato')) }}
            {{ Form::hidden('id_estado', old('id_estado', $inicio_estado ?? 1)) }}
        @endif

        <div class="row"> 
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white text-center">
                        <div class="row align-items-center">
                            <div class="col-auto mr-auto">
                                <i class="fas fa-file-contract fa-2x"></i>
                            </div>
                            <div class="col">
                                <h4 class="mb-0">{{ $isEdit ? 'Editar Contrato' : 'Crear Solicitud para Contratista' }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="No_Documento">Documento</label>
                                    <input type="text" name="No_Documento" id="No_Documento" class="form-control" readonly value="{{ old('No_Documento', $contrato->No_Documento) }}" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" readonly value="{{ old('nombre', $nombre) }}" >
                                </div>
                            </div>        
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('Oficina', 'Oficina') }}
                                    {{ Form::select('Oficina', $oficinas, old('Oficina', $contrato->Oficina), [
                                        'class' => 'form-control',
                                        'id'    => 'oficina',
                                        'placeholder' => 'Selecciona oficina'
                                    ]) }}
                                </div>
                            </div> 
                        </div>
                    </div> 

                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-link text-decoration-none" id="guardarContrato">
                            <i class="fa fa-save fa-2x"></i>
                            <div class="small">Guardar</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('guardarContrato');
    btn.addEventListener('click', function() {
        const oficina = document.getElementById('oficina').value;
        if (!oficina) {
            alert('❗ Por favor, selecciona una oficina antes de guardar.');
            return;
        }
        document.getElementById('contratoForm').submit();
    });
});
</script>
@endpush