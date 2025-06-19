@extends('layouts.app')

@section('template_title')
    Testigo
@endsection

@section('content')
    <div class="container-fluid">

        
        <div class="card" style="max-height: 190px; overflow: auto;zoom: 85%;">
            <div class="card-header">
            
                    <span id="card_title">
                        {{ __('Filtro') }}
                    </span>

                    <!-- Button trigger modal -->
                    
                    {{-- <div class="float-right">
                        <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal" 
                        style="color:#fff;text-align: right;border-radius: 50px; background-color: #FCD116; background-image: url('{{ asset('/images/avapp/upload.png') }}'); background-size: 20% 80%; width: 150px; height: 40px;
                        background-position: left center;
                        background-repeat: no-repeat;background-position: 5%;"
                        > Cargar Archivo</button>
                    </div> --}}

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
            <div class="card-body" >
                <div class="row" style="display: flex; justify-content: flex-end;">
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
                    
                </div>
                <div class="float-right">
                    <a class="btn btn-warning btn-sm float-right"  data-placement="left" onclick="getReportes()">
                      {{ __('Aplicar') }}
                    </a>
                </div>
            </div>
        </div>
        <p></p>
        <div class="row" style="max-height: 800px; overflow: auto;">
            <div class="col-md-12">
                <div class="row">
                    
                </div>
                <div id="tablaTestigos" style="zoom: 85%;" >
        
                </div>
            </div>
            {{-- <div class="col-md-5">
                <div id="miLlamadas" style="zoom: 85%;" >
                    <canvas id="myChart" width="20px" height="20px"></canvas>
                </div>
            </div> --}}
        </div>
        </div>

        <!-- Modal -->
        <div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reporte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="divModal"></div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-xl" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reporte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="divModal2"></div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    {{Html::script(asset('js/testigos/testigos.js'))}}
@endsection