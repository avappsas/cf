@extends('layouts.app')

@section('template_title')
    Cuotas
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        Cuotas pendientes por generar Entrada
                    </div>
                    <div class="card-body">

                        {{-- Sección para mostrar mensajes de sesión y errores de validación --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session('info'))
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                {{ session('info') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>¡Atención!</strong> Han ocurrido algunos errores:
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        {{-- Fin de la sección de mensajes --}}

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr> 
                                        <th>FUID</th>
                                        <th>Consecutivo</th>
                                        <th>No_Documento</th>
                                        <th>Nombre</th>
                                        <th>RPC</th>
                                        <th>Cuota</th>
                                        <th>Entrada</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cuotas as $cuota)
                                        <tr> 
                                            <td>{{ $cuota->FUID }}</td>
                                            <td>{{ $cuota->consecutivo }}</td>
                                            <td>{{ $cuota->No_Documento }}</td>
                                            <td>{{ $cuota->Nombre }}</td>
                                            <td>{{ $cuota->RPC }}</td>
                                            <td>{{ $cuota->Cuota }}</td>
                                            <td>
                                                
                                                <form method="POST" action="{{ route('updateEntrada', $cuota->Id) }}" role="form">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="PATCH">
                                                    <div class="form-group d-flex mb-0"> {{-- mb-0 para quitar margen inferior si es necesario --}}
                                                        <input type="text" class="form-control form-control-sm" name="Entrada" value="{{ old('Entrada', $cuota->Entrada) }}" required>
                                                        <button type="submit" class="btn btn-sm btn-primary ml-2">Actualizar</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-info" href="{{ route('vale.entrada.mostrar', ['id' => $cuota->Id]) }}">
                                                    <i class="fa fa-fw fa-eye"></i> pdf
                                                </a>                                            
                                            </td>
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
@endsection