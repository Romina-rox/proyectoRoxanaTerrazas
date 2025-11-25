@extends('adminlte::page')

@section('title', 'Reportes y Estadísticas')

@section('content_header')
    <h1><i class="fas fa-chart-line"></i> <b>Reportes y Estadísticas del Sistema</b></h1>
    <hr>
@stop

@section('content')
    <!-- TARJETAS DE ESTADÍSTICAS GENERALES -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$estadisticasGenerales['total_tickets']}}</h3>
                    <p>Total de Tickets</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <a href="{{url('/admin/tickets')}}" class="small-box-footer">
                    Ver todos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$estadisticasGenerales['total_reparados']}}</h3>
                    <p>Equipos Devueltos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{url('/admin/reportes/listado-devueltos')}}" class="small-box-footer">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 style="color: #fff;">{{$estadisticasGenerales['total_bajas']}}</h3>
                    <p style="color: #fff;">Equipos Dados de Baja</p>
                </div>
                <div class="icon">
                    <i class="fas fa-archive"></i>
                </div>
                <a href="{{url('/admin/reportes/listado-bajas')}}" class="small-box-footer" style="color: #fff;">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$estadisticasGenerales['en_proceso']}}</h3>
                    <p>En Proceso</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wrench"></i>
                </div>
                <a href="{{url('/admin/tickets')}}" class="small-box-footer">
                    Ver tickets <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- GRÁFICO: TICKETS POR MES Y AÑO -->
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Tickets Recibidos por Mes (Últimos 12 meses)</h3>
                </div>
                <div class="card-body">
                    <canvas id="ticketsPorMesChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clock"></i> Tiempo Promedio</h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4"><i class="fas fa-hourglass-half"></i></h1>
                    <h2>{{$tiempoPromedio}} días</h2>
                    <p class="text-muted">Tiempo promedio de reparación desde aceptación hasta finalización</p>
                </div>
            </div>
        </div>
    </div>

    <!-- COMPARATIVA REPARADOS VS BAJAS -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-balance-scale"></i> Comparativa: Equipos Devueltos vs Dados de Baja</h3>
                </div>
                <div class="card-body">
                    <canvas id="comparativaChart" height="60"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- DISTRIBUCIÓN POR ESTADO Y TICKETS POR AÑO -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-pie-chart"></i> Distribución por Estado</h3>
                </div>
                <div class="card-body">
                    <canvas id="distribucionEstadosChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar"></i> Tickets por Año</h3>
                </div>
                <div class="card-body">
                    <canvas id="ticketsPorAñoChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- TOP HOSPITALES -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-hospital"></i> Top 5 Hospitales con Más Solicitudes</h3>
                </div>
                <div class="card-body">
                    <canvas id="topHospitalesChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- EQUIPOS MÁS RECIBIDOS -->
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-laptop"></i> Top 10 Equipos Más Recibidos</h3>
                </div>
                <div class="card-body">
                    <canvas id="equiposMasRecibidosChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- EQUIPOS MÁS DADOS DE BAJA -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-times-circle"></i> Top 10 Equipos Más Dados de Baja</h3>
                </div>
                <div class="card-body">
                    <canvas id="equiposMasBajaChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <style>
        .small-box {
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .card {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .card-header {
            border-radius: 10px 10px 0 0;
        }
    </style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Configuración de colores
    const colores = {
        primary: 'rgba(54, 162, 235, 0.8)',
        success: 'rgba(75, 192, 192, 0.8)',
        warning: 'rgba(255, 206, 86, 0.8)',
        danger: 'rgba(255, 99, 132, 0.8)',
        info: 'rgba(153, 102, 255, 0.8)',
        secondary: 'rgba(201, 203, 207, 0.8)'
    };

    // 1. TICKETS POR MES
    new Chart(document.getElementById('ticketsPorMesChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($ticketsPorMes['labels']) !!},
            datasets: [{
                label: 'Tickets Recibidos',
                data: {!! json_encode($ticketsPorMes['datos']) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: colores.primary,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });

    // 2. COMPARATIVA REPARADOS VS BAJAS
    new Chart(document.getElementById('comparativaChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($comparativaReparadosBajas['labels']) !!},
            datasets: [
                {
                    label: 'Equipos Devueltos (Reparados)',
                    data: {!! json_encode($comparativaReparadosBajas['reparados']) !!},
                    backgroundColor: colores.success,
                    borderWidth: 2
                },
                {
                    label: 'Equipos Dados de Baja',
                    data: {!! json_encode($comparativaReparadosBajas['bajas']) !!},
                    backgroundColor: colores.danger,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // 3. DISTRIBUCIÓN POR ESTADO (Donut)
    new Chart(document.getElementById('distribucionEstadosChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($distribucionEstados['labels']) !!},
            datasets: [{
                data: {!! json_encode($distribucionEstados['datos']) !!},
                backgroundColor: [
                    colores.secondary,
                    colores.info,
                    colores.success,
                    colores.danger,
                    colores.primary,
                    colores.warning
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });

    // 4. TICKETS POR AÑO
    new Chart(document.getElementById('ticketsPorAñoChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($ticketsPorAño['labels']) !!},
            datasets: [{
                label: 'Tickets por Año',
                data: {!! json_encode($ticketsPorAño['datos']) !!},
                backgroundColor: colores.danger,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5
                    }
                }
            }
        }
    });

    // 5. TOP HOSPITALES
    new Chart(document.getElementById('topHospitalesChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($topHospitales['labels']) !!},
            datasets: [{
                label: 'Tickets Recibidos',
                data: {!! json_encode($topHospitales['datos']) !!},
                backgroundColor: colores.primary,
                borderWidth: 2
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // 6. EQUIPOS MÁS RECIBIDOS
    new Chart(document.getElementById('equiposMasRecibidosChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($equiposMasRecibidos['labels']) !!},
            datasets: [{
                label: 'Cantidad Recibida',
                data: {!! json_encode($equiposMasRecibidos['datos']) !!},
                backgroundColor: colores.info,
                borderWidth: 2
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // 7. EQUIPOS MÁS DADOS DE BAJA
    new Chart(document.getElementById('equiposMasBajaChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($equiposMasBaja['labels']) !!},
            datasets: [{
                label: 'Cantidad Dada de Baja',
                data: {!! json_encode($equiposMasBaja['datos']) !!},
                backgroundColor: colores.danger,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@stop