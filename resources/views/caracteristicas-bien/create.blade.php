@extends('layouts.app')

@section('template_title')
    Create Caracteristicas Bien
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Caracteristicas Bien</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('caracteristicas-biens.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('caracteristicas-bien.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
