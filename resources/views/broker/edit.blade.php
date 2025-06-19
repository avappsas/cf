@extends('layouts.app')

@section('template_title')
    Actualizar Broker
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Actualizar Broker</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('brokers.update', $broker->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('broker.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection