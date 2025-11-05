@extends('adminlte::page')

@section('title', 'Servicio Técnico')

@section('content_header')
    <div class="text-center mb-4">
        <h1 class="fw-bold text-primary">
            <i class="fas fa-tools"></i> SERVICIO TÉCNICO
        </h1>
        <p class="text-muted">Panel de control general del sistema</p>
        <hr class="w-25 mx-auto border-primary border-2">
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row g-4">

        @if(auth()->user()->hasAnyRole(['administrador']))

            <!-- Hospitales -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card dashboard-card bg-gradient-info text-white">
                    <div class="card-body position-relative">
                        <div class="card-bg-icon">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <h5 class="fw-bold mb-1 text-uppercase">Hospitales</h5>
                        <p class="mb-0 fs-6">{{ $total_hospitales }} registrados</p>
                    </div>
                    <div class="card-footer card-footer-modern footer-info text-white">
                        <a href="{{ route('admin.hospitales.index') }}" class="text-white text-decoration-none fw-semibold">
                            Más información <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Administrativos -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card dashboard-card bg-gradient-success text-white">
                    <div class="card-body position-relative">
                        <div class="card-bg-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h5 class="fw-bold mb-1 text-uppercase">Administrativos</h5>
                        <p class="mb-0 fs-6">{{ $total_administrativos }} registrados</p>
                    </div>
                    <div class="card-footer card-footer-modern footer-success text-white">
                        <a href="{{ route('admin.administrativos.index') }}" class="text-white text-decoration-none fw-semibold">
                            Más información <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Roles -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card dashboard-card bg-gradient-warning text-dark">
                    <div class="card-body position-relative">
                        <div class="card-bg-icon text-dark">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h5 class="fw-bold mb-1 text-uppercase">Roles</h5>
                        <p class="mb-0 fs-6">{{ $total_roles }} registrados</p>
                    </div>
                    <div class="card-footer card-footer-modern footer-warning text-dark">
                        <a href="{{ route('admin.roles.index') }}" class="text-dark text-decoration-none fw-semibold">
                            Más información <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Equipos -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                <div class="card dashboard-card bg-gradient-primary text-white">
                    <div class="card-body position-relative">
                        <div class="card-bg-icon">
                            <i class="fas fa-laptop-medical"></i>
                        </div>
                        <h5 class="fw-bold mb-1 text-uppercase">Equipos</h5>
                        <p class="mb-0 fs-6">{{ $total_equipos }} registrados</p>
                    </div>
                    <div class="card-footer card-footer-modern footer-primary text-white">
                        <a href="{{ route('admin.equipos.index') }}" class="text-white text-decoration-none fw-semibold">
                            Más información <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Usuarios -->
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="card dashboard-card bg-gradient-cyan text-white">
                <div class="card-body position-relative">
                    <div class="card-bg-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="fw-bold mb-1 text-uppercase">Usuarios</h5>
                    <p class="mb-0 fs-6">{{ $total_usuarios }} registrados</p>
                </div>
                <div class="card-footer card-footer-modern footer-cyan text-white">
                    <a href="{{ route('admin.usuarios.index') }}" class="text-white text-decoration-none fw-semibold">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Reportes -->
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="card dashboard-card bg-gradient-danger text-white">
                <div class="card-body position-relative">
                    <div class="card-bg-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h5 class="fw-bold mb-1 text-uppercase">Reportes</h5>
                    <p class="mb-0 fs-6">0 generados</p>
                </div>
                <div class="card-footer card-footer-modern footer-danger text-white">
                    <a href="#" class="text-white text-decoration-none fw-semibold">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@stop

@section('css')
<style>
   
    .dashboard-card {
        border-radius: 0.75rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        position: relative;
    }
    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }

   
    .card-bg-icon {
        position: absolute;
        bottom: 10px;
        right: 15px;
        font-size: 3.8rem;
        opacity: 0.15;
        color: rgba(255, 255, 255, 0.7);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .dashboard-card:hover .card-bg-icon {
        opacity: 0.25;
        transform: scale(1.1);
    }

    /* Footer */
    .card-footer-modern {
        border-top: 3px solid rgba(255,255,255,0.25);
        font-size: 0.95rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        padding: 0.75rem 1rem;
        position: relative;
    }
    .card-footer-modern::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: rgba(255,255,255,0.5);
    }

   
    .bg-gradient-info { background: linear-gradient(135deg, #007cf0, #00dfd8); }
    .bg-gradient-success { background: linear-gradient(135deg, #00b09b, #96c93d); }
    .bg-gradient-warning { background: linear-gradient(135deg, #f7971e, #ffd200); }
    .bg-gradient-primary { background: linear-gradient(135deg, #004e92, #000428); }
    .bg-gradient-danger { background: linear-gradient(135deg, #e52d27, #b31217); }
    .bg-gradient-cyan { background: linear-gradient(135deg, #06beb6, #48b1bf); }


    .footer-info { background: #005fb8; }
    .footer-success { background: #0f8f6a; }
    .footer-warning { background: #d48a00; color: #212529 !important; }
    .footer-primary { background: #002f75; }
    .footer-danger { background: #a20e0e; }
    .footer-cyan { background: #057e85; }

    .card-footer-modern a:hover {
        opacity: 0.85;
        text-decoration: underline;
    }

    h1 i { color: #007bff; }
</style>
@stop

@section('js')
<script>
    console.log("Dashboard de Servicio Técnico con fondos visuales actualizado");
</script>
@stop
