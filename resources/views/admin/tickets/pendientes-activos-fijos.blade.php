@extends('adminlte::page')

@section('content_header')
    <h1><b>Equipos Pendientes de Entrega a Activos Fijos</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-archive"></i> Equipos dados de baja listos para entregar</h3>
                    <div class="card-tools">
                        <span class="badge badge-warning">{{$tickets->count()}} equipos pendientes</span>
                        <a href="{{url('/admin/tickets')}}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('mensaje'))
                        <div class="alert alert-{{ session('icono') == 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                            {{ session('mensaje') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($tickets->isEmpty())
                        <div class="alert alert-success text-center">
                            <h4><i class="fas fa-check-circle"></i> ¡Todo al día!</h4>
                            <p>No hay equipos dados de baja pendientes de entrega a Activos Fijos.</p>
                            <a href="{{url('/admin/tickets')}}" class="btn btn-primary mt-2">
                                <i class="fas fa-list"></i> Ver todos los tickets
                            </a>
                        </div>
                    @else

                        <table id="tablaPendientesActivosFijos" class="table table-bordered table-hover table-striped table-sm">
                        
                            <tr>
                                <th style="text-align: center">Ticket #</th>
                                <th style="text-align: center">Hospital</th>
                                <th style="text-align: center">Tipo Equipo</th>
                                <th style="text-align: center">Problema Reportado</th>
                                <th style="text-align: center">Motivo de Baja</th>
                                <th style="text-align: center">Fecha Ingreso</th>
                                <th style="text-align: center">Fecha Baja</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                            
                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr class="table-warning-light">
                                    <td style="text-align: center">
                                        <strong>{{$ticket->id}}</strong>  
                                        <br><small class="text-muted">{{$ticket->created_at->format('d/m/Y')}}</small>
                                    </td>
                                    <td>
                                        <strong>{{$ticket->usuario->hospital->nombre ?? 'N/A'}}</strong>
                                        <br><strong>{{$ticket->usuario->nombre_completo}}</strong>
                                        <br><small class="text-muted">{{$ticket->usuario->user->email}}</small>
                                    </td>                   
                                    <td>
                                        <strong>{{$ticket->equipo->nombre}}</strong> <br>
                                         {{Str::limit($ticket->descripcion_equipo, 40)}} <br>
                                        <span class="badge badge-dark badge-lg">{{$ticket->numero_activo}}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted"><strong>Problema:</strong> {{Str::limit($ticket->descripcion_problema, 50)}}</small>
                                    </td>
                                    <td>
                                        @if($ticket->detalle_salida)
                                            <div class="text-danger">
                                                <small><strong>Diagnóstico:</strong></small><br>
                                                {{Str::limit($ticket->detalle_salida, 100)}}
                                            </div>
                                        @else
                                            <span class="text-muted">Sin detalles</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        {{$ticket->fecha_ingreso->format('d/m/Y')}}
                                        <br><small class="text-muted">{{$ticket->fecha_ingreso->diffForHumans()}}</small>
                                    </td>
                                    <td style="text-align: center">
                                        {{$ticket->fecha_salida ? $ticket->fecha_salida->format('d/m/Y') : '-'}}
                                        @if($ticket->fecha_finalizacion)
                                            <br><small class="text-muted">{{$ticket->fecha_finalizacion->format('H:i')}}</small>
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
                                            {{-- mensaje gmail usuario baja --}}
                                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{$ticket->usuario->user->email}}&su=Información sobre su equipo - Ticket {{$ticket->id}}&body=Estimado/a {{$ticket->usuario->nombre_completo}},%0A%0ALamentamos informarle que, tras una revisión exhaustiva, su equipo de cómputo no pudo ser reparado.%0A%0ADetalles del ticket:%0A- Número de Ticket: {{$ticket->id}}%0A- Equipo: {{$ticket->equipo->nombre}} - {{$ticket->descripcion_equipo}}%0A- Número de Activo: {{$ticket->numero_activo}}%0A- Centro de Salud: {{$ticket->usuario->hospital->nombre ?? 'N/A'}}%0A- Diagnóstico: {{$ticket->detalle_salida ?? 'Equipo no reparable'}}%0A%0ADado que no es posible su reparación, el equipo será dado de baja y entregado al Departamento de Activos Fijos para su gestión administrativa correspondiente. Esto significa que ya no estará disponible para su uso, y seguiremos los procedimientos internos para su disposición adecuada.%0A%0ASi tiene alguna pregunta o necesita más información, no dude en contactarnos. Estamos a su disposición para ayudarlo.%0A%0ACon comprensión y apoyo,%0ADepartamento de Sistemas - GAMS" 
                                            target="_blank" 
                                            class="btn btn-primary btn-sm mb-1 notificar-baja-btn"
                                            data-ticket-id="{{ $ticket->id }}"
                                            title="Notificar baja al usuario">
                                                <i class="fas fa-envelope"></i> Mensaje
                                            </a>
                                            
                                            <button type="button" class="btn btn-warning btn-sm" 
                                                    title="Entregar a Activos Fijos"
                                                    onclick="marcarEntregadoActivosFijos(
                                                            {{$ticket->id}}, 
                                                            '{{ addslashes($ticket->equipo->nombre) }}',
                                                            '{{ addslashes($ticket->descripcion_equipo) }}',
                                                            '{{ addslashes($ticket->numero_activo) }}',
                                                            '{{ addslashes($ticket->usuario->hospital->nombre ?? 'N/A') }}'
                                                        )">
                                                <i class="fas fa-archive"></i> Entregar/A.F.
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="card-footer bg-light">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="mb-0 text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Los equipos dados de baja deben ser entregados al Departamento de Activos Fijos para su registro y disposición final.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     {{-- MODAL ENTREGAR A ACTIVOS FIJOS --}}
        <div class="modal fade" id="entregaActivosFijosModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border border-warning shadow-sm rounded-3">
                    <form id="entregaActivosFijosForm" method="POST">
                        @csrf
                        <div class="modal-header border-0 bg-light">
                            <h5 class="modal-title text-warning">
                                <i class="fas fa-archive me-1"></i> Entregar a Activos Fijos
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-warning bg-white border border-warning text-center">
                                <h6 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle"></i> Equipo Dado de Baja</h6>
                                <div id="modal-texto-activos-fijos" class="text-muted small"></div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="detalle_entrega" class="text-muted">Observaciones (opcional):</label>
                                <textarea class="form-control" name="detalle_entrega" id="detalle_entrega" rows="2" placeholder="Ej: Equipo obsoleto o sin reparación posible..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0 justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning text-dark">
                                <i class="fas fa-archive"></i> Confirmar Entrega
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@stop

@section('css')
    <style>
        .table-warning-light { 
            background-color: rgba(255, 243, 205, 0.3) !important; 
            border-left: 4px solid #ffc107;
        }
        
        .badge-lg {
            font-size: 0.9rem;
            padding: 0.5rem 0.7rem;
        }
        
        .btn-group-vertical .btn {
            margin-bottom: 2px;
        }
        
        #tablaPendientesActivosFijos_wrapper .dt-buttons {
            background-color: transparent;
            box-shadow: none;
            border: none;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        #tablaPendientesActivosFijos_wrapper .btn {
            color: #fff;
            border-radius: 4px;
            padding: 5px 15px;
            font-size: 14px;
        }

        .btn-danger { background-color: #dc3545; border: none; }
        .btn-success { background-color: #28a745; border: none; }
        .btn-info { background-color: #17a2b8; border: none; }
        .btn-warning { background-color: #ffc107; color: #212529; border: none; }
    </style>
@stop

@section('js')
    <script>
    $(function () {
        @if(!$tickets->isEmpty())
        $("#tablaPendientesActivosFijos").DataTable({
            "pageLength": 15,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Equipos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Equipos",
                "infoFiltered": "(Filtrado de _MAX_ total Equipos)",
                "lengthMenu": "Mostrar _MENU_ Equipos",
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
            "order": [[ 8, "asc" ]], // Ordenar por fecha de baja (más antiguos primero)
            buttons: [
                { text: '<i class="fas fa-file-pdf"></i> PDF', extend: 'pdf', className: 'btn btn-danger' },
                { text: '<i class="fas fa-file-excel"></i> EXCEL', extend: 'excel', className: 'btn btn-success' },
                { text: '<i class="fas fa-print"></i> IMPRIMIR', extend: 'print', className: 'btn btn-info' }
            ]
        }).buttons().container().appendTo('#tablaPendientesActivosFijos_wrapper .row:eq(0)');
        @endif
    });

    function marcarEntregadoActivosFijos(ticketId, tipoEquipo, descripcionEquipo, numeroActivo, nombreHospital) {
        $('#entregaActivosFijosForm').attr('action', '/admin/tickets/' + ticketId + '/entregado-activos-fijos');
        $('#modal-texto-activos-fijos').html(`
            <p><strong>Ticket:</strong> #${ticketId}</p>
            <p><strong>Equipo:</strong> ${tipoEquipo} - ${descripcionEquipo}</p>
            <p><strong>N° Activo:</strong> ${numeroActivo}</p>
            <p><strong>Centro Salud:</strong> ${nombreHospital}</p>
            <p class="mb-0 text-danger"><strong>Este equipo dado de baja será entregado al Departamento de Activos Fijos</strong></p>
        `);
        $('#detalle_entrega').val('');
        $('#entregaActivosFijosModal').modal('show');
    }

    $(document).ready(function() {
        // Verificar notificaciones de BAJA guardadas al cargar la página
        $('.notificar-baja-btn').each(function() {
            const ticketId = $(this).data('ticket-id');
            if (localStorage.getItem('notificado_baja_' + ticketId)) {
                $(this).replaceWith(`
                    <button class="btn btn-success btn-sm mb-1" title="Baja notificada al usuario">
                        <i class="fas fa-check-circle"></i> Notificado
                    </button>
                `);
            }
        });

        // Marcar como notificado BAJA cuando se hace clic
        $(document).on('click', '.notificar-baja-btn', function(e) {
            const ticketId = $(this).data('ticket-id');
            const btn = $(this);
            
            console.log('Marcando ticket ' + ticketId + ' como notificado (baja)');
            
            // Guardar en localStorage inmediatamente con clave diferente
            localStorage.setItem('notificado_baja_' + ticketId, 'true');
            
            // Cambiar el botón después de un breve delay (1 segundo)
            setTimeout(() => {
                btn.replaceWith(`
                    <button class="btn btn-success btn-sm mb-1" title="Baja notificada al usuario">
                        <i class="fas fa-check-circle"></i> Notificado
                    </button>
                `);
            }, 1000);
        });
    });
</script>
@stop