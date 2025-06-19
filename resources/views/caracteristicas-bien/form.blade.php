<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('id_bien') }}
            {{ Form::text('id_bien', $caracteristicasBien->id_bien, ['class' => 'form-control' . ($errors->has('id_bien') ? ' is-invalid' : ''), 'placeholder' => 'Id Bien']) }}
            {!! $errors->first('id_bien', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('caracteristica') }}
            {{ Form::text('caracteristica', $caracteristicasBien->caracteristica, ['class' => 'form-control' . ($errors->has('caracteristica') ? ' is-invalid' : ''), 'placeholder' => 'Caracteristica']) }}
            {!! $errors->first('caracteristica', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('valor') }}
            {{ Form::text('valor', $caracteristicasBien->valor, ['class' => 'form-control' . ($errors->has('valor') ? ' is-invalid' : ''), 'placeholder' => 'Valor']) }}
            {!! $errors->first('valor', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>