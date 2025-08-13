@extends('layouts.app')

@section('template_title')
    Configuraciones
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title" class="d-block text-center w-100">
                              {{ __('Configuración') }}   
                        </span>
                    </div>
                </div>
                <div class="card-body">

                  <a href="{{ route('users.index') }}" class="btn btn-primary mb-3">
                      Usuarios
                  </a>
              
                  {{-- Aquí puedes agregar más contenido en el futuro --}}
              
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
