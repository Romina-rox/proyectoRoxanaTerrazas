@extends('adminlte::page')

@section('content_header')
    <h1><b>Alertas de Tiempo - Tickets Urgentes</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tickets que exceden 4 días en reparación</h3>
                    <div class="card-tools">
                        <span class="badge badge-danger">{{$tickets->count()}} tickets urgentes</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($tickets->count() > 0)
                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Atención Requerida:</h5>
                            Los siguientes tickets han excedido el tiempo límite de <strong>4 días</strong> desde su aceptación.
                            Se requiere atención inmediata del personal técnico.
                        </div>
                        
                        <table id="example1" class="table table-bordered table-hover table-striped table-sm">
                            <thead class="thead">
                            <tr>
                                <th style="text-align: center">Ticket #</th>
                                <th style="text-align: center">Hospital</th>
                                <th style="text-align: center">Usuario</th>
                                <th style="text-align: center">Equipo</th>
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
                                <tr class="{{$prioridad == 'critica' ? 'table-danger-light' : ($prioridad == 'muy-alta' ? 'table-warning-light' : 'table-info-light')}}">
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
                                        <br><small>{{Str::limit($ticket->descripcion_equipo, 30)}}</small> <br>
                                        <span class="badge badge-secondary">{{$ticket->numero_activo}}</span>
                                    </td>
                                    <td style="text-align: center">
                                        {{$ticket->fecha_aceptacion->format('d/m/Y H:i')}}
                                        <br><small class="text-muted">{{$ticket->fecha_aceptacion->diffForHumans()}}</small>
                                    </td>
                                    <td style="text-align: center">
                                        <span class="badge badge-{{$prioridad == 'critica' ? 'danger-light' : ($prioridad == 'muy-alta' ? 'warning-light' : 'info-light')}} badge-lg">
                                            <i class="fas fa-clock"></i> {{$diasTranscurridos}} días
                                        </span>
                                    </td>
                                    <td style="text-align: center">
                                        @if($prioridad == 'critica')
                                            <span class="badge badge-danger-light">
                                                <i class="fas fa-exclamation-circle"></i> CRÍTICA
                                            </span>
                                        @elseif($prioridad == 'muy-alta')
                                            <span class="badge badge-warning-light">
                                                <i class="fas fa-exclamation-triangle"></i> MUY ALTA
                                            </span>
                                        @else
                                            <span class="badge badge-info-light">
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
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert text-center">
                            <h4><i class="icon fas fa-check-circle"></i> ¡Excelente trabajo!</h4>
                            <p>No hay tickets con alertas de tiempo. Todos los equipos están siendo procesados dentro del tiempo establecido.</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer text-center">
                    <a href="{{url('/admin/tickets')}}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Volver a Gestión de Tickets
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Colores suavizados para las alertas */
        .table-danger-light { 
            background-color: rgba(248, 215, 218, 0.3) !important; 
            border-left: 4px solid #dc3545;
        }
        .table-warning-light { 
            background-color: rgba(255, 243, 205, 0.3) !important; 
            border-left: 4px solid #ffc107;
        }
        .table-info-light { 
            background-color: rgba(209, 236, 241, 0.3) !important; 
            border-left: 4px solid #17a2b8;
        }
        
        /* Badges con colores suavizados */
        .badge-danger-light {
            background-color: #f8d7da;
            color: #721c24;
        }
        .badge-warning-light {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-info-light {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        .badge-lg {
            font-size: 0.9rem;
            padding: 0.5rem 0.7rem;
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
        
        /* Mejoras para el botón de volver */
        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        
        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }
        
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }
        /* Alerta suavizada para Atención Requerida */
        .alert-warning {
            background-color: #fff !important;              /* Fondo blanco */
            border-left: 5px solid #ffc107 !important;      /* Línea amarilla suave */
            color: #4a4a4a !important;                      /* Texto gris elegante */
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);         /* Sombrita leve */
            padding: 15px 18px;
        }
        .alert-warning h5 {
            color: #856404 !important;                      /* Tono suave para el título */
            font-weight: 700;
        }

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