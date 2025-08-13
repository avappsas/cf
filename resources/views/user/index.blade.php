@extends('layouts.app')

@section('template_title')
    Activar usuario
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Activar usuario') }}
                            </span>

                             <div class="float-right"> 
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                    {{ __('Nuevo') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('usuarios.index') }}" method="GET" class="row mb-3">
                            <div class="col-sm-4">
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ old('search', $search ?? '') }}"
                                    class="form-control"
                                    placeholder="Buscar por cédula o nombre..."
                                >
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                                    Limpiar
                                </a>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>Id</th>
										<th>Nombre</th>
										<th>Email</th>
										<th>Usuario</th> 
										<th>Perfil</th> 
                                        <th> </th>
                                        <th> Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $user->id }}</td>
											<td>{{ $user->name }}</td>
											<td>{{ $user->email }}</td>
											<td>{{ $user->usuario }}</td> 
											<td> {!! str_replace('CONTRATISTA', '<i class="fas fa-user-tie" title="Contratista"></i>', $user->PERFILES) !!} </td>
                                            
                                            <td> <a class="btn btn-sm btn-primary " href="{{ route('users.edit',$user->id) }}"><i class="fa fa-fw fa-edit"></i> Editar</a> </td>
                                            <td> 
                                                <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-success">
                                                        <i class="fa-solid fa-hammer"></i> Resetear Clave 
                                                    </button>
                                                </form> 
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {!! $users->links() !!} --}}
            </div>
        </div>
    </div>
    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mediumBody">
                    <div class="form-group" >
                        {{ Form::label('Cedula') }}
                        {{ Form::text('Cedula', '', ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Cedula']) }}
                    
                        <p>

                        </p>
                        <div class="box-footer mt20"  >
                            <a class="btn btn-success btn-sm float-right" onclick="CrearUsuario()">Crear</a>
                            
                            {{-- <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-fw fa-trash"></i> Crear</button> --}}
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('js')
    {{Html::script(asset('js/user/gestion_usuario.js'))}}
@endsection