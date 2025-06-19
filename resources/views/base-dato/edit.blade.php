@extends('layouts.app')

@section('template_title')
    Update Base Dato
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title"> </span>
                        <div class="float-right"> 
                            Actualizar Datos del Contratista  <a class="btn btn-light text-dark mr-1"  href="{{ route('base-datos.index') }}" style="padding-top: 2px; padding-bottom: 2px;"> Volver</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('base-datos.update', $baseDato->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('base-dato.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
