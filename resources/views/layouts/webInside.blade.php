<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('assets/fontello/css/fontello.css') }}">

    @if ($titulo == 'RECOGER EN LA ARROCERIA')
        @if (isset($movil) and $movil)
            <link rel="stylesheet" href="{{ asset('assets/css/orden-movil.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('assets/css/recoger.css') }}">
        @endif
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/facturacion.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="{{ asset('vendor/jquery/jquery.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <title>Pide en EL CASINO</title>
</head>

<body>
    <div class="contenedor">
        <!-- Header Inicio -->
        <div class="header">
            @if (Auth::user() != null)
                <nav class="navbar navbar-expand-lg fondoNavbar "
                    style="background-color: rgb(36, 100, 202);font-size: 30px">
                    Desde la arrocería &nbsp;<a class="btn btn-success"
                        href="{{ route('admin.order.list', ['status' => 1]) }}">Volver</a>
                </nav>
            @endif
            <nav class="navbar navbar-expand-lg fondoNavbar ">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('front.index') }}">
                        <img style="color: white; width: 200px;" src="{{ asset('assets/img/logo-los-bartolos.png') }}"
                            alt="">
                    </a>
                    <button class="navbar-toggler float-end" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="bi bi-list text-white fs-1 my-2"></i>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarText">
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item ">
                                <a class="nav-link text-white {{ Route::current()->getName() == 'front.index' ? 'active border-bottom border-success border-2' : '' }}"
                                    href="{{ route('front.index') }}">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ Route::current()->getName() == 'front.carta' ? 'active border-bottom border-success border-2' : '' }}"
                                    href="{{ route('front.carta') }}">Carta</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ Route::current()->getName() == 'front.pedido' ? 'active border-bottom border-success border-2' : '' }}"
                                    href="{{ route('front.pedido') }}">Hacer pedido</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ Route::current()->getName() == 'front.contacto' ? 'active border-bottom border-success border-2' : '' }}"
                                    href="{{ route('front.contacto') }}">Contáctanos</a>
                            </li>

                            @if (!session()->get('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ Route::current()->getName() == 'front.login' ? 'active border-bottom border-success border-2' : '' }}"
                                        href="{{ route('front.login') }}">Acceder</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ Route::current()->getName() == 'front.registro' ? 'active border-bottom border-success border-2' : '' }}"
                                        href="{{ route('front.registro') }}">Registro</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ Route::current()->getName() == 'front.perfil' ? 'active border-bottom border-success border-2' : '' }}"
                                        href="{{ route('front.perfil') }}">Tu perfil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ Route::current()->getName() == 'front.logout' ? 'active border-bottom border-success border-2' : '' }}"
                                        href="{{ route('front.logout') }}">Salir</a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link" target="blank" href="https://facebook.com/858359344185966/">
                                    <i class="text-white bi bi-facebook"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" target="blank"
                                    href="https://www.instagram.com/restaurantelosbartolos/?hl=es">
                                    <i class="text-white bi bi-instagram"></i>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>


            <div class="d-flex justify-content-center p-3">
                <div class="contenedorTextoPrincipal d-flex justify-content-center mb-5">
                    <div class="text-center col-12 p-4 fs-1 fw-bold">

                        {{ $titulo }}

                        <br>

                    </div>

                </div>


            </div>

        </div>
        <!-- Header fin -->



        @yield('content')



        <!-- Modal -->
        <div class="modal fade" id="telefonoModal" tabindex="-1" role="dialog" aria-labelledby="telefonoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="telefonoModalLabel">Insertar número de teléfono</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="tel" class="form-control" name="telefono" placeholder="Número de teléfono"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Footer inicio -->
        <footer class="mt-5">
            <div style="background-color: rgba(255, 255, 255, 0.3);"
                class="w-100 d-lg-flex d-sm-block d-md-flex flex-wrap">

                <div class="col-lg-4 col-sm-12 p-3 text-center">
                    <ul class="p-0">
                        <li class="fs-3 fw-bold my-3">
                            Privacidad
                        </li>
                        <li>
                            <a class="fw-bold text-dark fs-5" href="{{ route('front.privacidad') }}">
                                Nosotros
                            </a>
                        </li>
                        <li>
                            <a class="fw-bold text-dark fs-5" href="{{ route('front.privacidad') }}">
                                Politicas de privacidad
                            </a>
                        </li>
                        <li>
                            <a class="fw-bold text-dark fs-5" href="{{ route('front.privacidad') }}">
                                Unete a nuestro equipo
                            </a>
                        </li>
                        <li>
                            <a class="fw-bold text-dark fs-5" href="{{ route('front.privacidad') }}">
                                Aviso legal
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-12 p-3 text-center">
                    <img class="img-fluid" src="assets/img/Copia de logo-los-bartolos.svg" alt="">
                </div>
                <div class="col-lg-4 col-sm-12 p-3">
                    <ul class="p-0">
                        <li class="fs-3 fw-bold text-center my-3">
                            Siguenos
                        </li>
                        <li class="text-center">
                            <a class="fw-bold text-dark d-flex justify-content-evenly" href="">
                                <a class="nav-link" target="blank" href="https://facebook.com/858359344185966/"
                                    style="color: rgb(33, 37, 41) !important">
                                    <i class="fs-1 bi bi-facebook"></i>
                                </a>
                                <a class="nav-link" target="blank"
                                    href="https://www.instagram.com/restaurantelosbartolos/?hl=es"
                                    style="color: rgb(33, 37, 41) !important">
                                    <i class="fs-1 bi bi-instagram "></i>
                                </a>
                            </a>
                        </li>
                        <li class="fs-3 fw-bold text-center my-3">
                            Contáctanos
                        </li>

                        <li class="text-center">
                            <a class="fw-bold fs-5 text-dark" href="">
                                <i class="bi bi-telephone-fill"></i>
                                868 920 297
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </footer>
        <!-- Footer fin -->

        <!-- Cookie Consent by TermsFeed (https://www.TermsFeed.com) -->
        <script type="text/javascript" src="https://www.termsfeed.com/public/cookie-consent/4.0.0/cookie-consent.js"
            charset="UTF-8"></script>
        <script type="text/javascript" charset="UTF-8">
            document.addEventListener('DOMContentLoaded', function() {
                cookieconsent.run({
                    "notice_banner_type": "simple",
                    "consent_type": "express",
                    "palette": "light",
                    "language": "es",
                    "page_load_consent_levels": ["strictly-necessary"],
                    "notice_banner_reject_button_hide": false,
                    "preferences_center_close_button_hide": false,
                    "page_refresh_confirmation_buttons": false
                });
            });
        </script>

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-4D22N8FJVN"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-4D22N8FJVN');
        </script>

    </div>

</body>

</html>
