<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('seguro') }}
            {{ Form::text('seguro', $seguro->seguro, ['class' => 'form-control' . ($errors->has('seguro') ? ' is-invalid' : ''), 'placeholder' => 'Seguro']) }}
            {!! $errors->first('seguro', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>