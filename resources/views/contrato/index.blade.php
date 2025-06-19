@extends('layouts.app')

@section('template_title')
    Contrato
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{-- {{ __('Mis Contrato') }} --}}
                            </span>

                             <div class="float-right">
                                {{-- <a href="{{ route('contratos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a> --}}
                                <i class="fa fa-fw fa-file-contract"></i> 
                                {{ __('Mis Contrato') }}
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead2">
                                    <tr>
                                        {{-- <th>No</th> --}}
                                        
										<th>Id</th>
										{{-- <th>No Documento</th> --}}
										<th>Estado</th>
										{{-- <th>Tipo Contrato</th> --}}
										<th>Num Contrato</th>
										{{-- <th>Objeto</th>
										<th>Actividades</th> --}}
										<th>Plazo</th>
										{{--  <th>Valor Total</th>  --}}
										<th>Cuotas</th>
										{{--  <th>Cuotas Letras</th>  --}}
										<th>Oficina</th>
										{{-- <th>Cdp</th>
										<th>Fecha Cdp</th>
										<th>Apropiacion</th>
										<th>Interventor</th>
										<th>Fecha Estudios</th>
										<th>Fecha Idoneidad</th>
										<th>Fecha Notificacion</th>
										<th>Fecha Suscripcion</th>
										<th>Rpc</th>
										<th>Fecha Invitacion</th>
										<th>Cargo Interventor</th>
										<th>Valor Total Letras</th>
										<th>Valor Mensual</th>
										<th>Valor Mensual Letras</th>
										<th>N C</th>
										<th>Fecha Venc Cdp</th>
										<th>Nivel</th> --}}

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contratos as $contrato)
                                        <tr>
                                            
											<td>{{ $contrato->Id }}</td>
											<td>{{ $contrato->Estado }}</td>
											<td>{{ $contrato->Num_Contrato }}</td>
											
											<td>{{ date('d-m-Y', strtotime($contrato->Plazo)) }}</td>
                                            <td>{{ $contrato->Cuotas }}</td>
											<td>{{ $contrato->Oficina }}</td>

                                            <td>
                                                <form action="{{ route('contratos.destroy',$contrato->Id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('contratos.show',$contrato->Id) }}"><i class="fa fa-fw fa-eye"></i> Ver</a>
                                                    <a class="btn btn-sm btn-success" onclick="btnRegistrarCuenta({{$contrato->Id}})"><i class="fa fa-fw fa-file-invoice"></i> Gestionar Cuenta</a>
                                                    {{-- <a class="btn btn-sm btn-success" href="{{ route('contratos.edit',$contrato->Id) }}"><i class="fa fa-fw fa-file-invoice"></i> Generar Cuenta</a> --}}
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button> --}}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $contratos->links() !!}
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-xl" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                background-repeat: no-repeat;
                color: white;
                font-family: 'Mallanna';
                font-size: 17px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mediumBody">


                    <div class="card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                
                                <span id="card_title">
                                    
                                </span>
                
                                 <div class="float-right">                                         
                                    {{ __('CuentaFacil') }} 
                                    <img src="{{ asset('/images/logo_CuentaFacil/icon_only/logo2.png') }}" class="logo"  style="height: 25px"/>

                                  </div>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                
                            <div class="card-body">
                                <div class="row">
                                        
                                    <div class="float-right">
                                        <a onclick="btnmodalRegCuota(1,)" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                        <i class="fa fa-fw fa-file-contract"></i> 
                                        {{ __('Crear Nueva Cuenta') }}
                                        </a>
                                        {{-- {{ __('Crear Nueva Cuenta') }} --}}
                                    </div>
                                </div>
                                <p></p>
                                <div class="row">    
                                        <div class="table-responsive">
                                            <div class="table table-striped table-hover" id="tablaCuotas">

                                            </div>   
                                        </div>
                                </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer"  >
                    
                </div>
            </div>
        </div>
    </div>

    <div id="modalPDF"></div>

    {{-- modal para registrar cuotas --}}

    <div class="modal fade bd-example-modal-xl" id="modalRegCuota" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                background-repeat: no-repeat;
                                color: white;
                                font-family: 'Mallanna';
                                font-size: 17px;">

                                <div class="float-right">
                                    <i class="fa fa-fw fa-file-contract"></i> 
                                    {{ __('Generar Nueva Cuenta') }}
                                </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalRegCuota"><div class="card">
                    <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">

                                <span id="card_title">
                                    
                                </span>
                                <div class="float-right">
                                    {{ __('CuentaFacil') }} 
                                    <img src="{{ asset('/images/logo_CuentaFacil/icon_only/logo2.png') }}" class="logo"  style="height: 25px"/>
                                    <label for="fecha"> :</label>
                                    <span id="fecha"><?php echo $fecha_mensaje; ?></span>
                                </div>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                    
                        <div class="card-body">
                            <div class="form-group" >
                                <div class="row">
                                    <div class="col-md-1">
                                        {{ Form::label('Cuota') }}
                                        {{-- {{ Form::select('Cuota', array(1 => 'Cuota 1',2 => 'Cuota 2',3 => 'Cuota 3',4 => 'Cuota 4',5 => 'Cuota 5',6 => 'Cuota 6'), 0, ['class' => 'form-control' . ($errors->has('Cuota') ? ' is-invalid' : ''), 'placeholder' => '0', 'id' => 'Cuota']) }} --}}
                                        {{ Form::number('Cuota', 0, ['class' => 'form-control' . ($errors->has('Cuota') ? ' is-invalid' : ''), 'placeholder' => '0','required', 'min' => 1, 'id' => 'Cuota','disabled']) }}
                                    </div>
                                    <div class="col-md-2">
                                        {{ Form::label('Fecha de cuenta') }}
                                        {{ Form::date('Fecha_acta', $fecha_formateada, ['class' => 'form-control' . ($errors->has('Fecha_acta') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Acta', 'id' => 'fecActa']) }}
                                    </div>
                                </div>
                                <p></p>
                                <div class="row">
                                    <div class="col-md-2">
                                        {{ Form::label('Operador') }}
                                        {{ Form::select('Operador', $operadores, 0, ['class' => 'form-control' . ($errors->has('Operador') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione', 'id' => 'Operador']) }}         
                                    </div>
                                    <div class="col-md-2">
                                        {{ Form::label('No Planilla') }}
                                        {{ Form::number('NumPlanilla', 0, ['class' => 'form-control' . ($errors->has('NumPlanilla') ? ' is-invalid' : ''), 'placeholder' => 'NumPlanilla','required', 'min' => 9999, 'id' => 'numPlantilla']) }}        
                                    </div>
                                    <div class="col-md-2">
                                        {{ Form::label('Pin planilla') }}
                                        {{ Form::number('PinPlanilla', 0, ['class' => 'form-control' . ($errors->has('PinPlanilla') ? ' is-invalid' : ''), 'placeholder' => 'PinPlanilla','required', 'min' => 9999, 'id' => 'pinPlantilla']) }}
                                    </div>

                                    <div class="col-md-2">
                                        {{ Form::label('Fecha Pago') }}
                                        {{ Form::date('Fecha_pago', 0, ['class' => 'form-control' . ($errors->has('Fecha_pago') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Pago', 'id' => 'fecPago']) }}
                                        
                                    </div>
                                    <div class="col-md-2">
                                        {{ Form::label('Periodo') }}
                                        {{ Form::select('PeriodoP', array('1' => 'Enero','2' => 'Febrero','3' => 'Marzo','4' => 'Abril','5' => 'Mayo','6' => 'Junio','7' => 'Julio','8' => 'Agosto',
                                        '9' => 'Septiembre','10' => 'Octubre','11' => 'Noviembre','12' => 'Diciembre'), 0, ['class' => 'form-control' . ($errors->has('PeriodoP') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione opcion', 'id' => 'periodoPlanilla']) }}
                                        
                                    </div>
                                </div>
                                <p></p>
                                <div class="form-group">
                                    <div>
                                        {!! Form::label('Actividades') !!}
                                        <div style="height:20%">
                                            {!! Form::textarea('observacion', '',["style" => "min-width: 100%", 'id' => 'Actividades']) !!}
                                        </div>
                                    </div>
                                    <p></p>
                                    <a class="btn btn-sm btn-success" onclick="btnGenerarCuenta()"><i class="fa fa-fw fa-file-invoice"></i> Guardar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer"  >
                    
                </div>
            </div>
        </div>
    </div>

    {{-- modal para cargar documentos cuotas --}}

    <div class="modal fade bd-example-modal-xl" id="modalDocUploadCuota" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                background-repeat: no-repeat;
                                color: white;
                                font-family: 'Mallanna';
                                font-size: 17px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalDocUploadCuota"><div class="card">
                    <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                    
                                <span id="card_title">
                                    
                                </span>
                    
                                <div class="float-right">
                                    <i class="fa fa-fw fa-file-contract"></i> 
                                    {{ __('Cargar Documentos') }}
                                </div>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                    
                        <div class="card-body">
                            <div class="form-group" >
                                <div class="row">
                                    <div class="table-responsive">
                                        <div class="table table-striped table-hover" id="tablaDocs">

                                        </div>   
                                    </div>
                                    
                                </div>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <div class="row">
                        <a class="btn btn-sm btn-success" onclick="btnEnvioCuenta()"><i class="fa-solid fa-paper-plane"></i>  Enviar Cuenta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal para ver documentos cuotas --}}

    <div class="modal fade bd-example-modal-xl" id="modalVerDocCuota" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(30deg, rgba(201,251,74,1) 12%, rgba(86,140,29,1) 71%);
                                background-repeat: no-repeat;
                                color: white;
                                font-family: 'Mallanna';
                                font-size: 17px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalVerDocCuota"><div class="card">
                    <div class="row">
                        <embed id="pdfEmbed" src="" type="application/pdf" width="100%" height="800px">
                    </div>
                </div>
                
                <div class="modal-footer"  >
                    
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
    {{Html::script(asset('js/contrato/contratista.js'))}}
@endsection



