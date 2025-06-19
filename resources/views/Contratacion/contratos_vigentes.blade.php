{{-- resources/views/Contratacion/contratos_vigentes.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="card">
    {{-- HEADER: filtros --}}
    <div class="card-header d-flex justify-content-between align-items-center py-2">
      <h5 class="mb-0">
        <i class="fa fa-file-contract mr-1"></i>
        Mis Contratos
      </h5>

      <form method="GET" action="{{ route('contratos_vigentes') }}" class="form-inline">
        {{-- selector de periodo --}}
        <select name="periodo" class="form-control" onchange="this.form.submit()">
          @foreach($opcionesPeriodo as $value => $label)
            <option value="{{ $value }}"
                    {{ $value === $periodoSeleccionado ? 'selected' : '' }}>
              {{ $label }}
            </option>
          @endforeach
        </select>

        {{-- campo único de búsqueda --}}
        <div class="input-group ml-2">
          <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Buscar por nombre, contrato o documento"
            value="{{ $search }}"
            onchange="this.form.submit()"
          >
          <div class="input-group-append">
            <button class="btn btn-light" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
        {{-- selector de supervisor --}}
        <div class="input-group ml-2">
          <select name="supervisor" class="form-control" onchange="this.form.submit()">
            <option value="">Todos los supervisores</option>
            @foreach($listaSupervisores as $sup)
              <option value="{{ $sup }}" {{ $sup === $fSupervisor ? 'selected' : '' }}>
                {{ $sup }}
              </option>
            @endforeach
          </select>
          
        </div>
      </form>
    </div>

    {{-- BODY: tabla de resultados --}}
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped mb-0">
          <thead class="thead2">
            <tr>

              <th>Contrato</th>
              <th>Documento</th>
              <th>Nombre</th>  
              <th>Oficina</th> 
              <th>Cuota</th>
              <th>Periodo</th>
              <th>Estado</th> 
              <th>Responsable</th>
            </tr>
          </thead>
          <tbody>
            @forelse($datos as $d)
              <tr> 
                <td>{{ $d->N_C  }}</td>
                <td>{{ $d->No_Documento  }}</td>
                <td>{{ $d->Nombre        }}</td>   
                <td>{{ $d->Supervisor}} <strong>({{ $d->Oficina}})</strong> </td> 
                <td>{{ $d->Cuota         }}</td>
                <td>{{ $d->periodo       }}</td>
                <td>{{ $d->Estado_juridica       }}</td>
                <td>{{ $d->Responsable       }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="12" class="text-center">
                  No se encontraron contratos.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- FOOTER: paginación --}}
<div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-center">
  {{-- Rango de resultados --}}
  <div class="mb-2 mb-md-0">
    <small class="text-muted">
      Mostrando 
      <strong>{{ $datos->firstItem() }}</strong>  
      a  
      <strong>{{ $datos->lastItem() }}</strong>  
      de  
      <strong>{{ $datos->total() }}</strong> resultados
    </small>
  </div>

  {{-- Paginación --}}
  <nav aria-label="Paginación de contratos">
    {{ $datos->links() }}
  </nav>
</div>
  </div>
</div>
@endsection
