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
                            <a href="{{url('/admin/tickets-pendientes')}}" class="btn btn-warning">
                                <i class="fas fa-clock"></i> Pendientes Devolución
                            </a>
                            <a href="{{url('/admin/tickets-alerta-tiempo')}}" class="btn btn-danger">
                                <i class="fas fa-exclamation-triangle"></i> Alertas de Tiempo
                            </a>
                            <a href="{{url('/admin/tickets-dashboard')}}" class="btn btn-info">
                                <i class="fas fa-chart-bar"></i> Dashboard
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    {{-- Mensajes de sesión (éxito/error) --}}
                    @if (session('mensaje'))
                        <div class="alert alert-{{ session('icono') == 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                            {{ session('mensaje') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Mensaje si no hay tickets (especial para usuarios normales) --}}
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
                            <th style="text-align: center">Usuario</th>
                            <th style="text-align: center">Tipo Equipo</th>
                            <th style="text-align: center">N° Activo</th>
                            <th style="text-align: center">Descripción</th>
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
                                    <strong>{{str_pad($ticket->id, 6, '0', STR_PAD_LEFT)}}</strong>
                                    {!! $ticket->icono_alerta !!}
                                </td>
                                <td>{{$ticket->hospital->nombre ?? 'N/A'}}</td>
                                <td>{{$ticket->usuario->nombre_completo}}</td>
                                <td>{{$ticket->equipo->nombre}}</td>
                                <td style="text-align: center">
                                    <span class="badge badge-secondary">{{$ticket->numero_activo}}</span>
                                </td>
                                <td>{{Str::limit($ticket->descripcion_equipo, 40)}}</td>
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
                                    @if($ticket->estado == 'devuelto')
                                        <br><small class="text-success">
                                            <i class="fas fa-check"></i> Entregado
                                        </small>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    <div class="btn-group" role="group">
                                        {{-- Botón Ver detalles (siempre visible para todos) --}}
                                        <a href="{{url('/admin/tickets/'.$ticket->id)}}" 
                                           class="btn btn-info btn-sm" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        {{-- Para roles admin/tecnico/pasante: Editar, Aceptar, Devolver --}}
                                        @if(auth()->user()->hasAnyRole(['administrador', 'tecnico', 'pasante']))
                                            <a href="{{url('/admin/tickets/'.$ticket->id.'/edit')}}" 
                                               class="btn btn-success btn-sm" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            
                                            {{-- Botón para aceptar tickets en espera --}}
                                            @if($ticket->estado == 'en_espera')
                                                <a href="{{url('/admin/tickets/'.$ticket->id.'/aceptar')}}" 
                                                   class="btn btn-primary btn-sm" title="Aceptar ticket"
                                                   onclick="return confirm('¿Está seguro de aceptar este ticket?')">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @endif
                                            
                                            {{-- Botón para devolver (solo si reparado o baja) --}}
                                            @if(in_array($ticket->estado, ['reparado', 'baja']) && $ticket->estado != 'devuelto')
                                                <button type="button" class="btn btn-warning btn-sm" 
                                                        title="Marcar como devuelto"
                                                        onclick="marcarDevuelto({{$ticket->id}}, '{{ addslashes($ticket->descripcion_equipo) }}', '{{ addslashes($ticket->usuario->nombre_completo) }}')">
                                                    <i class="fas fa-handshake"></i>
                                                </button>
                                            @endif
                                        @endif
                                        
                                        {{-- Para rol usuario: Solo mostrar Comprobante si devuelto --}}
                                        @if(auth()->user()->hasRole('usuario') && $ticket->estado == 'devuelto')
                                            <a href="{{url('/admin/tickets/'.$ticket->id.'/comprobante')}}" 
                                               class="btn btn-primary btn-sm" title="Ver/Imprimir Comprobante" target="_blank">
                                                <i class="fas fa-print"></i> Comprobante
                                            </a>
                                        @endif
                                        
                                        {{-- Para roles admin/tecnico/pasante: Comprobante si devuelto --}}
                                        @if(auth()->user()->hasAnyRole(['administrador', 'tecnico', 'pasante']) && $ticket->estado == 'devuelto')
                                            <a href="{{url('/admin/tickets/'.$ticket->id.'/comprobante')}}" 
                                               class="btn btn-primary btn-sm" title="Ver/Imprimir Comprobante" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                           
                                        @endif
                                        
                                        {{-- Eliminar solo para admin --}}
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
                                        @endif
                                    </div>

                                    {{-- Script para confirmar eliminación (solo admin, por ticket) --}}
                                    @if(auth()->user()->hasRole('administrador'))
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

    {{-- Modal para marcar como devuelto: SOLO para roles con permiso (evita error para usuarios normales) --}}
    @if(auth()->user()->hasAnyRole(['administrador', 'tecnico', 'pasante']))
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
                            <p id="modal-texto">¿Está seguro de marcar este equipo como devuelto al usuario?</p>
                        </div>
                        <div class="form-group mt-3">
                            <label for="detalle_devolucion">Detalle adicional (opcional):</label>
                            <textarea class="form-control" name="detalle_devolucion" id="detalle_devolucion" rows="2" placeholder="Ej: Entregado en buen estado, usuario capacitado..."></textarea>
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
        .btn-default { background-color: #6e7176; color: #212529; border: none; }
        
        .badge {
            font-size: 0.8rem;
        }
        
        .text-danger {
            color: #dc3545 !important;
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

        {{-- JS para modal: SOLO para roles con permiso --}}

        
        @if(auth()->user()->hasAnyRole(['administrador', 'tecnico', 'pasante']))
        function marcarDevuelto(ticketId, descripcionEquipo, nombreUsuario) {
            const numeroTicket = String(ticketId).padStart(6, '0');
            $('#devolucionForm').attr('action', '/admin/tickets/' + ticketId + '/devuelto');
            $('#modal-texto').html(`
                                <p>¿Está seguro de marcar este equipo como devuelto al usuario?</p>
                <p><strong>Ticket:</strong> #${numeroTicket}</p>
                <p><strong>Equipo:</strong> ${descripcionEquipo}</p>
                <p><strong>Usuario:</strong> ${nombreUsuario}</p>
            `);
            // Limpiar el campo de detalle cada vez que se abre el modal
            $('#detalle_devolucion').val('');
            $('#devolucionModal').modal('show');
        }
        @endif
    </script>
@stop

               
                