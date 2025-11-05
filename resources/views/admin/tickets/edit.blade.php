@extends('adminlte::page')

@section('content_header')
    <h1><b>Editar Ticket #{{$ticket->id}}</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Actualizar información del ticket</h3>
                </div>
                <div class="card-body">
                    <!-- Información del solicitante -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info-circle"></i> Información del Solicitante</h5>
                                <strong>Usuario:</strong> {{$ticket->usuario->nombre_completo}} <br>
                                <strong>Hospital:</strong> {{$ticket->hospital->nombre}} <br>
                                <strong>Cargo:</strong> {{ucfirst($ticket->usuario->cargo)}} <br>
                                <strong>Fecha de creación:</strong> {{$ticket->created_at->format('d/m/Y H:i')}}
                            </div>
                        </div>
                    </div>

                    <form action="{{url('admin/tickets/'.$ticket->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- TIPO DE EQUIPO -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="equipo_id">Tipo de Equipo <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-desktop"></i></span>
                                        </div>
                                        <select name="equipo_id" id="equipo_id" class="form-control" required>
                                            <option value="">Seleccione el tipo de equipo...</option>
                                            @foreach ($equipos as $equipo)
                                                <option value="{{$equipo->id}}" {{ $ticket->equipo_id == $equipo->id ? 'selected' : '' }}>
                                                    {{$equipo->nombre}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('equipo_id')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- NÚMERO DE ACTIVO -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="numero_activo">Número de Activo <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="numero_activo" id="numero_activo" 
                                               value="{{$ticket->numero_activo}}" required>
                                    </div>
                                    @error('numero_activo')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- ESTADO -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado">Estado <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                        </div>
                                        <select name="estado" id="estado" class="form-control" required>
                                            <option value="en_espera" {{ $ticket->estado == 'en_espera' ? 'selected' : '' }}>
                                                En Espera
                                            </option>
                                            <option value="aceptado" {{ $ticket->estado == 'aceptado' ? 'selected' : '' }}>
                                                Aceptado (En Revisión)
                                            </option>
                                            <option value="reparado" {{ $ticket->estado == 'reparado' ? 'selected' : '' }}>
                                                ✅ Reparado (Listo para entrega)
                                            </option>
                                            <option value="baja" {{ $ticket->estado == 'baja' ? 'selected' : '' }}>
                                                ❌ Dado de Baja (No reparable)
                                            </option>
                                            <option value="devuelto" {{ $ticket->estado == 'devuelto' ? 'selected' : '' }}>
                                                Devuelto al Usuario
                                            </option>
                                        </select>
                                    </div>
                                    <small class="text-muted" id="estado-ayuda">
                                        <i class="fas fa-info-circle"></i> 
                                        <span id="estado-texto">Seleccione el estado actual</span>
                                    </small>
                                    @error('estado')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- FECHA DE INGRESO -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_ingreso">Fecha de Ingreso <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" 
                                               value="{{$ticket->fecha_ingreso->format('Y-m-d')}}" required>
                                    </div>
                                    @error('fecha_ingreso')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- FECHA DE SALIDA -->
                            <div class="col-md-6" id="fecha_salida_group">
                                <div class="form-group">
                                    <label for="fecha_salida">
                                        Fecha de Salida 
                                        <span class="badge badge-warning" id="badge-requerido" style="display:none;">Requerido</span>
                                    </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input type="date" class="form-control" name="fecha_salida" id="fecha_salida" 
                                               value="{{$ticket->fecha_salida ? $ticket->fecha_salida->format('Y-m-d') : ''}}">
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-lightbulb"></i> 
                                        Se completa automáticamente al marcar como Reparado o Dado de Baja
                                    </small>
                                    @error('fecha_salida')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- DESCRIPCIÓN DEL EQUIPO -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="descripcion_equipo">Descripción Específica del Equipo <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="descripcion_equipo" id="descripcion_equipo" 
                                               value="{{$ticket->descripcion_equipo}}" required>
                                    </div>
                                    @error('descripcion_equipo')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- DESCRIPCIÓN DEL PROBLEMA -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="descripcion_problema">Descripción del Problema <b>(*)</b></label>
                                    <textarea class="form-control" name="descripcion_problema" id="descripcion_problema" 
                                              rows="3" required>{{$ticket->descripcion_problema}}</textarea>
                                    @error('descripcion_problema')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- DETALLE DE SALIDA - Se muestra/oculta según estado -->
                        <div class="row" id="detalle_salida_group" style="display:none;">
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    <h6><i class="fas fa-exclamation-triangle"></i> Importante: Complete el detalle antes de cambiar el estado</h6>
                                </div>
                                <div class="form-group">
                                    <label for="detalle_salida">
                                        <i class="fas fa-tools"></i> Detalle de la Reparación / Diagnóstico Final 
                                        <b id="detalle-requerido" style="display:none;">(*)</b>
                                    </label>
                                    <textarea class="form-control" name="detalle_salida" id="detalle_salida" 
                                              rows="5" placeholder="Describa detalladamente qué se hizo para reparar, repuestos utilizados, diagnóstico final, motivo de la baja, etc.">{{$ticket->detalle_salida}}</textarea>
                                    <small class="text-muted">
                                        <strong>Para Reparado:</strong> Indique qué se reparó, piezas cambiadas, pruebas realizadas.<br>
                                        <strong>Para Baja:</strong> Explique por qué no es reparable (costo elevado, obsoleto, daño irreparable, etc.)
                                    </small>
                                    @error('detalle_salida')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <a href="{{url('/admin/tickets')}}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-success btn-lg" id="btnActualizar">
                                        <i class="fas fa-save"></i> Actualizar Ticket
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Panel lateral con información del estado -->
        <div class="col-md-2">
            <div class="card card-{{$ticket->estado_color}}">
                <div class="card-header">
                    <h3 class="card-title">Estado Actual</h3>
                </div>
                <div class="card-body p-2">
                    <div class="text-center">
                        <h4>
                            <span class="badge badge-{{$ticket->estado_color}}">
                                {{$ticket->estado_humano}}
                            </span>
                        </h4>
                        
                        @if($ticket->fecha_aceptacion)
                            <small>
                                <strong>Aceptado:</strong><br>
                                {{$ticket->fecha_aceptacion->format('d/m/Y')}}
                            </small>
                        @endif
                        
                        @if($ticket->fecha_salida)
                            <small class="d-block mt-2">
                                <strong>Fecha de salida:</strong><br>
                                {{$ticket->fecha_salida->format('d/m/Y')}}
                            </small>
                        @endif
                        
                        @if($ticket->dias_transcurridos > 0)
                            <div class="mt-2">
                                <span class="badge badge-{{$ticket->dias_transcurridos > 3 ? 'danger' : 'info'}}">
                                    {{$ticket->dias_transcurridos}} días
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Flujo de Estados</h3>
                </div>
                <div class="card-body p-2">
                    <small>
                        <strong>1. En Espera</strong><br>
                        ↓<br>
                        <strong>2. Aceptado</strong><br>
                        (En revisión/reparación)<br>
                        ↓<br>
                        <strong>3a. Reparado</strong><br>
                        <em>o</em><br>
                        <strong>3b. Dado de Baja</strong><br>
                        ↓<br>
                        <strong>4. Devuelto</strong>
                    </small>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Función para actualizar la interfaz según el estado seleccionado
        function actualizarInterfazEstado() {
            const estado = document.getElementById('estado').value;
            const detalleSalidaGroup = document.getElementById('detalle_salida_group');
            const detalleSalidaTextarea = document.getElementById('detalle_salida');
            const fechaSalidaInput = document.getElementById('fecha_salida');
            const badgeRequerido = document.getElementById('badge-requerido');
            const detalleRequerido = document.getElementById('detalle-requerido');
            const estadoTexto = document.getElementById('estado-texto');
            const btnActualizar = document.getElementById('btnActualizar');
            
            // Textos de ayuda según estado
            const textos = {
                'en_espera': 'Ticket esperando ser revisado por el técnico',
                'aceptado': 'Ticket aceptado y en proceso de reparación',
                'reparado': 'Equipo reparado y listo para devolución',
                'baja': 'Equipo no reparable, será dado de baja',
                'devuelto': 'Equipo devuelto al usuario'
            };
            
            estadoTexto.textContent = textos[estado] || 'Seleccione el estado actual';
            
            // Mostrar/ocultar detalle de salida
            if (estado === 'reparado' || estado === 'baja') {
                detalleSalidaGroup.style.display = 'block';
                badgeRequerido.style.display = 'inline';
                detalleRequerido.style.display = 'inline';
                
                // Establecer fecha de salida si está vacía
                if (!fechaSalidaInput.value) {
                    fechaSalidaInput.value = new Date().toISOString().split('T')[0];
                }
                
                // Cambiar texto del botón
                if (estado === 'reparado') {
                    btnActualizar.innerHTML = '<i class="fas fa-check-circle"></i> Marcar como Reparado';
                    btnActualizar.className = 'btn btn-success btn-lg';
                } else {
                    btnActualizar.innerHTML = '<i class="fas fa-times-circle"></i> Marcar como Dado de Baja';
                    btnActualizar.className = 'btn btn-danger btn-lg';
                }
                
                // Advertencia si el detalle está vacío
                if (!detalleSalidaTextarea.value.trim()) {
                    detalleSalidaTextarea.style.borderColor = '#ffc107';
                    detalleSalidaTextarea.focus();
                }
            } else {
                detalleSalidaGroup.style.display = 'none';
                badgeRequerido.style.display = 'none';
                detalleRequerido.style.display = 'none';
                detalleSalidaTextarea.style.borderColor = '';
                
                btnActualizar.innerHTML = '<i class="fas fa-save"></i> Actualizar Ticket';
                btnActualizar.className = 'btn btn-success btn-lg';
                
                // Limpiar fecha de salida si vuelve a en_espera o aceptado
                if (estado === 'en_espera' || estado === 'aceptado') {
                    // No limpiar automáticamente, dejar que el usuario decida
                }
            }
        }
        
        // Evento al cambiar estado
        document.getElementById('estado').addEventListener('change', actualizarInterfazEstado);
        
        // Ejecutar al cargar para el estado inicial
        document.addEventListener('DOMContentLoaded', actualizarInterfazEstado);
        
        // Convertir número de activo a mayúsculas
        document.getElementById('numero_activo').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
        
        // Validación antes de enviar
        document.querySelector('form').addEventListener('submit', function(e) {
            const estado = document.getElementById('estado').value;
            const detalleSalida = document.getElementById('detalle_salida').value.trim();
            
            if ((estado === 'reparado' || estado === 'baja') && !detalleSalida) {
                e.preventDefault();
                alert('⚠️ Debe completar el detalle de ' + (estado === 'reparado' ? 'reparación' : 'baja') + ' antes de continuar');
                document.getElementById('detalle_salida').focus();
                return false;
            }
            
            // Confirmación para cambios importantes
            if (estado === 'baja') {
                if (!confirm('¿Está seguro de marcar este equipo como DADO DE BAJA? Esta acción indica que el equipo no es reparable.')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    </script>
@stop