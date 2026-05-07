@extends('layouts.web')

@section('content')

    @php
        function esMesa2()
        {
            return isset(session()->get('login')['mesa']) and session()->get('login')['mesa'];
        }
        function esGestor()
        {
            return isset($customer['admin']) and $customer['admin'] or Auth::user();
        }

        function remplazarPatatas($descripcion)
        {
            return str_replace('Con patatas incluidas', '<strong>Con patatas incluidas</strong>', $descripcion);
        }
    @endphp

    <!-- Content -->

    <!-- Menu mobile -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden-lg" id="hscroll">
        @foreach ($carta as $item)
            @if ($item['tipo']->IsVisible)
                <div><a href="#categoria{{ $item['tipo']->id }}" class="active">{{ $item['tipo']->name }}</a></div>
            @endif
        @endforeach
    </div>
    <!-- /Menu mobile -->
    </div>
    </div>
    </div>
    </header>

    <section id="service" class="service">
        <div class="container">
            <div class="row">
                <div class="main_service_area sections text-center">
                    <div class="col-lg-2 hidden-md hidden-sm hidden-xs" id="category">
                        <div class="post1 fix">
                            <ul class="get_cate" style="top: 100px;margin-top: 13px;">
                                <li id="special">
                                    <a href="javascript:void(0);" id="cart" class="btn_cart"><i
                                            class="fa fa-shopping-basket"></i>&nbsp;CESTA&nbsp;&nbsp;&nbsp;
                                        <span id="totaal2"> 0 </span>
                                    </a>
                                </li>

                                @foreach ($carta as $item)
                                    @if ($item['tipo']->IsVisible)
                                        @if (!esGestor() and $item['tipo']->waiter_only)
                                            @php
                                                continue;
                                            @endphp
                                        @endif

                                        <li><a href="#categoria{{ $item['tipo']->id }}">{{ $item['tipo']->name }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @if (Session::get('error'))
                        <p style="color: red">{{ Session::get('error') }}</p>
                    @endif

                    <div class="col-lg-9 col-lg-offset-3 col-md-12" id="get_products">

                        @foreach ($carta as $item)
                            @if ($item['tipo']->IsVisible)
                                @if (!esGestor() and $item['tipo']->waiter_only)
                                    @php
                                        continue;
                                    @endphp
                                @endif

                                @if (!esMesa2() and $item['tipo']->room_only)
                                    @php
                                        //continue;
                                    @endphp
                                @endif

                                <!-- Categoria y platos -->
                                <div id="categoria{{ $item['tipo']->id }}" class="get_product">
                                    <div class="title">
                                        <h2 id="cate">{{ $item['tipo']->name }}<br /><small></small>
                                            <hr />
                                        </h2>
                                    </div>

                                    <div class="row rowmenu" style="margin-top: -10px">

                                        @foreach ($item['platos'] as $dish)
                                            @if ($dish->HasStock and !$dish->hidden)
                                                @if (!esMesa2() and $dish->room_only)
                                                    @php
                                                        continue;
                                                    @endphp
                                                @endif

                                                @if (esMesa2() and $dish->delivery_only)
                                                    @php
                                                        continue;
                                                    @endphp
                                                @endif

                                                @if (!esGestor() and $dish->waiter_only)
                                                    @php
                                                        continue;
                                                    @endphp
                                                @endif

                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pro"
                                                    data-dish-id="{{ $dish->id }}">
                                                    <div class="col-xs-12 item1">
                                                        <div class="col-xs-5 item-img-box">
                                                            <img src="{{ asset('images/' . ($dish->img1 ?: ($tema == 1 ? 'producto_k.jpg' : 'producto.jpg'))) }}"
                                                            alt="" class="ft2" />
                                                        </div>
                                                        <div class="col-xs-7 item-info">
                                                            <div class="panel-body">
                                                                <div class="col-xs-12 pname">
                                                                    <b style="font-size: 16px"> {{ $dish->name }} </b>
                                                                </div>
                                                                <div class="col-xs-12 pdes">
                                                                    {!! remplazarPatatas($dish->description) !!}

                                                                    @if (isset($customer['admin']) and $customer['admin'] or Auth::user())
                                                                        @if ($dish->room_only)
                                                                            <br>
                                                                            <strong style="color: red;font-size: 14px">SOLO
                                                                                EN
                                                                                LOCAL</strong>
                                                                        @endif
                                                                    @endif
                                                                </div>

                                                                <!-- <div class='panel-footer1'> -->

                                                                <div class="col-xs-12 pprice">
                                                                    <b>{{ $dish->price }}&nbsp;&euro;</b>
                                                                </div>
                                                                <!-- </div>  -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <!-- /Categoria y platos -->
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Content -->
@endsection
