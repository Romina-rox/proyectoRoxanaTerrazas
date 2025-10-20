 @extends('adminlte::page')

@section('content_header')
    <h1><b> Datos del Personal </b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">datos registrados</h3>
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
                                                @if ($rol->name=='tecnico')
                                                    <option value="{{$rol->name}}" {{$rol->name=='tecnico' ? 'selected':'' }}>{{$rol->name}}</option>
                                                @else
                                                    <option value="">no exixte el rol tecnico</option>
                                                @endif
                                            @endforeach
                                       </select>
                                    </div>
                                    @error('rol')
                                    <small style="color: red">{{$message}}</small>
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
                                        <input type="text" class="form-control" name="nombres" id="nombres" value="{{old('nombres',$tecnico->nombres)}}" placeholder="Ingrese nombres...." disabled>
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
                                        <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{old('apellidos',$tecnico->apellidos)}}" placeholder="Ingrese apellidos...." disabled>
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
                                        <input type="text" class="form-control" name="ci" id="ci" value="{{old('ci',$tecnico->ci)}}" placeholder="Ingrese carnet de indentidad...." disabled>
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
                                        <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" value="{{old('fecha_nacimiento',$tecnico->fecha_nacimiento)}}" placeholder="Ingrese su fecha_nacimiento...." disabled>
                                    </div>
                                    @error('fecha_nacimiento')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- celular-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="celular">celular <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="celular" id="celular" value="{{old('celular',$tecnico->celular)}}" placeholder="Ingrese su celular...." disabled>
                                    </div>
                                    @error('celular')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                              <!-- referencia TELEFONO-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ref_celular">telefono de referencia <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="ref_celular" id="ref_celular" value="{{old('ref_celular',$tecnico->ref_celular)}}" placeholder="Ingrese su telefono...." disabled>
                                    </div>
                                    @error('ref_celular')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- PARENTESCO-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="parentesco">parentesco <b>(*)</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="parentesco" id="parentesco" value="{{old('parentesco',$tecnico->parentesco)}}" placeholder="Ingrese parentesco...." disabled>
                                    </div>
                                    @error('parentesco')
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
                                    <input type="email" class="form-control" name="email" id="email" value="{{old('email',$tecnico->email)}}" placeholder="Ingrese su email...." disabled>
                                </div>
                                @error('email')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <!-- PROFESIONS -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="profesion">Profeccion <b>(*)</b></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="profesion" id="profesion" value="{{old('profesion',$tecnico->profesion)}}" placeholder="Ingrese su profesion...." disabled>
                                </div>
                                @error('profesion')
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
                                    <input type="text" class="form-control" name="direccion" id="direccion" value="{{old('direccion',$tecnico->direccion)}}" placeholder="Ingrese su direccion...." disabled>
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
                                        @if (isset($tecnico->foto))
                                            <img class="thumb thumbnail" src="{{url($tecnico->foto)}}" width="250px" title="foto">
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
                                    <a href="{{url('/admin/tecnicos')}}" class="btn btn-secondary">volver</a>
                                  
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
