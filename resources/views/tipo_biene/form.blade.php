

<div class="form-group">
    {{ Form::label('tipo') }}
    {{ Form::text('tipo', $tipoBiene->tipo ?? '', ['class' => 'form-control' . ($errors->has('tipo') ? ' is-invalid' : ''), 'placeholder' => 'Tipo']) }}
    {!! $errors->first('tipo', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group">
    {{ Form::label('Caracteristicas a solicitar') }}
    {{ Form::text('caracteristicas', $tipoBiene->caracteristicas ?? '', ['class' => 'form-control' . ($errors->has('caracteristicas') ? ' is-invalid' : ''), 'placeholder' => 'caracteristicas']) }}
    {!! $errors->first('caracteristicas', '<div class="invalid-feedback">:message</div>') !!}
</div>
<div class="form-group mt-3">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a class="btn btn-secondary" href="{{ route('tipo_bienes.index') }}">Cancelar</a>
</div>
