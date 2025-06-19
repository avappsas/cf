@extends('layouts.app')

@section('template_title')
    {{ $baseDato->name ?? 'Show Base Dato' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Base Dato</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('base-datos.index') }}"> Atras</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Tipo Doc:</strong>
                            {{ $baseDato->Tipo_Doc }}
                        </div>
                        <div class="form-group">
                            <strong>Documento:</strong>
                            {{ $baseDato->Documento }}
                        </div>
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $baseDato->Nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Nacimiento:</strong>
                            {{ $baseDato->Fecha_Nacimiento }}
                        </div>
                        <div class="form-group">
                            <strong>Telefono:</strong>
                            {{ $baseDato->Telefono }}
                        </div>
                        <div class="form-group">
                            <strong>Celular:</strong>
                            {{ $baseDato->Celular }}
                        </div>
                        <div class="form-group">
                            <strong>Direccion:</strong>
                            {{ $baseDato->Direccion }}
                        </div>
                        <div class="form-group">
                            <strong>Referido:</strong>
                            {{ $baseDato->Referido }}
                        </div>
                        <div class="form-group">
                            <strong>Observacion:</strong>
                            {{ $baseDato->Observacion }}
                        </div>
                        <div class="form-group">
                            <strong>Profesion:</strong>
                            {{ $baseDato->Profesion }}
                        </div>
                        <div class="form-group">
                            <strong>Correo:</strong>
                            {{ $baseDato->Correo }}
                        </div>
                        <div class="form-group">
                            <strong>Dv:</strong>
                            {{ $baseDato->Dv }}
                        </div>
                        <div class="form-group">
                            <strong>Correo Secop:</strong>
                            {{ $baseDato->correo_secop }}
                        </div>
                        <div class="form-group">
                            <strong>Nivel Estudios:</strong>
                            {{ $baseDato->Nivel_estudios }}
                        </div>
                        <div class="form-group">
                            <strong>Perfil:</strong>
                            {{ $baseDato->Perfil }}
                        </div>
                        <div class="form-group">
                            <strong>Genero:</strong>
                            {{ $baseDato->Genero }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
