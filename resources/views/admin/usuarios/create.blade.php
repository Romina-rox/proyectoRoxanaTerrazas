@extends('adminlte::page')

@section('content_header')
    <h1><b>CREAR UN NUEVO USUARIO</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">LLENE LOS DATOS DEL FORMULARIO</h3>
                </div>
                <div class="card-body">
                    <form action="{{url('admin/usuarios/create')}}" method="post">
                        @csrf
                        <div class="row">
                            <!-- ROLES (CAMPO OCULTO) -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Nombre del rol</label><b> (*)</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                        </div>
                                        <select class="form-control" disabled>
                                            <option selected>usuario</option>
                                        </select>
                                        <!-- ⭐ CAMPO OCULTO QUE SÍ SE ENVÍA -->
                                        <input type="hidden" name="rol" value="usuario">
                                    </div>
                                    @error('rol')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- HOSPITAL -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Hospital de trabajo</label><b> (*)</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                       <select name="hospital_id" id="hospital_id" class="form-control" required>
                                         <option value="">Seleccione un hospital...</option>
                                         @foreach ($hospitales as $hospital)
                                             <option value="{{$hospital->id}}" {{ old('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                                 {{$hospital->nombre}}
                                             </option>
                                         @endforeach
                                       </select>
                                    </div>
                                    @error('hospital_id')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- NOMBRES-->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombres">Nombres <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="nombres" id="nombres" value="{{old('nombres')}}" placeholder="Ingrese nombres..." required>
                                    </div>
                                    @error('nombres')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- APELLIDOS-->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="apellidos">Apellidos <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{old('apellidos')}}" placeholder="Ingrese apellidos..." required>
                                    </div>
                                    @error('apellidos')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- CÉDULA (CAMBIADO A type="text") -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ci">Cédula de identidad <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="ci" id="ci" value="{{old('ci')}}" placeholder="Ingrese cédula de identidad..." required>
                                    </div>
                                    @error('ci')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- FECHA DE NACIMIENTO-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_nacimiento">Fecha de nacimiento <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" value="{{old('fecha_nacimiento')}}" required>
                                    </div>
                                    @error('fecha_nacimiento')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- TELEFONO-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="telefono">Teléfono <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="telefono" id="telefono" value="{{old('telefono')}}" placeholder="Ingrese su teléfono..." required>
                                    </div>
                                    @error('telefono')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- CORREO-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Email <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" name="email" id="email" value="{{old('email')}}" placeholder="Ingrese su email..." required>
                                    </div>
                                    @error('email')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- CARGO -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cargo">Cargo <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                        </div>
                                        <select name="cargo" id="cargo" class="form-control" required>
                                            <option value="">Seleccione un cargo...</option>
                                            <option value="medico" {{ old('cargo') == 'medico' ? 'selected' : '' }}>Médico</option>
                                            <option value="enfermero" {{ old('cargo') == 'enfermero' ? 'selected' : '' }}>Enfermero(a)</option>
                                            <option value="funcionario" {{ old('cargo') == 'funcionario' ? 'selected' : '' }}>Funcionario</option>
                                            <option value="tecnico" {{ old('cargo') == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                            <option value="auxiliar" {{ old('cargo') == 'auxiliar' ? 'selected' : '' }}>Auxiliar</option>
                                        </select>
                                    </div>
                                    @error('cargo')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- ESPECIALIDAD -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="especialidad">Especialidad <small>(Solo para médicos)</small></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="especialidad" id="especialidad" value="{{old('especialidad')}}" placeholder="Ej: Pediatría, Cardiología...">
                                    </div>
                                    @error('especialidad')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- DIRECCION-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direccion">Dirección <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="direccion" id="direccion" value="{{old('direccion')}}" placeholder="Ingrese su dirección..." required>
                                    </div>
                                    @error('direccion')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{url('/admin/usuarios')}}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Registrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        // Mostrar/ocultar campo especialidad según el cargo seleccionado
        document.getElementById('cargo').addEventListener('change', function() {
            const especialidadGroup = document.getElementById('especialidad').closest('.form-group');
            if (this.value === 'medico') {
                especialidadGroup.style.display = 'block';
            } else {
                especialidadGroup.style.display = 'none';
                document.getElementById('especialidad').value = '';
            }
        });

        // Ejecutar al cargar la página para mantener estado
        document.addEventListener('DOMContentLoaded', function() {
            const cargo = document.getElementById('cargo').value;
            const especialidadGroup = document.getElementById('especialidad').closest('.form-group');
            if (cargo !== 'medico') {
                especialidadGroup.style.display = 'none';
            }
        });
    </script>
@stop