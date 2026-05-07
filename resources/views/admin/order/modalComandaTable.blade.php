@php
    date_default_timezone_set('Europe/Madrid');
@endphp

<style>
    .servido {
        text-decoration: line-through;
        color: silver
    }
</style>

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $table->name }} TOTAL
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    @php
        $i = 0;
        $total = 0;
    @endphp
    @foreach ($lineas as $line)
        @php
            $total += $line['precio'];
        @endphp

        @if ($i > 0)
            <hr>
        @endif
        <!-- Plato -->
        <div class="row {!! $line['unidadesServidas'] >= $line['unidades'] ? 'servido' : '' !!}" style="font-weight: bold;font-size: 19px;">
            <button data-order-line-id="{{ $line['linea'] }}" type="button"
                class="col-1 btn btn-block btn-danger masServido">+</button>
            <div class="col-1">
            </div>

            <div class="col-2 text">
                {{ $line['unidadesServidas'] }}/{{ $line['unidades'] }}x
            </div>
            <div class="col-7 text">
                {{ $line['plato']->name }}
            </div>
            <button data-order-line-id="{{ $line['linea'] }}" type="button"
                class=" col-1 btn btn-block btn-success menosServido">-</button>
        </div>
        <!-- /Plato -->

        @if ($line['elementos'])
            @foreach ($line['elementos'] as $ele)
                <!-- Elementos -->
                <div class="row text-primary">
                    <div class="col-1"></div>
                    <div class="col-11">
                        - {{ $ele->name }}
                    </div>
                </div>
                <!-- /Elementos -->
            @endforeach
        @endif


        @php
            $i++;
        @endphp
    @endforeach


</div>

<script>
    $('#gestionPedido').change(function() {
        var select = $(this).find(":selected").val();
        if (select == "OK") {
            $("#divMotivos").hide();
            $("#divBolsas").show();
            $("#divFormaPago").show();
            $("#btnAceptar").show();
            $("#btnRechazar").hide();
        } else if (select == "KO") {
            $("#divMotivos").show();
            $("#divBolsas").hide();
            $("#divFormaPago").hide();
            $("#btnAceptar").hide();
            $("#btnRechazar").show();
        } else {
            $("#divMotivos").hide();
            $("#divBolsas").hide();
            //$("#divHora").hide();
            $("#btnAceptar").hide();
            $("#btnRechazar").hide();
        }
    });

    $('.masServido').click(function() {
        var line = $(this).attr("data-order-line-id");
        desservirUnidad(line, {{ $table->id }});
    });

    $('.menosServido').click(function() {
        var line = $(this).attr("data-order-line-id");
        servirUnidad(line, {{ $table->id }});
    });

    function desservirUnidad(line, table) {
        $.post('{{ route('admin.table.unservedLine') }}', {
            line: line,
            "_token": "{{ csrf_token() }}"
        }, function(resp) {
            recuperarModalPedidoTable(table, 1);
        });
    }

    function servirUnidad(line, table) {
        $.post('{{ route('admin.table.servedLine') }}', {
            line: line,
            "_token": "{{ csrf_token() }}"
        }, function(resp) {
            recuperarModalPedidoTable(table, 1);
        });
    }
</script>
