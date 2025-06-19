<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('id_bien') }}
            {{ Form::text('id_bien', $valoracione->id_bien, ['class' => 'form-control' . ($errors->has('id_bien') ? ' is-invalid' : ''), 'placeholder' => 'Id Bien']) }}
            {!! $errors->first('id_bien', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('descripcion') }}
            {{ Form::text('descripcion', $valoracione->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
            {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Cant') }}
            {{ Form::text('cant', $valoracione->cant, ['class' => 'form-control' . ($errors->has('cant') ? ' is-invalid' : ''), 'placeholder' => 'cant']) }}
            {!! $errors->first('cant', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Valor_Cotizado') }}
            {{ Form::text('valor_cotizado', $valoracione->valor_cotizado, ['class' => 'form-control' . ($errors->has('valor_cotizado') ? ' is-invalid' : ''), 'placeholder' => 'valor cotizado']) }}
            {!! $errors->first('valor_cotizado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('valor_aprobado') }}
            {{ Form::text('valor_aprobado', $valoracione->valor_aprobado, ['class' => 'form-control' . ($errors->has('valor_aprobado') ? ' is-invalid' : ''), 'placeholder' => 'valor aprobado']) }}
            {!! $errors->first('valor_aprobado', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>