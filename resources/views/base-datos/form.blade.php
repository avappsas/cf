@if (session('error'))
    <div class="bg-red-100 text-red-700 border border-red-400 px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
<div class="box box-info padding-1">
    <div class="box-body"> 
        <div class="col-md-2">
        </div>

            <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Tipo_Doc') }}
                            {{ Form::select('Tipo_Doc', ['CC' => 'CC', 'PT' => 'PT', 'CE' => 'CE'], $baseDato->Tipo_Doc ?? 'CC', ['class' => 'form-control' . ($errors->has('Tipo_Doc') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona el tipo de documento']) }}
                            {!! $errors->first('Tipo_Doc', '<div class="invalid-feedback">:message</div>') !!}
                        </div>                        
                    </div>   

                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('Documento') }}
                            {{ Form::text('Documento', $baseDato->Documento, ['class' => 'form-control' . ($errors->has('Documento') ? ' is-invalid' : ''), 'placeholder' => 'Documento']) }}
                            {!! $errors->first('Documento', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Dv') }}
                            {{ Form::select('Dv', 
                                ['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9'], 
                                $baseDato->Dv ?? null, 
                                ['class' => 'form-control' . ($errors->has('Dv') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona un valor']) }}
                            {!! $errors->first('Dv', '<div class="invalid-feedback">:message</div>') !!}
                        </div>                        
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            {{ Form::label('Nombre completo') }}
                            {{ Form::text('Nombre', $baseDato->Nombre, ['class' => 'form-control' . ($errors->has('Nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                            {!! $errors->first('Nombre', '<div class="invalid-feedback">:message</div>') !!}
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

                    <div class="col-md-3"> 
                        <div class="form-group">
                            {{ Form::label('Fecha de Nacimiento') }}
                            {{ Form::date('Fecha_Nacimiento', $baseDato->Fecha_Nacimiento, ['class' => 'form-control' . ($errors->has('Fecha_Nacimiento') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Nacimiento']) }}
                            {!! $errors->first('Fecha_Nacimiento', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('Genero') }}
                            {{ Form::select('Genero', ['Femenino' => 'Femenino', 'Masculino' => 'Masculino'], $baseDato->Genero ?? null, ['class' => 'form-control' . ($errors->has('Genero') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona un género']) }}
                            {!! $errors->first('Genero', '<div class="invalid-feedback">:message</div>') !!}
                        </div> 
                    </div> 
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {{ Form::label('Correo personal') }}
                        {{ Form::email('Correo', $baseDato->Correo, ['class' => 'form-control' . ($errors->has('Correo') ? ' is-invalid' : ''), 'placeholder' => 'Correo']) }}
                        {!! $errors->first('Correo', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('Municipio') }}
                            {{ Form::text('Municipio', $baseDato->Municipio, ['class' => 'form-control' . ($errors->has('Municipio') ? ' is-invalid' : ''), 'placeholder' => 'Municipio']) }}
                            {!! $errors->first('Municipio', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                </div> 
                <div class="col-md-5">
                    <div class="form-group">
                        {{ Form::label('Direccion y barrio') }}
                        {{ Form::text('Direccion', $baseDato->Direccion, ['class' => 'form-control' . ($errors->has('Direccion') ? ' is-invalid' : ''), 'placeholder' => 'Direccion']) }}
                        {!! $errors->first('Direccion', '<div class="invalid-feedback">:message</div>') !!}
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
                <div class="col-md-3">
                    <div class="form-group">
                        {{ Form::label('Perfil') }}
                        {{ Form::text('Perfil', $baseDato->Perfil, ['class' => 'form-control' . ($errors->has('Perfil') ? ' is-invalid' : ''), 'placeholder' => 'Perfil']) }}
                        {!! $errors->first('Perfil', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        {{ Form::label('Profesion') }}
                        {{ Form::text('Profesion', $baseDato->Profesion, ['class' => 'form-control' . ($errors->has('Profesion') ? ' is-invalid' : ''), 'placeholder' => 'Profesion']) }}
                        {!! $errors->first('Profesion', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
 
                <div class="col-md-6">
                    <div class="card border-light shadow-sm" style="height: 200px;"> 
                        <div class="card-header bg-white border-0 pb-0">
                            <h5 class="mb-0 text-primary">Observaciones</h5> 
                            {{ Form::textarea('Observacion', $baseDato->Observacion, ['class' => 'form-control' . ($errors->has('Observacion') ? ' is-invalid' : ''),
                            'placeholder' => 'puedes escribir alguna Observación', 'style' => 'height: 150px;' ]) }}
                            {!! $errors->first('Observacion', '<div class="invalid-feedback">:message</div>') !!}
                        </div>                    
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-light shadow-sm" style="height: 200px;">
                        <div class="card-header bg-white border-0 pb-0">
                            <h5 class="mb-0 text-primary">🖊️ Firma del Contratista</h5>
                                @if($baseDato->firma && Storage::disk('public')->exists($baseDato->firma))
                                    <div class="card-header bg-white border-0 pb-0">
                                        <img 
                                                src="{{ Storage::url($baseDato->firma) }}" 
                                                alt="Firma actual" 
                                                class="img-thumbnail border border-success"
                                                style="max-height: 60px; max-width: 180px; object-fit: contain; cursor: pointer;"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#firmaModal"
                                                title="Haz clic para ver en grande">
                                    </div> 
                                @endif 
                        </div>     
                        <div class="card-body">
                            <div class="mb-3">
                                
                                <small class="text-muted">Carga tu firma digital para incluirla en documentos y reportes.</small>
                                <div class="d-flex align-items-center gap-3 flex-wrap"> 
                                    {{-- Botón y nombre del archivo --}}
                                    <div class="input-group" style="max-width: 400px;">
                                        <label class="btn btn-outline-secondary" for="firma">
                                            <i class="fas fa-upload me-1"></i> Subir firma
                                        </label>
                                        <input 
                                            type="file" 
                                            name="firma" 
                                            id="firma" 
                                            accept=".jpg,.jpeg,.png" 
                                            class="d-none"
                                            onchange="document.getElementById('firma-file-name').textContent = this.files[0]?.name || 'Ningún archivo seleccionado'">

                                        <span class="form-control bg-light text-muted" id="firma-file-name">Ningún archivo seleccionado</span>
                                    </div> 
                                </div>

                                @error('firma')
                                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                @enderror
                            </div> 
                        </div>

                    </div>
                </div>
   
    </div>
<br>

           
            <div class="row">
                @if ($perfiUser == 10)
                <div class="col-md-12">
                    <div class="card border-light shadow-sm">
                        <div class="card-header bg-white border-0 pb-0">
                            <h5 class="mb-0 text-primary">Datos Contables</h5>
                        </div>
                    <div class="card-body">
                         <div class="row"> 
                           
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('Actividad Principal') }}
                                        {{ Form::text('actividad_principal', $baseDato->actividad_principal, ['class' => 'form-control' . ($errors->has('actividad_principal') ? ' is-invalid' : ''), 'placeholder' => 'Actividad Principal']) }}
                                        {!! $errors->first('actividad_principal', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('Actividad Secundaria') }}
                                        {{ Form::text('actividad_secundaria', $baseDato->actividad_secundaria, ['class' => 'form-control' . ($errors->has('actividad_secundaria') ? ' is-invalid' : ''), 'placeholder' => 'Actividad Secundaria']) }}
                                        {!! $errors->first('actividad_secundaria', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('Actividad Contractual') }}
                                                {{ Form::select('actividad_contractual', [
                                            '8211' => '8211 - Asistenciales y tecnicos administrativos',
                                            '8299' => '8299 - Asistenciales y tecnicos de apoyo',
                                            '6910' => '6910 - Actividades jurídicas (abogados)',
                                            '7490' => '7490 - Actividades profesionales',
                                            '7220' => '7220 - Actividades de Asesores'
                                        ], $baseDato->actividad_contractual ?? null, ['class' => 'form-control' . ($errors->has('actividad_contractual') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione']) }}
                                        {!! $errors->first('actividad_contractual', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('Renta') }}
                                                {{ Form::select('renta', [ 
                                                    'R4'  => 'R4 - Impuesto de Renta y Complementarios Regimen tributario especial',
                                                    'R5'  => 'R5 - Impuesto Renta y Complementarios',
                                                    'R6'  => 'R6 - Ingresos y Patrimonio',
                                                    'R15' => 'R15 - Autorretenedor',
                                                    'R47' => 'R47 - Régimen Simple de Tributación '
                                                ], $baseDato->renta ?? null, ['class' => 'form-control renta-select' . ($errors->has('renta') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione']) }}
                                        {!! $errors->first('renta', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {{ Form::label('IVA') }} 
                                                {{ Form::select('iva', [ 
                                                    'R-48' => 'R-48 - Responsable del IVA',
                                                    'R-49' => 'R-49 - No Responsable del IVA - Exclusiva de Personas Naturales',
                                                    'R-53' => 'R-53 - Persona Jurídica No responsable del IVA',
                                                    'R-13' => 'R-13 - Gran Contribuyente',
                                                    'R-47' => 'R-47 - Régimen Simple de Tributación RST'
                                            ], $baseDato->iva ?? null, ['class' => 'form-control' . ($errors->has('iva') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione']) }}
                                        {!! $errors->first('iva', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>


    <BR> 
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div> 
</div>

 @if($baseDato->firma && Storage::disk('public')->exists($baseDato->firma))
<!-- Modal para firma -->
<div class="modal fade" id="firmaModal" tabindex="-1" aria-labelledby="firmaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Vista previa de la firma</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <img 
            src="{{ Storage::url($baseDato->firma) }}" 
            alt="Firma actual" 
            class="img-fluid" 
            style="max-height: 300px;">
      </div>
    </div>
  </div>
</div>
@endif


 

 