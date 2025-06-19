<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">

                    <span id="card_title">
                        {{ __('Reporte por municipio') }}
                    </span>

                     <div class="float-right">
                        {{-- <a href="{{ route('testigos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                          {{ __('Create New') }}
                        </a> --}}
                      </div>
                </div>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <div class="card-body">
                <div class="row" style="display: flex; justify-content: flex-end; align-items: center;">
                    <div class="col-md-12" style="background-color: rgb(90, 128, 158);color:white; display: flex; justify-content: flex-end; align-items: center; padding-top: 5px;">
                        <label style="font-weight: bold; font-size: 18px;">Total Zonas: <span style="font-weight: normal;">{{$totales->Zona}}</span></label>
                        <label style="margin-left: 40px; font-weight: bold; font-size: 16px;">Total Puestos: <span style="font-weight: normal;">{{$totales->puestos}}</span></label>
                        <label style="margin-left: 40px; font-weight: bold; font-size: 16px;">Total Mesas: <span style="font-weight: normal;">{{$totales->mesas}}</span></label>
                        <label style="margin-left: 40px; font-weight: bold; font-size: 16px;">Total Testigos: <span style="font-weight: normal;">{{$totales->Testigos}}</span></label>
                        <label style="margin-left: 40px; font-weight: bold; font-size: 16px;">Total Mesas Reportadas: <span style="font-weight: normal;">{{$totales->Reportado}}</span></label>
                    </div>
                </div>
                <p></p>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead" style="text-align: center">
                            <tr>
                                {{-- <th>No</th> --}}
                                
                                <th>Zonas</th>
                                <th>Puestos</th>
                                <th>Mesas</th>
                                <th>Testigos</th>
                                <th>Reportados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($zonas as $zona)
                                <tr style="text-align: center" onclick="getPuestDeZona({{$zona->Dpt}},{{$zona->Mpio}},{{$zona->Zona}})">
                                    {{-- <td>{{ ++$i }}</td> --}}
                                    
                                    <td>{{ $zona->Zona }}</td>
                                    <td>{{ $zona->puestos }}</td>
                                    <td>{{ $zona->mesas }}</td>
                                    <td>{{ $zona->Testigos }}</td>
                                    <td>{{ $zona->Reportado }}</td>

                                    {{-- <td>
                                        <form action="{{ route('getMesaVot',$testigo->id) }}" method="POST">
                                            <a class="btn btn-sm btn-success" href="{{ route('testigos.edit',$testigo->id) }}"><i class="fa fa-fw fa-edit"></i> Ver</a>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {!! $zonas->links() !!}
    </div>
</div>