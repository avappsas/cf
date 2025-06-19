
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

    <form action="{{ $formAction }}" method="POST">
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
        @endif

        <div class="row">
            {{-- === PANEL IZQUIERDO: DATOS DEL CONTRATO EN 2 COLUMNAS === --}}
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white text-center">
                        <div class="row">
                            <div class="col-md-3 text-dark">
                                Datos del {{ $contrato->Modalidad }}
                            </div>
                            <div class="col-md-6">
                                {{ $nombre ?? $contrato->No_Documento }} 
                            </div>
                            <div class="col-md-3">
                                 <strong>Estado:</strong> {{ $contrato->Estado }} 
                            </div>  
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Primera columna de campos --}}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="No_Documento">Documento</label>
                                            <input
                                                type="text"
                                                name="No_Documento"
                                                id="No_Documento"
                                                class="form-control"
                                                readonly
                                                value="{{ old('No_Documento', $contrato->No_Documento) }}"
                                            >
                                        </div>
                                    </div>           
                                    <div class="col-md-5">                
                                        <div class="form-group">
                                            {{ Form::label('Tipo_Contrato', 'Tipo de Contrato') }}
                                            {{ Form::select('Tipo_Contrato', [
                                                '1'=>'Prestación de servicios',
                                                '2'=>'Nombramiento'
                                            ], $contrato->Tipo_Contrato, ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('Nivel', 'Nivel / Perfil') }}
                                            {{ Form::select('Nivel', [
                                                'Asistencial'               => 'Asistencial',
                                                'Tecnico'                   => 'Tecnico',
                                                'Profesional'               => 'Profesional',
                                                'Profesional Especializado' => 'Especializado',
                                            ], $contrato->Nivel, [
                                                'class' => 'form-control' . ($errors->has('Nivel') ? ' is-invalid' : ''),
                                                'placeholder' => 'Selecciona un nivel'
                                            ]) }}
                                            {!! $errors->first('Nivel', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('N_C', 'No. Contrato') }}
                                            {{ Form::text('N_C', old('N_C', $contrato->N_C ?? $next_nc), ['class' => 'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            {{ Form::label('Num_Contrato', 'Código Contrato') }}
                                            {{ Form::text('Num_Contrato', old('Num_Contrato', $contrato->Num_Contrato ?? $next_num_contrato), ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('Plazo', 'Plazo Ejecución') }}
                                            {{ Form::date('Plazo', $contrato->Plazo, ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('Cuotas', 'Cuotas') }}
                                            {{ Form::selectRange('Cuotas', 1, 12, $contrato->Cuotas, ['class'=>'form-control', 'id'=>'cuotas']) }}
                                        </div>
                                    </div>  
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {{ Form::label('Valor_Total', 'Valor Total') }}
                                            {{ Form::text(
                                                'Valor_Total',
                                                '$' . number_format($contrato->Valor_Total, 0, ',', '.'),
                                                ['class' => 'form-control' . ($errors->has('Valor_Total') ? ' is-invalid' : ''), 'id' => 'valor_total']
                                            ) }}
                                            {!! $errors->first('Valor_Total', '<div class="invalid-feedback">:message</div>') !!}
                                        </div>
                                    </div> 
                                 
                                    <div class="col-md-3">
                                            <div class="form-group">
                                                {{ Form::label('Valor_Mensual', 'Valor Mensual') }}
                                                {{ Form::text(
                                                    'Valor_Mensual',
                                                    '$' . number_format($contrato->Valor_Mensual, 0, ',', '.'),
                                                    ['class' => 'form-control' . ($errors->has('Valor_Mensual') ? ' is-invalid' : ''), 'id' => 'valor_mensual']
                                                ) }}
                                                {!! $errors->first('Valor_Mensual', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                    </div>
                                    <div class="col-md-3">
                                            <div class="form-group">
                                                {{ Form::label('Valor_Cuota_1', 'Valor Cuota 1') }}
                                                {{ Form::text(
                                                    'Valor_Cuota_1',
                                                    '$' . number_format($contrato->Valor_Cuota_1, 0, ',', '.'),
                                                    ['class' => 'form-control' . ($errors->has('Valor_Cuota_1') ? ' is-invalid' : '')]
                                                ) }}
                                                {!! $errors->first('Valor_Cuota_1', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('Oficina', 'Oficina') }}
                                            {{ Form::select(
                                                'Oficina',
                                                $oficinas,                                  // listado de id => nombre
                                                old('Oficina', $contrato->Oficina),        // <--- aquí el valor seleccionado
                                                [
                                                  'class' => 'form-control',
                                                  'id'    => 'oficina',
                                                  'placeholder' => 'Selecciona oficina'
                                                ]
                                            ) }}
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('Interventor', 'Supervisor') }}
                                            {{ Form::select(
                                                'Interventor',
                                                $interventores,
                                                old('Interventor', $contrato->Interventor),
                                                [
                                                  'class' => 'form-control',
                                                  'id'    => 'interventor',
                                                  'placeholder' => 'Selecciona supervisor'
                                                ]
                                            ) }}
                                          </div>
                                    </div>
                                  </div>

 

 
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('CDP', 'CDP') }}
                                            {{ Form::text('CDP', $contrato->CDP, ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('Fecha_CDP', 'Fecha CDP') }}
                                            {{ Form::date('Fecha_CDP', $contrato->Fecha_CDP, ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('Fecha_Venc_CDP', 'Vencimiento CDP') }}
                                            {{ Form::date('Fecha_Venc_CDP', $contrato->Fecha_Venc_CDP, ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('Fecha_Estudios', 'Fecha Estudios') }}
                                            {{ Form::date('Fecha_Estudios', $contrato->Fecha_Estudios ?? \Carbon\Carbon::now(), ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('Fecha_Invitacion', 'Fecha Invitación') }}
                                            {{ Form::date('Fecha_Invitacion', $contrato->Fecha_Invitacion ?? \Carbon\Carbon::now(), ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('Fecha_Idoneidad', 'Fecha Idoneidad') }}
                                            {{ Form::date('Fecha_Idoneidad', $contrato->Fecha_Idoneidad ?? \Carbon\Carbon::now(), ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('RPC', 'RPC') }}
                                            {{ Form::text('RPC', $contrato->RPC, ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('Fecha_Suscripcion', 'Fecha Suscripción') }}
                                            {{ Form::date('Fecha_Suscripcion', $contrato->Fecha_Suscripcion, ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            {{ Form::label('Fecha_Notificacion', 'Fecha Notificación') }}
                                            {{ Form::date('Fecha_Notificacion', $contrato->Fecha_Notificacion, ['class'=>'form-control']) }}
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
  

            {{-- === PANEL DERECHO: OBJETO Y ACTIVIDADES === --}}
            <div class="col-md-6">
                {{-- Objeto --}}
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white text-center">
                        Objeto
                    </div>
                    <div class="card-body">
                        {{ Form::textarea('Objeto', $contrato->Objeto, ['class'=>'form-control', 'rows'=>4]) }}
                    </div>
                </div>
                {{-- Actividades --}} 
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white text-center">
                        Actividades
                    </div>
                    <div class="card-body" style="max-height:300px; overflow-y:auto;">
                        {{ Form::textarea(
                            'Actividades',
                            // Si $contrato existe y tiene Actividades, úsalo; si no, el default
                            old(
                                'Actividades',
                                isset($contrato) && $contrato->Actividades
                                    ? $contrato->Actividades
                                    : ''
                            ),
                            ['class' => 'form-control', 'rows' => 8]
                        ) }}
                    </div>
                </div>
    </form>


    
                {{-- opciones --}}
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white text-center">
                        Opciones
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center text-center">
                            
                            <!-- Guardar -->
                            <div class="col-auto">
                                <button type="submit" class="btn btn-link text-decoration-none">
                                    <i class="fa fa-save fa-2x"></i>
                                    <div class="small">Guardar</div>
                                </button>
                            </div>
                            @if(isset($contrato) && $contrato->Estado == 'CDP - Aprobado' )
                            <div class="col-auto">
                                    <button type="button" class="btn btn-link text-decoration-none" onclick="cambioEstadoContrato(1, {{ isset($contrato) ? $contrato->Id : 'null' }})">
                                        <i class="fa-solid fa-file-circle-xmark fa-2x"></i>
                                        <div class="small">Secop-Contratista</div>
                                    </button>
                                </div>
                            @endif
                            @if(isset($contrato) && $contrato->Estado == 'Firma Secop-Contratista')
                                <div class="col-auto">
                                    <button type="button" class="btn btn-link text-decoration-none" onclick="cambioEstadoContrato(1, {{ isset($contrato) ? $contrato->Id : 'null' }})">
                                        <i class="fa-solid fa-file-circle-check fa-2x"></i>
                                        <div class="small">Secop-Presidencia</div>
                                    </button>
                                </div>
                            @endif
                            @if(isset($contrato)  && $contrato->Estado != 'Documentación')
                                <div class="col-auto">
                                    <button type="button" class="btn btn-link text-decoration-none" onclick="btnAbrirModalCarguecontrato({{ $contrato->Id }})">
                                        <i class="fa-solid fa-upload fa-2x"></i>
                                        <div class="small">Documentos</div>
                                    </button>
                                </div>
                            @endif
                            <!-- Contrato A -->
                            <div class="col-auto">
                                @php
                                    $suffix = $contrato->Modalidad === 'Otrosí' ? 5 : ($contrato->Tipo_Contrato == 1 ? 1 : 2);
                                    $numContrato = $contrato->Num_Contrato;
                                @endphp
                            
                                <a href="javascript:void(0);"
                                   onclick="descargarContrato('{{ $numContrato }}', {{ $suffix }})"
                                   class="btn btn-link text-decoration-none"
                                   id="btnDescargar_{{ $numContrato }}">
                                    <i class="fa fa-file-contract fa-2x"></i>
                                    <div class="small">Contrato PDF</div>
                                </a>
                            
                                <div id="spinner_{{ $numContrato }}" style="display:none;">
                                    <i class="fas fa-spinner fa-spin fa-lg text-primary"></i>
                                </div>
                            </div>
                         <!-- Contrato A word -->
                            <div class="col-auto">
                                <a href="javascript:void(0);"
                                onclick="window.location.href = 'https://apicontrato.glitch.me/generarZip/{{ $contrato->Num_Contrato }}/1/0';"
                                class="btn btn-link text-decoration-none"
                                id="btnDescargar_{{ $contrato->Num_Contrato }}">
                                    <i class="fa fa-file-contract fa-2x"></i>
                                    <div class="small">Contrato Word</div>
                                </a>
                                <div id="spinner_{{ $contrato->Num_Contrato }}" style="display:none;">
                                    <i class="fas fa-spinner fa-spin fa-lg text-primary"></i>
                                </div>
                            </div>
                            <!-- Notificación -->
                        @php
                            // Asigna el número de contrato real (en edit) o el siguiente draft (en create)
                            $jsNumContrato = $contrato->Num_Contrato ?? $next_num_contrato;
                        @endphp
                        
                        <div class="col-auto">
                            <button
                                type="button"
                                class="btn btn-link text-decoration-none"
                                onclick="
                                    const fs  = '{{ $contrato->Fecha_Suscripcion ?? '' }}'.trim();
                                    const fn  = '{{ $contrato->Fecha_Notificacion ?? '' }}'.trim();
                                    const rpc = '{{ $contrato->RPC ?? '' }}'.trim();
                                    const numContrato = '{{ $jsNumContrato }}';
                        
                                    if (!fs || !fn || !rpc) {
                                        alert('Debe diligenciar:\n- Fecha de Suscripción\n- Fecha de Notificación\n- RPC\nantes de generar la notificación.');
                                    } else if (!numContrato) {
                                        alert('El número de contrato no está definido.');
                                    } else {
                                        // Redirige construyendo la URL dinámicamente
                                        window.location.href = `/contratos/notificacion/${numContrato}`;
                                    }
                                "
                            >
                                <i class="fa fa-envelope fa-2x"></i>
                                <div class="small">Notificación PDF</div>
                            </button>
                        </div>
                        
                        <!-- Notificación word -->
                            {{-- <div class="col-auto">
                                <button
                                    type="button"
                                    class="btn btn-link text-decoration-none"
                                    onclick="
                                        // Obtener valores de Blade
                                        var fs  = '{{ $contrato->Fecha_Suscripcion ?? '' }}';
                                        var fn  = '{{ $contrato->Fecha_Notificacion ?? '' }}';
                                        var rpc = '{{ $contrato->RPC ?? '' }}';
                                        if (!fs || !fn || !rpc) {
                                            alert('Debe diligenciar Fecha Suscripción, Fecha Notificación y RPC antes de generar la notificación.');
                                        } else {
                                            window.location.href = 'https://apicontrato.glitch.me/generarZip/{{ $contrato->Num_Contrato }}/3';
                                        }
                                    "
                                >
                                    <i class="fa fa-envelope fa-2x"></i>
                                    <div class="small">Notificación Word</div>
                                </button>
                            </div> --}}
                            <!-- Otro-SI -->
                            <div class="col-auto">
                                @if($isEdit)
                                    <form 
                                        action="{{ route('contratos.otrosi', $contrato->Id) }}" 
                                        method="POST" 
                                        style="display:inline"
                                        onsubmit="return confirm('¿Está seguro que desea crear un Otrosí para este contrato?');"
                                    >
                                        @csrf
                                        <button type="submit" class="btn btn-link text-decoration-none">
                                            <i class="fa fa-plus-square fa-2x"></i>
                                            <div class="small">Otro‑SI</div>
                                        </button>
                                    </form> 
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
  
 
</div>

    {{-- modal para cargar documentos cuotas --}}

    <div class="modal fade" id="modalDocUploadCuota" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document" style="max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                background-repeat: no-repeat;
                                color: white;
                                font-family: 'Mallanna';
                                font-size: 17px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalDocUploadCuota"><div class="card">
                    <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;"> 
                                <span id="card_title"> 
                                </span> 
                                <div class="float-right">
                                    <i class="fa fa-fw fa-file-contract"></i> 
                                    {{ __('Documentos') }}
                                </div>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                    
                        <div class="card-body">
                            <div class="form-group" >
                                <div class="row">
                                    <div class="table-responsive">
                                        <div class="table table-striped table-hover" id="tablaDocs">

                                        </div>   
                                    </div>
                                    
                                </div>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    {{-- modal para ver documentos cuotas --}}

    <div class="modal fade bd-example-modal-xl" id="modalVerDocCuota" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                background-repeat: no-repeat;
                                color: white;
                                font-family: 'Mallanna';
                                font-size: 17px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalVerDocCuota"><div class="card">
                    <div class="row">
                        <embed id="pdfEmbed" src="" type="application/pdf" width="100%" height="800px">
                    </div>
                </div>
                
                <div class="modal-footer"  >
                    
                </div>
            </div>
        </div>
    </div>
 
@endsection


@section('js')
<script>

 const dataToken = document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute('content');



document.addEventListener('DOMContentLoaded', function () {
    // 1) Guardamos en JS el interventor preseleccionado (o cadena vacía)
    const selectedInterventor = @json(old('Interventor', $contrato->Interventor));

    $('#oficina').on('change', function () {
        const oficinaId = $(this).val();
        const $interventor = $('#interventor');

        if (!oficinaId) {
            return $interventor
                .empty()
                .append('<option value="">Selecciona un interventor</option>');
        }

        $.get(`/interventores-por-oficina/${oficinaId}`, function (data) {
            $interventor.empty().append('<option value="">Selecciona un interventor</option>');

            // 2) Poblar opciones
            $.each(data, function (id, nombre) {
                $interventor.append(`<option value="${id}">${nombre}</option>`);
            });

            // 3) Si solo hay uno, selecciónalo
            if (Object.keys(data).length === 1) {
                const onlyId = Object.keys(data)[0];
                $interventor.val(onlyId);
            }

            // 4) Y ahora forzamos el valor guardado (solo en edit habrá uno)
            if (selectedInterventor) {
                $interventor.val(selectedInterventor);
            }
        });
    });

    @if($isEdit)
        // Disparamos el change al cargar en edit
        $('#oficina').trigger('change');
    @endif
});

function AbrirPDFM2(Ruta){
    console.log(Ruta)
    document.getElementById('pdfEmbed').src = Ruta;
    $('#modalVerDocCuota').modal('show'); 
}

 
    function descargarContrato(numContrato, suffix) {
        // Mostrar spinner
        document.getElementById('spinner_' + numContrato).style.display = 'inline-block';

        // Desactivar el botón
        const btn = document.getElementById('btnDescargar_' + numContrato);
        btn.style.pointerEvents = 'none';
        btn.style.opacity = 0.6;

        // Generar URL
        const url = `/contratos/${numContrato}/descargar-documentos?suffix=${suffix}`;

        // Simulación de carga breve y abrir ZIP
        setTimeout(() => {
            window.open(url, '_blank');

            // Restaurar estado
            document.getElementById('spinner_' + numContrato).style.display = 'none';
            btn.style.pointerEvents = 'auto';
            btn.style.opacity = 1;
        }, 1000);
    }



    $(document).ready(function() {

  function actualizarValorMensual() {
    // 1) Obtener valor total sin símbolos ni puntos
    let totalStr = $('#valor_total').val();
    let soloNumeros = totalStr.replace(/[^0-9]/g, '');
    let total = parseFloat(soloNumeros) || 0;

    // 2) Obtener número de cuotas
    let cuotas = parseInt($('#cuotas').val()) || 1;

    // 3) Calcular mensual
    let mensual = total / cuotas;

    // 4) Formatear como moneda COP sin decimales
    let formatted = new Intl.NumberFormat('es-CO', {
      style: 'currency',
      currency: 'COP',
      minimumFractionDigits: 0,
      maximumFractionDigits: 0
    }).format(mensual);

    // 5) Actualizar el campo
    $('#valor_mensual').val(formatted);
  }

  // Disparadores de recálculo
  $('#valor_total').on('input', actualizarValorMensual);
  $('#cuotas').on('change', actualizarValorMensual);

  // Opcional: recalcular al cargar la página (por si hay valor previo)
  actualizarValorMensual();
});
 

function cambioEstadoContrato(estado, idContrato) {
  // 1) Si intentas APROBAR (estado == 1), validamos en la tabla 
        Swal.fire({
    title: '¿Estás seguro?',
    text: `¿Deseas ${estado == 1 ? 'aprobar' : 'devolver'} este contrato?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, ¡adelante!',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '{{ url("/cambioEstadoContrato") }}',
        type: 'get',
        dataType: 'json',       // para forzar JSON
        data: {
          _token: "{{ csrf_token() }}",
          estado:    estado,
          idContrato: idContrato,
          idCuota:   1          // ← lo que te faltaba
        },
        success: function(resp) {
          if (resp.success) {
            Swal.fire({
                text: "Estado Actualizado Correctamente.",
                icon: "success"
            });
        location.reload(); // Recarga la página actual
      } else {
            Swal.fire({
                text: '❌ No se pudo actualizar el estado. Inténtalo de nuevo.',
                icon: 'error'
            });
      }
    },
    error: function() {
          Swal.fire({
                text: '❌ Ocurrió un error en el servidor.',
                icon: 'error'
  });
}
      });
    }
  });
}



function btnAbrirModalCarguecontrato(idContrato){
    
    $.ajax({
        url: ('/documentosContrato'),
        type:'get',
        data: {_token:dataToken, idContrato:idContrato},
        success: function(data) {
            $('#tablaDocs').empty();
            $('#tablaDocs').html(data);
            // console.log(data);
            $('#modalDocUploadCuota').modal('show');
        }
    });
}

</script>
@endsection
    
 