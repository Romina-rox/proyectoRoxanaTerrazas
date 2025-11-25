@extends('adminlte::page')

@section('title', 'Listado de Equipos Devueltos')

@section('content_header')
    <h1><i class="fas fa-check-circle text-success"></i> <b>Listado Detallado de Equipos Devueltos a Usuarios</b></h1>
    <hr>
@stop

@section('content')
    <!-- ESTADÍSTICAS RÁPIDAS -->
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{$estadisticas['total']}}</h3>
                    <p>Total de Devueltos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$estadisticas['este_mes']}}</h3>
                    <p>Devueltos Este Mes</p>
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
                    <p>Devueltos Este Año</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLA DE DEVUELTOS -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list"></i> Todos los Equipos Devueltos a Usuarios</h3>
                    <div class="card-tools">
                        <a href="{{url('/admin/reportes')}}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a Reportes
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($tickets->isEmpty())
                        <div class="alert alert-info text-center">
                            <h5><i class="fas fa-info-circle"></i> No hay equipos devueltos</h5>
                            <p>Aún no se han devuelto equipos reparados en el sistema</p>
                        </div>
                    @else
                    <table id="tablaDevueltos" class="table table-bordered table-hover table-striped table-sm">
                        <thead class="thead-dark">
                        <tr>
                            <th style="text-align: center">Ticket #</th>
                            <th style="text-align: center">Fecha Devolución</th>
                            <th style="text-align: center">Hospital</th>
                            <th style="text-align: center">Usuario</th>
                            <th style="text-align: center">Equipo</th>
                            <th style="text-align: center">N° Activo</th>
                            <th style="text-align: center">Solución Aplicada</th>
                            <th style="text-align: center">Días Reparación</th>
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
                                    {{$ticket->fecha_devolucion_usuario->format('d/m/Y')}}
                                    <br><small class="text-muted">{{$ticket->fecha_devolucion_usuario->format('H:i')}}</small>
                                </td>
                                <td>
                                    <strong>{{$ticket->hospital->nombre}}</strong>
                                    <br><small class="text-muted">{{$ticket->hospital->tipo}}</small>
                                </td>
                                <td>
                                    <strong>{{$ticket->usuario->nombre_completo}}</strong>
                                    <br><small class="text-muted">{{ucfirst($ticket->usuario->cargo)}}</small>
                                </td>
                                <td>
                                    <strong>{{$ticket->equipo->nombre}}</strong>
                                    <br><small>{{Str::limit($ticket->descripcion_equipo, 40)}}</small>
                                </td>
                                <td style="text-align: center">
                                    <span class="badge badge-success badge-lg">{{$ticket->numero_activo}}</span>
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
                                        <a href="{{url('/admin/tickets/'.$ticket->id.'/comprobante-usuario')}}" 
                                           class="btn btn-success btn-sm" title="Comprobante" target="_blank">
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
        #tablaDevueltos_wrapper .dt-buttons {
            background-color: transparent;
            box-shadow: none;
            border: none;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        #tablaDevueltos_wrapper .btn {
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
            $("#tablaDevueltos").DataTable({
                "pageLength": 25,
                "language": {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Devueltos",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Devueltos",
                    "infoFiltered": "(Filtrado de _MAX_ total Devueltos)",
                    "lengthMenu": "Mostrar _MENU_ Devueltos",
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
            }).buttons().container().appendTo('#tablaDevueltos_wrapper .row:eq(0)');
            @endif
        });
    </script>
@stop