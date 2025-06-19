<div class="box box-info padding-1">
    <div class="box-body">
        

        <div class="col-md-2">
        </div>

            <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            {{ Form::label('Tipo_Doc') }}
                            {{ Form::select('Tipo_Doc', ['CC' => 'CC', 'PT' => 'PT', 'CE' => 'CE'], $baseDato->Tipo_Doc ?? 'CC', ['class' => 'form-control' . ($errors->has('Tipo_Doc') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona el tipo de documento']) }}
                            {!! $errors->first('Tipo_Doc', '<div class="invalid-feedback">:message</div>') !!}
                        </div>                        
                    </div>   

                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Documento') }}
                            {{ Form::text('Documento', $baseDato->Documento, ['class' => 'form-control' . ($errors->has('Documento') ? ' is-invalid' : ''), 'placeholder' => 'Documento']) }}
                            {!! $errors->first('Documento', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            {{ Form::label('Dv') }}
                            {{ Form::select('Dv', 
                                ['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9'], 
                                $baseDato->Dv ?? null, 
                                ['class' => 'form-control' . ($errors->has('Dv') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona un valor']) }}
                            {!! $errors->first('Dv', '<div class="invalid-feedback">:message</div>') !!}
                        </div>                        
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('Nombre completo') }}
                            {{ Form::text('Nombre', $baseDato->Nombre, ['class' => 'form-control' . ($errors->has('Nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                            {!! $errors->first('Nombre', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                        
                        <div class="form-group">
                            {{ Form::label('Fecha de Nacimiento') }}
                            {{ Form::date('Fecha_Nacimiento', $baseDato->Fecha_Nacimiento, ['class' => 'form-control' . ($errors->has('Fecha_Nacimiento') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Nacimiento']) }}
                            {!! $errors->first('Fecha_Nacimiento', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Genero') }}
                            {{ Form::select('Genero', ['Femenino' => 'Femenino', 'Masculino' => 'Masculino'], $baseDato->Genero ?? null, ['class' => 'form-control' . ($errors->has('Genero') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona un género']) }}
                            {!! $errors->first('Genero', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('Celular llamadas') }}
                            {{ Form::text('Telefono', $baseDato->Telefono, ['class' => 'form-control' . ($errors->has('Telefono') ? ' is-invalid' : ''), 'placeholder' => 'Telefono']) }}
                            {!! $errors->first('Telefono', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('Celular WhatsApp') }}
                            {{ Form::text('Celular', $baseDato->Celular, ['class' => 'form-control' . ($errors->has('Celular') ? ' is-invalid' : ''), 'placeholder' => 'Celular']) }}
                            {!! $errors->first('Celular', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Direccion y barrio') }}
                            {{ Form::text('Direccion', $baseDato->Direccion, ['class' => 'form-control' . ($errors->has('Direccion') ? ' is-invalid' : ''), 'placeholder' => 'Direccion']) }}
                            {!! $errors->first('Direccion', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('Correo personal') }}
                        {{ Form::email('Correo', $baseDato->Correo, ['class' => 'form-control' . ($errors->has('Correo') ? ' is-invalid' : ''), 'placeholder' => 'Correo']) }}
                        {!! $errors->first('Correo', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('correo_secop') }}
                        {{ Form::email('correo_secop', $baseDato->correo_secop, ['class' => 'form-control' . ($errors->has('correo_secop') ? ' is-invalid' : ''), 'placeholder' => 'Correo Secop']) }}
                        {!! $errors->first('correo_secop', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        {{ Form::label('Nivel_estudios') }}
                        {{ Form::select('Nivel_estudios', [
                            'Bachiller' => 'Bachiller','Tecnico o Tecnologico' => 'Tecnico o Tecnologico','Profesional' => 'Profesional','Especializacion' => 'Especializacion','Maestria o Doctorado' => 'Maestria o Doctorado'],
                             $baseDato->Nivel_estudios, ['class' => 'form-control' . ($errors->has('Nivel_estudios') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione Nivel de Estudios']) }}
                        {!! $errors->first('Nivel_estudios', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {{ Form::label('Perfil') }}
                        {{ Form::text('Perfil', $baseDato->Perfil, ['class' => 'form-control' . ($errors->has('Perfil') ? ' is-invalid' : ''), 'placeholder' => 'Perfil']) }}
                        {!! $errors->first('Perfil', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {{ Form::label('Profesion') }}
                        {{ Form::text('Profesion', $baseDato->Profesion, ['class' => 'form-control' . ($errors->has('Profesion') ? ' is-invalid' : ''), 'placeholder' => 'Profesion']) }}
                        {!! $errors->first('Profesion', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{ Form::label('Observacion') }}
                        {{ Form::text('Observacion', $baseDato->Observacion, ['class' => 'form-control' . ($errors->has('Observacion') ? ' is-invalid' : ''), 'placeholder' => 'Observacion', 'style' => 'height: 100px;']) }}
                        {!! $errors->first('Observacion', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    {{--  <div class="form-group">  --}}
                        {{ Form::label('firma', 'Subir mi firma para las cuentas') }}
                        {{ Form::file('firma', ['class' => 'form-control' . ($errors->has('firma') ? ' is-invalid' : ''), 'placeholder' => 'firma', 'style' => 'height: 100px;', 'accept' => '.jpg, .png', 'id'=>'firma']) }}
                        {!! $errors->first('firma', '<div class="invalid-feedback">:message</div>') !!}
                    {{--  </div>  --}}
                </div>
            </div>

            
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>

