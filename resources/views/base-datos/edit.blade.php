@extends('layouts.app')

@section('template_title')
    Update Base Dato
@endsection

@section('content')
    <section class="content container-fluid">
            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
             @endif
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title"> </span>
                        <div class="float-right"> 
                            Actualizar Datos del Contratista   
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('base-datos.update', $baseDato->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('base-datos.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
