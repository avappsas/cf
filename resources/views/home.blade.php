@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">{{ __('') }}</div>
                <div class="card-body" style="align-content: center">
                    <p></p>
                    {{-- <div class="row">
                        <div class="col-md-4">
                            <div class="btn-1">
                              <a href="{{ route('contratos_vigentes') }}"><span><i class="fa-solid fa-users-line"></i> Contratistas</span></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="btn-1">
                              <a href="{{ route('bandeja') }}"><span><i class="fa-solid fa-inbox"></i> Bandeja</span></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="btn-1">
                              <a href="{{ route('contratos.index') }}"><i class="fa-solid fa-users-line"></i><span> Contratistas</span></a>
                            </div>
                        </div>
                    </div> --}}


                    <div class="row" style="align-content: center">
                        <div class="col-md-4">
                            <article>
                                <figure class="zoom-effect"><img class="zoom-effect-img" src="http://cf.avapp.digital/cf/public/images/logo_CuentaFacil/png/home/art_1.png" alt=""></figure>
                                <h2 style="font-size: 22px">Seguridad: Prioridad para CuentaFácil</h2>
                                <p>Para CuentaFácil, la seguridad se asegura mediante la implementación de métodos sólidos de autenticación y verificación de identidad, un control de acceso preciso, registros detallados de actividades, actualizaciones regulares de seguridad y formación en buenas prácticas de seguridad. Estas medidas garantizan un entorno seguro para los contratistas y entidades, protegiendo la información confidencial y previniendo accesos no autorizados.</p>
                                {{-- <p>Course • Mindful Mike</p> --}}
                              </article>
                        </div>
                        <div class="col-md-4">
                            <article>
                                <figure class="zoom-effect"><img class="zoom-effect-img" src="http://cf.avapp.digital/cf/public/images/logo_CuentaFacil/png/home/art_2.png" alt=""></figure>
                                <h2 style="font-size: 22px">Facilidad: CuentaFácil en Acción</h2>
                                <p>CuentaFácil se enfoca en la facilidad de uso para los contratistas. Con una interfaz intuitiva y funciones simplificadas, permite a los usuarios generar y validar cuentas de forma rápida y sencilla. Esto se logra mediante procesos eficientes de registro y verificación, así como una navegación amigable que facilita la gestión de cuentas y la realización de tareas relacionadas con los contratos.</p>
                              </article>
                        </div>
                        <div class="col-md-4">
                            <article>
                                <figure class="zoom-effect"><img class="zoom-effect-img" src="http://cf.avapp.digital/cf/public/images/logo_CuentaFacil/png/home/art_3.png" alt=""></figure>
                                <h2 style="font-size: 22px">Agilidad y Eficiencia: CuentaFácil Simplifica la Gestión de Cuentas</h2>
                                <p>
                                    En CuentaFácil, el proceso de generar y radicar cuentas para contratistas, así como su revisión y aprobación por parte de la entidad, es ágil y eficiente. Con interfaces intuitivas y herramientas automatizadas, tanto los contratistas como la entidad pueden completar estas tareas de manera rápida y sencilla, facilitando una gestión eficaz de los contratos.</p>
                              </article>
                        </div>
                    </div>
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
