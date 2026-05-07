@php
    $customer = isset(Session::get('login')['cliente']) ? Session::get('login')['cliente'] : null;
    function esMesa()
    {
        return isset(session()->get('login')['mesa']) and session()->get('login')['mesa'];
    }
@endphp

<!DOCTYPE html>

<html class="no-js" lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Pide en El Casino</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="apple-touch-icon" href="" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">

    <link rel="stylesheet" href="{{ asset('css/fonticons.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />

    <!--For Plugins external css-->

    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />

    <!--Theme custom css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom1.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/extra.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/choose.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <!--Theme Responsive css-->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />

    <!--<script src="{{ asset('js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>-->

    @if (!Auth::user() and !esMesa())
        <!-- Cookie Consent by TermsFeed https://www.TermsFeed.com -->
        <script type="text/javascript" src="//www.termsfeed.com/public/cookie-consent/4.1.0/cookie-consent.js" charset="UTF-8">
        </script>
        <script type="text/javascript" charset="UTF-8">
            document.addEventListener('DOMContentLoaded', function() {
                cookieconsent.run({
                    "notice_banner_type": "interstitial",
                    "consent_type": "express",
                    "palette": "dark",
                    "language": "es",
                    "page_load_consent_levels": ["strictly-necessary"],
                    "notice_banner_reject_button_hide": false,
                    "preferences_center_close_button_hide": false,
                    "page_refresh_confirmation_buttons": false
                });
            });
        </script>

        <noscript>Free cookie consent management tool by <a href="https://www.termsfeed.com/">TermsFeed</a></noscript>
        <!-- End Cookie Consent by TermsFeed https://www.TermsFeed.com -->
    @endif

    <!-- Google tag (gtag.js) -->
    <!--<script async src="https://www.googletagmanager.com/gtag/js?id=G-4D22N8FJVN"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-4D22N8FJVN');
    </script>-->
    <style>
        :root {
            --tema-color: {{ $tema == 1 ? 'rgb(253 49 50)' : '#aad7d4' }};
        }
        .bg-tema {
            background-color: var(--tema-color) !important;
        }
        .text-tema {
            color: var(--tema-color) !important;
        }
        .border-tema {
            border-color: var(--tema-color) !important;
        }
    </style>
</head>

<body data-spy="scroll" data-target=".navbar-collapse">
    <div class="overlay"></div>

    <!-- CESTA -->
    <nav id="sidebar2">
        <div id="dismiss2">
            <i class="fa fa-times fa-lg" aria-hidden="true"></i>
        </div>
        <div class="sidebar-header">
            <h3>CESTA</h3>
        </div>
        <div id="sidebar-body"></div>
    </nav>
    <!-- /CESTA -->

    <header id="home_menu2" class="header navbar-fixed-top" style="background-color: var(--tema-color)">
        <div id="inner-header-wrapper" style="background-color: var(--tema-color)">
            <div id="inner-header" class="wrap cf">
                <div id="">
                    @if (Auth::user() == null and isset(session()->get('login')['mesa']) and session()->get('login')['mesa'])
                        <a rel="nofollow" href="{{ route('tableMenu') }}">
                            <img height="90" src="{{ asset('images/' . ($tema == 1 ? 'logo_su_k.png' : 'logo_su.png')) }}" alt="El Casino" />
                        </a>
                    @elseif (Auth::user() != null and isset(session()->get('login')['mesa']) and session()->get('login')['mesa'])
                        <a rel="nofollow" href="{{ route('admin.roomSituation') }}">
                            <img height="90" src="{{ asset('images/' . ($tema == 1 ? 'logo_su_k.png' : 'logo_su.png')) }}" alt="El Casino" />
                        </a>
                    @else
                        <a href="{{ url('/') }}" rel="nofollow">
                            <img height="90" src="{{ asset('images/' . ($tema == 1 ? 'logo_su_k.png' : 'logo_su.png')) }}" alt="El Casino" />
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="main_menu_bg">
            <div class="container">
                <div class="row" id="nav-component">
                    <div class="col-lg-3 col-md-5 col-sm-5 col-xs-5 navbar-header " id="left"
                        style="padding-top: 5px">
                        @if (isset($customer['admin']) and $customer['admin'] or Auth::user())
                            <a href="{{ route('admin.order.list', ['status' => 1]) }}" type="button"
                                class="btn btn-block btn-primary">Volver al
                                gestor</a>
                        @endif
                    </div>

                    <div class="col-lg-3 navbar-header visible-lg" id="left" style="padding-top: 5px">
                        @if (isset($customer['admin']) and $customer['admin'] or Auth::user())
                        @endif
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 visible-lg" id="center">
                        <ul class="nav top-nav2">
                            <li>
                                <p>
                                    &nbsp;
                                    <span id="underline_text"></span>
                                </p>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6" id="right">
                        @if ($customer)
                            <ul class="nav navbar-right top-nav" style="margin-block-start: 0px !important">
                                <li style="">
                                    @if (isset(session('login')['mesa']) and !session('login')['mesa'])
                                        <div style="">Hola de nuevo</div>
                                        <a style="padding: 0px !important;font-size: 19px !important;font-weight: bold !important"
                                            href="{{ route('front.perfil') }}">&nbsp;{{ $customer->name }}</a>
                                    @else
                                        <div style="font-size: 10px">&nbsp;</div>
                                        <a
                                            style="padding: 0px !important;font-size: 19px !important;font-weight: bold !important">&nbsp;{{ $customer->name }}</a>
                                    @endif
                                </li>
                                <li class="visible-lg"></li>
                            </ul>
                        @else
                            <ul class="nav navbar-right top-nav">
                                <li>
                                    {{-- <a href="#" data-toggle="modal" data-target="#login-modal"><i
                                            class="fa fa-user-o"></i>&nbsp;Iniciar sesión</a> --}}
                                </li>
                                <li class="visible-lg"></li>
                            </ul>
                        @endif
                    </div>

                    @yield('content')

                    <footer class="footer" style="background-color: var(--tema-color)">
                        <div id="inner-footer" class="wrap cf">
                            <div class="col-md-3">
                                <nav role="navigation">
                                    <div class="footer-links">
                                        <ul id="menu-menu-del-pie" class="nav footer-nav cf">
                                            <!--<li style="list-style: none" class="menu-item">
                                                <a href=""
                                                    style="color: #ffffff; text-decoration: none !important">Carta</a>
                                            </li>-->
                                            <!--<li style="list-style: none" class="menu-item">
                                                <a href=""
                                                    style="color: #ffffff; text-decoration: none !important">Contacto</a>
                                            </li>-->
                                            <li style="list-style: none" class="menu-item">
                                                <a href="{{ asset('assets/Alergenos.pdf') }}" target="_black"
                                                    style="color: #ffffff; text-decoration: none !important">Alérgenos</a>
                                            </li>
                                            <li style="list-style: none" class="menu-item">
                                                <a href="{{ route('cookies') }}"
                                                    style="color: #ffffff; text-decoration: none !important">Cookies</a>
                                            </li>
                                            <li style="list-style: none" class="menu-item">
                                                <a href="{{ route('privacidad') }}"
                                                    style="color: #ffffff; text-decoration: none !important">Política
                                                    de Privacidad</a>
                                            </li>
                                            <li style="list-style: none" class="menu-item">
                                                <a href="{{ route('legal') }}"
                                                    style="color: #ffffff; text-decoration: none !important">Aviso
                                                    Legal</a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <div class="col-md-6">
                                <div id="footer-middle">
                                    <p id="logo1">
                                        <a href="">
                                            <img style="max-width: 125px; margin: 0 auto; text-align: center"
                                                src="{{ asset('images/' . ($tema == 1 ? 'logo_su_k.png' : 'logo_su.png')) }}" alt="El Casino" />
                                        </a>
                                    </p>
                                    <small style="color: var(--tema-color)"><i class="second-copyright" aria-hidden="true"></i>
                                        &#9400;
                                        <script>
                                            document.write(new Date().getFullYear());
                                        </script>
                                        El Casino - Todos los derechos reservados
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-3" id="footer-right">
                                <ul class="social">
                                    <li>
                                        <a href="" target="_blank"><i class="fa fa-map-marker fa-lg"
                                                aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="" target="_blank"><i class="fa fa-facebook fa-lg"
                                                aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a href="" target="_blank"><i class="fa fa-instagram fa-lg"
                                                aria-hidden="true"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </footer>

                    <!-- Cesta -->
                    @if (
                        !in_array(Route::currentRouteName(), [
                            'front.resumen.mesa',
                            'tableMenu',
                            'front.cuenta.mesa',
                            'front.resumen',
                            'front.resumenFin',
                            'readToQr',
                        ]))
                        <div class="shopCart hidden-lg">
                            <div class="content" style="background-color: var(--tema-color) !important;">
                                <a href="javascript:void(0);" id="cart"><i
                                        class="fa fa-shopping-basket"></i>&nbsp;<span>CESTA</span>
                                    <span id="totaal1">&nbsp;&nbsp;&nbsp;0 </span>
                                </a>
                            </div>
                        </div>
                    @endif
                    <!-- /Cesta -->

                    <!-- Boton para subir al principio -->
                    <div class="scrollup">
                        <a href="#"><i class="fa fa-chevron-up"></i></a>
                    </div>
                    <!-- /Boton para subir al principio -->

                    <!-- Modal Inicio de sesion -->
                    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login"
                        aria-hidden="true">
                        <div class="vertical-alignment-helper">
                            <div class="modal-dialog modal-sm vertical-align-center">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">
                                            &times;
                                        </button>
                                        <h4 class="modal-title" id="Login">Iniciar Sesión</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="post">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="email1"
                                                    id="email1" placeholder="Correo electrónico" />
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password1"
                                                    id="password1" placeholder="Contraseña" />
                                            </div>

                                            <p class="error" style="color: red"></p>
                                            <p class="text-center">
                                                <a class="btn" id="enter">Iniciar Sesión</a>
                                            </p>
                                        </form>

                                        <p class="text-center text-muted">
                                            <a href="#" data-toggle="modal" data-target="#forgetPasswordModal"
                                                id="forget"><strong>Recuperar contraseña</strong></a>
                                        </p>
                                        <div class="line">
                                            <hr />
                                        </div>
                                        <p class="text-center text-muted" id="donker">
                                            ¿No te has registrado?
                                        </p>
                                        <p class="text-center">
                                            <a class="btn2" href="{{ route('front.registro') }}">registrarse</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Modal Inicio de sesion -->

                    <!-- Modal recuperar contraseña -->
                    <div class="modal fade" id="forgetPasswordModal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="vertical-alignment-helper">
                            <div class="modal-dialog vertical-align-center" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">
                                            &times;
                                        </button>
                                        <h4 class="modal-title" id="Login">Recuperar contraseña</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="post">
                                            <div class="form-group">
                                                <label for="email" class="control-label">Tu email: </label>
                                                <input type="text" class="form-control" name="email_recu"
                                                    id="email_recu" />
                                            </div>
                                            <p class="message" style="color: red"></p>
                                            <br />
                                            <p class="text-center">
                                                <a class="btn" href="#" id="verzenden">Enviar</a>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Modal recuperar contraseña -->

                    <!-- Modal plato -->
                    <div class="modal fade" id="choose_modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel"></div>
                    <!-- /Modal plato -->

                    <div class="modal fade" id="alert_modal" tabindex="-1" role="dialog"
                        aria-labelledby="alertLabel" aria-hidden="true"></div>
                    <div class="portfolio-modal modal fade" id="detail_modal" tabindex="-1" role="dialog"
                        aria-labelledby="detailLabel" aria-hidden="true"></div>

                    <script src="{{ asset('js/vendor/jquery-1.11.3.min.js') }}"></script>
                    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>

                    <script src="{{ asset('js/jquery.easypiechart.min.js') }}"></script>
                    <script src="{{ asset('js/jquery.mixitup.min.js') }}"></script>
                    <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
                    <script src="{{ asset('css/skills/inview.min.js') }}"></script>
                    <script src="{{ asset('js/main.js') }}"></script>
                    <script src="{{ asset('js/plugins.js') }}"></script>
                    <script src="{{ asset('js/service/jquery.scrollTo.min.js') }}"></script>
                    <script src="{{ asset('js/service/jquery.localScroll.min.js') }}"></script>
                    <script src="{{ asset('js/service/cs.js') }}"></script>
                    <script src="{{ asset('js/service/minAndPlus.js') }}"></script>
                    <script src="{{ asset('js/service/addAndDelQty.js') }}"></script>
                    <script src="{{ asset('js/addAndDel.js') }}"></script>
                    <script src="{{ asset('js/service/clearData.js') }}"></script>
                    <script src="{{ asset('js/login%EF%B9%96version=1.js') }}"></script>
                    <script src="{{ asset('js/offerPwd%EF%B9%96version=1.js') }}"></script>
                    <script src="{{ asset('js/forgetPwd.js') }}"></script>
                    <script>
                        $(function() {
                            $("a.showMobileMenu").click(function(e) {
                                e.preventDefault();
                                $("#mobileMenu").fadeToggle();
                                $(".main_menu_bg").fadeToggle();
                            });
                        });

                        $(".get_product .pro").on("click", function() {
                            var dish_id = $(this).data("dish-id")

                            $.get(
                                "{{ route('front.recuperarModalPlato') }}", {
                                    dish_id: dish_id
                                },
                                function(data) {
                                    $("#choose_modal").html(data);
                                    $("#choose_modal").modal("show");
                                }
                            );
                        });

                        //Desde aqui lanzamos los eventos tras la carga de la página
                        $(document).ready(function() {
                            //Cargar aqui la cesta
                            cargarCesta()
                        });

                        function cargarCesta() {
                            $.get("{{ route('front.cargarCesta') }}", {},
                                function(data, status) {
                                    $('#sidebar-body').html(data);
                                    $('#totaal1').html($('#total_cesta').val());
                                    $('#totaal2').html($('#total_cesta').val());
                                });
                        }

                        $(function() {
                            $("#enter1").on("click", function() {
                                $(".error").html("");
                                var self = $(this);
                                var email = $("#mail1").val().trim();
                                var password = $("#password1").val().trim();
                                var rid = self.attr("rid");
                                var preg = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,})$/;
                                if (email == "" || !preg.test(email)) {
                                    $(".error").html("Correo electrónico no válido.");
                                } else if (password == "") {
                                    $(".error").html("El campo de contraseña no puede estar vacío.");
                                } else {
                                    $.post(
                                        "{{ route('front.validarLogin') }}", {
                                            email: email,
                                            password: password,
                                            "_token": "{{ csrf_token() }}"
                                        },
                                        function(msg) {
                                            if (msg == "ko") {
                                                $(".error").html(
                                                    "La contraseña es incorrecta."
                                                );
                                            } else if (msg == "ok") {
                                                location.reload();
                                            }
                                        }
                                    );
                                }
                            });

                            $("#enter").on("click", function() {
                                var self = $(this);
                                var email = $("#email1").val().trim();
                                var password = $("#password1").val().trim();
                                var rid = self.attr("rid");
                                var preg = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,})$/;
                                if (email == "" || !preg.test(email)) {
                                    $(".error").html("Correo electrónico no válido.");
                                } else if (password == "") {
                                    $(".error").html("El campo de contraseña no puede estar vacío.");
                                } else {
                                    $.post(
                                        "{{ route('front.validarLogin') }}", {
                                            email: email,
                                            password: password,
                                            "_token": "{{ csrf_token() }}"
                                        },
                                        function(msg) {
                                            if (msg == "ko") {
                                                $(".error").html(
                                                    "La contraseña ingresada no coincide con tu cuenta."
                                                );
                                            } else {
                                                location.reload();
                                            }
                                        }
                                    );
                                }
                            });

                            $("#login").on("click", function() {
                                var self = $(this);
                                var email = $("#mail").val().trim();
                                var password = $("#password").val().trim();
                                var rid = self.attr("rid");
                                var preg = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,})$/;
                                if (email == "" || !preg.test(email)) {
                                    $(".error").html("Correo electrónico no válido.");
                                } else if (password == "") {
                                    $(".error").html("El campo de contraseña no puede estar vacío.");
                                } else {
                                    $.post(
                                        "{{ route('front.validarLogin') }}", {
                                            mail: email,
                                            password: password,
                                            "_token": "{{ csrf_token() }}"
                                        },
                                        function(msg) {
                                            console.log(msg);
                                            if (msg == "ongeldig") {
                                                $(".error").html(
                                                    "La contraseña ingresada no coincide con tu cuenta."
                                                );
                                            } else {
                                                //location.href = "../profiel/";
                                            }
                                        }
                                    );
                                }
                            });
                        });

                        $(document).ready(function() {
                            $("#name").focus();
                            $("#registrarse").click(function() {
                                if ($("#name").val() && $("#lastname").val() && $("#email").val() && $("#phone").val()) {

                                    if ($("#password").val() == $("#password2").val()) {

                                        if ($("#password").val().length >= 6) {
                                            if (document.getElementById('terminos').checked) {
                                                $("#formu_registro").submit();
                                            } else {
                                                alert("Debes de aceptar los Términos y Condiciones");
                                            }
                                        } else {
                                            alert("La contraseña debe de tener más de 6 caracteres");
                                        }
                                    } else {
                                        alert("Las contraselas no coinciden");
                                    }
                                } else {
                                    alert("Inserta todos los datos");
                                }
                            });
                        });

                        $(".link2").on("click", function() {
                            $("#link2").toggle();
                        });

                        $(".link1").on("click", function() {
                            $("#link1").toggle();
                        });

                        $(function() {
                            $("#verzenden").on('click', function() {
                                var self = $(this);
                                var email = $("#email_recu").val().trim();
                                var rid = self.attr('rid');
                                var preg = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,})$/;
                                if (email == '' || !preg.test(email)) {
                                    $(".message").html("Correo electrónico no válido!");
                                } else {
                                    $.post('{{ route('front.recordar1') }}', {
                                        email: email,
                                        "_token": "{{ csrf_token() }}"
                                    }, function(msg) {
                                        if (msg == "ko") {
                                            $(".message").html(
                                                "No hay una cuenta asociada con este correo electrónico!");
                                        } else {
                                            $("#forgetPasswordModal").modal('hide').data('bs.modal', null);
                                            //showAlert("Te hemos enviado un correo para recuperar tu contraseña");
                                        }
                                    });
                                }
                            });
                        })
                    </script>


</body>

</html>
