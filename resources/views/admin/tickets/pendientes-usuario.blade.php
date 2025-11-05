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
                        <div class="alert alert-success">
                            <h5><i class="fas fa-check-circle"></i> Equipos Reparados</h5>
                            <p class="mb-0">Los siguientes equipos han sido reparados exitosamente y están listos para ser devueltos a sus respectivos usuarios.</p>
                        </div>

                        <table id="tablaPendientesUsuario" class="table table-bordered table-hover table-striped table-sm">
                            <thead class="thead-dark">
                            <tr>
                                <th style="text-align: center">Ticket #</th>
                                <th style="text-align: center">Hospital</th>
                                <th style="text-align: center">Usuario</th>
                                <th style="text-align: center">Tipo Equipo</th>
                                <th style="text-align: center">N° Activo</th>
                                <th style="text-align: center">Descripción</th>
                                <th style="text-align: center">Solución Aplicada</th>
                                <th style="text-align: center">Fecha Ingreso</th>
                                <th style="text-align: center">Fecha Reparación</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr class="table-success-light">
                                    <td style="text-align: center">
                                        <strong>{{str_pad($ticket->id, 6, '0', STR_PAD_LEFT)}}</strong>
                                        <br><small class="text-muted">{{$ticket->created_at->format('d/m/Y')}}</small>
                                    </td>
                                    <td>
                                        <strong>{{$ticket->usuario->hospital->nombre ?? 'N/A'}}</strong>
                                        <br><small class="text-muted">{{$ticket->usuario->hospital->tipo ?? ''}}</small>
                                    </td>
                                    <td>
                                        <strong>{{$ticket->usuario->nombre_completo}}</strong>
                                        <br><small class="text-primary">{{ucfirst($ticket->usuario->cargo)}}</small>
                                        <br><small class="text-muted">{{$ticket->usuario->user->email}}</small>
                                    </td>
                                    <td>
                                        <strong>{{$ticket->equipo->nombre}}</strong>
                                    </td>
                                    <td style="text-align: center">
                                        <span class="badge badge-success badge-lg">{{$ticket->numero_activo}}</span>
                                    </td>
                                    <td>
                                        {{Str::limit($ticket->descripcion_equipo, 40)}}
                                        <br><small class="text-muted"><strong>Problema:</strong> {{Str::limit($ticket->descripcion_problema, 50)}}</small>
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
                                            
                                            <button type="button" class="btn btn-success btn-sm" 
                                                    title="Devolver al usuario"
                                                    onclick="marcarDevueltoUsuario({{$ticket->id}}, '{{ addslashes($ticket->descripcion_equipo) }}', '{{ addslashes($ticket->usuario->nombre_completo) }}', '{{$ticket->numero_activo}}')">
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="devolucionUsuarioForm" method="POST">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-user-check"></i> Confirmar Devolución al Usuario
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle"></i> Equipo Reparado</h6>
                            <p id="modal-texto-usuario">Confirmación de devolución</p>
                        </div>
                        <div class="alert alert-info">
                            <small>
                                <strong>Importante:</strong> Al confirmar, el equipo será marcado como devuelto al usuario y se generará un comprobante de entrega que puede ser impreso.
                            </small>
                        </div>
                        <div class="form-group mt-3">
                            <label for="detalle_devolucion">Observaciones adicionales (opcional):</label>
                            <textarea class="form-control" name="detalle_devolucion" id="detalle_devolucion" rows="3" 
                                      placeholder="Ej: Entregado en buen estado, usuario capacitado en el uso, etc."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Confirmar Devolución al Usuario
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

        function marcarDevueltoUsuario(ticketId, descripcionEquipo, nombreUsuario, numeroActivo) {
            const numeroTicket = String(ticketId).padStart(6, '0');
            $('#devolucionUsuarioForm').attr('action', '/admin/tickets/' + ticketId + '/devuelto-usuario');
            $('#modal-texto-usuario').html(`
                <p><strong>Ticket:</strong> #${numeroTicket}</p>
                <p><strong>N° Activo:</strong> ${numeroActivo}</p>
                <p><strong>Equipo:</strong> ${descripcionEquipo}</p>
                <p><strong>Usuario:</strong> ${nombreUsuario}</p>
                <p class="mb-0 text-success"><strong>Este equipo reparado será devuelto al usuario</strong></p>
            `);
            $('#detalle_devolucion').val('');
            $('#devolucionUsuarioModal').modal('show');
        }
    </script>
@stop