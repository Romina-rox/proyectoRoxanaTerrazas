@extends('adminlte::master')

@php
    $authType = $authType ?? 'login';
    $dashboardUrl = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home');

    if (config('adminlte.use_route_url', false)) {
        $dashboardUrl = $dashboardUrl ? route($dashboardUrl) : '';
    } else {
        $dashboardUrl = $dashboardUrl ? url($dashboardUrl) : '';
    }

    $bodyClasses = "{$authType}-page";

    if (! empty(config('adminlte.layout_dark_mode', null))) {
        $bodyClasses .= ' dark-mode';
    }
@endphp

@section('adminlte_css')
<style>
    body.login-page {
        background: linear-gradient(135deg, #6b0f2f, #0d5181);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-box {
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(33, 150, 243, 0.25);
        background: #ffffff;
        padding: 25px;
        max-width: 420px;
        width: 100%;
        border: 1.5px solid #bbdefb;
        transition: transform 0.3s ease;
    }
    .login-box:hover {
        transform: translateY(-3px);
    }

    /* Logo rectangular grande */
.login-box img.login-image {
    display: block;
    width: 100%;                
    height: 180px;              
    border-radius: 10px;      
    border: 3px solid #81d4fa;
    box-shadow: 0 0 8px rgba(3, 169, 244, 0.4);
    object-fit: cover;          
    background-color: #e1f5fe;
    margin-bottom: 18px;
}

    .login-box img.login-image:hover {
        transform: scale(1.05);
    }

    .card.card-outline.card-primary {
        border: none;
        background: transparent;
        box-shadow: none;
        padding: 0;
    }

    .card-header {
        border-bottom: none;
        background-color: transparent;
        padding-bottom: 0;
    }

    .card-title {
        font-weight: 700;
        font-size: 26px;
        color: #0a1161;
        text-align: center;
        font-family: 'Georgia', serif;
        margin-bottom: 25px;
    }

    .card-body.login-card-body {
        background: #f1f8ff;
        border-radius: 12px;
        padding: 25px 30px;
        box-shadow: inset 0 0 15px rgba(100, 181, 246, 0.15);
    }

    .card-footer {
        background: transparent;
        text-align: center;
        padding-top: 15px;
        font-size: 14px;
        color: #0d47a1;
        font-style: italic;
    }

    .btn-primary {
        background: linear-gradient(90deg, #0288d1, #0277bd);
        border: none;
        font-weight: 500;
        border-radius: 25px;
        font-size: 14px;
        padding: 10px 0;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #013964, #003255);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(2, 136, 209, 0.4);
    }

    input.form-control {
        border-radius: 12px;
        border: 1.8px solid #81d4fa;
        padding-left: 15px;
        font-size: 16px;
        color: #01579b;
        font-weight: 500;
        background-color: #ffffff;
        transition: all 0.3s ease;
    }
    input.form-control:focus {
        border-color: #0288d1;
        box-shadow: 0 0 10px rgba(2, 136, 209, 0.3);
        background-color: #e3f2fd;
    }

    /* Enlaces del login */
    a {
        color: #0288d1;
        transition: color 0.3s ease;
    }
    a:hover {
        color: #01579b;
        text-decoration: underline;
    }
</style>
@stack('css')
@yield('css')
@stop


@section('classes_body'){{ $bodyClasses }}@stop

@section('body')
    <div class="login-box">

        {{-- Imagen login ovalada --}}
        <img src="{{ asset('vendor/adminlte/dist/img/logo.png') }}" alt="Login Imagen" class="login-image">

        {{-- Card Box --}}
        <div class="card card-outline card-primary">

            {{-- Card Header --}}
            @hasSection('auth_header')
                <div class="card-header">
                    <h3 class="card-title">
                        @yield('auth_header')
                    </h3>
                </div>
            @endif

            {{-- Card Body --}}
            <div class="card-body login-card-body">
                @yield('auth_body')
            </div>

            {{-- Card Footer --}}
            @hasSection('auth_footer')
                <div class="card-footer">
                    @yield('auth_footer')
                </div>
            @endif

        </div>

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop