@extends('adminlte::page')

@section('content_header')
    <h1><b>Gestión de Tickets de Reparación</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tickets registrados</h3>

                    <div class="card-tools">
                        @if(auth()->user()->hasRole('usuario'))
                            <a href="{{url('/admin/tickets/create')}}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Nuevo Ticket
                            </a>
                        @endif
                        @if(auth()->user()->hasAnyRole(['administrador', 'tecnico', 'pasante']))
                            <a href="{{url('/admin/tickets-pendientes-usuario')}}" class="btn btn-success">
                                <i class="fas fa-user-check"></i> Pendientes Usuario
                            </a>
                            <a href="{{url('/admin/tickets-pendientes-activos-fijos')}}" class="btn btn-warning">
                                <i class="fas fa-archive"></i> Pendientes Activos Fijos
                            </a>
                            <a href="{{url('/admin/tickets-alerta-tiempo')}}" class="btn btn-danger">
                                <i class="fas fa-exclamation-triangle"></i> Alertas
                            </a>
                            <a href="{{url('/admin/tickets-historial')}}" class="btn btn-info">
                                <i class="fas fa-history"></i> Historial
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if (session('mensaje'))
                        <div class="alert alert-{{ session('icono') == 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                            {{ session('mensaje') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(auth()->user()->hasRole('usuario') && $tickets->isEmpty())
                        <div class="alert alert-info text-center">
                            <h4><i class="fas fa-info-circle"></i> No hay tickets</h4>
                            <p>No has registrado ningún ticket aún. <a href="{{url('/admin/tickets/create')}}">Crea uno ahora</a> para reportar un equipo con problemas.</p>
                        </div>
                    @endif

                    @if(!$tickets->isEmpty())
                    <table id="example1" class="table table-bordered table-hover table-striped table-sm">
                        <thead>
                        <tr>
                            <th style="text-align: center">Ticket #</th>
                            <th style="text-align: center">Hospital</th>
                            <th style="text-align: center">Tipo Equipo</th>
                            <th style="text-align: center">Nº Activo</th>
                            <th style="text-align: center">Fecha Ingreso</th>
                            <th style="text-align: center">Fecha Salida</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                        </thead>

                        <tbody>
                            
                        @foreach($tickets as $ticket)
                            <tr>
                                <td style="text-align: center">
                                   <strong>{{str_pad($ticket->id, 6)}}</strong>
                                     {!! $ticket->icono_alerta !!}
                                </td>
                               
                                <td>
                                    <div style="text-align: center;">
                                        <strong>{{$ticket->hospital->nombre ?? 'N/A'}}</strong><br>
                                        <small class="text-muted">{{$ticket->usuario->nombre_completo}}</small>
                                    </div>
                                </td>
                                <td>
                                    <div style="text-align: center">
                                        <strong>{{$ticket->equipo->nombre}}</strong><br>
                                        <small class="text-muted">{{Str::limit($ticket->descripcion_equipo, 40)}}</small> 
                                    </div>  
                                </td>
                                <td style="text-align: center">
                                    <span class="badge badge-secondary">{{$ticket->numero_activo}}</span>
                                </td>
                                <td style="text-align: center">{{$ticket->fecha_ingreso->format('d/m/Y')}}</td>
                                <td style="text-align: center">
                                    {{$ticket->fecha_salida ? $ticket->fecha_salida->format('d/m/Y') : '-'}}
                                </td>
                                <td style="text-align: center">
                                    <span class="badge badge-{{$ticket->estado_color}}">
                                        {{$ticket->estado_humano}}
                                    </span>
                                    @if($ticket->alerta_tiempo && $ticket->estado == 'aceptado')
                                        <br><small class="text-danger">
                                            <i class="fas fa-clock"></i> {{$ticket->dias_transcurridos}} días
                                        </small>
                                    @endif
                                    {{-- Indicadores específicos --}}
                                    @if($ticket->estado == 'devuelto_usuario')
                                        <br><small class="text-success">
                                            <i class="fas fa-check"></i> Reparado y Entregado
                                        </small>
                                    @endif

                                    @if($ticket->estado == 'aceptado')
                                        <br><small class="text-success">
                                            <i class="fas fa-wrench"></i> en-reparacion
                                        </small>
                                    @endif

                                    @if($ticket->estado == 'entregado_activos_fijos')
                                        <br><small class="text-red">
                                            <i class="fas fa-archive"></i> baja
                                        </small>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    <div class="btn-group" role="group">
                                        <a href="{{url('/admin/tickets/'.$ticket->id)}}" 
                                           class="btn btn-info btn-sm" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if(auth()->user()->hasAnyRole(['administrador', 'tecnico', 'pasante']))
                                            <a href="{{url('/admin/tickets/'.$ticket->id.'/edit')}}" 
                                               class="btn btn-success btn-sm" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            
                                            @if($ticket->estado == 'en_espera')
                                                <a href="{{url('/admin/tickets/'.$ticket->id.'/aceptar')}}" 
                                                   class="btn btn-primary btn-sm" title="Aceptar ticket"
                                                   onclick="return confirm('¿Está seguro de aceptar este ticket?')">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @endif
                                            
                                            {{-- Botón devolver AL USUARIO (solo reparados) --}}
                                            @if($ticket->estado == 'reparado')
                                                <button type="button" class="btn btn-success btn-sm" 
                                                        title="Devolver al usuario"
                                                        onclick="marcarDevueltoUsuario({{$ticket->id}}, '{{ addslashes($ticket->descripcion_equipo) }}', '{{ addslashes($ticket->usuario->nombre_completo) }}')">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            @endif
                                            
                                            {{-- Botón entregar A ACTIVOS FIJOS (solo bajas) --}}
                                            @if($ticket->estado == 'baja')
                                                <button type="button" class="btn btn-warning btn-sm" 
                                                        title="Entregar a Activos Fijos"
                                                        onclick="marcarEntregadoActivosFijos({{$ticket->id}}, '{{ addslashes($ticket->descripcion_equipo) }}')">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                            @endif
                                        @endif
                                        
                                        {{-- Comprobantes SEPARADOS --}}
                                        @if(auth()->user()->hasRole('usuario') && $ticket->estado == 'devuelto_usuario')
                                            <a href="{{url('/admin/tickets/'.$ticket->id.'/comprobante-usuario')}}" 
                                               class="btn btn-primary btn-sm" title="Comprobante" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        @endif
                                        
                                        @if(auth()->user()->hasAnyRole(['administrador', 'tecnico', 'pasante']))
                                            @if($ticket->estado == 'devuelto_usuario')
                                                <a href="{{url('/admin/tickets/'.$ticket->id.'/comprobante-usuario')}}" 
                                                   class="btn btn-primary btn-sm" title="Comprobante Usuario" target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            @endif
                                            @if($ticket->estado == 'entregado_activos_fijos')
                                                <a href="{{url('/admin/tickets/'.$ticket->id.'/comprobante-activos-fijos')}}" 
                                                   class="btn btn-warning btn-sm" title="Comprobante A.F." target="_blank">
                                                    <i class="fas fa-file-archive"></i>
                                                </a>
                                            @endif
                                        @endif
                                        
                                        @if(auth()->user()->hasRole('administrador'))
                                            <form action="{{url('/admin/tickets/'.$ticket->id)}}" method="post"
                                                  class="d-inline" onclick="preguntar{{$ticket->id}}(event)" 
                                                  id="miFormulario{{$ticket->id}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <script>
                                                function preguntar{{$ticket->id}}(event) {
                                                    event.preventDefault();
                                                    Swal.fire({
                                                        title: '¿Desea eliminar este ticket?',
                                                        text: 'Esta acción no se puede deshacer',
                                                        icon: 'question',
                                                        showDenyButton: true,
                                                        confirmButtonText: 'Eliminar',
                                                        confirmButtonColor: '#a5161d',
                                                        denyButtonColor: '#270a0a',
                                                        denyButtonText: 'Cancelar',
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            $('#miFormulario{{$ticket->id}}').off('submit').submit();
                                                        }
                                                    });
                                                }
                                            </script>
                                        @endif
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

    {{-- MODAL DEVOLVER AL USUARIO --}}
    @if(auth()->user()->hasAnyRole(['administrador', 'tecnico', 'pasante']))
    <div class="modal fade" id="devolucionUsuarioModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="devolucionUsuarioForm" method="POST">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="fas fa-user-check"></i> Devolver al Usuario</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle"></i> Equipo Reparado</h6>
                            <p id="modal-texto-usuario">Confirmación de devolución al usuario</p>
                        </div>
                        <div class="form-group mt-3">
                            <label for="detalle_devolucion">Detalle adicional (opcional):</label>
                            <textarea class="form-control" name="detalle_devolucion" id="detalle_devolucion" rows="2" placeholder="Ej: Entregado en buen estado..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Confirmar Devolución al Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL ENTREGAR A ACTIVOS FIJOS --}}
    <div class="modal fade" id="entregaActivosFijosModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="entregaActivosFijosForm" method="POST">
                    @csrf
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title"><i class="fas fa-archive"></i> Entregar a Activos Fijos</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle"></i> Equipo Dado de Baja</h6>
                            <p id="modal-texto-activos-fijos">Confirmación de entrega a Activos Fijos</p>
                        </div>
                        <div class="form-group mt-3">
                            <label for="detalle_entrega">Observaciones (opcional):</label>
                            <textarea class="form-control" name="detalle_entrega" id="detalle_entrega" rows="2" placeholder="Ej: Equipo obsoleto, sin reparación..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Confirmar Entrega a Activos Fijos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@stop

@section('css')
    <style>
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
        .btn-default { background-color: #6e7176; color: #fff; border: none; }
        
        .badge {
            font-size: 0.8rem;
        }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            @if(!$tickets->isEmpty())
            $("#example1").DataTable({
                "pageLength": 10,
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
                "order": [[ 0, "desc" ]],
                buttons: [
                    { text: '<i class="fas fa-copy"></i> COPIAR', extend: 'copy', className: 'btn btn-default' },
                    { text: '<i class="fas fa-file-pdf"></i> PDF', extend: 'pdf', className: 'btn btn-danger' },
                    { text: '<i class="fas fa-file-csv"></i> CSV', extend: 'csv', className: 'btn btn-info' },
                    { text: '<i class="fas fa-file-excel"></i> EXCEL', extend: 'excel', className: 'btn btn-success' },
                    { text: '<i class="fas fa-print"></i> IMPRIMIR', extend: 'print', className: 'btn btn-warning' }
                ]
            }).buttons().container().appendTo('#example1_wrapper .row:eq(0)');
            @endif
        });

        @if(auth()->user()->hasAnyRole(['administrador', 'tecnico', 'pasante']))
        function marcarDevueltoUsuario(ticketId, descripcionEquipo, nombreUsuario) {
            const numeroTicket = String(ticketId).padStart(6, '0');
            $('#devolucionUsuarioForm').attr('action', '/admin/tickets/' + ticketId + '/devuelto-usuario');
            $('#modal-texto-usuario').html(`
                <p><strong>Ticket:</strong> #${numeroTicket}</p>
                <p><strong>Equipo:</strong> ${descripcionEquipo}</p>
                <p><strong>Usuario:</strong> ${nombreUsuario}</p>
                <p class="mb-0">Este equipo será marcado como <strong>REPARADO Y DEVUELTO AL USUARIO</strong></p>
            `);
            $('#detalle_devolucion').val('');
            $('#devolucionUsuarioModal').modal('show');
        }

        function marcarEntregadoActivosFijos(ticketId, descripcionEquipo) {
            const numeroTicket = String(ticketId).padStart(6, '0');
            $('#entregaActivosFijosForm').attr('action', '/admin/tickets/' + ticketId + '/entregado-activos-fijos');
            $('#modal-texto-activos-fijos').html(`
                <p><strong>Ticket:</strong> #${numeroTicket}</p>
                <p><strong>Equipo:</strong> ${descripcionEquipo}</p>
                <p class="mb-0">Este equipo será marcado como <strong>DADO DE BAJA Y ENTREGADO A ACTIVOS FIJOS</strong></p>
            `);
            $('#detalle_entrega').val('');
            $('#entregaActivosFijosModal').modal('show');
        }
        @endif
    </script>
@stop