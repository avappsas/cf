@extends('layouts.app')

@section('template_title')
    Testigo
@endsection

@section('content')
    <div class="container-fluid">

        
        <div class="card">
            <div class="card-header">
            
                    <span id="card_title">
                        {{ __('Filtro') }}
                    </span>

                    <!-- Button trigger modal -->
                    
                    <div class="float-right">
                        <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal" 
                        style="color:#fff;text-align: right;border-radius: 50px; background-color: #FCD116; background-image: url('{{ asset('/images/arroyave/upload.png') }}'); background-size: 20% 80%; width: 150px; height: 40px;
                        background-position: left center;
                        background-repeat: no-repeat;background-position: 5%;"
                        > Cargar Archivo</button>
                    </div>

                    <!-- Modal -->
                    <form action="{{ route('importar-archivo') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cargar Archivo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="archivo">Seleccionar Archivo:</label>
                            <input type="file" name="archivo" id="archivo" accept=".csv">                        
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Cargar Archivo</button>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    </form>

                     <div class="float-right">
                        {{-- <a href="{{ route('testigos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                          {{ __('Create New') }}
                        </a> --}}
                      </div>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            {{ Form::label('Departamento') }}
                            {{ Form::select('id_departamento', $Departamento, '', ['class' => 'form-control' . ($errors->has('id_departamento') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione una opcion','id' => 'id_departamento','onchange="selectDep(this)"']) }}
                            {!! $errors->first('id_departamento', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            {{ Form::label('Municipio') }}
                            {{ Form::select('id_municipio', $municipio, '', ['class' => 'form-control' . ($errors->has('id_municipio') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione una opcion','id' => 'id_municipio','onchange="selectMuni(this)"',' disabled']) }}
                            {{-- {{ Form::text('id_municipio', '', ['class' => 'form-control' . ($errors->has('id_municipio') ? ' is-invalid' : ''), 'placeholder' => 'Id Municipio',' disabled']) }} --}}
                            {!! $errors->first('id_municipio', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            {{ Form::label('Zona') }}
                            {{ Form::select('mesa', $municipio, '', ['class' => 'form-control' . ($errors->has('mesa') ? ' is-invalid' : ''), 'placeholder' => 'Zona','id' => 'id_mesa','onchange="selectZona(this)"',' disabled']) }}
                            {{-- {{ Form::text('mesa', '', ['class' => 'form-control' . ($errors->has('mesa') ? ' is-invalid' : ''), 'placeholder' => 'Mesa',' disabled','id' => 'id_mesa']) }} --}}
                            {!! $errors->first('mesa', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            {{ Form::label('Puesto') }}
                            {{ Form::select('id_puesto', $municipio, '', ['class' => 'form-control' . ($errors->has('id_puesto') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione una opcion','id' => 'id_puesto',' disabled']) }}
                            {{-- {{ Form::text('id_puesto', '', ['class' => 'form-control' . ($errors->has('id_puesto') ? ' is-invalid' : ''), 'placeholder' => 'Id Puesto',' disabled']) }} --}}
                            {!! $errors->first('id_puesto', '<div class="invalid-feedback">:message</div>') !!}
                        </div>
                    </div>
                </div>
                <div class="float-right">
                    <a class="btn btn-warning btn-sm float-right"  data-placement="left" onclick="getMesaVot()">
                      {{ __('Aplicar') }}
                    </a>
                </div>
            </div>
        </div>
        <p></p>
        <div id="tablaTestigos" >
        </div>
    </div>
@endsection


@section('js')
    {{Html::script(asset('js/testigos/testigos.js'))}}
@endsection