<div class="card">
    <!--<div class="card-title text-center">
        <p style="font-size: 25px; padding: 5px;">Tu orden</p>
        <div style="text-align: left; font-size: 13px;" class="alert alert-secondary" role="alert">
            <a href="">
                <i class="icon-attention-alt"></i>
                Si tu o alguien para el que estas pidiendo tiene una alergia o intolerancia a algún alimento
                haz click aqui
            </a>
        </div>
    </div>-->
    <div class="card-body">
        <div class="mb-2">
            <h3>Tu pedido</h3>
        </div>
        <div>
            @php
                $total = 0;
            @endphp
            @if ($cestaHumana)
                @foreach ($cestaHumana as $k => $elemento)
                    <div class="listado-pedido">
                        <div class="informacion-plato">
                            <p style="font-size: 15px;">{{ $elemento['plato'] }}</p>
                            @foreach ($elemento['elementos'] as $ele)
                                <p style="font-size: 11px;margin-bottom: 5px;">{{ $ele }}</p>
                            @endforeach
                        </div>
                        <div class="cantidad-plato">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn menos" id="menos"
                                    data-plato-id="{{ $k }}">
                                    <i style="color: red;" class="icon-minus-1"></i>
                                </button>
                                <input id="cantidad" type="text" style="text-align: center; width: 30px; border: none;"
                                    value="{{ $elemento['unidades'] }}">
                                <button type="button" class="btn mas" id="mas"
                                    data-plato-id="{{ $k }}">
                                    <i style="color: green;" class="icon-plus"></i>
                                </button>
                            </div>

                        </div>
                        <div class="precio-plato">
                            <p class="text-danger" style="font-size: 15px;">{{ $elemento['precio'] }} €</p>
                        </div>
                    </div>
                    @if ($elemento['observaciones'])
                        <div style="font-size: 11px;padding: 4px 16px;margin-top: 4px !important;"
                            class="alert alert-warning mt-3" role="alert">
                            {{ $elemento['observaciones'] }}
                        </div>
                    @endif

                    @php
                        $total += $elemento['precio'];
                    @endphp
                @endforeach
            @else
                Cesta vacía
            @endif

            <!--<div class="observaciones">
                <input style="font-size: 12px;" placeholder="Agregar observaciones" type="text" class="form-control">
            </div>-->
            <div class="precio-totalidad">
                <div class="subtotal-caja">
                    <div class="subtotal">
                        <p>
                            Subtotal
                        </p>
                    </div>
                    <div class="subtotal-valor">
                        <p>
                            {{ $total }} €
                        </p>
                    </div>
                </div>
            </div>
            <div class="totalidad-caja">
                <div class="totalidad">
                    <p>
                        Total
                    </p>
                </div>
                <div class="totalidad-valor text-success">
                    <p>
                        <span id="total_cesta">{{ $total }}</span> €
                    </p>
                </div>
            </div>
        </div>
        <!--<div style="font-size: 12px;" class="alert alert-danger mt-3" role="alert">
            Importe mínimo 10 €, te falta añadir 5€
        </div>
        <div style="font-size: 12px;" class="alert alert-info" role="alert">
            Importe mínimo para pagar con tarjeta al repartidor 20 €, te falta añadir 2€
        </div>-->
        @if ($boton == false)
            <div style="text-align: center;">
                <a style="color: white;" onclick="return enviar()">
                    <button class="btn btn-success">Siguiente paso</button>
                </a>
            </div>
        @endif
    </div>
</div>

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
