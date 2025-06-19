<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('Broker') }}
            {{ Form::text('broker', $broker->broker, ['class' => 'form-control' . ($errors->has('broker') ? ' is-invalid' : ''), 'placeholder' => 'Nombre del Broker']) }}
            {!! $errors->first('broker', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        
        <div class="form-group">
            {{ Form::label('observacion') }}
            {{ Form::text('observacion', $broker->observacion, ['class' => 'form-control' . ($errors->has('observacion') ? ' is-invalid' : ''), 'placeholder' => 'Campo 1']) }}
            {!! $errors->first('observacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>