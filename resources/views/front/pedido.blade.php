@extends('layouts.webInside')

@section('content')
    <!-- Sección pedir a domicilio o recoger en restaurantes inicio -->
    <div class="my-5 d-flex justify-content-center">
        <div class="col-12 col-lg-10  d-lg-flex d-block">
            <!--<div class="col-12 col-lg-6 d-flex justify-content-center">
                        <div class="text-center col-lg-8">
                            <img class="imagen-pedido" src="assets/img/imagen moto.png" alt="">
                            <div class="fs-5 fw-bold my-2">
                                Pedido a domicilio
                            </div>
                            <p>
                                Pide a domicilio los platos que mas te gusten y nosotros te lo llevamos
                            </p>
                            <a class="btn fondoVerde my-2" target="blank"
                                href="https://comoaqui.com/platos/restaurante/restaurante-los-bartolos">
                                <div class="fs-5">
                                    Pedir a domicilio
                                </div>
                            </a>

                        </div>

                    </div>-->
            <div class="col-12 col-lg-12 d-flex justify-content-center">
                <div class="text-center col-lg-8">
                    <img class="imagen-pedido" src="assets/img/imagen pedido empacado.png" alt="">
                    <div class="fs-5 fw-bold my-2">
                        Recoger en la arrocería
                    </div>
                    <p>
                        Pide a domicilio los platos que mas te gusten y lo podras recoger en nuestro restaurante
                    </p>
                    <a class="btn fondoVerde my-2" href="{{ route('front.recoger') }}">
                        <div class="fs-5">
                            Recoger en la arrocería
                        </div>
                    </a>

                </div>

            </div>
        </div>

    </div>
    <!-- Sección pedir a domicilio o recoger en restaurantes fin -->
@endsection
