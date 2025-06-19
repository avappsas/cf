<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('Id') }}
            {{ Form::text('Id', $cuota->Id, ['class' => 'form-control' . ($errors->has('Id') ? ' is-invalid' : ''), 'placeholder' => 'Id']) }}
            {!! $errors->first('Id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Contrato') }}
            {{ Form::text('Contrato', $cuota->Contrato, ['class' => 'form-control' . ($errors->has('Contrato') ? ' is-invalid' : ''), 'placeholder' => 'Contrato']) }}
            {!! $errors->first('Contrato', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Cuota') }}
            {{ Form::text('Cuota', $cuota->Cuota, ['class' => 'form-control' . ($errors->has('Cuota') ? ' is-invalid' : ''), 'placeholder' => 'Cuota']) }}
            {!! $errors->first('Cuota', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Fecha_Acta') }}
            {{ Form::text('Fecha_Acta', $cuota->Fecha_Acta, ['class' => 'form-control' . ($errors->has('Fecha_Acta') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Acta']) }}
            {!! $errors->first('Fecha_Acta', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Porcentaje') }}
            {{ Form::text('Porcentaje', $cuota->Porcentaje, ['class' => 'form-control' . ($errors->has('Porcentaje') ? ' is-invalid' : ''), 'placeholder' => 'Porcentaje']) }}
            {!! $errors->first('Porcentaje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Actividades') }}
            {{ Form::text('Actividades', $cuota->Actividades, ['class' => 'form-control' . ($errors->has('Actividades') ? ' is-invalid' : ''), 'placeholder' => 'Actividades']) }}
            {!! $errors->first('Actividades', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Planilla') }}
            {{ Form::text('Planilla', $cuota->Planilla, ['class' => 'form-control' . ($errors->has('Planilla') ? ' is-invalid' : ''), 'placeholder' => 'Planilla']) }}
            {!! $errors->first('Planilla', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Perioro_Planilla') }}
            {{ Form::text('Perioro_Planilla', $cuota->Perioro_Planilla, ['class' => 'form-control' . ($errors->has('Perioro_Planilla') ? ' is-invalid' : ''), 'placeholder' => 'Perioro Planilla']) }}
            {!! $errors->first('Perioro_Planilla', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Parcial') }}
            {{ Form::text('Parcial', $cuota->Parcial, ['class' => 'form-control' . ($errors->has('Parcial') ? ' is-invalid' : ''), 'placeholder' => 'Parcial']) }}
            {!! $errors->first('Parcial', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Mes_cobro') }}
            {{ Form::text('Mes_cobro', $cuota->Mes_cobro, ['class' => 'form-control' . ($errors->has('Mes_cobro') ? ' is-invalid' : ''), 'placeholder' => 'Mes Cobro']) }}
            {!! $errors->first('Mes_cobro', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Oficina') }}
            {{ Form::text('Oficina', $cuota->Oficina, ['class' => 'form-control' . ($errors->has('Oficina') ? ' is-invalid' : ''), 'placeholder' => 'Oficina']) }}
            {!! $errors->first('Oficina', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Pin_planilla') }}
            {{ Form::text('Pin_planilla', $cuota->Pin_planilla, ['class' => 'form-control' . ($errors->has('Pin_planilla') ? ' is-invalid' : ''), 'placeholder' => 'Pin Planilla']) }}
            {!! $errors->first('Pin_planilla', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Operador_planilla') }}
            {{ Form::text('Operador_planilla', $cuota->Operador_planilla, ['class' => 'form-control' . ($errors->has('Operador_planilla') ? ' is-invalid' : ''), 'placeholder' => 'Operador Planilla']) }}
            {!! $errors->first('Operador_planilla', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('Fecha_pago_planilla') }}
            {{ Form::text('Fecha_pago_planilla', $cuota->Fecha_pago_planilla, ['class' => 'form-control' . ($errors->has('Fecha_pago_planilla') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Pago Planilla']) }}
            {!! $errors->first('Fecha_pago_planilla', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>