@extends('adminlte::page')

@section('content_header')
    <h1><b>Tickets Pendientes de Devolución</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Tickets listos para entregar (Reparados o en Baja)</h3>
                    <div class="card-tools">
                        <a href="{{url('/admin/tickets')}}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a Todos
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
                            <h4><i class="fas fa-info-circle"></i> No hay tickets pendientes</h4>
                            <p>Todos los tickets reparados o en baja han sido entregados. <a href="{{url('/admin/tickets')}}">Ver todos los tickets</a>.</p>
                        </div>
                    @else
                    <table id="example2" class="table table-bordered table-hover table-striped table-sm">
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
                                </td>
                                <td>{{$ticket->usuario->hospital->nombre ?? 'N/A'}}</td>
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
                                    <span class="badge badge-warning">{{$ticket->estado_humano}}</span>
                                    <br><small class="text-info">
                                        <i class="fas fa-clock"></i> Pendiente de entrega
                                    </small>
                                </td>
                                <td style="text-align: center">
                                    <div class="btn-group" role="group">
                                        <a href="{{url('/admin/tickets/'.$ticket->id)}}" 
                                           class="btn btn-info btn-sm" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{url('/admin/tickets/'.$ticket->id.'/edit')}}" 
                                           class="btn btn-success btn-sm" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        
                                        {{-- Botón para devolver --}}
                                        <button type="button" class="btn btn-warning btn-sm" 
                                                title="Marcar como devuelto"
                                                onclick="marcarDevuelto({{$ticket->id}}, '{{ addslashes($ticket->descripcion_equipo) }}', '{{ addslashes($ticket->usuario->nombre_completo) }}')">
                                            <i class="fas fa-handshake"></i>
                                        </button>
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

    {{-- Modal para devolución (igual que en index) --}}
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
                            <textarea class="form-control" name="detalle_devolucion" id="detalle_devolucion" rows="2" placeholder="Ej: Entregado en buen estado..."></textarea>
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
    {{-- Mismo CSS que en index --}}
    <style>
        #example2_wrapper .dt-buttons { /* ... igual que index ... */ }
        /* Copia el CSS completo de index.blade.php aquí si es necesario */
    </style>
@stop

@section('js')
    <script>
        $(function () {
            @if(!$tickets->isEmpty())
            $("#example2").DataTable({
                // Configuración igual que en index (copia de index.blade.php)
                "pageLength": 10,
                "language": { /* ... igual ... */ },
                "responsive": true,
                "order": [[ 0, "desc" ]],
                buttons: [ /* ... igual ... */ ]
            }).buttons().container().appendTo('#example2_wrapper .row:eq(0)');
            @endif
        });

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
            $('#detalle_devolucion').val('');
            $('#devolucionModal').modal('show');
        }
        @endif
    </script>
@stop