@extends('layouts.app')

@section('template_title')
    Base Dato
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title"> 
                            </span> 
                             <div class="float-right"> 
                                Datos Contratista <a href="{{ route('base-datos.create') }}" class="btn btn-light text-dark mr-1"   data-placement="left" style="padding-top: 2px; padding-bottom: 2px;">
                                  {{ __('Crear Contratista') }}  </a>
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
                                        <th>No</th>
                                        
										<th>Tipo Doc</th>
										<th>Documento</th>
										<th>Nombre</th>
										{{--  <th>Fecha Nacimiento</th>  --}}
										{{--  <th>Telefono</th>  --}}
										<th>Celular</th>
										{{--  <th>Direccion</th>
										<th>Referido</th>
										<th>Observacion</th>
										<th>Profesion</th>
										<th>Correo</th>
										<th>Dv</th>
										<th>Correo Secop</th>
										<th>Nivel Estudios</th>
										<th>Perfil</th>
										<th>Genero</th>  --}}

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($baseDatos as $baseDato)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $baseDato->Tipo_Doc }}</td>
											<td>{{ $baseDato->Documento }}</td>
											<td>{{ $baseDato->Nombre }}</td>
											{{--  <td>{{ $baseDato->Fecha_Nacimiento }}</td>  --}}
											{{--  <td>{{ $baseDato->Telefono }}</td>  --}}
											<td>{{ $baseDato->Celular }}</td>
											{{--  <td>{{ $baseDato->Direccion }}</td>
											<td>{{ $baseDato->Referido }}</td>
											<td>{{ $baseDato->Observacion }}</td>
											<td>{{ $baseDato->Profesion }}</td>
											<td>{{ $baseDato->Correo }}</td>
											<td>{{ $baseDato->Dv }}</td>
											<td>{{ $baseDato->correo_secop }}</td>
											<td>{{ $baseDato->Nivel_estudios }}</td>
											<td>{{ $baseDato->Perfil }}</td>
											<td>{{ $baseDato->Genero }}</td>  --}}

                                            <td>
                                                {{--  <form action="{{ route('base-datos.destroy',$baseDato->id) }}" method="POST">  --}}
                                                    {{--  <a class="btn btn-sm btn-primary " href="{{ route('base-datos.show',$baseDato->id) }}"><i class="fa fa-fw fa-eye"></i> Ver</a>  --}}
                                                    <a class="btn btn-sm btn-success" href="{{ route('base-datos.edit',$baseDato->id) }}"><i class="fa fa-fw fa-edit"></i> Editar</a>
                                                    @csrf
                                                    {{--  @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>  --}}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $baseDatos->links() !!}
            </div>
        </div>
    </div>
@endsection
