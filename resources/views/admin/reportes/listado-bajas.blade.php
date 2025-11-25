@extends('adminlte::page')

@section('title', 'Listado de Equipos Dados de Baja')

@section('content_header')
    <h1><i class="fas fa-archive text-warning"></i> <b>Listado Detallado de Equipos Dados de Baja</b></h1>
    <hr>
@stop

@section('content')
    <!-- ESTADÍSTICAS RÁPIDAS -->
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 style="color: #fff;">{{$estadisticas['total']}}</h3>
                    <p style="color: #fff;">Total de Bajas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-archive"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$estadisticas['este_mes']}}</h3>
                    <p>Bajas Este Mes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{$estadisticas['este_año']}}</h3>
                    <p>Bajas Este Año</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLA DE BAJAS -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list"></i> Todos los Equipos Dados de Baja</h3>
                    <div class="card-tools">
                        <a href="{{url('/admin/reportes')}}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a Reportes
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($tickets->isEmpty())
                        <div class="alert alert-info text-center">
                            <h5><i class="fas fa-info-circle"></i> No hay equipos dados de baja</h5>
                            <p>Aún no se han dado de baja equipos en el sistema</p>
                        </div>
                    @else
                    <table id="tablaBajas" class="table table-bordered table-hover table-striped table-sm">
                        <thead class="thead-dark">
                        <tr>
                            <th style="text-align: center">Ticket #</th>
                            <th style="text-align: center">Fecha Baja</th>
                            <th style="text-align: center">Hospital</th>
                            <th style="text-align: center">Equipo</th>
                            <th style="text-align: center">N° Activo</th>
                            <th style="text-align: center">Motivo/Diagnóstico</th>
                            <th style="text-align: center">Días Evaluación</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td style="text-align: center">
                                    <strong>{{str_pad($ticket->id, 6, '0', STR_PAD_LEFT)}}</strong>
                                </td>
                                <td style="text-align: center">
                                    {{$ticket->fecha_entrega_activos_fijos->format('d/m/Y')}}
                                    <br><small class="text-muted">{{$ticket->fecha_entrega_activos_fijos->format('H:i')}}</small>
                                </td>
                                <td>
                                    <strong>{{$ticket->hospital->nombre}}</strong>
                                    <br><small class="text-muted">{{$ticket->hospital->tipo}}</small>
                                </td>
                                <td>
                                    <strong>{{$ticket->equipo->nombre}}</strong>
                                    <br><small>{{Str::limit($ticket->descripcion_equipo, 40)}}</small>
                                </td>
                                <td style="text-align: center">
                                    <span class="badge badge-dark badge-lg">{{$ticket->numero_activo}}</span>
                                </td>
                                <td>
                                    @if($ticket->detalle_salida)
                                        {{Str::limit($ticket->detalle_salida, 80)}}
                                    @else
                                        <span class="text-muted">Sin detalles</span>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    <span class="badge badge-info">{{$ticket->dias_transcurridos}} días</span>
                                </td>
                                <td style="text-align: center">
                                    <div class="btn-group-vertical" role="group">
                                        <a href="{{url('/admin/tickets/'.$ticket->id)}}" 
                                           class="btn btn-info btn-sm mb-1" title="Ver detalles">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        <a href="{{url('/admin/tickets/'.$ticket->id.'/comprobante-activos-fijos')}}" 
                                           class="btn btn-warning btn-sm" title="Comprobante" target="_blank">
                                            <i class="fas fa-print"></i> Comprobante
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .badge-lg {
            font-size: 0.9rem;
            padding: 0.4rem 0.6rem;
        }
        #tablaBajas_wrapper .dt-buttons {
            background-color: transparent;
            box-shadow: none;
            border: none;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        #tablaBajas_wrapper .btn {
            color: #fff;
            border-radius: 4px;
            padding: 5px 15px;
            font-size: 14px;
        }
        .btn-danger { background-color: #dc3545; border: none; }
        .btn-success { background-color: #28a745; border: none; }
        .btn-info { background-color: #17a2b8; border: none; }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            @if(!$tickets->isEmpty())
            $("#tablaBajas").DataTable({
                "pageLength": 25,
                "language": {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Bajas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Bajas",
                    "infoFiltered": "(Filtrado de _MAX_ total Bajas)",
                    "lengthMenu": "Mostrar _MENU_ Bajas",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true,
                "autoWidth": false,
                "order": [[ 1, "desc" ]],
                buttons: [
                    { text: '<i class="fas fa-file-pdf"></i> PDF', extend: 'pdf', className: 'btn btn-danger' },
                    { text: '<i class="fas fa-file-excel"></i> EXCEL', extend: 'excel', className: 'btn btn-success' },
                    { text: '<i class="fas fa-print"></i> IMPRIMIR', extend: 'print', className: 'btn btn-info' }
                ]
            }).buttons().container().appendTo('#tablaBajas_wrapper .row:eq(0)');
            @endif
        });
    </script>
@stop