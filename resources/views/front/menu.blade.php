@extends('layouts.web')

@section('content')
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

                    <div class="col-lg-9 col-lg-offset-3 col-md-12" id="" style="">
                        <div class="box">
                            <h3>Tus Opciones</h3>
                            <div class="separator4"></div>

                            <p class="text-center">
                                <a class="btn2 btn2menu" href="{{ route('front.recoger') }}">🍔 Ver la carta</a>
                            </p>

                            @if ($table->getOrders()->count())
                                <br><br>
                                <p class="text-center">
                                    <a class="btn2 btn2menu" href="{{ route('front.resumen.mesa') }}">🛒 Ver pedidos
                                        ({{ $table->getOrders()->count() }})</a>
                                </p>

                                <br><br>
                                <p class="text-center">
                                    <a class="btn2 btn2menu {!! $table->request_account ? 'btn2activo' : '' !!}"
                                        href="{{ $table->request_account ? '#' : route('front.cuenta.mesa') }}">💶 Pedir la
                                        cuenta</a>
                                </p>
                            @endif

                            <br><br>
                            <p class="text-center">
                                <a class="btn2 btn2menu {!! $table->notify_waiter ? 'btn2activo' : '' !!}"
                                    id="{{ $table->notify_waiter ? '' : 'notifyWaiter' }}"
                                    data-table="{{ session()->get('login')['cliente']->id }}">
                                    🙋🏻‍♂️ Avisar al camarero
                                </a>
                            </p>

                            @if (Auth::user())
                                <br><br>
                                <p class="text-center">
                                    <a class="btn2 btn2menu" href="{{ route('front.ultimoticket.mesa') }}">
                                        🧾 Ver el último ticket
                                    </a>
                                </p>
                            @endif

                            @if (!$table->getOrders()->count())
                                <br><br><br><br><br><br>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Content -->
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
@section('js')
    <script>
        $(document).ready(function() {
            $('#notifyWaiter').click(function() {
                $.get("{{ route('notifyWaiter') }}", {
                        table: $(this).attr("data-table")
                    },
                    function(data) {
                        location.reload();
                    });
            });
        });

        $(document).ready(function() {
            var isPaused = false;
            var time = 0;
            var t = window.setInterval(function() {
                if (!isPaused) {
                    time++;
                    if (time % 30 == 0) {
                        window.location.reload();
                    }
                }
            }, 300);
        });
    </script>
