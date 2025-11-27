@extends('adminlte::page')

@section('content_header')
    <h1 class="text-center font-weight-bold">SERVICIO TÉCNICO</h1>
    <hr class="header-divider">
@stop

@section('content')
<div class="container-fluid px-4">

    <!-- Carrusel de imágenes -->
    <div id="carouselExampleCaptions" class="carousel slide mb-5" data-ride="carousel" data-interval="4000">
        <!-- Indicadores -->
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>

        <!-- Imágenes del carrusel -->
        <div class="carousel-inner rounded shadow-lg">
            <div class="carousel-item active">
                <img src="{{ asset('img/principal/img4.jpg') }}" class="d-block w-100 carousel-img" alt="Servicio Técnico 1">
                <div class="carousel-caption d-none d-md-block">
                    <div class="caption-content">
                        <h5>Mantenimiento Preventivo</h5>
                        <p>Nos aseguramos de que todos los equipos médicos estén en perfecto estado.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/principal/img2.png') }}" class="d-block w-100 carousel-img" alt="Servicio Técnico 2">
                <div class="carousel-caption d-none d-md-block">
                    <div class="caption-content">
                        <h5>Reparación Rápida</h5>
                        <p>Respondemos con eficiencia ante cualquier fallo técnico.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/principal/img3.png') }}" class="d-block w-100 carousel-img" alt="Servicio Técnico 3">
                <div class="carousel-caption d-none d-md-block">
                    <div class="caption-content">
                        <h5>Compromiso y Calidad</h5>
                        <p>Brindamos soluciones confiables con personal calificado.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controles del carrusel -->
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
        </a>
    </div>

    <!-- Sección de bienvenida -->
    <div class="row mb-5">
        <div class="col-12 text-center" data-aos="fade-up">
            <h2 class="section-title">Bienvenido al Servicio Técnico</h2>
            <p class="lead text-muted px-md-5">
                Somos el equipo especializado en mantener y reparar los equipos médicos de 24 centros de salud dependientes de GAMS.
            </p>
        </div>
    </div>

    <!-- Sección: Nosotros -->
    <div class="row mb-5 align-items-center" data-aos="fade-right">
        <div class="col-md-6 mb-4 mb-md-0">
            <h3 class="section-subtitle">Nosotros</h3>
            <p class="text-justify">
                Somos un equipo de profesionales altamente capacitados dedicados al mantenimiento y reparación de equipos médicos. 
                Con más de 10 años de experiencia, nos especializamos en garantizar el funcionamiento óptimo de toda la tecnología 
                médica que salva vidas día a día.
            </p>
            <p class="text-justify">
                Nuestro personal está certificado y constantemente actualizado en las últimas tecnologías del sector salud, 
                trabajando bajo los más altos estándares de calidad y seguridad.
            </p>
            <ul class="custom-list">
                <li><i class="fas fa-check-circle text-success"></i> Técnicos certificados</li>
                <li><i class="fas fa-check-circle text-success"></i> Respuesta rápida 24/7</li>
                <li><i class="fas fa-check-circle text-success"></i> Garantía de servicio</li>
            </ul>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('img/principal/img1.png') }}" class="img-fluid rounded shadow standard-img" alt="Nosotros">
        </div>
    </div>

    <!-- Sección: Qué hacemos -->
    <div class="row mb-5 align-items-center" data-aos="fade-left">
        <div class="col-md-6 order-md-2 mb-4 mb-md-0">
            <h3 class="section-subtitle">¿Qué hacemos?</h3>
            <p class="text-justify">
                Brindamos servicios integrales de mantenimiento  correctivo para equipos de computo de los centros de salud tanto en area administrativa, operativos. 
                
            </p>
            <p class="text-justify">
                Ofrecemos servicio técnico especializado en la reparación de impresoras, teclados, monitores, laptops y unidades de escritorio (CPU)
            </p>
            <div class="services-grid mt-4">
                <div class="service-item">
                    <i class="fas fa-tools text-primary"></i>
                    <span>Revision de equipos </span>
                </div>
                <div class="service-item">
                    <i class="fas fa-wrench text-primary"></i>
                    <span>Reparaciones Correctivas</span>
                </div>
                <div class="service-item">
                    <i class="fas fa-cog text-primary"></i>
                    <span>Calibración de Equipos</span>
                </div>
                <div class="service-item">
                    <i class="fas fa-laptop-medical text-primary"></i>
                    <span>Actualizaciones</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 order-md-1">
            <img src="{{ asset('img/principal/img4.jpg') }}" class="img-fluid rounded shadow standard-img" alt="Qué hacemos">
        </div>
    </div>

    <!-- Sección: Ubicación -->
    <div class="row mb-5 align-items-center" data-aos="fade-right">
        <div class="col-md-6 mb-4 mb-md-0">
            <h3 class="section-subtitle">Ubicación</h3>
            <p class="text-justify">
                Nos encontramos dentro de las Instalaciones del Hospital México, en el segundo piso del edificio central, cerca del área de emergencia. 
                Nuestra ubicación estratégica nos permite responder rápidamente a cualquier solicitud de soporte técnico.
            </p>
            <p class="text-justify mb-3">
                <strong>Dirección:</strong> Hospital México, Sacaba, Cbba.<br>
                <strong>Horario:</strong> Lunes a Viernes de 8:00 AM a 6:00 PM<br>
                <strong>Emergencias:</strong> Disponible 24/7
            </p>
            <a href="tel:+51971443900" class="btn btn-primary mb-2 mr-2">
                <i class="fas fa-phone"></i> Llamar ahora
            </a>
            <a href="mailto:servicio.tecnico@gams.com" class="btn btn-outline-primary mb-2">
                <i class="fas fa-envelope"></i> Enviar email
            </a>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('img/principal/img2.png') }}" class="img-fluid rounded shadow standard-img" alt="Ubicación">
        </div>
    </div>

    <!-- Sección: Compromiso -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-12 text-center">
            <h3 class="section-subtitle">Nuestro Compromiso</h3>
            <p class="text-muted px-md-5 mb-4">
                Estamos comprometidos con la excelencia en el servicio, la seguridad del paciente y la satisfacción de nuestros clientes. 
                Cada intervención que realizamos está respaldada por protocolos rigurosos de calidad y un equipo que trabaja con pasión y dedicación.
            </p>
            <img src="{{ asset('img/principal/img3.png') }}" class="img-fluid rounded shadow standard-img-large" alt="Compromiso">
        </div>
    </div>

    <!-- Sección del mapa -->
    <div class="row mb-5" data-aos="zoom-in">
        <div class="col-12">
            <h3 class="section-subtitle text-center mb-4">Encuéntranos aquí</h3>
            <div class="map-container rounded shadow-lg overflow-hidden">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3807.2291959102186!2d-66.03775622483481!3d-17.40078508348874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93e37a727b2bcd7f%3A0xa08c569ee11093f7!2sHospital%20M%C3%A9xico!5e0!3m2!1ses-419!2sbo!4v1760750375271!5m2!1ses-419!2sbo" 
                    width="100%" 
                    height="500" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

</div>

<!-- Footer -->
<footer class="footer bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="text-uppercase mb-3">Servicio Técnico GAMS</h5>
                <p>Comprometidos con la excelencia en el mantenimiento de equipos médicos.</p>
                <div class="social-links mt-3">
                    <a href="#" class="text-white mr-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white mr-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white mr-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin fa-lg"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="text-uppercase mb-3">Contacto</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-map-marker-alt mr-2"></i> Hospital México, Sacaba </li>
                    <li class="mb-2"><i class="fas fa-phone mr-2"></i> +591 71443900</li>
                    <li class="mb-2"><i class="fas fa-envelope mr-2"></i> servicio.tecnico@gams.com</li>
                    <li class="mb-2"><i class="fas fa-clock mr-2"></i> Lun - Vie: 8:00 AM - 6:00 PM</li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="text-uppercase mb-3">Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">  <a href="{{url('/admin/tickets')}}" class="text-white">tickets</a></li>
                   
                </ul>
            </div>
        </div>
        <hr class="bg-light my-4">
        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-0">&copy; 2025 Servicio Técnico GAMS. Todos los derechos reservados.</p>
            </div>
        </div>
    </div>
</footer>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* General */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-divider {
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, #2980b9, #1b4f72);
            border: none;
            margin: 20px auto;
        }

        .section-title {
            color: #1b4f72;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 2.5rem;
        }

        .section-subtitle {
            color: #2980b9;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 2rem;
            position: relative;
            padding-bottom: 10px;
        }

        .section-subtitle::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, #2980b9, #1b4f72);
        }

        /* Carrusel */
        .carousel-img {
            height: 500px;
            object-fit: cover;
            filter: brightness(0.85);
            transition: filter 0.3s ease;
        }

        .carousel-item:hover .carousel-img {
            filter: brightness(1);
        }

        .carousel-caption {
            bottom: 80px;
        }

        .caption-content {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            padding: 20px 30px;
            backdrop-filter: blur(5px);
        }

        .carousel-caption h5 {
            font-weight: bold;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .carousel-caption p {
            font-size: 1.1rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .carousel-indicators li {
            background-color: #2980b9;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .carousel-indicators li.active {
            background-color: #1b4f72;
            width: 14px;
            height: 14px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(41, 128, 185, 0.8);
            border-radius: 50%;
            padding: 20px;
            transition: all 0.3s ease;
            width: 50px;
            height: 50px;
        }

        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background-color: rgba(27, 79, 114, 0.9);
            transform: scale(1.1);
        }

        /* Imágenes estandarizadas */
        .standard-img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .standard-img:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .standard-img-large {
            width: 100%;
            max-width: 900px;
            height: 450px;
            object-fit: cover;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .standard-img-large:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        /* Lista personalizada */
        .custom-list {
            list-style: none;
            padding-left: 0;
        }

        .custom-list li {
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .custom-list i {
            margin-right: 10px;
        }

        /* Grid de servicios */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .service-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #2980b9;
            transition: all 0.3s ease;
        }

        .service-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .service-item i {
            margin-right: 10px;
            font-size: 1.3rem;
        }

        /* Mapa */
        .map-container {
            border: 3px solid #2980b9;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1b4f72 0%, #2c3e50 100%);
        }

        .footer h5 {
            font-weight: bold;
            letter-spacing: 1px;
        }

        .footer a {
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #2980b9 !important;
        }

        .social-links a {
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .social-links a:hover {
            transform: translateY(-3px);
        }

        /* Botones */
        .btn {
            transition: all 0.3s ease;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2980b9, #1b4f72);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1b4f72, #2980b9);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(41, 128, 185, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .carousel-img {
                height: 300px;
            }

            .standard-img,
            .standard-img-large {
                height: 300px;
            }

            .section-title {
                font-size: 2rem;
            }

            .section-subtitle {
                font-size: 1.5rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Animación suave al cargar */
        .container-fluid {
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Inicializar AOS
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Inicializar carrusel con jQuery (Bootstrap 3/4)
        $(document).ready(function() {
            $('#carouselExampleCaptions').carousel({
                interval: 4000,
                pause: 'hover',
                wrap: true,
                keyboard: true
            });

            // Asegurar que los controles funcionen
            $('.carousel-control-prev').click(function() {
                $('#carouselExampleCaptions').carousel('prev');
            });

            $('.carousel-control-next').click(function() {
                $('#carouselExampleCaptions').carousel('next');
            });

            // Permitir clic en indicadores
            $('.carousel-indicators li').click(function() {
                var slideTo = $(this).data('slide-to');
                $('#carouselExampleCaptions').carousel(slideTo);
            });
        });

        // Smooth scroll para enlaces
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
@stop