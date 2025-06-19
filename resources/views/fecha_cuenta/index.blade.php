@php
    use Carbon\Carbon;
    // Asegúrate de que Carbon esté en Español
    Carbon::setLocale('es');
@endphp
@extends('layouts.app')

@section('template_title')
    Fecha Cuentum
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Fecha Cuentum') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('fecha_cuenta.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
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
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th> 
										<th>Fecha Cuenta</th> 
										<th>Fecha Máxima</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fechaCuenta as $fechaCuentum)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>  {{  Carbon::parse($fechaCuentum->fecha_cuenta) ->locale('es') ->isoFormat('D [de] MMMM [del] YYYY')  }} </td>
                                            <td>  {{  Carbon::parse($fechaCuentum->fecha_max) ->locale('es') ->isoFormat('D [de] MMMM [del] YYYY')  }} </td> 
                                            <td>
                                                <form action="{{ route('fecha_cuenta.destroy',$fechaCuentum->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-success" href="{{ route('fecha_cuenta.edit',$fechaCuentum->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $fechaCuenta->links() !!}
            </div>
        </div>
    </div>
@endsection
