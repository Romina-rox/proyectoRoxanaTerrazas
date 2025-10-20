@extends('adminlte::page')

@section('content_header')
    <h1><b>Detalles del Ticket #{{str_pad($ticket->id, 6, '0', STR_PAD_LEFT)}}</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <!-- Información principal del ticket -->
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-ticket-alt"></i> Información del Ticket
                        @if($ticket->alerta_tiempo)
                            <span class="badge badge-warning ml-2">
                                <i class="fas fa-exclamation-triangle"></i> Alerta de Tiempo
                            </span>
                        @endif
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Número de Ticket:</strong></td>
                                    <td>#{{str_pad($ticket->id, 6, '0', STR_PAD_LEFT)}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Estado Actual:</strong></td>
                                    <td>
                                        <span class="badge badge-{{$ticket->estado_color}} badge-lg">
                                            {{$ticket->estado_humano}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha de Creación:</strong></td>
                                    <td>{{$ticket->created_at->format('d/m/Y H:i')}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha de Ingreso:</strong></td>
                                    <td>{{$ticket->fecha_ingreso->format('d/m/Y')}}</td>
                                </tr>
                                @if($ticket->fecha_aceptacion)
                                <tr>
                                    <td><strong>Fecha de Aceptación:</strong></td>
                                    <td>{{$ticket->fecha_aceptacion->format('d/m/Y H:i')}}</td>
                                </tr>
                                @endif
                                @if($ticket->fecha_finalizacion)
                                <tr>
                                    <td><strong>Fecha de Finalización:</strong></td>
                                    <td>{{$ticket->fecha_finalizacion->format('d/m/Y H:i')}}</td>
                                </tr>
                                @endif
                                @if($ticket->fecha_devolucion)
                                <tr>
                                    <td><strong>Fecha de Devolución:</strong></td>
                                    <td>{{$ticket->fecha_devolucion->format('d/m/Y H:i')}}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Tipo de Equipo:</strong></td>
                                    <td>{{$ticket->equipo->nombre}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Número de Activo:</strong></td>
                                    <td>
                                        <span class="badge badge-secondary">{{$ticket->numero_activo}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Descripción del Equipo:</strong></td>
                                    <td>{{$ticket->descripcion_equipo}}</td>
                                </tr>
                                @if($ticket->dias_transcurridos > 0)
                                <tr>
                                    <td><strong>Tiempo de Procesamiento:</strong></td>
                                    <td>
                                        <span class="badge badge-{{$ticket->alerta_tiempo ? 'warning' : 'info'}}">
                                            {{$ticket->dias_transcurridos}} día{{$ticket->dias_transcurridos != 1 ? 's' : ''}}
                                        </span>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td><strong>Última Actualización:</strong></td>
                                    <td>{{$ticket->updated_at->format('d/m/Y H:i')}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del solicitante -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Información del Solicitante
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nombre Completo:</strong></td>
                                    <td>{{$ticket->usuario->nombre_completo}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Cargo:</strong></td>
                                    <td>{{ucfirst($ticket->usuario->cargo)}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>
                                        <a href="mailto:{{$ticket->usuario->user->email}}">
                                            {{$ticket->usuario->user->email}}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Hospital/Centro:</strong></td>
                                    <td>{{$ticket->hospital->nombre}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tipo de Centro:</strong></td>
                                    <td>{{ucfirst($ticket->hospital->tipo)}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Teléfono del Centro:</strong></td>
                                    <td>{{$ticket->hospital->telefono}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Problema reportado -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-circle"></i> Problema Reportado
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <p class="mb-0">{{$ticket->descripcion_problema}}</p>
                    </div>
                </div>
            </div>

            <!-- Detalle de la solución -->
            @if($ticket->detalle_salida)
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tools"></i> 
                        {{$ticket->estado == 'reparado' ? 'Solución Aplicada' : 'Diagnóstico Final'}}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-{{$ticket->estado == 'reparado' ? 'success' : 'danger'}}">
                        <p class="mb-0">{{$ticket->detalle_salida}}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Panel lateral con acciones -->
        <div class="col-md-4">
            <!-- Estado y acciones -->
            <div class="card card-{{$ticket->estado_color}}">
                <div class="card-header">
                    <h3 class="card-title">Estado y Acciones</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <span class="badge badge-{{$ticket->estado_color}} badge-lg" style="font-size: 1.2rem;">
                            {{$ticket->estado_humano}}
                        </span>
                    </div>

                    <!-- Botones de acción según el estado -->
                    <div class="btn-group-vertical w-100 mb-3">
                        @if(auth()->user()->hasAnyRole(['administrador', 'tecnico', 'pasante']))
                            @if($ticket->estado == 'en_espera')
                                <a href="{{url('/admin/tickets/'.$ticket->id.'/aceptar')}}" 
                                   class="btn btn-primary"
                                   onclick="return confirm('¿Está seguro de aceptar este ticket?')">
                                    <i class="fas fa-check"></i> Aceptar Ticket
                                </a>
                            @endif

                            <a href="{{url('/admin/tickets/'.$ticket->id.'/edit')}}" 
                               class="btn btn-success">
                                <i class="fas fa-pencil-alt"></i> Editar Ticket
                            </a>

                            @if(in_array($ticket->estado, ['reparado', 'baja']) && $ticket->estado != 'devuelto')
                                <button type="button" class="btn btn-warning" 
                                        onclick="marcarDevuelto({{$ticket->id}})">
                                    <i class="fas fa-handshake"></i> Marcar como Devuelto
                                </button>
                            @endif
                        @endif

                        @if($ticket->estado == 'devuelto')
                            <a href="{{url('/admin/tickets/'.$ticket->id.'/comprobante')}}" 
                               class="btn btn-primary" target="_blank">
                                <i class="fas fa-print"></i> Ver Comprobante
                            </a>
                            <a href="{{url('/admin/tickets/'.$ticket->id.'/descargar-word')}}" 
                               class="btn btn-info">
                                <i class="fas fa-download"></i> Descargar Word
                            </a>
                        @endif

                        <a href="{{url('/admin/tickets')}}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a Lista
                        </a>
                    </div>

                    <!-- Información adicional -->
                    @if($ticket->alerta_tiempo)
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle"></i> Alerta de Tiempo</h6>
                            <small>
                                Este ticket lleva <strong>{{$ticket->dias_transcurridos}} días</strong> 
                                desde su aceptación. Se recomienda dar seguimiento prioritario.
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Línea de tiempo -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history"></i> Línea de Tiempo
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="time-label">
                            <span class="bg-secondary">
                                {{$ticket->created_at->format('d/m/Y')}}
                            </span>
                        </div>
                        
                        <div>
                            <i class="fas fa-plus bg-primary"></i>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="far fa-clock"></i> {{$ticket->created_at->format('H:i')}}
                                </span>
                                <h3 class="timeline-header">Ticket Creado</h3>
                                <div class="timeline-body">
                                    El usuario {{$ticket->usuario->nombre_completo}} creó el ticket para el equipo {{$ticket->descripcion_equipo}}.
                                </div>
                            </div>
                        </div>

                        @if($ticket->fecha_aceptacion)
                        <div>
                            <i class="fas fa-check bg-info"></i>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="far fa-clock"></i> {{$ticket->fecha_aceptacion->format('H:i')}}
                                </span>
                                <h3 class="timeline-header">Ticket Aceptado</h3>
                                <div class="timeline-body">
                                    El ticket fue aceptado y está en proceso de reparación.
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($ticket->fecha_finalizacion)
                        <div>
                            <i class="fas fa-{{$ticket->estado == 'reparado' ? 'wrench' : 'times'}} bg-{{$ticket->estado == 'reparado' ? 'success' : 'danger'}}"></i>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="far fa-clock"></i> {{$ticket->fecha_finalizacion->format('H:i')}}
                                </span>
                                <h3 class="timeline-header">
                                    {{$ticket->estado == 'reparado' ? 'Equipo Reparado' : 'Equipo Dado de Baja'}}
                                </h3>
                                <div class="timeline-body">
                                    @if($ticket->detalle_salida)
                                        {{Str::limit($ticket->detalle_salida, 100)}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($ticket->fecha_devolucion)
                        <div>
                            <i class="fas fa-handshake bg-primary"></i>
                            <div class="timeline-item">
                                <span class="time">
                                    <i class="far fa-clock"></i> {{$ticket->fecha_devolucion->format('H:i')}}
                                </span>
                                <h3 class="timeline-header">Equipo Devuelto</h3>
                                <div class="timeline-body">
                                    El equipo fue devuelto al usuario. Proceso completado.
                                </div>
                            </div>
                        </div>
                        @endif

                        <div>
                            <i class="far fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para marcar como devuelto -->
    <div class="modal fade" id="devolucionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="devolucionForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Devolución</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Confirmación de Devolución</h6>
                            <p>¿Está seguro de marcar este equipo como devuelto al usuario?</p>
                            <p><strong>Ticket:</strong> #{{$ticket->id}}</p>
                            <p><strong>Equipo:</strong> {{$ticket->descripcion_equipo}}</p>
                            <p><strong>Usuario:</strong> {{$ticket->usuario->nombre_completo}}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Confirmar Devolución</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .badge-lg {
            font-size: 1rem;
            padding: 0.5rem 1rem;
        }
        
        .timeline {
            position: relative;
            margin: 0 0 30px 0;
            padding: 0;
            list-style: none;
        }
        
        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #dee2e6;
            left: 31px;
            margin: 0;
            border-radius: 2px;
        }
        
        .timeline > div {
            margin-bottom: 15px;
            position: relative;
        }
        
        .timeline > div > .timeline-item {
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            border-radius: 3px;
            margin-top: 0;
            background: #fff;
            color: #444;
            margin-left: 60px;
            margin-right: 15px;
            padding: 10px;
            position: relative;
        }
        
        .timeline > div > i {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-size: 15px;
            font-weight: bold;
            color: #fff;
            position: absolute;
            left: 18px;
            top: 0;
        }
        
        .time-label > span {
            font-weight: 600;
            color: #fff;
            border-radius: 4px;
            padding: 5px 10px;
            margin-left: 60px;
            display: inline-block;
        }
        
        .timeline-header {
            margin: 0;
            color: #555;
            font-size: 16px;
            font-weight: 600;
        }
        
        .timeline-body {
            padding-top: 10px;
        }
        
        .time {
            color: #999;
            float: right;
            font-size: 12px;
        }
    </style>
@stop

@section('js')
    <script>
        function marcarDevuelto(ticketId) {
            $('#devolucionForm').attr('action', '/admin/tickets/' + ticketId + '/devuelto');
            $('#devolucionModal').modal('show');
        }
    </script>
@stop