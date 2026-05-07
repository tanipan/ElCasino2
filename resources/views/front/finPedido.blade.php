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

                    @if ($pago)
                        <div style="margin-left: 15px; margin-right: 15px" class="get_product">
                            <div style="text-align: center; color: #000;font-weight: bolder !important"
                                class="title get_product">
                                <h2 style="font-weight: bolder">¡Gracias por pedir El Casino!</h2>
                                <h4>Hemos recibido tu pedido {{ $order->order }} <br> <strong>corréctamente</strong>.</h4>
                            </div>
                            <div
                                style="
                                text-align: center;
                                color: #000;
                                margin-top: 20px;
                            ">
                                <p>Resumen de tu compra:</p>

                                <div id="cart2" style="display: flex;justify-content: center;align-items: center;">
                                    <div id="cesta-resumen-pedido" style="width: 50%">

                                    </div>
                                </div>

                                <p class="space"><strong>Nombre:</strong> {{ $custo->name }} {{ $custo->lastname }}</p>

                                @if ($order->time_ready)
                                    <p class="space">
                                        <strong>Hora de recogida del pedido:</strong> hoy a las {{ $order->time_ready }}
                                    </p>
                                @else
                                    <p class="space">
                                        <strong>En unos minutos tendrás tu pedido 😉</strong>
                                    </p>
                                @endif

                                <p><strong>Lugar de recogida:</strong> Calle Vidal Abarca 3, bajo</p>
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d342.5211040976555!2d-1.4269966109854384!3d37.85154445809935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd648e8d0d31454b%3A0x384bf56282999cc2!2sC.%20Postigos%2C%2030840%20Alhama%20de%20Murcia%2C%20Murcia!5e1!3m2!1ses!2ses!4v1682861704516!5m2!1ses!2ses"
                                    width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            <div class="col-sm-12" style="text-align: center; margin-top: 10px">
                                <a href="{{ route('front.recoger') }}" class="btn btn-primary">Nuevo pedido</a>
                            </div>
                        </div>
                    @else
                        <div style="margin-left: 15px; margin-right: 15px" class="get_product">
                            <div style="text-align: center; color: #000;font-weight: bolder !important"
                                class="title get_product">
                                <h2 style="font-weight: bolder;color: red">Lo sentimos</h2>
                                <h4>Pero no se ha podido cobrar correctamente tu pedido 😔</h4>
                            </div>
                            <div
                                style="
                                text-align: center;
                                color: #000;
                                margin-top: 20px;
                            ">
                                <p class="space">
                                    Inténtalo de nuevo
                                </p>
                            </div>
                            <div class="col-sm-12" style="text-align: center; margin-top: 10px">
                                <a href="{{ route('front.recoger') }}" class="btn btn-primary">Nuevo pedido</a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!-- Content -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            cargarResumenCesta();
        });

        function cargarResumenCesta() {
            $.get("{{ route('front.cargarPedidoRealizado') }}", {
                    "order": '{{ $order->order }}',
                    "boton": false,
                    "cleanCart": true
                },
                function(data, status) {
                    $('#cesta-resumen-pedido').html(data);

                    if (data.includes("vacío")) {
                        //window.location.reload();
                    }
                });
        }
    </script>
@endsection
