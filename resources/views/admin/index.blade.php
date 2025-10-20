@extends('adminlte::page')

@section('content_header')
    <h1 class="text-center">Servicio Técnico</h1>
    <hr>
@stop

@section('content')
    <p class="text-center">panel administrativo ROX</p>
    <div class="row">
        <!-- Hospitales Registrados -->
        <div class="col-md-3 col-sm-6 col-12 mb-4">
            <div class="info-box zoomP bg-info">
                <img src="{{ url('/img/hospital.gif') }}" width="70px" alt="">
                <div class="info-box-content">
                    <span class="info-box-text"><b>hospitales</b></span>
                    <span class="info-box-number">{{ $total_hospitales }} registrados</span>
                </div>
            </div>
           <a href="{{ route('admin.hospitales.index') }}" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>

        <!-- Administrativos Registrados -->
        <div class="col-md-3 col-sm-6 col-12 mb-4">
            <div class="info-box zoomP bg-success">
                <img src="{{ url('/img/administrativos.gif') }}" width="70px" alt="">
                <div class="info-box-content">
                    <span class="info-box-text"><b>Administrativos </b></span>
                    <span class="info-box-number">{{ $total_administrativos }} registrados</span>
                </div>
            </div>
             <a href="{{ route('admin.administrativos.index') }}" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>

        <!-- Roles Registrados -->
        <div class="col-md-3 col-sm-6 col-12 mb-4">
            <div class="info-box zoomP bg-warning">
                <img src="{{ url('/img/roles.gif') }}" width="70px" alt="">
                <div class="info-box-content">
                    <span class="info-box-text"><b>Roles </b></span>
                    <span class="info-box-number">{{ $total_roles }} registrados</span>
                </div>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>

        <!-- Reportes -->
        <div class="col-md-3 col-sm-6 col-12 mb-4">
            <div class="info-box zoomP bg-danger">
                 <img src="{{ url('/img/roles.gif') }}" width="70px" alt="">
                <div class="info-box-content">
                    <span class="info-box-text"><b>Reportes</b></span>
                    <span class="info-box-number">0</span>
                </div>
                
            </div>
            <a href="#" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
        <!-- equipos-->
         <div class="col-md-3 col-sm-6 col-12 mb-4">
            <div class="info-box zoomP bg-warning">
                <img src="{{ url('/img/hospital.gif') }}" width="70px" alt="">
                <div class="info-box-content">
                    <span class="info-box-text"><b>Equipos</b></span>
                    <span class="info-box-number">{{ $total_equipos }} registrados</span>
                </div>
            </div>
           <a href="{{ route('admin.equipos.index') }}" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>

          <!-- usuarios-->
         <div class="col-md-3 col-sm-6 col-12 mb-4">
            <div class="info-box zoomP bg-info">
                <img src="{{ url('/img/hospital.gif') }}" width="70px" alt="">
                <div class="info-box-content">
                    <span class="info-box-text"><b>usuarios</b></span>
                    <span class="info-box-number">{{ $total_usuarios }} registrados</span>
                </div>
            </div>
           <a href="{{ route('admin.usuarios.index') }}" class="small-box-footer">
                Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>

        <!-- tickets-->
         <div class="col-md-3 col-sm-6 col-12 mb-4">
            <div class="info-box zoomP bg-info">
                <img src="{{ url('/img/hospital.gif') }}" width="70px" alt="">
                <div class="info-box-content">
                    <span class="info-box-text"><b>ticket</b></span>
                    <span class="info-box-number">{{ $total_tickets }} registrados</span>
                </div>
            </div>
           
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop