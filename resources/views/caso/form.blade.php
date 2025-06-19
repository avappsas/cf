<div class="box box-info padding-1">
    <div class="box-body">

        <div class="col-md-2"> 
            {{ Form::hidden('estado', 'EN PROCESO') }}
        </div>

        {{-- ======= DATOS BÁSICOS ======= --}}
        <div class="card card-default">
            <div class="card-header"><span class="card-title"></span></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        {{ Form::label('ramo') }}
                        {!! Form::select('ramo', $Ramo, $caso->ramo ?? '', [
                            'id'        => 'ramo',
                            'class'     => 'form-control'.($errors->has('ramo') ? ' is-invalid':''),
                            'placeholder'=> 'Seleccione el Ramo',
                            'onchange'  => 'ramoSeleccionado(this)'
                        ]) !!}
                        {!! $errors->first('ramo','<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-3">
                        {{ Form::label('aseguradora') }}
                        {!! Form::select('aseguradora', $Aseguradora, $caso->aseguradora, [ 'class' => 'form-control' . ($errors->has('aseguradora') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione la Aseguradora', 'id' => 'aseguradora']) !!}
                        {!! $errors->first('aseguradora', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('broker') }}
                        {!! Form::select('broker', $Broker, $caso->broker, ['class' => 'form-control' . ($errors->has('broker') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione el Broker']) !!}
                        {!! $errors->first('broker', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('no_reporte') }}
                        {{ Form::text('no_reporte', $caso->no_reporte, ['class' => 'form-control' . ($errors->has('no_reporte') ? ' is-invalid' : ''), 'placeholder' => 'No Reporte']) }}
                        {!! $errors->first('no_reporte', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-3">
                        {{ Form::label('reclamo_aseguradora') }}
                        {{ Form::text('reclamo_aseguradora', $caso->reclamo_aseguradora, ['class' => 'form-control' . ($errors->has('reclamo_aseguradora') ? ' is-invalid' : ''), 'placeholder' => 'Reclamo Aseguradora']) }}
                        {!! $errors->first('reclamo_aseguradora', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>

                <div class="row pt-3">
                    <div class="col-md-3">
                        {{ Form::label('poliza_anexo') }}
                        {{ Form::text('poliza_anexo', $caso->poliza_anexo, ['class' => 'form-control' . ($errors->has('poliza_anexo') ? ' is-invalid' : ''), 'placeholder' => 'Poliza Anexo']) }}
                        {!! $errors->first('poliza_anexo', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('inicio_poliza') }}
                        {{ Form::date('inicio_poliza', $caso->inicio_poliza, ['class' => 'form-control' . ($errors->has('inicio_poliza') ? ' is-invalid' : ''), 'placeholder' => 'Inicio Poliza']) }}
                        {!! $errors->first('inicio_poliza', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('fin_poliza') }}
                        {{ Form::date('fin_poliza', $caso->fin_poliza, ['class' => 'form-control' . ($errors->has('fin_poliza') ? ' is-invalid' : ''), 'placeholder' => 'Fin Poliza']) }}
                        {!! $errors->first('fin_poliza', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- ======= DATOS DEL ASEGURADO ======= --}}
        <p></p>
        <div class="card card-default">
            <div class="card-header"><span class="card-title">Datos del Asegurado</span></div>
            <div class="card-body">
                <div class="row"> 
                    <div class="col-md-2">
                        {{ Form::label('no documento') }}
                        {{ Form::text('asegurado', $caso->asegurado, ['class' => 'form-control' . ($errors->has('asegurado') ? ' is-invalid' : ''), 'placeholder' => 'Documento']) }}
                        {!! $errors->first('asegurado', '<div class="invalid-feedback">:message</div>') !!}
                    </div>    
                    <div class="col-md-3">
                        {{ Form::label('nombre') }}
                        {{ Form::text('nombre_asegurado', $caso->nombre_asegurado, ['class' => 'form-control' . ($errors->has('nombre_asegurado') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                        {!! $errors->first('nombre_asegurado', '<div class="invalid-feedback">:message</div>') !!}
                    </div> 
                    <div class="col-md-3">
                        {{ Form::label('dirección') }}
                        {{ Form::text('direccion_asegurado', $caso->direccion_asegurado, ['class' => 'form-control' . ($errors->has('direccion_asegurado') ? ' is-invalid' : ''), 'placeholder' => 'Dirección']) }}
                        {!! $errors->first('direccion_asegurado', '<div class="invalid-feedback">:message</div>') !!}
                    </div> 
                    <div class="col-md-4">
                        {{ Form::label('correo electrónico') }}
                        {{ Form::text('email_asegurado', $caso->email_asegurado, ['class' => 'form-control' . ($errors->has('email_asegurado') ? ' is-invalid' : ''), 'placeholder' => 'Correo']) }}
                        {!! $errors->first('email_asegurado', '<div class="invalid-feedback">:message</div>') !!}
                    </div> 
                </div>
            </div>
        </div>

        {{-- ======= DATOS DEL SINIESTRO ======= --}}
        <p></p>
        <div class="card card-default">
            <div class="card-header"><span class="card-title">Datos del Siniestro</span></div>
            <div class="card-body">
                <div class="row"> 
                    <div class="col-md-2">
                        {{ Form::label('fecha_siniestro') }}
                        {{ Form::date('fecha_siniestro', $caso->fecha_siniestro, ['class' => 'form-control' . ($errors->has('fecha_siniestro') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Siniestro']) }}
                        {!! $errors->first('fecha_siniestro', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('hora_siniestro') }}
                        {{ Form::time('hora_siniestro', $caso->hora_siniestro, ['class' => 'form-control' . ($errors->has('hora_siniestro') ? ' is-invalid' : ''), 'placeholder' => 'Hora Siniestro']) }}
                        {!! $errors->first('hora_siniestro', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('fecha_asignacion') }}
                        {{ Form::date('fecha_asignacion', $caso->fecha_asignacion, ['class' => 'form-control' . ($errors->has('fecha_asignacion') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Asignación']) }}
                        {!! $errors->first('fecha_asignacion', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('fecha_reporte') }}
                        {{ Form::date('fecha_reporte', $caso->fecha_reporte, ['class' => 'form-control' . ($errors->has('fecha_reporte') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Reporte']) }}
                        {!! $errors->first('fecha_reporte', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('sector_evento') }}
                        {{ Form::text('sector_evento', $caso->sector_evento, ['class' => 'form-control' . ($errors->has('sector_evento') ? ' is-invalid' : ''), 'placeholder' => 'Sector Evento']) }}
                        {!! $errors->first('sector_evento', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>   

                <br>

                <div class="row"> 
                    <div class="col-md-4">
                        {{ Form::label('lugar_siniestro') }}
                        {{ Form::text('lugar_siniestro', $caso->lugar_siniestro, ['class' => 'form-control' . ($errors->has('lugar_siniestro') ? ' is-invalid' : ''), 'placeholder' => 'Lugar Siniestro']) }}
                        {!! $errors->first('lugar_siniestro', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
 

                    <div class="col-md-2">
                        {{ Form::label('causa') }}
                        {!! Form::select('causa', $Causa, $caso->causa, ['class' => 'form-control' . ($errors->has('causa') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione la Causa', 'id' => 'causa']) !!}
                        {!! $errors->first('causa', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
 
                    <div class="col-md-2">
                        {{ Form::label('seguro_afectado') }}
                        {{ Form::select('seguro_afectado', $Seguro, $caso->seguro_afectado, ['class' => 'form-control' . ($errors->has('seguro_afectado') ? ' is-invalid' : ''), 'placeholder' => 'Seguro Afectado']) }}
                        {!! $errors->first('seguro_afectado', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-4">
                        {{ Form::label('inspector') }}
                        {{ Form::select('inspector', $User, $caso->inspector, ['class' => 'form-control' . ($errors->has('inspector') ? ' is-invalid' : ''), 'placeholder' => 'Inspector']) }}
                        {!! $errors->first('inspector', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>      

                <br>
                <div class="row">
                    <div class="col-md-6">
                        {{ Form::label('circunstancias') }}
                        {{ Form::textarea('circunstancias', $caso->circunstancias, ['class' => 'form-control' . ($errors->has('circunstancias') ? ' is-invalid' : ''), 'placeholder' => 'Circunstancias', 'rows' => 5]) }}
                        {!! $errors->first('circunstancias', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-6">
                        {{ Form::label('observaciones') }}
                        {{ Form::textarea('observaciones', $caso->observaciones, ['class' => 'form-control' . ($errors->has('observaciones') ? ' is-invalid' : ''), 'placeholder' => 'Observaciones', 'rows' => 5]) }}
                        {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>      
            </div>
        </div>  

        {{-- ======= DATOS DEL CONTACTO =======     --}}
        <p></p>
        @if(($ramo ?? $caso->ramo ?? null) == 4)
        <div id="roboCard" class="card card-default"> 
         <div class="card-header"><span class="card-title">Datos sobre el robo</span></div>
            <div class="card-body">
                <div class="row"> 
                        <div class="col-md-3">
                            {{ Form::label('robo_fractura', 'Existe fractura, Si, No') }}
                            {{ Form::text('robo_fractura', old('robo_fractura', $caso->robo_fractura ?? ''), [
                                'class'       => 'form-control'.($errors->has('robo_fractura') ? ' is-invalid':''),
                                'placeholder' => 'Fractura'
                            ]) }}
                            {!! $errors->first('robo_fractura','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    
                        {{-- robo_violencia --}}
                        <div class="col-md-3">
                            {{ Form::label('robo_violencia', 'Existe violencia, Si, No') }}
                            {{ Form::text('robo_violencia', old('robo_violencia', $caso->robo_violencia ?? ''), [
                                'class'       => 'form-control'.($errors->has('robo_violencia') ? ' is-invalid':''),
                                'placeholder' => 'Violencia'
                            ]) }}
                            {!! $errors->first('robo_violencia','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    
                        {{-- robo_escalamiento --}}
                        <div class="col-md-3">
                            {{ Form::label('robo_escalamiento', 'Existe escalamiento, Si, No') }}
                            {{ Form::text('robo_escalamiento', old('robo_escalamiento', $caso->robo_escalamiento ?? ''), [
                                'class'       => 'form-control'.($errors->has('robo_escalamiento') ? ' is-invalid':''),
                                'placeholder' => 'Escalamiento'
                            ]) }}
                            {!! $errors->first('robo_escalamiento','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    
                        {{-- robo_otros_detalle --}}
                        <div class="col-md-3">
                            {{ Form::label('robo_otros_detalle', 'Otros (detalle)') }}
                            {{ Form::text('robo_otros_detalle', old('robo_otros_detalle', $caso->robo_otros_detalle ?? ''), [
                                'class'       => 'form-control'.($errors->has('robo_otros_detalle') ? ' is-invalid':''),
                                'placeholder' => 'Otros (detalle)'
                            ]) }}
                            {!! $errors->first('robo_otros_detalle','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    
                        {{-- robo_alarma --}}
                        <div class="col-md-3">
                            {{ Form::label('robo_alarma', 'Alarma Monitoreada, Si, No, Cual?') }}
                            {{ Form::text('robo_alarma', old('robo_alarma', $caso->robo_alarma ?? ''), [
                                'class'       => 'form-control'.($errors->has('robo_alarma') ? ' is-invalid':''),
                                'placeholder' => 'Alarma'
                            ]) }}
                            {!! $errors->first('robo_alarma','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    
                        {{-- robo_guardiania --}}
                        <div class="col-md-3">
                            {{ Form::label('robo_guardiania', 'Guardianía, Si, No, Cual?') }}
                            {{ Form::text('robo_guardiania', old('robo_guardiania', $caso->robo_guardiania ?? ''), [
                                'class'       => 'form-control'.($errors->has('robo_guardiania') ? ' is-invalid':''),
                                'placeholder' => 'Guardianía'
                            ]) }}
                            {!! $errors->first('robo_guardiania','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    
                        {{-- robo_camaras --}}
                        <div class="col-md-3">
                            {{ Form::label('robo_camaras', 'Cámaras de Seguridad, Si, No, Cuantas?') }}
                            {{ Form::text('robo_camaras', old('robo_camaras', $caso->robo_camaras ?? ''), [
                                'class'       => 'form-control'.($errors->has('robo_camaras') ? ' is-invalid':''),
                                'placeholder' => 'Cámaras'
                            ]) }}
                            {!! $errors->first('robo_camaras','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    
                        {{-- robo_sensores --}}
                        <div class="col-md-3">
                            {{ Form::label('robo_sensores', 'Sensores de movimiento, Si, No, Cuantos?') }}
                            {{ Form::text('robo_sensores', old('robo_sensores', $caso->robo_sensores ?? ''), [
                                'class'       => 'form-control'.($errors->has('robo_sensores') ? ' is-invalid':''),
                                'placeholder' => 'Sensores'
                            ]) }}
                            {!! $errors->first('robo_sensores','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    
                        {{-- robo_rejas_externas --}}
                        <div class="col-md-3">
                            {{ Form::label('robo_rejas_externas', 'Rejas externas, Si, No') }}
                            {{ Form::text('robo_rejas_externas', old('robo_rejas_externas', $caso->robo_rejas_externas ?? ''), [
                                'class'       => 'form-control'.($errors->has('robo_rejas_externas') ? ' is-invalid':''),
                                'placeholder' => 'Rejas externas'
                            ]) }}
                            {!! $errors->first('robo_rejas_externas','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    
                        {{-- robo_candados --}}
                        <div class="col-md-3">
                            {{ Form::label('robo_candados', 'Candados y chapas, Si, No, donde?') }}
                            {{ Form::text('robo_candados', old('robo_candados', $caso->robo_candados ?? ''), [
                                'class'       => 'form-control'.($errors->has('robo_candados') ? ' is-invalid':''),
                                'placeholder' => 'Candados'
                            ]) }}
                            {!! $errors->first('robo_candados','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    
                        {{-- robo_policia --}}
                        <div class="col-md-3">
                            {{ Form::label('robo_policia', 'Policía Nacional, Si, No, a que distancia?') }}
                            {{ Form::text('robo_policia', old('robo_policia', $caso->robo_policia ?? ''), [
                                'class'       => 'form-control'.($errors->has('robo_policia') ? ' is-invalid':''),
                                'placeholder' => 'Aviso a policía'
                            ]) }}
                            {!! $errors->first('robo_policia','<div class="invalid-feedback">:message</div>') !!}
                        </div>
                </div>
            </div>
        </div> 
        @endif
        {{-- ======= DATOS DEL CONTACTO ======= --}}
        <p></p>
        <div class="card card-default">
            <div class="card-header"><span class="card-title">Datos del Contacto</span></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        {{ Form::label('nombre') }}
                        {{ Form::text('nombre', $caso->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('ci') }}
                        {{ Form::text('ci', $caso->ci, ['class' => 'form-control' . ($errors->has('ci') ? ' is-invalid' : ''), 'placeholder' => 'CI']) }}
                        {!! $errors->first('ci', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('parentezo') }}
                        {{ Form::text('parentezo', $caso->parentezo, ['class' => 'form-control' . ($errors->has('parentezo') ? ' is-invalid' : ''), 'placeholder' => 'Parentezo']) }}
                        {!! $errors->first('parentezo', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('ocupacion') }}
                        {{ Form::text('ocupacion', $caso->ocupacion, ['class' => 'form-control' . ($errors->has('ocupacion') ? ' is-invalid' : ''), 'placeholder' => 'Ocupación']) }}
                        {!! $errors->first('ocupacion', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::label('telefonos') }}
                        {{ Form::text('telefonos', $caso->telefonos, ['class' => 'form-control' . ($errors->has('telefonos') ? ' is-invalid' : ''), 'placeholder' => 'Teléfonos']) }}
                        {!! $errors->first('telefonos', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
            </div>
        </div> 

    </div>

    <br>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>
