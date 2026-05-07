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
                    $importe_actual = ($elemento['precio'] / $elemento['unidades']) * $elemento['unidadesPagar'];
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

                        <a href="#">
                            <i style="font-size: 24px" class="fa menos2" data-plato-id="{{ $elemento['plato_id'] }}"
                                data-line-id="{{ $elemento['idLinea'] }}">⛔️</i>
                        </a>

                        <b style="padding-left: 3px; padding-right: 3px">{{ $elemento['unidadesPagar'] }}</b>

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
                <tr style="font-size: 24px">
                    <th colspan="2">Total</th>
                    <th colspan="2" id="total_cesta_pago" data-total="{{ $total }}" style="text-align: right">
                        {{ $total }} &euro;</th>
                </tr>
                <tr style="border">
                    <th colspan="1" style="border-top: none">
                        <p class="text-center">
                            <a style="font-size: 15px !important" data-forma-pago="card" class="btn2 btnPagar"
                                href="#">
                                Pagar con tarjeta 💳
                            </a>
                        </p>
                    </th>
                    <th colspan="3" style="border-top: none">
                        <p class="">
                            <a style="font-size: 15px !important" data-forma-pago="cash" class="btn2 btnPagar"
                                href="#">
                                Pagar en efectivo 💶
                            </a>
                        </p>
                    </th>
                </tr>
            @endif
        </tfoot>
    </table>
@else
    <div>
        <p style="font-size:18px;padding:20px;text-align:center">La cuenta está vacía.
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
    $(".menos2").click(function() {
        subPagar($(this).attr("data-plato-id"), $(this).attr("data-line-id"));
    });

    $(".btnPagar").click(function() {
        pagarLineas($(this).attr("data-forma-pago"));
    });

    function subPagar(plato, idLinea) {
        $.get("{{ route('front.subPagar') }}", {
                plato: plato,
                linea: idLinea
            },
            function(data, status) {
                actualizarCestas();
            });
    }

    function pagarLineas(formaPago) {
        $.get("{{ route('front.marcamosPagadasLineasUltimoTicket') }}", {
                formaPago: formaPago
            },
            function(data, status) {
                actualizarCestas();
            });
    }
</script>
