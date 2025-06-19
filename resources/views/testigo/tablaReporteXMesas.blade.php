<div class="row" style="zoom: 85%;">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">

                    <span id="card_title" style="font-weight: bold; font-size: 17px;">
                        {{ __('Reporte del puesto: ' .$nomPuesto) }}
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
                        <label style="font-weight: bold; font-size: 18px;">Total Mesas Reportadas: <span style="font-weight: normal;">{{$totales->mesas}}</span></label>
                        <label style="margin-left: 40px; font-weight: bold; font-size: 16px;">Votos Gobernacion: <span style="font-weight: normal;">{{$totales->GO}}</span></label>
                        <label style="margin-left: 40px; font-weight: bold; font-size: 16px;">Votos Asamblea: <span style="font-weight: normal;">{{$totales->AS}}</span></label>
                        <label style="margin-left: 40px; font-weight: bold; font-size: 16px;">Votos Alcaldia: <span style="font-weight: normal;">{{$totales->AL}}</span></label>
                        <label style="margin-left: 40px; font-weight: bold; font-size: 16px;">Votos Concejo: <span style="font-weight: normal;">{{$totales->CO}}</span></label>
                    </div>
                </div>
                <p></p>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead" style="text-align: center">
                            <tr>
                                {{-- <th>No</th> --}}
                                
                                <th>Puesto</th>
                                <th>Nombre Testigo</th>
                                <th>Celular</th>
                                <th>Mesa</th>
                                <th>Gobernacion</th>
                                <th>Alcaldia</th>
                                <th>Concejo</th>
                                <th>Asamblea</th>
                                <th>Reportado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($zonas as $zona)
                                <tr style="text-align: center">
                                    {{-- <td>{{ ++$i }}</td> --}}
                                    
                                    <td>{{ $zona->Puesto }}</td>
                                    <td>{{ $zona->NomTestigo }}</td>
                                    <td>{{ $zona->Celular }}</td>
                                    <td>{{ $zona->mesa }}</td>
                                    <td>{{ $zona->GOBERNACION }}</td>
                                    <td>{{ $zona->ALCALDIA }}</td>
                                    <td>{{ $zona->CONCEJO }}</td>
                                    <td>{{ $zona->ASAMBLEA }}</td>
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