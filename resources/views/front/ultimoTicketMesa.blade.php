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
                        <h3 style="margin-bottom: 0;">
                            Contenido pendiente del ticket de la {{ session()->get('login')['cliente']->name }}
                        </h3>
                        <div id="cart2">
                            <div id="cesta-resumen-pedido-pendiente">

                            </div>
                        </div>
                        <h3 style="margin-bottom: 0;color: green">
                            Contenido a pagar
                        </h3>
                        <div id="cart2" style="color: green">
                            <div id="cesta-resumen-pedido-pagar">

                            </div>
                        </div>
                        <h3 style="margin-bottom: 0;color:gray">
                            Contenido pagado
                        </h3>
                        <div id="cart2" style="color:gray">
                            <div id="cesta-resumen-pedido-pagado">

                            </div>
                        </div>
                        <!-- /.table-responsive -->
                        <div class="box-footer">
                            <div class="pull-left">
                                <a href="{{ route('tableMenu') }}" class="btn_main"><i class="fa fa-chevron-left"></i>
                                    Volver al menú</a>
                            </div>
                        </div>
                        <br>
                        <br>
                        @if (session('cesta'))

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
        function actualizarCestas() {
            cargarResumenCestaPendiente();
            cargarResumenCestaPagar();
            cargarResumenCestaPagado();
        }

        $(document).ready(function() {
            actualizarCestas();
        });

        function cargarResumenCestaPendiente() {
            $.post("{{ route('front.cargarResumenCestaUltimoTicketMesa') }}", {
                    "botones": true,
                    "orders": "{{ implode(',', $orders) }}",
                    "type": "pendiente",
                    "_token": "{{ csrf_token() }}"
                },
                function(data, status) {
                    $('#cesta-resumen-pedido-pendiente').html(data);

                    if (data.includes("vacío")) {
                        //window.location.reload();
                    }
                });
        }

        function cargarResumenCestaPagar() {
            $.post("{{ route('front.cargarResumenCestaUltimoTicketMesa') }}", {
                    "botones": true,
                    "orders": "{{ implode(',', $orders) }}",
                    "type": "pagar",
                    "_token": "{{ csrf_token() }}"
                },
                function(data, status) {
                    $('#cesta-resumen-pedido-pagar').html(data);

                    if (data.includes("vacío")) {
                        //window.location.reload();
                    }
                });
        }

        function cargarResumenCestaPagado() {
            $.post("{{ route('front.cargarResumenCestaUltimoTicketMesa') }}", {
                    "botones": true,
                    "orders": "{{ implode(',', $orders) }}",
                    "type": "pagado",
                    "_token": "{{ csrf_token() }}"
                },
                function(data, status) {
                    $('#cesta-resumen-pedido-pagado').html(data);

                    if (data.includes("vacío")) {
                        //window.location.reload();
                    }
                });
        }

        $(function() {
            $("#siguiente").on("click", function() {
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
            });
        });

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
    </script>

    <script>
        // Obtener el elemento select
        var select = document.getElementById("time");

        // Obtener la hora actual
        var now = new Date();
        var currentHour = now.getHours();
        var currentMinute = now.getMinutes();

        // Recorrer las opciones del select y eliminar las franjas horarias pasadas
        for (var i = select.options.length - 1; i >= 1; i--) {
            var option = select.options[i];
            var [hour, minute] = option.value.split(":");

            if (currentHour > parseInt(hour) || (currentHour === parseInt(hour) && currentMinute > parseInt(minute))) {
                select.remove(i);
            }
        }
    </script>
@endsection
