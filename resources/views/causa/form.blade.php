<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('id_ramo', 'Ramo') }}
            {{ Form::select('id_ramo', $ramos, $causa->id_ramo, [
                'class' => 'form-control' . ($errors->has('id_ramo') ? ' is-invalid' : ''), 
                'placeholder' => 'Seleccione un Ramo'
            ]) }}
            {!! $errors->first('id_ramo', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('Causa') }}
            {{ Form::text('causa', $causa->causa, ['class' => 'form-control' . ($errors->has('causa') ? ' is-invalid' : ''), 'placeholder' => 'causa']) }}
            {!! $errors->first('causa', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>