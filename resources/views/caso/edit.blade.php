@extends('layouts.app')

@section('template_title')
    Update Caso
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="col-md-12">

            @includeif('partials.errors')

            <div class="card card-default">
                <div class="card-header">
                    <span class="card-title">{{ 'Caso ' . $caso->id }}</span>
                    <div class="float-right">
 
                        <a href="{{ route('bienes.index', ['id_caso' => $caso->id, 'ramo' => $caso->ramo]) }}" class="btn btn-secondary btn-sm">
                            {{ __('Ver Bienes') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('casos.update', $caso->id) }}" role="form" enctype="multipart/form-data">
                        {{ method_field('PATCH') }}
                        @csrf

                        @include('caso.form')
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal para cargar bienes --}}
    <div class="modal fade" id="modalbienes" tabindex="-1" role="dialog" aria-labelledby="modalbienesLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalbienesLabel">Bienes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Contenido cargado dinámicamente --}}
                    <p>Cargando bienes...</p>
                </div>
            </div>
        </div>
    </div>


    <div id="modalContainer"></div> 

 @endsection
 

 @section('js')
    {{Html::script(asset('js/casos.js'))}}
@endsection