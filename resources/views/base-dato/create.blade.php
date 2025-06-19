@extends('layouts.app')

@section('template_title')
    Create Base Dato
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title"> </span>
                        <div class="float-right"> 
                            Crear Base de Datos  <a class="btn btn-light text-dark mr-1"  href="{{ route('base-datos.index') }}" style="padding-top: 2px; padding-bottom: 2px;"> Volver</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('base-datos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('base-dato.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
