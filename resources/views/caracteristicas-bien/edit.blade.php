@extends('layouts.app')

@section('template_title')
    Update Caracteristicas Bien
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update Caracteristicas Bien</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('caracteristicas-biens.update', $caracteristicasBien->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('caracteristicas-bien.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
