@extends('adminlte::page')

@section('content_header')
    <h1 class="text-primary"><b>Dashboard - Sistema de Tickets</b></h1>
    <hr>
@stop

@section('content')

    <!-- FILTRO DE PERIODO -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body">
                    <form method="GET" action="{{url('/admin/tickets-dashboard')}}" class="form-inline d-flex align-items-center">
                        <label class="mr-2 font-weight-semibold text-white">📅 Filtrar por período:</label>
                        <select name="periodo" class="form-control mr-3 border-0 shadow-sm rounded-pill px-3" id="selectPeriodo" style="background: rgba(255,255,255,0.95); font-weight: 500;">
                            <option value="dia" {{request('periodo', 'mes') == 'dia' ? 'selected' : ''}}>Hoy</option>
                            <option value="semana" {{request('periodo', 'mes') == 'semana' ? 'selected' : ''}}>Esta Semana</option>
                            <option value="mes" {{request('periodo', 'mes') == 'mes' ? 'selected' : ''}}>Este Mes</option>
                            <option value="año" {{request('periodo', 'mes') == 'año' ? 'selected' : ''}}>Este Año</option>
                            <option value="todo" {{request('periodo', 'mes') == 'todo' ? 'selected' : ''}}>Todo el Tiempo</option>
                        </select>
                        <button type="submit" class="btn btn-light rounded-pill shadow px-4 font-weight-semibold">
                            <i class="fas fa-filter"></i> Aplicar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MÉTRICAS PRINCIPALES -->
    <div class="row text-white">
        <div class="col-lg-3 col-6">
            <div class="small-box" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <div class="inner">
                    <h3>{{$estadisticasPeriodo['reparados']}}</h3>
                    <p>Equipos Reparados</p>
                    <small style="opacity: 0.9;">{{$periodoTexto}}</small>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{url('/admin/tickets')}}" class="small-box-footer" style="background: rgba(0,0,0,0.15);">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);">
                <div class="inner">
                    <h3>{{$estadisticasPeriodo['baja']}}</h3>
                    <p>Equipos Dados de Baja</p>
                    <small style="opacity: 0.9;">{{$periodoTexto}}</small>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <a href="{{url('/admin/tickets')}}" class="small-box-footer" style="background: rgba(0,0,0,0.15);">
                    Ver detalles <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="inner">
                    <h3>{{$estadisticas['aceptados']}}</h3>
                    <p>En Proceso</p>
                    <small style="opacity: 0.9;">Actualmente</small>
                </div>
                <div class="icon">
                    <i class="fas fa-wrench"></i>
                </div>
                <a href="{{url('/admin/tickets')}}" class="small-box-footer" style="background: rgba(0,0,0,0.15);">
                    Ver todos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="inner">
                    <h3>{{$estadisticas['con_alerta']}}</h3>
                    <p>Con Alertas</p>
                    <small style="opacity: 0.9;">Actualmente</small>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{url('/admin/tickets-alerta-tiempo')}}" class="small-box-footer" style="background: rgba(0,0,0,0.15);">
                    Ver alertas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- COMPARATIVA DE PERIODO -->
    <div class="card border-0 shadow-lg mt-3">
        <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h3 class="card-title"><i class="fas fa-chart-pie"></i> Resumen del Período: <b>{{$periodoTexto}}</b></h3>
        </div>
        <div class="card-body" style="background: #f8f9fa;">
            <div class="row">
                @foreach([
                    ['icon'=>'fa-tools','color'=>'#11998e','label'=>'Equipos Reparados','valor'=>$estadisticasPeriodo['reparados'],'porcentaje'=>$estadisticasPeriodo['porcentaje_reparados']],
                    ['icon'=>'fa-ban','color'=>'#ee0979','label'=>'Equipos Dados de Baja','valor'=>$estadisticasPeriodo['baja'],'porcentaje'=>$estadisticasPeriodo['porcentaje_baja']],
                    ['icon'=>'fa-handshake','color'=>'#4facfe','label'=>'Equipos Devueltos','valor'=>$estadisticasPeriodo['devueltos'],'porcentaje'=>null],
                    ['icon'=>'fa-clipboard-list','color'=>'#fa709a','label'=>'Total Procesados','valor'=>$estadisticasPeriodo['total_procesados'],'porcentaje'=>null]
                ] as $info)
                    <div class="col-md-3">
                        <div class="info-box mb-3 shadow-sm border-0" style="background: white;">
                            <span class="info-box-icon elevation-1" style="background: linear-gradient(135deg, {{$info['color']}} 0%, {{$info['color']}}dd 100%);">
                                <i class="fas {{$info['icon']}}" style="color: white;"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text text-muted">{{$info['label']}}</span>
                                <span class="info-box-number text-lg font-weight-bold" style="color: {{$info['color']}};">{{$info['valor']}}</span>
                                @if($info['porcentaje'])
                                    <div class="progress mt-2" style="height: 6px; border-radius: 10px;">
                                        <div class="progress-bar" style="width: {{$info['porcentaje']}}%; background: linear-gradient(90deg, {{$info['color']}} 0%, {{$info['color']}}cc 100%); border-radius: 10px;"></div>
                                    </div>
                                    <span class="progress-description" style="color: #6c757d; font-size: 0.8rem;">
                                        {{$info['porcentaje']}}% del total finalizado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- GRÁFICOS -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 font-weight-bold text-dark"><i class="fas fa-chart-bar text-primary"></i> Equipos Reparados vs Dados de Baja</h5>
                </div>
                <div class="card-body">
                    <canvas id="reparadosVsBajaChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 font-weight-bold text-dark"><i class="fas fa-chart-pie text-info"></i> Distribución por Estados</h5>
                </div>
                <div class="card-body">
                    <canvas id="estadosChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- HOSPITALES -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 font-weight-bold text-dark"><i class="fas fa-hospital text-success"></i> Hospitales con Más Solicitudes</h5>
                </div>
                <div class="card-body">
                    <canvas id="hospitalesChart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg border-0">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: 0;">
                    <h5 class="mb-0 font-weight-bold">Top 5 Hospitales</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th class="border-0">Hospital</th>
                                <th class="text-center border-0">Tickets</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topHospitales as $hospital => $cantidad)
                                <tr>
                                    <td>{{Str::limit($hospital, 25)}}</td>
                                    <td class="text-center">
                                        <span class="badge badge-pill shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 5px 12px;">{{$cantidad}}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
<style>
    body {
        background: #f5f7fa;
    }
    h1 { 
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    .small-box {
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        transition: all .3s ease;
        overflow: hidden;
    }
    .small-box:hover { 
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.25);
    }
    .small-box .icon {
        font-size: 70px;
        opacity: 0.3;
    }
    .small-box-footer {
        transition: all .3s ease;
    }
    .small-box:hover .small-box-footer {
        background: rgba(0,0,0,0.25) !important;
    }
    .info-box {
        border-radius: 12px;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .info-box:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }
    .info-box-icon {
        border-radius: 12px;
        width: 70px;
        height: 70px;
        line-height: 70px;
        text-align: center;
        font-size: 30px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    .card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-3px);
    }
    .table-hover tbody tr:hover {
        background: #f0f4ff;
    }
    select#selectPeriodo {
        transition: all 0.3s ease;
    }
    select#selectPeriodo:focus {
        box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
    }
</style>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    const coloresVibrantes = [
        '#667eea', '#764ba2', '#f093fb', '#4facfe', 
        '#43e97b', '#fa709a', '#fee140', '#30cfd0'
    ];

    // Configuración común para gráficos
    Chart.defaults.font.family = "'Segoe UI', 'Roboto', sans-serif";
    Chart.defaults.color = '#495057';

    // GRÁFICO REPARADOS VS BAJA
    new Chart(document.getElementById('reparadosVsBajaChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($datosTemporales['labels']) !!},
            datasets: [
                { 
                    label:'Reparados', 
                    data:{!! json_encode($datosTemporales['reparados']) !!}, 
                    backgroundColor:'rgba(17, 153, 142, 0.8)',
                    borderColor: '#11998e',
                    borderWidth: 2,
                    borderRadius: 8
                },
                { 
                    label:'Dados de Baja', 
                    data:{!! json_encode($datosTemporales['baja']) !!}, 
                    backgroundColor:'rgba(238, 9, 121, 0.8)',
                    borderColor: '#ee0979',
                    borderWidth: 2,
                    borderRadius: 8
                }
            ]
        },
        options: { 
            responsive:true, 
            maintainAspectRatio:false, 
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        padding: 15,
                        font: { size: 13, weight: 'bold' }
                    }
                }
            },
            scales:{ 
                y:{
                    beginAtZero:true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            } 
        }
    });

    // GRÁFICO ESTADOS
    new Chart(document.getElementById('estadosChart'), {
        type: 'doughnut',
        data: {
            labels:['En Espera','Aceptados','Reparados','Dados de Baja','Devueltos'],
            datasets:[{
                data:[{{$estadisticas['en_espera']}},{{$estadisticas['aceptados']}},{{$estadisticas['reparados']}},{{$estadisticas['baja']}},{{$estadisticas['devueltos']}}],
                backgroundColor: coloresVibrantes,
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options:{ 
            responsive:true, 
            plugins:{ 
                legend:{ 
                    position:'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 12 }
                    }
                }
            } 
        }
    });

    // GRÁFICO HOSPITALES
    new Chart(document.getElementById('hospitalesChart'), {
        type:'bar',
        data:{
            labels:{!! json_encode(array_keys($topHospitales)) !!},
            datasets:[{ 
                data:{!! json_encode(array_values($topHospitales)) !!}, 
                backgroundColor: coloresVibrantes,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options:{ 
            responsive:true, 
            maintainAspectRatio:false, 
            indexAxis:'y', 
            plugins:{ 
                legend:{display:false}
            },
            scales: {
                x: {
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                y: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@stop