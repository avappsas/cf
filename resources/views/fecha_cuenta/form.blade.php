<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('id_dp') }}
            {{ Form::text('id_dp', $fechaCuentum->id_dp, ['class' => 'form-control' . ($errors->has('id_dp') ? ' is-invalid' : ''), 'placeholder' => 'Id Dp']) }}
            {!! $errors->first('id_dp', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Fecha_max') }}
            {{ Form::date('fecha_max', $fechaCuentum->fecha_max, ['class' => 'form-control' . ($errors->has('fecha_max') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Máxima']) }}
            {!! $errors->first('fecha_max', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_cuenta') }}
            {{ Form::date('fecha_cuenta', $fechaCuentum->fecha_cuenta, ['class' => 'form-control' . ($errors->has('fecha_cuenta') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Cuenta']) }}
            {!! $errors->first('fecha_cuenta', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>