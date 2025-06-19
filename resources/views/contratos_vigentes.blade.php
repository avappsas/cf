@extends("layouts.app")

@section('content')

<div class="container-fluid">
  
    <div class="row">
        <div class="col-sm-12"> 
            <div class="card">
                <div class="card-header" style="padding-top: 8px;    padding-bottom: 8px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title"> </span>
                            <div class="float-right"> 
                                <div class="d-flex justify-content-center align-items-center">
                                    <a class="btn btn-light text-dark mr-1" onclick="validarDocumento()" style="padding-top: 2px; padding-bottom: 2px;">Ingresar Nuevo Contratista</a>
                                    <img src="{{asset("/images/logo_CuentaFacil/png/notificacion/lupa-blanca.png")}}" alt="Lupa" width="20" height="20" onclick="mostrarFormulario()" style="margin-right: 5px;">
                                    <i class="fa fa-fw fa-file-contract mr-1"></i>
                                    {{ __('Mis Contrato') }}
                                </div>
                            </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <p></p>
                <form method="GET" id="contratos_form" action="{{ route('contratos_vigentes') }}" style="display: none;">
                    @csrf 
                    <div class="box-body padding-1">
                        <div class="row" style="padding-left: 10px; padding-right: 10px;">
                            <div class="col-md-4">
                                {{ Form::select('periodo', $opcionesPeriodo, $periodoSeleccionado, ['class' => 'form-control mr-2' . ($errors->has('periodo') ? ' is-invalid' : ''),
                                'id' => 'periodos', 'data-previous-value' => $periodoSeleccionado, 'onchange' => 'actualizarFormulario()']) }}
                            </div>
                            <div class="col-md-4">
                                <input class='form-control' onchange="actualizarFormulario()" type="text" id="nombre" name="nombre" value="{{ request('nombre') }}" placeholder="Buscar por Nombre">
                            </div>
                            <div class="col-md-4">
                                <input class='form-control' onchange="actualizarFormulario()" type="text" id="documento" name="documento" value="{{ request('documento') }}" placeholder="Buscar por Documento">
                            </div>
                        </div>
                    </div>
                </form>
                
                
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="thead2">
                                                <tr>
                                                <th>Oficina</th>
                                                <th>No_Documento</th>
                                                <th>nombre</th> 
                                                <th>Periodo</th> 
                                                <th>Cuota</th>
                                                <th>Estado</th>
                                                <th>Responsable</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datos as $dato)
                                                <tr> 
                                                    <td>{{ $dato->Oficina}}</td>
                                                    <td>{{ $dato->No_Documento}}</td>
                                                    <td>{{ $dato->nombre}}</td>
                                                    <td>{{ $dato->mes }}</td>
                                                    <td>{{ $dato->Cuota }}</td>
                                                    <td>{{ $dato->Estado_juridica }}</td>
                                                    <td>{{ $dato->Responsable }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>


            </div>
        </div>
    </div>
</div>

        <script>
            function mostrarFormulario() {
                var formulario = document.getElementById('contratos_form');
                if (formulario.style.display === 'none') {
                    formulario.style.display = 'block';
                } else {
                    formulario.style.display = 'none';
                }
            }

            function actualizarPeriodo() {
                console.log("Cambiaste el periodo");
                var periodoSeleccionado = document.getElementById('periodos').value;
                document.getElementById('periodo').value = periodoSeleccionado;
                document.getElementById('periodo').form.submit();
            }

           
                function actualizarFormulario() {
                    document.getElementById('contratos_form').submit();
                }
            
        </script>
 
@endsection
@section('js')
    {{Html::script(asset('js/juridica/juridica.js'))}}
@endsection