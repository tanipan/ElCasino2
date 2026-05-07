@php
    $total = 0;
    $i = 0;
@endphp

@if ($cestaHumana)

    <input type="hidden" id="hayCesta" value="{{ Session::get('cesta') == null ? '0' : '1' }}">

    <table class="table">
        <thead>
            <tr>
                <th>Plato</th>
                <th class="table_center">Cantidad</th>
                <th class="table_center">Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cestaHumana as $k => $elemento)
                @php
                    $importe_actual = ($elemento['precio'] / $elemento['unidades']) * $elemento['unidadesPagadas'];
                @endphp

                <tr>
                    <td style="word-break:break-all;" id="pro_name_img">
                        <!--<div id="pro_img">
                            <img src="{{ asset('images/' . $elemento['img1']) }}" alt="pro_img">
                        </div>-->
                        <div>{{ $elemento['plato'] }}
                            @foreach ($elemento['elementos'] as $ele)
                                <br><small>{{ $ele }}</small>
                            @endforeach
                        </div>
                    </td>
                    <td width="20%" class="table_center" style="vertical-align: middle">
                        <b style="padding-left: 3px; padding-right: 3px">{{ $elemento['unidadesPagadas'] }}</b>
                    </td>

                    <td width="20%" class="table_center" style="vertical-align: middle">{{ $importe_actual }}
                        &euro;</td>
                </tr>
                @php
                    $total += $importe_actual;
                    $i += $elemento['unidades'];
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            @if (session()->get('descuento'))
                <tr style="color: red">
                    <th colspan="2">Total (con descuento)</th>
                    <th colspan="2" style="text-align: right">
                        {{ $total - ($total * session()->get('descuento')) / 100 }} &euro;</th>
                </tr>
            @else
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="2" id="total_cesta_pago" data-total="{{ $total }}" style="text-align: right">
                        {{ $total }} &euro;</th>
                </tr>
            @endif
        </tfoot>
    </table>
@else
    <div>
        <p style="font-size:18px;padding:20px;text-align:center">Tu carrito de compra está
            vacío.
        </p>
    </div>
@endif

@php
    //Si
    if ($cleanCart) {
        session()->forget('cesta');
    }
@endphp


<script>
    $(".mas2").click(function() {
        actualizarCesta("+", $(this).attr("data-plato-id"));
    });

    $(".menos2").click(function() {
        actualizarCesta("-", $(this).attr("data-plato-id"));
    });

    $(".borrar").click(function() {
        actualizarCesta("x", $(this).attr("data-plato-id"));
    });

    function actualizarCesta(signo, plato) {
        $.get("{{ route('front.actualizarCesta') }}", {
                plato: plato,
                signo: signo
            },
            function(data, status) {
                cargarResumenCesta();
            });
    }
</script>
