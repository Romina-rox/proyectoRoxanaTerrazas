@extends('adminlte::page')

@section('title','403 - Acceso no autorizado')

@section('content_header')
    <center class="text-danger"> 
        <h1>403 - Acceso no autorizado</h1>
    </center>
@stop

@section('content')

<br><br><br><br>
    <div class="text-center">
        <img src="{{url('img/403.png')}}" alt="">
        <br><br>
        <h3>no tiene permiso para ingresar a esta pagina</h3>
        <p>favor de contactarse con el administrador si cree que existe un error</p>
        <a href="{{url()->previous() }}" class="btn btn-primary">Regresar</a>
    </div>
@stop