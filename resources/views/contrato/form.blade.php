<div class="box box-info padding-1">
    <div class="box-body">
        

        <div class="form-group" style="display: none;">
            {{ Form::label('Estado') }}
            {{ Form::text('Estado', 'Vigente', ['class' => 'form-control', 'readonly']) }}
        </div>

        <div class="form-group" style="display: none;">
            {{ Form::label('Id_Dp') }}
            {{ Form::text('Id_Dp', Auth::user()->id_dp, ['class' => 'form-control', 'readonly']) }}
        </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('No_Documento') }}
                            {{ Form::text('No_Documento', $contrato->No_Documento, ['class' => 'form-control' . ($errors->has('No_Documento') ? ' is-invalid' : ''), 'placeholder' => 'No Documento']) }}
                            {!! $errors->first('No_Documento', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {{ Form::label('Tipo_Contrato') }}
                            {{ Form::select('Tipo_Contrato', ['1' => 'Contrato de prestación de servicios', '2' => 'Nombramiento'], $contrato->Tipo_Contrato, ['class' => 'form-control' . ($errors->has('Tipo_Contrato') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona el Tipo de Contrato']) }}
                            {!! $errors->first('Tipo_Contrato', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Num_Contrato') }}
                            {{ Form::text('N_C', $contrato->N_C, ['class' => 'form-control' . ($errors->has('N_C') ? ' is-invalid' : ''), 'placeholder' => 'N C']) }}
                            {!! $errors->first('N_C', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            {{ Form::label('Cuotas') }}
                            {{ Form::selectRange('Cuotas', 1, 12, $contrato->Cuotas, ['class' => 'form-control' . ($errors->has('Cuotas') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona el número de cuotas']) }}
                            {!! $errors->first('Cuotas', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Valor_Total') }}
                            {{ Form::text('Valor_Total', $contrato->Valor_Total, ['class' => 'form-control' . ($errors->has('Valor_Total') ? ' is-invalid' : ''), 'placeholder' => 'Valor Total']) }}
                            {!! $errors->first('Valor_Total', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Valor_Mensual') }}
                            {{ Form::text('Valor_Mensual', $contrato->Valor_Mensual, ['class' => 'form-control' . ($errors->has('Valor_Mensual') ? ' is-invalid' : ''), 'placeholder' => 'Valor Mensual']) }}
                            {!! $errors->first('Valor_Mensual', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('Oficina') }}
                            {{ Form::select('Oficina', $oficinas, $contrato->Oficina, ['class' => 'form-control' . ($errors->has('Oficina') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona una oficina']) }}
                            {!! $errors->first('Oficina', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('Interventor') }}
                            {{ Form::select('Interventor',$interventores, $contrato->Interventor, ['class' => 'form-control' . ($errors->has('Interventor') ? ' is-invalid' : ''), 'placeholder' => 'Interventor']) }}
                            {!! $errors->first('Interventor', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Codigo Apropiacion') }}
                            {{ Form::text('Apropiacion', $contrato->Apropiacion, ['class' => 'form-control' . ($errors->has('Apropiacion') ? ' is-invalid' : ''), 'placeholder' => 'Apropiacion']) }}
                            {!! $errors->first('Apropiacion', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Fecha_CDP') }}
                            {{ Form::date('Fecha_CDP', $contrato->Fecha_CDP, ['class' => 'form-control' . ($errors->has('Fecha_CDP') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Cdp']) }}
                            {!! $errors->first('Fecha_CDP', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('CDP') }}
                            {{ Form::text('CDP', $contrato->CDP, ['class' => 'form-control' . ($errors->has('CDP') ? ' is-invalid' : ''), 'placeholder' => 'Cdp']) }}
                            {!! $errors->first('CDP', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                        
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('RPC') }}
                            {{ Form::text('RPC', $contrato->RPC, ['class' => 'form-control' . ($errors->has('RPC') ? ' is-invalid' : ''), 'placeholder' => 'Rpc']) }}
                            {!! $errors->first('RPC', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    

                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Plazo') }}
                            {{ Form::date('Plazo', $contrato->Plazo, ['class' => 'form-control' . ($errors->has('Plazo') ? ' is-invalid' : ''), 'placeholder' => 'Plazo']) }}
                            {!! $errors->first('Plazo', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Fecha_Estudios') }}
                            {{ Form::date('Fecha_Estudios', $contrato->Fecha_Estudios, ['class' => 'form-control' . ($errors->has('Fecha_Estudios') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Estudios']) }}
                            {!! $errors->first('Fecha_Estudios', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Fecha_Idoneidad') }}
                            {{ Form::date('Fecha_Idoneidad', $contrato->Fecha_Idoneidad, ['class' => 'form-control' . ($errors->has('Fecha_Idoneidad') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Idoneidad']) }}
                            {!! $errors->first('Fecha_Idoneidad', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Fecha_Notificacion') }}
                            {{ Form::date('Fecha_Notificacion', $contrato->Fecha_Notificacion, ['class' => 'form-control' . ($errors->has('Fecha_Notificacion') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Notificacion']) }}
                            {!! $errors->first('Fecha_Notificacion', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Fecha_Suscripcion') }}
                            {{ Form::date('Fecha_Suscripcion', $contrato->Fecha_Suscripcion, ['class' => 'form-control' . ($errors->has('Fecha_Suscripcion') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Suscripcion']) }}
                            {!! $errors->first('Fecha_Suscripcion', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Fecha_Invitacion') }}
                            {{ Form::date('Fecha_Invitacion', $contrato->Fecha_Invitacion, ['class' => 'form-control' . ($errors->has('Fecha_Invitacion') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Invitacion']) }}
                            {!! $errors->first('Fecha_Invitacion', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Fecha_Venc_CDP') }}
                            {{ Form::date('Fecha_Venc_CDP', $contrato->Fecha_Venc_CDP, ['class' => 'form-control' . ($errors->has('Fecha_Venc_CDP') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Venc Cdp']) }}
                            {!! $errors->first('Fecha_Venc_CDP', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Nivel') }}
                            {{ Form::text('Nivel', $contrato->Nivel, ['class' => 'form-control' . ($errors->has('Nivel') ? ' is-invalid' : ''), 'placeholder' => 'Nivel']) }}
                            {!! $errors->first('Nivel', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Num_Contrato') }}
                            {{ Form::text('Num_Contrato', $contrato->Num_Contrato, ['class' => 'form-control' . ($errors->has('Num_Contrato') ? ' is-invalid' : ''), 'placeholder' => 'Num Contrato']) }}
                            {!! $errors->first('Num_Contrato', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {{ Form::label('Valor_Cuota_1') }}
                            {{ Form::text('Valor_Cuota_1', $contrato->Valor_Cuota_1, ['class' => 'form-control' . ($errors->has('Valor_Cuota_1') ? ' is-invalid' : ''), 'placeholder' => 'Valor_Cuota_1']) }}
                            {!! $errors->first('Valor_Cuota_1', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Objeto') }}
                            {{ Form::textarea('Objeto', $contrato->Objeto, ['class' => 'form-control' . ($errors->has('Objeto') ? ' is-invalid' : ''), 'placeholder' => 'Objeto', 'style' => 'height: 100px;']) }}
                            {!! $errors->first('Objeto', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('Actividades') }}
                            {{ Form::textarea('Actividades', $contrato->Actividades, ['class' => 'form-control' . ($errors->has('Actividades') ? ' is-invalid' : ''), 'placeholder' => 'Actividades', 'style' => 'height: 100px;']) }}
                            {!! $errors->first('Actividades', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                </div>



    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>