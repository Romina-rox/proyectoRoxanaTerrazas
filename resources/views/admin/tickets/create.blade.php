@extends('adminlte::page')

@section('content_header')
    <h1><b>Nuevo Ticket</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Registrar equipo para reparación</h3>
                </div>
                <div class="card-body">
                    <!-- Información del usuario y hospital -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info-circle"></i> Información del Solicitante</h5>
                                <strong>Usuario:</strong> {{$usuario->nombre_completo}} <br>
                                <strong>Hospital:</strong> {{$usuario->hospital->nombre}} <br>
                                <strong>Cargo:</strong> {{ucfirst($usuario->cargo)}}
                            </div>
                        </div>
                    </div>

                    <form action="{{url('admin/tickets/create')}}" method="post">
                        @csrf
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
                                                <option value="{{$equipo->id}}" {{ old('equipo_id') == $equipo->id ? 'selected' : '' }}>
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
                                               value="{{old('numero_activo')}}" 
                                               placeholder="Ej: ACT-001234" required>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        Número de identificación pegado en el equipo
                                    </small>
                                    @error('numero_activo')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- FECHA DE INGRESO -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_ingreso">Fecha de Ingreso <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" 
                                               value="{{old('fecha_ingreso', date('Y-m-d'))}}" required>
                                    </div>
                                    @error('fecha_ingreso')
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
                                               value="{{old('descripcion_equipo')}}" 
                                               placeholder="Ej: Impresora Epson L355, Monitor Dell 19 pulgadas, etc." required>
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-lightbulb"></i> 
                                        Sea específico: marca, modelo, características principales
                                    </small>
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
                                              rows="3" required placeholder="Describa detalladamente qué problema presenta el equipo...">{{old('descripcion_problema')}}</textarea>
                                    <small class="text-muted">
                                        <i class="fas fa-exclamation-triangle"></i> 
                                        Detalle todos los síntomas y problemas observados
                                    </small>
                                    @error('descripcion_problema')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    <h6><i class="icon fas fa-exclamation-triangle"></i> Importante:</h6>
                                    <ul class="mb-0">
                                        <li>Verifique que el número de activo sea correcto</li>
                                        <li>Asegúrese de describir claramente el problema</li>
                                        <li>El técnico revisará y puede modificar la información si es necesario</li>
                                        <li>Recibirá notificaciones sobre el estado de su equipo</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <a href="{{url('/admin/tickets')}}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane"></i> Crear Ticket
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Panel lateral con información -->
        <div class="col-md-2">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Ayuda</h3>
                </div>
                <div class="card-body p-2">
                    <small>
                        <strong>Tipos de equipo más comunes:</strong><br>
                        • Computadora<br>
                        • Impresora<br>
                        • Monitor<br>
                        • Teclado/Mouse<br>
                        • Scanner<br><br>
                        
                        <strong>¿Dónde encontrar el N° de Activo?</strong><br>
                        Busque una etiqueta pegada en el equipo con números como "km-001234"
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
        // Convertir número de activo a mayúsculas automáticamente
        document.getElementById('numero_activo').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
        
        // Validar formato de número de activo
        document.getElementById('numero_activo').addEventListener('blur', function() {
            const valor = this.value;
            if (valor && !valor.match(/^[A-Z0-9\-]+$/)) {
                this.classList.add('is-invalid');
                if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Use solo letras mayúsculas, números y guiones';
                    this.parentNode.appendChild(errorDiv);
                }
            } else {
                this.classList.remove('is-invalid');
                const errorDiv = this.parentNode.querySelector('.invalid-feedback');
                if (errorDiv) errorDiv.remove();
            }
        });
        
        // Sugerencias automáticas basadas en el tipo de equipo
        document.getElementById('equipo_id').addEventListener('change', function() {
            const descripcionInput = document.getElementById('descripcion_equipo');
            const tipoEquipo = this.options[this.selectedIndex].text.toLowerCase();
            
            if (tipoEquipo.includes('impresora')) {
                descripcionInput.placeholder = 'Ej: Impresora Epson L355, Canon Pixma, HP DeskJet...';
            } else if (tipoEquipo.includes('computadora') || tipoEquipo.includes('pc')) {
                descripcionInput.placeholder = 'Ej: Computadora Dell OptiPlex, HP Compaq, Lenovo ThinkCentre...';
            } else if (tipoEquipo.includes('monitor')) {
                descripcionInput.placeholder = 'Ej: Monitor Dell 19", Samsung 22", LG UltraWide...';
            } else {
                descripcionInput.placeholder = 'Especifique marca, modelo y características...';
            }
        });
    </script>
@stop