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
                        <h3>
                            Hola {{ session()->get('login')['cliente']->name }}, selecciona tu forma de pago
                        </h3>

                        <div class="form-group col-sm-12" style="font-size: 20px">
                            <label for="cupon">Forma de pago</label>
                            <div>
                                <div class="form-group col-sm-6" id="discount">
                                    <select class="form-select" name="formaPago" id="formaPago">
                                        <option value="">- Forma de pago -</option>
                                        <option value="cash">Efectivo</option>
                                        <option value="card">Tarjeta</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-12" style="font-size: 20px">
                            <label for="cupon">¿Pagar la cuenta entre varios?</label>
                            <div>
                                <div class="form-group col-sm-6" id="discount">
                                    <select class="form-select" name="variosPagos" id="variosPagos">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>


                        <div class="col-sm-12" style="text-align:center">
                            <a name="notifyAccount" id="notifyAccount" class="btn btn-primary"
                                data-table="{{ session()->get('login')['cliente']->id }}"
                                style="border: 2px solid #f49819;border-radius: 5px;font-size: 20px !important;padding-bottom: 15px;">
                                <i class="fa fa-credit-card fa-2x" style="color: #f49819;"
                                    aria-hidden="true"></i>&nbsp;&nbsp;PEDIR
                                LA CUENTA</a>
                        </div>


                        <div id="cart2">
                            <br><br>
                            <div id="cesta-resumen-pedido">

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
        $(document).ready(function() {
            cargarResumenCesta();
        });

        function cargarResumenCesta() {
            $.post("{{ route('front.cargarResumenCestaMesa') }}", {
                    "botones": true,
                    "orders": "{{ implode(',', $orders) }}",
                    "_token": "{{ csrf_token() }}"
                },
                function(data, status) {
                    $('#cesta-resumen-pedido').html(data);
                    generarOpciones($('#total_cesta_pago').attr("data-total"));
                });
        }

        $(document).ready(function() {
            $('#notifyAccount').click(function() {
                var formaPago = $('#formaPago').val();

                if (!formaPago) {
                    alert("Selecciona una forma de pago");
                    return;
                }


                var divisionPago = $('#variosPagos').val();

                $.get("{{ route('notifyAccount') }}", {
                        table: $(this).attr("data-table"),
                        formaPago: formaPago,
                        divisionPago: divisionPago
                    },
                    function(data) {
                        location.href = "{{ route('tableMenu') }}";
                    });
            });
        });
    </script>

    <script>
        function generarOpciones(importe) {
            // Obtener el elemento select y limpiar las opciones actuales
            var selectPersonas = document.getElementById("variosPagos");
            selectPersonas.innerHTML = "";

            // Crear y agregar las opciones al select
            for (var i = 1; i <= 10; i++) {
                var opcion = document.createElement("option");
                opcion.value = i;
                opcion.text = "Dividir entre " + i + '. Por persona: ' + (importe / i).toFixed(2) + "€";
                selectPersonas.add(opcion);
            }
        }
    </script>


@endsection
