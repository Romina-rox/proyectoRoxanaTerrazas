@extends('adminlte::page')

@section('content_header')
    <h1><b><i class="fas fa-history"></i> Historial de Equipos</b></h1>
    <hr>
@stop

@section('content')
    <!-- FORMULARIO DE BÚSQUEDA -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-search"></i> Buscar Equipo por Número de Activo o Hospital</h3>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{url('/admin/tickets-historial')}}">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Número de Activo:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                        </div>
                                        <input type="text" name="numero_activo" class="form-control" 
                                               value="{{request('numero_activo')}}" 
                                               placeholder="Ej: ACT-001234">
                                    </div>
                                    <small class="text-muted">Ingrese el número de activo para ver cuántas veces vino ese equipo</small>
                                </div>
                            </div>
                            
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Hospital:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <select name="hospital_id" class="form-control">
                                            <option value="">Todos los hospitales</option>
                                            @foreach($hospitales as $hospital)
                                                <option value="{{$hospital->id}}" 
                                                        {{request('hospital_id') == $hospital->id ? 'selected' : ''}}>
                                                    {{$hospital->nombre}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                                @if(request('numero_activo') || request('hospital_id'))
                                    <a href="{{url('/admin/tickets-historial')}}" class="btn btn-secondary btn-block mt-1">
                                        <i class="fas fa-times"></i> Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- RESUMEN SI SE BUSCA POR NÚMERO DE ACTIVO -->
    @if(!empty($estadisticasPorActivo))
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <h4><i class="fas fa-info-circle"></i> Resumen del Equipo: <strong>{{$estadisticasPorActivo['numero_activo']}}</strong></h4>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-redo"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total de Visitas</span>
                                    <span class="info-box-number">{{$estadisticasPorActivo['total_visitas']}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-hospital"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Hospital</span>
                                    <span class="info-box-number">{{Str::limit($estadisticasPorActivo['hospital'], 25)}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-tools"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Estado Actual</span>
                                    <span class="info-box-number">
                                        {{$estadisticasPorActivo['tickets'][0]->estado_humano ?? 'N/A'}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- TABLA DE RESULTADOS -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        @if(request('numero_activo'))
                            Historial del Equipo: <strong>{{request('numero_activo')}}</strong>
                        @elseif(request('hospital_id'))
                            Tickets del Hospital Seleccionado
                        @else
                            Todos los Tickets
                        @endif
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-primary">{{$tickets->count()}} resultado(s)</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($tickets->isEmpty())
                        <div class="alert alert-warning text-center">
                            <h5><i class="fas fa-search"></i> No se encontraron resultados</h5>
                            <p>Intente con otro número de activo u hospital</p>
                        </div>
                    @else
                    <table id="historialTable" class="table table-bordered table-hover table-striped table-sm">
                        
                        <tr>
                            <th style="text-align: center">ticket#</th>
                            <th style="text-align: center">Fecha Ingreso</th>
                            <th style="text-align: center">Equipo</th>
                            <th style="text-align: center">Hospital</th>
                            <th style="text-align: center">Problema</th>
                            <th style="text-align: center">Detalle</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Días</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td style="text-align: center">
                                    <a href="{{url('/admin/tickets/'.$ticket->id)}}" class="btn btn-sm btn-info" title="Ver detalles">
                                        <i class="fas fa-eye"></i> {{$ticket->id}}
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    {{$ticket->fecha_ingreso->format('d/m/Y')}}
                                    <br><small class="text-muted">{{$ticket->created_at->format('H:i')}}</small>
                                </td>
                                <td style="text-align: center">
                                    <strong>{{$ticket->equipo->nombre}}</strong> 
                                    <br><small>{{Str::limit($ticket->descripcion_equipo, 30)}}</small> <br>
                                    <span class="badge badge-secondary badge-lg">{{$ticket->numero_activo}}</span>
                                </td>
                                <td>
                                    <strong>{{$ticket->hospital->nombre}}</strong>
                                    <br><small class="text-muted">{{$ticket->usuario->nombre_completo}}</small>
                                </td>
                                <td>
                                    {{Str::limit($ticket->descripcion_problema, 50)}}
                                </td>
                                <td>
                                    @if($ticket->detalle_salida)
                                        {{Str::limit($ticket->detalle_salida, 50)}}
                                    @else
                                        <span class="text-muted">Sin detalles</span>
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    <span class="badge badge-{{$ticket->estado_color}}">
                                        {{$ticket->estado_humano}}
                                    </span>
                                </td>
                                <td style="text-align: center">
                                    @if($ticket->dias_transcurridos > 0)
                                        <span class="badge badge-{{$ticket->dias_transcurridos > 3 ? 'danger' : 'info'}}">
                                            {{$ticket->dias_transcurridos}} días
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
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
@stop

@section('css')
    <style>
        .info-box {
            border-radius: 10px;
        }
        .badge-lg {
            font-size: 0.9rem;
            padding: 0.4rem 0.6rem;
        }
        #historialTable_wrapper .dt-buttons {
            background-color: transparent;
            box-shadow: none;
            border: none;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        #historialTable_wrapper .btn {
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
            $("#historialTable").DataTable({
                "pageLength": 25,
                "language": {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(Filtrado de _MAX_ total registros)",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar en resultados:",
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
                "order": [[ 1, "desc" ]],
                buttons: [
                    { text: '<i class="fas fa-file-pdf"></i> PDF', extend: 'pdf', className: 'btn btn-danger' },
                    { text: '<i class="fas fa-file-excel"></i> EXCEL', extend: 'excel', className: 'btn btn-success' },
                    { text: '<i class="fas fa-print"></i> IMPRIMIR', extend: 'print', className: 'btn btn-info' }
                ]
            }).buttons().container().appendTo('#historialTable_wrapper .row:eq(0)');
            @endif
        });
    </script>
@stop