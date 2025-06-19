@extends('layouts.app')

@section('template_title')
    Tipo Bien
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('Tipo Bienes') }}
                        </span>
                        <a href="{{ route('tipo_bienes.create') }}" class="btn btn-primary btn-sm float-right">
                            {{ __('Crear nuevo') }}
                        </a>
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
                            <thead>
                                <tr>
                                    <th>No</th> 
                                    <th>Tipo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipoBienes as $tipoBiene)
                                    <tr>
                                        <td>{{ ++$i }}</td> 
                                        <td>{{ $tipoBiene->tipo }}</td>
                                        <td>
                                            <form action="{{ route('tipo_bienes.destroy',$tipoBiene->id) }}" method="POST">
                                                <a class="btn btn-sm btn-primary" href="{{ route('tipo_bienes.show',$tipoBiene->id) }}">Ver</a>
                                                <a class="btn btn-sm btn-success" href="{{ route('tipo_bienes.edit',$tipoBiene->id) }}">Editar</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $tipoBienes->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection