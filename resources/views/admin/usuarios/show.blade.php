 @extends('adminlte::page')

@section('content_header')
    <h1><b> DATOS DE USUARIOS REGISTRADOS </b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">DATOS DEL USUARIO</h3>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">        
                        @csrf
                        <div class="row">
                            <!-- ROLES -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Nombre del rol</label><b> (*)</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                        </div>
                                       <select name="rol" id="" class="form-control" style="pointer-events: none" disabled>
                                            @foreach ($roles as $rol)
                                                @if ($rol->name=='usuario')
                                                    <option value="{{$rol->name}}" {{$rol->name=='usuario' ? 'selected':'' }}>{{$rol->name}}</option>
                                                @else
                                                    <option value="">no exixte el rol usuario</option>
                                                @endif
                                            @endforeach
                                       </select>
                                    </div>
                                    @error('rol')
                                    <small style="color: red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- HOSPITAL -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="hospital_id">Hospital de trabajo</label><b> (*)</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hospital"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="hospital_id" id="hospital_id" value="{{old('hospital_id',$usuario->hospital->nombre)}}" placeholder="Ingrese nombres...." disabled>
                                         
                                    </div>
                                    @error('hospital_id')
                                    <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                             
                            <!-- NOMBRES-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nombres">Nombres <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="nombres" id="nombres" value="{{old('nombres',$usuario->nombres)}}" placeholder="Ingrese nombres...." disabled>
                                    </div>
                                    @error('nombres')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- APELLIDOS-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="apellidos">Apellidos <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{old('apellidos',$usuario->apellidos)}}" placeholder="Ingrese apellidos...." disabled>
                                    </div>
                                    @error('apellidos')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- CARNET-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ci">Cedula de identidad <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="ci" id="ci" value="{{old('ci',$usuario->ci)}}" placeholder="Ingrese carnet de indentidad...." disabled>
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
                                        <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" value="{{old('fecha_nacimiento',$usuario->fecha_nacimiento)}}" placeholder="Ingrese su fecha_nacimiento...." disabled>
                                    </div>
                                    @error('fecha_nacimiento')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- telefono-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="telefono">telefono <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="telefono" id="telefono" value="{{old('telefono',$usuario->telefono)}}" placeholder="Ingrese su telefono...." disabled>
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
                                    <input type="email" class="form-control" name="email" id="email" value="{{old('email',$usuario->user->email)}}" placeholder="Ingrese su email...." disabled>
                                </div>
                                @error('email')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                                    <!-- cargo-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="cargo">cargo <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="cargo" id="cargo" value="{{old('cargo',$usuario->cargo)}}" placeholder="Ingrese cargo...." disabled>
                                    </div>
                                    @error('cargo')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        <!-- especialidadS -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="especialidad">especialidad </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                        </div>
                                    <input type="text" class="form-control" name="especialidad" id="especialidad" value="{{old('especialidad',$usuario->especialidad)}}" placeholder="Ingrese su especialidad...." disabled>
                                </div>
                                @error('especialidad')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- DIRECCION-->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="direccion">Direccion <b>(*)</b></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="direccion" id="direccion" value="{{old('direccion',$usuario->direccion)}}" placeholder="Ingrese su direccion...." disabled>
                                </div>
                                @error('direccion')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                         <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="foto">foto</label>
                                    @error('foto')
                                        <small style="color: red">{{$message}}</small>
                                    @enderror
                                    <br>
                                    <output id="list">
                                        @if (isset($usuario->foto))
                                            <img class="thumb thumbnail" src="{{url($usuario->foto)}}" width="250px" title="foto">
                                        @endif
                                    </output>
                                    <script>
                                        function archivo(evt){
                                            var files = evt.target.files;
                                            for(var i = 0, f; f = files[i]; i++){
                                                if (!f.type.match('image.*')) {
                                                    continue;
                                                }
                                                var reader = new FileReader();
                                                reader.onload = (function(theFile){
                                                    return function(e){
                                                        document.getElementById("list").innerHTML = '<img class="thumb thumbnail" src="' + e.target.result + '" width="70%">';
                                                    };
                                                })(f);
                                                reader.readAsDataURL(f);
                                            }
                                        }
                                        document.getElementById('file').addEventListener('change', archivo, false);
                                    </script>
                                </div>
                            </div>

                    </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <a href="{{url('/admin/usuarios')}}" class="btn btn-secondary">volver</a>
                                  
                                </div>
                            </div>
                        </div>
                    
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
