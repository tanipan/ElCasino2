@extends('layouts.web')

@section('content')
    @php
        $customer = isset(Session::get('login')['cliente']) ? Session::get('login')['cliente'] : null;
    @endphp

    <!-- Content -->

    <!-- Menu mobile -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden-lg" id="hscroll">

    </div>
    <!-- /Menu mobile -->
    </div>
    </div>
    </div>
    </header>

    <section id="service" class="service">
        <div class="container">
            <div class="row">
                <div class="main_service_area sections">
                    <div class="col-md-10 col-md-offset-1">
                        <h3>Revisa tu cesta 🤔 </h3>

                        @if (!isset(session()->get('login')['mesa']) or !session()->get('login')['mesa'])
                        @else
                            <div class="col-sm-12" style="text-align:center">
                                <a name="siguiente" id="siguiente" class="btn btn-primary"
                                    style="border: 2px solid #f49819;border-radius: 5px;font-size: 13px !important;padding-bottom: 15px;">
                                    <i class="fa fa-shopping-cart fa-2x" style="color: #f49819;"
                                        aria-hidden="true"></i>&nbsp;&nbsp;FINALIZAR PEDIDO</a>
                            </div>
                            <br>
                        @endif

                        <div id="cart2">
                            <div id="cesta-resumen-pedido">

                            </div>
                        </div>


                        <!-- /.table-responsive -->
                        <div class="box-footer">
                            <div class="pull-left">
                                <a href="{{ route('front.recoger') }}" class="btn_main"><i class="fa fa-chevron-left"></i>
                                    Seguir comprando 🛒</a>
                            </div>
                            @if (Auth::user() and Auth::user()->role == 'admin')
                                <div class="pull-left">
                                    <select class="btn_main" style="margin-top: -7px" id="descuento">
                                        <option value="">- Descuento -</option>
                                        <option value="5">5%</option>
                                        <option value="10">10%</option>
                                        <option value="20">20%</option>
                                        <option value="30">30%</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                        <br>
                        <br>
                        @if (session('cesta'))

                            @if (Auth::user() == null)
                                @if (isset(session()->get('login')['mesa']) and session()->get('login')['mesa'])
                                    <div class="col-md-12" id="pspace">
                                        <h3>Hola {{ session()->get('login')['cliente']->name }}</h3>
                                    </div>
                                @else
                                    <div class="col-md-12" id="pspace">
                                        <h3>Información de usuario</h3>
                                    </div>
                                @endif
                            @endif

                            <div id="gegevens" class="col-lg-7 col-md-7 col-sm-12 col-xs-12">

                                @if (Auth::user() == null)
                                    <div class="col-sm-12" id="im">
                                        <p style="font-size: 16px;">
                                            @if (!$customer)
                                                HACER COMPRA COMO INVITADO
                                            @else
                                                @if (isset(session()->get('login')['mesa']) and !session()->get('login')['mesa'])
                                                    Hola, {{ $customer->name }} {{ $customer->lastname }}
                                                @endif
                                            @endif
                                        </p>
                                    </div>
                                @endif

                                <form method="post" id="formuPedido" action="{{ route('front.resumenFin') }}">
                                    @csrf
                                    @if (Auth::user() == null)
                                        @if (isset(session()->get('login')['mesa']) and session()->get('login')['mesa'])
                                            <div class="col-md-12 res " style="font-weight: bolder;margin-bottom:15px;">
                                                <p style="font-size:16px;">Si estás listo para disfrutar, finaliza tu
                                                    pedido.
                                                </p>
                                            </div>
                                            <br>
                                        @else
                                            <div class="col-md-12 res " style="font-weight: bolder;margin-bottom:15px;">
                                                <p style="font-size:16px;">Recoge tu pedido en Calle Vidal Abarca 3, bajo
                                                </p>
                                            </div>
                                        @endif
                                    @endif
                                    <input type="hidden" name="formaPago" id="formaPago" value="">


                                    @if (!$customer)
                                        <div id="userInfo">
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                <label for="firstname" style="font-weight: bolder">Nombre: </label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    value="">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                <label for="naam" style="font-weight: bolder">Apellido: </label>
                                                <input type="text" name="lastname" id="lastname" class="form-control"
                                                    value="">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                <label for="tel"style="font-weight: bolder">Teléfono: </label>
                                                <input type="text" name="phone" id="phone" class="form-control"
                                                    value="">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                <label for="email" style="font-weight: bolder">Correo electrónico:
                                                </label>
                                                <input type="text" name="email" id="email" class="form-control"
                                                    value="">
                                                @error('email')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif

                                    @if (Auth::user() == null)
                                        @if (!isset(session()->get('login')['mesa']))
                                            <div class="form-group col-sm-12">
                                                <label for="cupon">¿Quieres recoger el pedido a alguna hora?</label>
                                                <div>
                                                    <div class="form-group col-sm-6" id="discount">
                                                        <select class="form-select" name="time" id="time">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif


                                    @if (Auth::user() == null)
                                        @if (!isset(session()->get('login')['mesa']))
                                            <div class="form-group col-sm-12">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox"
                                                        {{ Auth::user() != null ? 'checked' : '' }} id="condiciones"
                                                        name="condiciones">
                                                    He leído y acepto la <a target="_black"
                                                        href="{{ route('privacidad') }}"><strong>política de
                                                            privacidad.</strong></a>
                                                </label>
                                                @if (!$customer)
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" id="newsletter"
                                                            name="newsletter">
                                                        Consiento la
                                                        recepción de comunicaciones del restaurante por e-mail y/o SMS con
                                                        fines
                                                        comerciales.
                                                    </label>
                                                @endif
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <p class="dmsg"></p>
                                            </div>
                                        @endif
                                    @endif
                                    <p class="error2" style="font-size:14px;color: red"></p>

                                    @if (Auth::user() != null and !isset(session()->get('login')['mesa']))
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <table style="width: 100%">
                                                        <tr>
                                                            <td style="
                                                        line-height: 1.4;
                                                        font-size: 1.2rem;
                                                        text-align: left;
                                                        cursor: pointer;
                                                        padding: 10px 0px;
                                                        font-family: "Quicksand",
                                                                sans-serif; color: #000; font-weight: 700;">Num. Comoaqui
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td style="line-height: 1.4;
                                                        font-size: 1.2rem;
                                                        text-align: left;
                                                        cursor: pointer;
                                                        padding: 10px 0px;
                                                        font-family: "Quicksand",
                                                                sans-serif; color: #000; font-weight: 700;">Hora preparación
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td style="line-height: 1.4;
                                                        font-size: 1.2rem;
                                                        text-align: left;
                                                        cursor: pointer;
                                                        padding: 10px 0px;
                                                        font-family: "Quicksand",
                                                                sans-serif; color: #000; font-weight: 700;">Comentarios
                                                                Cocina
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="num_comoaqui"
                                                                    id="num_comoaqui" class="form-control">
                                                            </td>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                            <td>
                                                                <input type="time" name="time" id="time"
                                                                    class="form-control">
                                                            </td>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                            <td>
                                                                <textarea name="comentario_cocina" id="comentario_cocina" cols="60" rows="5" class="form-control"></textarea>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br><br><br><br>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <br>
                                    @endif

                                    <div class="col-sm-12" style="text-align:center">
                                        <input type="hidden" id="hayLogin2" name="hayLogin2"
                                            value="{{ Session::get('login') == null ? '0' : '1' }}">
                                        <input type="hidden" id="hayCesta2" value="">

                                        @if (!isset(session()->get('login')['mesa']) or !session()->get('login')['mesa'])
                                            @if (Auth::user() != null)
                                                @if (Auth::user() and Auth::user()->name == 'Comoaqui')
                                                    <a name="siguiente" id="siguienteComoaqui"
                                                        class="btn btn-primary">COMOAQUI</a>
                                                @else
                                                    @if (session()->get('modificar_pedido'))
                                                        <a name="siguiente" id="siguienteTpvFisico"
                                                            class="btn btn-primary">MODIFICAR PEDIDO</a>
                                                    @else
                                                        <a name="siguiente" id="siguienteEfectivo"
                                                            class="btn btn-primary">PAGAR
                                                            EN EFECTIVO</a>
                                                        <a name="siguiente" id="siguienteTpvFisico"
                                                            class="btn btn-primary">PAGAR
                                                            CON TPV</a>
                                                    @endif
                                                @endif
                                            @else
                                                <a name="siguiente" id="siguiente" class="btn btn-primary"><i
                                                        class="fa fa-credit-card fa-2x"
                                                        aria-hidden="true"></i>&nbsp;&nbsp;CONTINUA
                                                    CON EL PAGO</a>
                                            @endif
                                        @else
                                            <a name="siguiente" id="siguiente22" class="btn btn-primary"
                                                style="border: 2px solid #f49819;border-radius: 5px;font-size: 20px !important;padding-bottom: 15px;">
                                                <i class="fa fa-shopping-cart fa-2x" style="color: #f49819;"
                                                    aria-hidden="true"></i>&nbsp;&nbsp;FINALIZAR PEDIDO</a>
                                        @endif

                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
                            </div>

                            @if (!$customer)
                                <div class="col-lg-4 col-md-4 hidden-sm hidden-xs" id="loginform">
                                    <div class="col-sm-12 text-center">
                                        <h4 class="modal-title" id="Login">Inicia sesión si ya te has registrado</h4>
                                    </div>
                                    <form action="{{ route('front.validarLogin') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="mail1" id="mail1"
                                                placeholder="Correo electrónico">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password1" id="password1"
                                                placeholder="Contraseña">
                                        </div>
                                        <p class="text-center text-muted"><a href="#" data-toggle="modal"
                                                data-target="#forgetPasswordModal" id="forget"><strong>Recuperar
                                                    contraseña</strong></a>
                                        </p>
                                        <p class="error" style="color: #EE2737;text-align: center"></p>
                                        <p class="text-center">
                                            <a class="btn_main" id="enter1" rid="11">Iniciar Sesión</a>
                                        </p>
                                    </form>
                                </div>
                            @endif
                        @endif
                        <!-- /.box -->
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Content -->

    <!-- Modal password -->
    <div class="modal fade" id="choose_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="padding: 17px 16px 0 16px">
                <div class="modal-header">
                    <h5 class="modal-title">Aplicar descuento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Contraseña</label>
                            <input type="password" id="discount_pass" class="form-control" id="recipient-name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn_aplicar">Aplicar descuento</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal password -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            cargarResumenCesta();
        });

        function cargarResumenCesta() {
            $.get("{{ route('front.cargarResumenCesta') }}", {
                    "botones": true
                },
                function(data, status) {
                    $('#cesta-resumen-pedido').html(data);

                    if (data.includes("vacío")) {
                        //window.location.reload();
                    }
                });
        }

        $(function() {
            $("#siguiente").on("click", function() {
                finalizarPedido2();
            });

            $("#siguiente22").on("click", function() {
                finalizarPedido2();
            });
        });

        function finalizarPedido2() {
            $(".error2").html("");

            $("#hayCesta2").val($("#hayCesta").val());
            $("#hayLogin2").val({{ Session::get('login') == null ? '0' : '1' }});

            var cesta = $("#hayCesta2").val();
            var login = $("#hayLogin2").val();

            if (cesta == 1) {
                if (login != 1) {

                    var self = $(this);
                    var email = $("#email").val().trim();
                    var name = $("#name").val().trim();
                    var lastname = $("#lastname").val().trim();
                    var phone = $("#phone").val().trim();

                    var preg = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,})$/;
                    if ((name == "") || (lastname == "") || (phone == "") || (email == "")) {
                        $(".error2").html("Inserta todos tus datos de contacto.");
                    } else if (!preg.test(email)) {
                        $(".error2").html("Correo electrónico no válido.");
                    } else {

                        if ($('#condiciones').is(':checked')) {
                            $('#formuPedido').submit();
                        } else {
                            $(".error2").html("Debes de aceptar las condiciones");
                            alert("Debes de aceptar las condiciones");
                        }
                    }
                } else {

                    @if (isset(session()->get('login')['mesa']) and session()->get('login')['mesa'])
                        $('#formuPedido').submit();
                    @else
                        if ($('#condiciones').is(':checked')) {
                            $('#formuPedido').submit();
                        } else {
                            $(".error2").html("Debes de aceptar las condiciones");
                            alert("Debes de aceptar las condiciones a");
                        }
                    @endif
                }
            } else {
                $(".error2").html("No se puede seguir sin elementos en la cesta");
                alert("No se puede seguir sin elementos en la cesta");
            }
        }

        $(function() {
            $("#siguienteEfectivo").on("click", function() {
                $('#formaPago').val("cash");
                enviarFormu();
            });
        });

        $(function() {
            $("#siguienteComoaqui").on("click", function() {
                $('#formaPago').val("ca");

                var order_ca = $("#num_comoaqui").val().trim();
                var time = $("#time").val().trim();

                if ((order_ca == "") || (time == "")) {
                    alert("Inserta los datos de Comoaqui");
                } else {
                    enviarFormu();
                }
            });
        });

        $(function() {
            $("#siguienteTpvFisico").on("click", function() {
                $('#formaPago').val("card");
                enviarFormu();
            });
        });

        function enviarFormu() {
            $(".error2").html("");

            $("#hayCesta2").val($("#hayCesta").val());
            $("#hayLogin2").val({{ Session::get('login') == null ? '0' : '1' }});

            var cesta = $("#hayCesta2").val();
            var login = $("#hayLogin2").val();

            if (cesta == 1) {
                $('#formuPedido').submit();
            } else {
                $(".error2").html("No se puede seguir sin elementos en la cesta");
                alert("No se puede seguir sin elementos en la cesta");
            }
        }


        //Aplicación del descuento de empleado
        $("#descuento").change(function() {
            $("#choose_modal").modal("show");
        });

        $("#btn_aplicar").click(function() {

            var descuento = $("#descuento").val();
            var sb64 = btoa($('#discount_pass').val());

            if (descuento != "") {

                //if (sb64 == "bG9hcGxpY29wb3JxdWVxdWllcm8=") {
                if (sb64 == "ODM4Nzk4") {

                    $.get('{{ route('front.setearDescuento') }}', {
                            descuento: descuento
                        },
                        function(resp) {

                            location.reload();
                            $('#choose_modal').modal('hide');
                            $("#descuento").val("");
                        });

                } else {
                    alert("Contraseña incorrecta");
                }
            } else {
                alert("Selecciona un descuento");
            }

            $('#discount_pass').val("");

        });

        //Aplicación del descuento de empleado
        ////////

        // function controlFranjas_() {
        //     const select = document.getElementById("time");

        //     // Obtener la hora actual
        //     const horaActual = new Date();

        //     // Obtener la hora actual más 15 minutos
        //     const horaLimite = new Date();
        //     horaLimite.setMinutes(horaLimite.getMinutes() + {{ $margen_seleccion_franja }});

        //     // Generar opciones de franjas horarias
        //     for (let hora = {{ $franja_inicio }}; hora <= {{ $franja_fin }}; hora++) {
        //         for (let minuto = 0; minuto < 60; minuto += {{ $saltos_franjas }}) {

        //             if ((hora == {{ $franja_fin }}) && (minuto > 0)) {
        //                 continue;
        //             }

        //             // Crear una nueva fecha con la hora y el minuto actual
        //             const fechaFranja = new Date();
        //             fechaFranja.setHours(hora);
        //             fechaFranja.setMinutes(minuto);

        //             // Crear una opción para el select
        //             const opcion = document.createElement("option");
        //             opcion.value = `${hora}:${minuto}`;
        //             opcion.textContent = `${hora.toString().padStart(2, "0")}:${minuto
    //       .toString()
    //       .padStart(2, "0")}`;

        //             // Eliminar las franjas horarias que están dentro de los próximos 15 minutos
        //             if (fechaFranja < horaLimite) {
        //                 opcion.remove();
        //             } else {
        //                 // Agregar la opción al select
        //                 select.appendChild(opcion);
        //             }
        //         }
        //     }
        // }
        // controlFranjas_()
    </script>

    <script>
        // Obtener el elemento select
        // var select = document.getElementById("time");

        // // Obtener la hora actual
        // var now = new Date();
        // var currentHour = now.getHours();
        // var currentMinute = now.getMinutes();

        // // Recorrer las opciones del select y eliminar las franjas horarias pasadas
        // for (var i = select.options.length - 1; i >= 1; i--) {
        //     var option = select.options[i];
        //     var [hour, minute] = option.value.split(":");

        //     if (currentHour > parseInt(hour) || (currentHour === parseInt(hour) && currentMinute > parseInt(minute))) {
        //         select.remove(i);
        //     }
        // }
    </script>

    <script>
        function padNumber(num) {
            return num < 10 ? '0' + num : num;
        }

        function addOptionsToSelect(startHour, endHour, interval, selectElement) {
            const now = new Date();
            const currentHour = now.getHours();
            const currentMinute = now.getMinutes();

            // Calcular el margen de 15 minutos a partir de la hora actual
            const nowInMinutes = (currentHour * 60) + currentMinute;
            const margin = {{ $margen_seleccion_franja }};

            for (let hour = startHour; hour <= endHour; hour++) {
                for (let minute = 0; minute < 60; minute += interval) {
                    // Para la última hora, solo agregar hasta 23:00
                    if (hour === 23 && minute > 0) break;

                    const timeInMinutes = (hour * 60) + minute;
                    if (timeInMinutes - nowInMinutes >= margin) { // Mostrar solo si hay más de 15 minutos de margen
                        let option = document.createElement('option');
                        option.value = padNumber(hour) + ':' + padNumber(minute);
                        option.text = padNumber(hour) + ':' + padNumber(minute);
                        selectElement.appendChild(option);
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const timeSelect = document.getElementById('time');
            addOptionsToSelect(20, 23, 10, timeSelect); // Rellenar de 20:00 a 23:00
        });
    </script>

@endsection
