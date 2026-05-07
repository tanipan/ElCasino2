<ul class="cd-cart-items">
    @php
        $total = 0;
        $i = 0;
    @endphp
    @if ($cestaHumana)
        @foreach ($cestaHumana as $k => $elemento)
            <li>
                <div id="pro_qty">{{ $elemento['unidades'] }}</div>
                <div id="pro_img"><img src="{{ asset('images/' . ($tema == 1 ? 'producto_k.jpg' : 'producto.jpg')) }}" alt="pro_img" /></div>
                <div id="pro_name">{{ $elemento['plato'] }}<br>
                    @foreach ($elemento['elementos'] as $ele)
                        <small>{{ $ele }}</small><br>
                    @endforeach
                </div>
                <div id="min_plus">
                    <div id="cart_item_price">
                        {{ $elemento['precio'] }} &euro;
                    </div>
                    <div id="cart_item_min_plus">
                        <span class="cd-button" style="display: block">
                            <a class="btn-min menos" href="#" data-plato-id="{{ $k }}">
                                <i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i>
                            </a>
                            <a class="btn-plus mas" href="#" data-plato-id="{{ $k }}">
                                <i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i>
                            </a>
                        </span>
                    </div>
                </div>
            </li>
            @php
                $total += $elemento['precio'];
                $i += $elemento['unidades'];
            @endphp
        @endforeach
    @else
    @endif
</ul>
@if ($i)
    <div class="cd-cart-total">
        <p>Total <span>{{ $total }} &euro;</span></p>
    </div>
    <!-- cd-cart-total -->

    @if (Auth::user() or isset(session()->get('login')['mesa']) and session()->get('login')['mesa'])
        {{-- <a href="{{ route('front.resumen') }}" class="checkout-btn" style="color: #f49819">HACER PEDIDO 🍔</a> --}}
        @if (1)
            <a href="{{ route('front.resumen') }}" class="checkout-btn" style="color: #f49819">HACER PEDIDO 🍔</a>
        @else
            <a href="#" class="checkout-btn" style="color: #f49819">Lo sentimos ya estamos agotados 😔</a>
        @endif
    @elseif ($web_abierta)
        @if (1)
            <a href="{{ route('front.resumen') }}" class="checkout-btn" style="color: #f49819">HACER PEDIDO 🍔</a>
        @else
            <a href="#" class="checkout-btn" style="color: #f49819">Lo sentimos ya estamos agotados 😔</a>
        @endif
    @else
        @if (isset(session()->get('login')['mesa']) and session()->get('login')['mesa'])
            {{-- <a href="{{ route('front.resumen') }}" class="checkout-btn" style="color: #f49819">HACER PEDIDO 🍔</a> --}}
            @if (1)
                <a href="{{ route('front.resumen') }}" class="checkout-btn" style="color: #f49819">HACER PEDIDO 🍔</a>
            @else
                <a href="#" class="checkout-btn" style="color: #f49819">Lo sentimos ya estamos agotados 😔</a>
            @endif
        @else
            <a href="#" class="checkout-btn" style="color: #f49819">Actualmente estamos cerrados 🔒</a>
        @endif
    @endif
@endif

<input type="hidden" id="total_cesta" value="{{ $i }}">

<script>
    $(".mas").click(function() {
        actualizarCesta("+", $(this).attr("data-plato-id"));
    });

    $(".menos").click(function() {
        actualizarCesta("-", $(this).attr("data-plato-id"));
    });

    function actualizarCesta(signo, plato) {
        $.get("{{ route('front.actualizarCesta') }}", {
                plato: plato,
                signo: signo
            },
            function(data, status) {
                cargarCesta();
            });
    }

    function enviar() {
        if ($("#total_cesta").html() != "0") {
            window.location.href = "{{ route('front.resumen') }}";
        } else {
            alert("La cesta está vacía");
        }
    }
</script>
