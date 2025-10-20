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
                                                Aceptado
                                            </option>
                                            <option value="reparado" {{ $ticket->estado == 'reparado' ? 'selected' : '' }}>
                                                Reparado
                                            </option>
                                            <option value="baja" {{ $ticket->estado == 'baja' ? 'selected' : '' }}>
                                                Dado de Baja
                                            </option>
                                            <option value="devuelto" {{ $ticket->estado == 'devuelto' ? 'selected' : '' }}>
                                                Devuelto
                                            </option>
                                        </select>
                                    </div>
                                    @error('estado')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- FECHA DE INGRESO -->
                            <div class="col-md-4">
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
                            <div class="col-md-4" id="fecha_salida_group">
                                <div class="form-group">
                                    <label for="fecha_salida">Fecha de Salida</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                        </div>
                                        <input type="date" class="form-control" name="fecha_salida" id="fecha_salida" 
                                               value="{{$ticket->fecha_salida ? $ticket->fecha_salida->format('Y-m-d') : ''}}">
                                    </div>
                                    <small class="text-muted">
                                        Se asigna automáticamente al marcar como "Reparado" o "Dado de Baja"
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

                        <!-- DETALLE DE SALIDA -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="detalle_salida">Detalle de la Reparación / Solución</label>
                                    <textarea class="form-control" name="detalle_salida" id="detalle_salida" 
                                              rows="4" placeholder="Describa qué se hizo para solucionar el problema, repuestos utilizados, diagnóstico final, etc.">{{$ticket->detalle_salida}}</textarea>
                                    <small class="text-muted">
                                        <i class="fas fa-tools"></i> 
                                        Campo para uso del técnico. Detalle todos los procedimientos realizados.
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
                                    <button type="submit" class="btn btn-success btn-lg">
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
                        
                        @if($ticket->fecha_salida)
                            <small>
                                <strong>Fecha de salida:</strong><br>
                                {{$ticket->fecha_salida->format('d/m/Y')}}
                            </small>
                        @endif
                        
                        @if($ticket->entregado)
                            <div class="mt-2">
                                <span class="badge badge-success">
                                    <i class="fas fa-check"></i> Entregado
                                </span>
                                <br>
                                <small>{{$ticket->fecha_entrega->format('d/m/Y H:i')}}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Estados</h3>
                </div>
                <div class="card-body p-2">
                    <small>
                        <strong>Aceptado:</strong> Ticket recibido<br>
                        <strong>En Reparación:</strong> Siendo trabajado<br>
                        <strong>Reparado:</strong> Listo para entrega<br>
                        <strong>Dado de Baja:</strong> No reparable
                    </small>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        // Mostrar/ocultar fecha de salida según el estado
        document.getElementById('estado').addEventListener('change', function() {
            const fechaSalidaGroup = document.getElementById('fecha_salida_group');
            const fechaSalidaInput = document.getElementById('fecha_salida');
            
            if (this.value === 'reparado' || this.value === 'baja') {
                fechaSalidaGroup.style.display = 'block';
                if (!fechaSalidaInput.value) {
                    fechaSalidaInput.value = new Date().toISOString().split('T')[0];
                }
            } else {
                // No ocultar el campo, pero permitir que se borre si es necesario
                if (this.value === 'en_espera' || this.value === 'aceptado') {
                    fechaSalidaInput.value = '';
                }
            }
        });
        
        // Ejecutar al cargar para el estado inicial
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('estado').dispatchEvent(new Event('change'));
        });
        
        // Convertir número de activo a mayúsculas
        document.getElementById('numero_activo').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    </script>
@stop