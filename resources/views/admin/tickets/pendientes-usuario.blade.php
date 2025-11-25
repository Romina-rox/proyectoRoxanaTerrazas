@extends('adminlte::page')

@section('content_header')
    <h1><b>Equipos Pendientes de Devolución al Usuario</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-check"></i> Equipos reparados listos para entregar</h3>
                    <div class="card-tools">
                        <span class="badge badge-success">{{$tickets->count()}} equipos pendientes</span>
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
                        <div class="alert alert-info text-center">
                            <h4><i class="fas fa-check-circle"></i> ¡Todo entregado!</h4>
                            <p>No hay equipos reparados pendientes de devolución a los usuarios.</p>
                            <a href="{{url('/admin/tickets')}}" class="btn btn-primary mt-2">
                                <i class="fas fa-list"></i> Ver todos los tickets
                            </a>
                        </div>
                    @else
                       

                        <table id="tablaPendientesUsuario" class="table table-bordered table-hover table-striped table-sm">
                           
                            <tr>
                                <th style="text-align: center">Ticket #</th>
                                <th style="text-align: center">Hospital</th>
        
                                <th style="text-align: center">Tipo Equipo</th>
                                <th style="text-align: center">Problema reportado</th>
                                <th style="text-align: center">Solución Aplicada</th>
                                <th style="text-align: center">Fecha Ingreso</th>
                                <th style="text-align: center">Fecha Reparación</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                            
                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr class="table-success-light">
                                    <td style="text-align: center">
                                        <strong>{{str_pad($ticket->id, 6)}}</strong>
                                        <br><small class="text-muted">{{$ticket->created_at->format('d/m/Y')}}</small>
                                    </td>
                                    <td>
                                        <strong>{{$ticket->usuario->hospital->nombre ?? 'N/A'}}</strong>
                                        <br><strong>{{$ticket->usuario->nombre_completo}}</strong>
                                        <br><small class="text-muted">{{$ticket->usuario->user->email}}</small>
                                    </td>
                                    <td>
                                        <strong>{{$ticket->equipo->nombre}}</strong> <br>
                                        {{Str::limit($ticket->descripcion_equipo, 40)}}
                                        <span class="badge badge-success badge-lg">{{$ticket->numero_activo}}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted"><strong>Problema:</strong> {{Str::limit($ticket->descripcion_problema, 50)}}</small>
                                    </td>
                                    <td>
                                        @if($ticket->detalle_salida)
                                            <div class="text-success">
                                                <small><strong>Reparación:</strong></small><br>
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
                                               class="btn btn-warning btn-sm mb-1" title="Editar">
                                                <i class="fas fa-pencil-alt"></i> Editar
                                            </a>
                                          {{-- Enviar mensaje por Gmail usuario --}}
                                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $ticket->usuario->user->email }}&body=Estimado {{ addslashes($ticket->usuario->nombre_completo) }},%0A%0A Nos complace informarle que su {{ $ticket->equipo->nombre }} ha sido resuelto exitosamente.%0A%0ADetalles del ticket:%0A- Número de Ticket: {{ $ticket->id }}%0A- Equipo: {{ $ticket->equipo->nombre }} - {{$ticket->descripcion_equipo}}%0A- Número de Activo: {{$ticket->numero_activo}}%0A- Centro de Salud: {{$ticket->usuario->hospital->nombre ?? 'N/A'}}%0A%0AEstado actual: {{ $ticket->estado_humano }}.%0A%0A{{ $ticket->fecha_salida ? 'Fecha de salida: ' . $ticket->fecha_salida->format('d/m/Y') : 'Aún en proceso.' }}%0A%0ASu equipo de cómputo está listo para ser devuelto. Le invitamos a pasar por nuestras oficinas dentro del hospital, Departamento de Sistemas, para recogerlo en el horario de atención de 08:00 a 18:00 horas. Si prefiere, podemos coordinar una entrega o responder cualquier duda que tenga.%0A%0AAtentamente,%0ADepartamento de Sistemas - GAMS" 
                                            target="_blank" 
                                            class="btn btn-primary btn-sm mb-1 notificar-btn"
                                            data-ticket-id="{{ $ticket->id }}"
                                            title="Notificar reparación al usuario">
                                                <i class="fas fa-envelope"></i> Mensaje 
                                            </a>

                                            
                                            <button type="button" class="btn btn-success btn-sm" 
                                                    title="Devolver al usuario"
                                                    onclick="marcarDevueltoUsuario(
                                                        {{$ticket->id}}, 
                                                        '{{ addslashes($ticket->equipo->nombre) }}',
                                                        '{{ addslashes($ticket->descripcion_equipo) }}', 
                                                        '{{ addslashes($ticket->numero_activo) }}',
                                                        '{{ addslashes($ticket->usuario->hospital->nombre ?? 'N/A') }}',
                                                        '{{ addslashes($ticket->usuario->nombre_completo) }}'
                                                    )">
                                                <i class="fas fa-user-check"></i> Devolver
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
                                Los equipos reparados deben ser devueltos a sus respectivos usuarios. Recuerde generar el comprobante de entrega.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DEVOLVER AL USUARIO --}}
        <div class="modal fade" id="devolucionUsuarioModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border border-success shadow-sm rounded-3">
                    <form id="devolucionUsuarioForm" method="POST">
                        @csrf
                        <div class="modal-header border-0 bg-light">
                            <h5 class="modal-title text-success">
                                <i class="fas fa-user-check me-1"></i> Devolver al Usuario
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-success bg-white border border-success text-center">
                                <h6 class="fw-bold mb-2"><i class="fas fa-check-circle"></i> Equipo Reparado</h6>
                                <div id="modal-texto-usuario" class="text-muted small"></div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="detalle_devolucion" class="text-muted">Detalle adicional (opcional):</label>
                                <textarea class="form-control" name="detalle_devolucion" id="detalle_devolucion" rows="2" placeholder="Ej: Entregado en buenas condiciones..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0 justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Confirmar Devolución
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@stop

@section('css')
    <style>
        .table-success-light { 
            background-color: rgba(212, 237, 218, 0.3) !important; 
            border-left: 4px solid #28a745;
        }
        
        .badge-lg {
            font-size: 0.9rem;
            padding: 0.5rem 0.7rem;
        }
        
        .btn-group-vertical .btn {
            margin-bottom: 2px;
        }
        
        #tablaPendientesUsuario_wrapper .dt-buttons {
            background-color: transparent;
            box-shadow: none;
            border: none;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        #tablaPendientesUsuario_wrapper .btn {
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
            $("#tablaPendientesUsuario").DataTable({
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
                "order": [[ 8, "asc" ]], // Ordenar por fecha de reparación (más antiguos primero)
                buttons: [
                    { text: '<i class="fas fa-file-pdf"></i> PDF', extend: 'pdf', className: 'btn btn-danger' },
                    { text: '<i class="fas fa-file-excel"></i> EXCEL', extend: 'excel', className: 'btn btn-success' },
                    { text: '<i class="fas fa-print"></i> IMPRIMIR', extend: 'print', className: 'btn btn-info' }
                ]
            }).buttons().container().appendTo('#tablaPendientesUsuario_wrapper .row:eq(0)');
            @endif
        });

       $(document).ready(function() {
            // Verificar notificaciones guardadas al cargar la página
            $('.notificar-btn').each(function() {
                const ticketId = $(this).data('ticket-id');
                if (localStorage.getItem('notificado_' + ticketId)) {
                    $(this).replaceWith(`
                        <button class="btn btn-success btn-sm mb-1" title="Ya notificado al usuario">
                            <i class="fas fa-check-circle"></i> Notificado
                        </button>
                    `);
                }
            });

            // Marcar como notificado cuando se hace clic
            $(document).on('click', '.notificar-btn', function(e) {
                const ticketId = $(this).data('ticket-id');
                const btn = $(this);
                
                console.log('Marcando ticket ' + ticketId + ' como notificado');
                
                // Guardar en localStorage inmediatamente
                localStorage.setItem('notificado_' + ticketId, 'true');
                
                // Cambiar el botón después de un breve delay (1 segundo)
                setTimeout(() => {
                    btn.replaceWith(`
                        <button class="btn btn-success btn-sm mb-1" title="Notificado al usuario">
                            <i class="fas fa-check-circle"></i> Notificado
                        </button>
                    `);
                }, 1000);
            });
        });

        function marcarDevueltoUsuario(ticketId, tipoEquipo, descripcionEquipo, numeroActivo, nombreHospital, nombreUsuario) {
            $('#devolucionUsuarioForm').attr('action', '/admin/tickets/' + ticketId + '/devuelto-usuario');
            $('#modal-texto-usuario').html(`
                <p><strong>Ticket:</strong> #${ticketId}</p>
                <p><strong>Equipo:</strong> ${tipoEquipo} - ${descripcionEquipo}</p>
                <p><strong>Nº Activo:</strong> ${numeroActivo}</p>
                <p><strong>Centro Salud:</strong> ${nombreHospital}</p>
                <p><strong>Usuario:</strong> ${nombreUsuario}</p>
                <p class="mb-0">Este equipo será marcado como <strong>REPARADO Y DEVUELTO AL USUARIO</strong></p>
            `);
            $('#detalle_devolucion').val('');
            $('#devolucionUsuarioModal').modal('show');
        }
    </script>
@stop