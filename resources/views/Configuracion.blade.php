@extends('layouts.app')

@section('template_title')
    Configuración
@endsection

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-5">Configuración del Sistema</h1>

    <!-- Gestión de Entidades -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Gestión de Entidades</h2>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-building fa-3x mb-3 text-primary"></i>
                            <h3 class="h5">Aseguradoras</h3>
                            <p class="text-muted">Gestione las compañías aseguradoras</p>
                            <a href="{{ route('aseguradoras.index') }}" class="btn btn-outline-primary">Administrar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-handshake fa-3x mb-3 text-primary"></i>
                            <h3 class="h5">Brokers</h3>
                            <p class="text-muted">Gestione los brokers del sistema</p>
                            <a href="{{ route('brokers.index') }}" class="btn btn-outline-primary">Administrar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                            <h3 class="h5">Usuarios</h3>
                            <p class="text-muted">Administre los usuarios del sistema</p>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-primary">Administrar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gestión de Casos -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Gestión de Casos</h2>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-box fa-3x mb-3 text-primary"></i>
                            <h3 class="h5">Objetos</h3>
                            <p class="text-muted">Gestione los objetos del sistema</p>
                            <a href="{{ route('objetos.index') }}" class="btn btn-outline-primary">Administrar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-clipboard-list fa-3x mb-3 text-primary"></i>
                            <h3 class="h5">Causas</h3>
                            <p class="text-muted">Administre las causas</p>
                            <a href="{{ route('causas.index') }}" class="btn btn-outline-primary">Administrar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt fa-3x mb-3 text-primary"></i>
                            <h3 class="h5">Provincias</h3>
                            <p class="text-muted">Gestione las provincias</p>
                            <a href="{{ route('provincias.index') }}" class="btn btn-outline-primary">Administrar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gestión Financiera -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="h5 mb-0">Gestión Financiera</h2>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-shield-alt fa-3x mb-3 text-primary"></i>
                            <h3 class="h5">Seguros</h3>
                            <p class="text-muted">Gestione los seguros del sistema</p>
                            <a href="{{ route('seguros.index') }}" class="btn btn-outline-primary">Administrar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-sitemap fa-3x mb-3 text-primary"></i>
                            <h3 class="h5">Ramos</h3>
                            <p class="text-muted">Administre los ramos del sistema</p>
                            <a href="{{ route('ramos.index') }}" class="btn btn-outline-primary">Administrar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-sitemap fa-3x mb-3 text-primary"></i>
                            <h3 class="h5">Tipos de Bienes</h3>
                            <p class="text-muted">Administre los tipos de bienes del sistema</p>
                            <a href="{{ route('tipo_bienes.index') }}" class="btn btn-outline-primary">Administrar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
}

.card-header {
    border-bottom: 0;
}

.btn-outline-primary:hover {
    color: white;
}

.text-primary {
    color: #0d6efd !important;
}
</style>
@endsection