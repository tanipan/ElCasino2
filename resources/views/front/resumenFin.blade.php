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
                    @if (isset(session()->get('login')['mesa']) and session()->get('login')['mesa'])
                        <div class="col-md-10 col-md-offset-1" style="text-align: center">
                        @else
                            <div class="col-md-10 col-md-offset-1">
                    @endif


                    @if (Auth::user() != null and !isset(session()->get('login')['mesa']))
                        <h3>Pedido {{ $order->order }} realizado</h3>
                    @else
                        @if (isset(session()->get('login')['mesa']) and session()->get('login')['mesa'])
                            <br>
                            <h3
                                style="text-align: center;
                                font-size: 2.575rem;
                                line-height: 4rem;
                                margin-bottom: 15px;
                                border: 5px solid #f49819;
                                border-radius: 7px;">
                                Pedido
                                <span style="color: #f49819">{{ explode('-', $order->order)[1] }}</span> realizado
                            </h3>
                        @else
                            <h3>Casi listo el Pedido {{ $order->order }}, solo queda el pago</h3>
                        @endif
                    @endif

                    @if (isset(session()->get('login')['mesa']) and session()->get('login')['mesa'])
                        <br><br><br>
                        <h3>Tu pedido está en marcha</h3>
                        <br><br>
                        <p class="text-center">
                            <a class="btn2" href="{{ route('tableMenu') }}">Volver al menú</a>
                        </p>
                    @else
                        @if (Auth::user() == null)
                            <div class="pull-right">
                                <div id="payment_style">
                                    <img width="100px" src="{{ asset('images/tarjetas.png') }}" alt="payment" />
                                </div>
                                {!! $form !!}
                            </div>

                            <!-- /.table-responsive -->
                            @if (Auth::user() == null)
                                <div id="gegevens">
                                    <h3>Información para tu recogida</h3>

                                    Número de pedido: <b>{{ $order->order }}</b><br />
                                    @if ($customer)
                                        Nombre completo: <b>{{ $customer->name }} {{ $customer->lastname }}</b><br />
                                        Teléfono: <b>{{ $customer->phone }}</b><br />
                                        Correo electrónico: <b>{{ $customer->email }}</b><br />
                                    @else
                                        Nombre completo: <b>{{ $guest->name }} {{ $guest->lastname }}</b><br />
                                        Teléfono: <b>{{ $guest->phone }}</b><br />
                                        Correo electrónico: <b>{{ $guest->email }}</b><br />
                                    @endif

                                    Lugar de recogida: <b>Calle Vidal Abarca 3, bajo</b><br />

                                    @if ($order->time_ready)
                                        Hora de recogida: <b>{{ date('d-m-Y') }} {{ $order->time_ready }}</b><br />
                                    @else
                                        Hora de recogida: <b>{{ $hora_recogida }}</b><br />
                                    @endif
                                </div>
                            @endif

                        @endif

                        <div id="cart2">
                            <div id="cesta-resumen-pedido">

                            </div>
                        </div>
                    @endif
                    <br /><br />
                    <div class="box-footer" id="box-footer">
                        <div class="pull-left">
                        </div>

                        @if (Auth::user())
                            @if ($order->table)
                                <a href="{{ route('admin.roomSituation') }}" class="btn btn-primary" id="volver_gestor">
                                    <i class="fa fa-2x" aria-hidden="true"></i>&nbsp;&nbsp; Volver al
                                    gestor&nbsp;&nbsp;<i class="fa fa-chevron-right"></i>
                                </a>
                            @else
                                <a href="{{ route('admin.order.list', ['status' => 2]) }}" class="btn btn-primary"
                                    id="volver_gestor">
                                    <i class="fa fa-2x" aria-hidden="true"></i>&nbsp;&nbsp; Volver al
                                    gestor&nbsp;&nbsp;<i class="fa fa-chevron-right"></i>
                                </a>
                            @endif
                        @endif
                    </div>
                    <br />
                    <!-- /.box -->
                </div>
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
            $.get("{{ route('front.cargarResumenCesta') }}", {
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

    @if (Auth::user())
        @if ($order->table)
            <script>
                setTimeout("window.location.href=\"{{ route('admin.roomSituation') }}\";", 3000);
            </script>
        @else
            <script>
                setTimeout("window.location.href=\"{{ route('admin.order.list', ['status' => 2]) }}\";", 3000);
            </script>
        @endif
    @endif
@endsection
