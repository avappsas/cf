<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('Aseguradora') }}
            {{ Form::text('aseguradora', $aseguradora->aseguradora, ['class' => 'form-control' . ($errors->has('aseguradora') ? ' is-invalid' : ''), 'placeholder' => 'aseguradora']) }}
            {!! $errors->first('aseguradora', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('id_ramo', 'Ramo') }}
            {{ Form::select('id_ramo', $ramos, $aseguradora->id_ramo, [
                'class' => 'form-control' . ($errors->has('id_ramo') ? ' is-invalid' : ''), 
                'placeholder' => 'Seleccione un Ramo'
            ]) }}
            {!! $errors->first('id_ramo', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>