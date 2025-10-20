@extends('adminlte::page')

@section('content_header')
    <h1><b>🚨 Alertas de Tiempo - Tickets Urgentes</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Tickets que exceden 4 días en reparación</h3>
                    <div class="card-tools">
                        <span class="badge badge-danger">{{$tickets->count()}} tickets urgentes</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($tickets->count() > 0)
                        <div class="alert alert-danger">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Atención Requerida:</h5>
                            Los siguientes tickets han excedido el tiempo límite de <strong>4 días</strong> desde su aceptación.
                            Se requiere atención inmediata del personal técnico.
                        </div>
                        
                        <table id="example1" class="table table-bordered table-hover table-striped table-sm">
                            <thead class="thead-dark">
                            <tr>
                                <th style="text-align: center">Ticket #</th>
                                <th style="text-align: center">Hospital</th>
                                <th style="text-align: center">Usuario</th>
                                <th style="text-align: center">Equipo</th>
                                <th style="text-align: center">N° Activo</th>
                                <th style="text-align: center">Fecha Aceptación</th>
                                <th style="text-align: center">Días Transcurridos</th>
                                <th style="text-align: center">Prioridad</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $ticket)
                                @php
                                    $diasTranscurridos = $ticket->dias_transcurridos;
                                    $prioridad = 'alta';
                                    if ($diasTranscurridos > 10) $prioridad = 'critica';
                                    elseif ($diasTranscurridos > 7) $prioridad = 'muy-alta';
                                @endphp
                                <tr class="{{$prioridad == 'critica' ? 'table-danger' : ($prioridad == 'muy-alta' ? 'table-warning' : 'table-info')}}">
                                    <td style="text-align: center">
                                        <strong>{{$ticket->id}}</strong>
                                        <br><small class="text-muted">{{$ticket->created_at->format('d/m/Y')}}</small>
                                    </td>
                                    <td>
                                        <strong>{{$ticket->hospital->nombre}}</strong>
                                        <br><small class="text-muted">{{$ticket->hospital->tipo}}</small>
                                    </td>
                                    <td>
                                        <strong>{{$ticket->usuario->nombre_completo}}</strong>
                                        <br><small class="text-primary">{{ucfirst($ticket->usuario->cargo)}}</small>
                                        <br><small class="text-muted">{{$ticket->usuario->user->email}}</small>
                                    </td>
                                    <td>
                                        <strong>{{$ticket->equipo->nombre}}</strong>
                                        <br><small>{{Str::limit($ticket->descripcion_equipo, 30)}}</small>
                                    </td>
                                    <td style="text-align: center">
                                        <span class="badge badge-secondary">{{$ticket->numero_activo}}</span>
                                    </td>
                                    <td style="text-align: center">
                                        {{$ticket->fecha_aceptacion->format('d/m/Y H:i')}}
                                        <br><small class="text-muted">{{$ticket->fecha_aceptacion->diffForHumans()}}</small>
                                    </td>
                                    <td style="text-align: center">
                                        <span class="badge badge-{{$prioridad == 'critica' ? 'danger' : ($prioridad == 'muy-alta' ? 'warning' : 'info')}} badge-lg">
                                            <i class="fas fa-clock"></i> {{$diasTranscurridos}} días
                                        </span>
                                    </td>
                                    <td style="text-align: center">
                                        @if($prioridad == 'critica')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-exclamation-circle"></i> CRÍTICA
                                            </span>
                                        @elseif($prioridad == 'muy-alta')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-exclamation-triangle"></i> MUY ALTA
                                            </span>
                                        @else
                                            <span class="badge badge-info">
                                                <i class="fas fa-info-circle"></i> ALTA
                                            </span>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        <div class="btn-group-vertical" role="group">
                                            <a href="{{url('/admin/tickets/'.$ticket->id)}}" 
                                               class="btn btn-info btn-sm mb-1" title="Ver detalles">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            
                                            <a href="{{url('/admin/tickets/'.$ticket->id.'/edit')}}" 
                                               class="btn btn-success btn-sm mb-1" title="Editar">
                                                <i class="fas fa-pencil-alt"></i> Editar
                                            </a>
                                            
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    title="Contactar usuario"
                                                    onclick="contactarUsuario('{{$ticket->usuario->user->email}}', '{{$ticket->id}}')">
                                                <i class="fas fa-phone"></i> Contactar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-success text-center">
                            <h4><i class="icon fas fa-check-circle"></i> ¡Excelente trabajo!</h4>
                            <p>No hay tickets con alertas de tiempo. Todos los equipos están siendo procesados dentro del tiempo establecido.</p>
                            <a href="{{url('/admin/tickets')}}" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Volver a Tickets
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen de estadísticas -->
    @if($tickets->count() > 0)
    <div class="row">
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Estadísticas de Alertas</h3>
                </div>
                <div class="card-body">
                    @php
                        $criticos = $tickets->where('dias_transcurridos', '>', 10)->count();
                        $muyAltos = $tickets->where('dias_transcurridos', '>', 7)->where('dias_transcurridos', '<=', 10)->count();
                        $altos = $tickets->where('dias_transcurridos', '>', 4)->where('dias_transcurridos', '<=', 7)->count();
                        $promedioTiempo = $tickets->avg('dias_transcurridos');
                    @endphp
                    
                    <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-exclamation-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Críticos (+10 días)</span>
                            <span class="info-box-number">{{$criticos}}</span>
                        </div>
                    </div>
                    
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Muy Altos (7-10 días)</span>
                            <span class="info-box-number">{{$muyAltos}}</span>
                        </div>
                    </div>
                    
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-info-circle"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Altos (4-7 días)</span>
                            <span class="info-box-number">{{$altos}}</span>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <strong>Tiempo promedio de procesamiento:</strong>
                        <span class="badge badge-primary">{{number_format($promedioTiempo, 1)}} días</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Recomendaciones de Acción</h3>
                </div>
                <div class="card-body">
                    <h5>Acciones Sugeridas:</h5>
                    <ul>
                        <li><strong>Tickets Críticos (>10 días):</strong> Requieren intervención inmediata del supervisor.</li>
                        <li><strong>Tickets Muy Altos (7-10 días):</strong> Contactar al técnico asignado y evaluar recursos adicionales.</li>
                        <li><strong>Tickets Altos (4-7 días):</strong> Seguimiento diario y priorización en el flujo de trabajo.</li>
                    </ul>
                    
                    <h5 class="mt-3">Contactos de Escalamiento:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <small>
                                <strong>Supervisor Técnico:</strong><br>
                                Ext. 123 | supervisor@sacaba.gob.bo
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small>
                                <strong>Administrador del Sistema:</strong><br>
                                Ext. 456 | admin@sacaba.gob.bo
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@stop

@section('css')
    <style>
        .table-danger { background-color: #f8d7da !important; }
        .table-warning { background-color: #fff3cd !important; }
        .table-info { background-color: #d1ecf1 !important; }
        
        .badge-lg {
            font-size: 0.9rem;
            padding: 0.5rem 0.7rem;
        }
        
        .info-box {
            margin-bottom: 10px;
        }
        
        .btn-group-vertical .btn {
            margin-bottom: 2px;
        }
        
        #example1_wrapper .dt-buttons {
            background-color: transparent;
            box-shadow: none;
            border: none;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        #example1_wrapper .btn {
            color: #fff;
            border-radius: 4px;
            padding: 5px 15px;
            font-size: 14px;
        }

        .btn-danger { background-color: #dc3545; border: none; }
        .btn-success { background-color: #28a745; border: none; }
        .btn-info { background-color: #17a2b8; border: none; }
        .btn-warning { background-color: #ffc107; color: #212529; border: none; }
        .btn-default { background-color: #6e7176; color: #212529; border: none; }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $("#example1").DataTable({
                "pageLength": 15,
                "language": {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Tickets",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Tickets",
                    "infoFiltered": "(Filtrado de _MAX_ total Tickets)",
                    "lengthMenu": "Mostrar _MENU_ Tickets",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscador:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "order": [[ 6, "desc" ]], // Ordenar por días transcurridos
                buttons: [
                    { text: '<i class="fas fa-file-pdf"></i> PDF', extend: 'pdf', className: 'btn btn-danger' },
                    { text: '<i class="fas fa-file-excel"></i> EXCEL', extend: 'excel', className: 'btn btn-success' }
                ]
            }).buttons().container().appendTo('#example1_wrapper .row:eq(0)');
        });

        function contactarUsuario(email, ticketId) {
            const asunto = 'Seguimiento Ticket #' + ticketId + ' - Sistema de Reparación';
            const cuerpo = 'Estimado/a usuario/a,%0D%0A%0D%0ANos ponemos en contacto respecto al ticket #' + ticketId + ' de su equipo de cómputo.%0D%0A%0D%0ASaludos cordiales,%0D%0AEquipo Técnico - GAMS';
            const mailtoLink = 'mailto:' + email + '?subject=' + encodeURIComponent(asunto) + '&body=' + cuerpo;
            
            window.location.href = mailtoLink;
        }
    </script>
@stop