<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group">
            <div class="row">
                <div class="col">
                    {{ Form::label('Cédula') }}
                    {{ Form::label($user->usuario) }}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    {{ Form::label('Nombres') }}
                    {{ Form::text('name', $user->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                    {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
                </div>
                <div class="col">
                    {{ Form::label('Email') }}
                    {{ Form::text('email', $user->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Correo Electrónico']) }}
                    {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    {{ Form::label('Teléfonos') }}
                    {{ Form::text('telefonos', $user->telefonos, ['class' => 'form-control' . ($errors->has('telefonos') ? ' is-invalid' : ''), 'placeholder' => 'Teléfonos']) }}
                    {!! $errors->first('telefonos', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    {{ Form::label('Provincia' ) }}
                    {{ Form::select('id_provincia', $provincias, $user->id_provincia, [
                        'class' => 'form-control',
                        'placeholder' => 'Seleccione una provincia'
                    ]) }}
                    {!! $errors->first('id_provincia', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    {{ Form::label('Contraseña') }}
                    {{ Form::password('password', ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'Contraseña']) }}
                    {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary" id="btnEnviarUsuario">Aplicar</button>
    </div>
</div>
