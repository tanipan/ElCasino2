@php
    date_default_timezone_set('Europe/Madrid');
@endphp

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Pedido #{{ explode('-', $order->order)[1] }}.
        {{ $order->customer->name }} {{ $order->customer->lastname }}
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
    @foreach ($lines as $line)
        @php
            $total += $line['precio'];
        @endphp

        @if ($i > 0)
            <hr>
        @endif
        <!-- Plato -->
        <div class="row" style="font-weight: bold;font-size: 19px;color:{!! $line['color'] !!}">
            <div class="col-1 text">
                {{ $line['unidades'] }}x
            </div>
            <div class="col-9 text">
                {{ $line['plato']->name }}
                @if (isset($line['preparado']) and $line['preparado'])
                    ✅
                @endif
            </div>
            <div class="col-1">
                {{ $line['precio'] }}€
            </div>
            <div class="col-1">
            </div>
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

        @if ($line['observaciones'])
            <div class="row text-danger">
                <div class="col-1"></div>
                <div class="col-11">
                    {{ $line['observaciones'] }}
                </div>
            </div>
        @endif

        @php
            $i++;
        @endphp
    @endforeach

    @if ($order->observacions)
        <hr>
        <div class="form-group row">
            <h4>
                <span class="badge bg-warning">{{ $order->observacions }}</span>
            </h4>
        </div>
    @endif

    @if ($static == 0)
        <hr>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-4 col-form-label">Gestiona pedido</label>
            <div class="col-sm-8">
                <select class="form-control" id="gestionPedido">
                    <option value="">- Opciones -</option>
                    <option value="OK">&#9989 &nbsp;ACEPTAR PEDIDO</option>
                    <option value="KO">&#10060 &nbsp;RECHAZAR</option>
                </select>
            </div>
        </div>
    @endif

    <div class="form-group" id="divBolsas" style="display: none;">
        <hr>
        <label for="exampleInputEmail1">Indica el número de bolsas</label>
        <table style="margin: auto">
            <tr>
                <td style="border: 0px">
                    <button type="button" class="btn btn-lg btn-block btn-danger menos"
                        data-dish="">&nbsp;&nbsp;-&nbsp;&nbsp;</button>
                </td>
                <td style="border: 0px">
                    <input style="text-align: center;width: 100px;margin-left: 10px;margin-right: 10px;"
                        class="form-control form-control-lg" type="text" disabled value="0" id="bolsas">
                </td>
                <td style="border: 0px">
                    <button type="button" class="btn btn-lg btn-block btn-success mas"
                        data-dish="">&nbsp;&nbsp;+&nbsp;&nbsp;</button>
                </td>
            </tr>
        </table>
    </div>

    @if ($menuDelDia)
        <div class="form-group" id="divFormaPago" style="display: none;">
            <hr>
            <label for="exampleInputEmail1">Indica la forma de pago</label>
            <div class="col-sm-8">
                <select class="form-control" id="payment_method">
                    <option value="">- Opciones -</option>
                    <option value="cash">EFECTIVO</option>
                    <option value="card">TARJETA</option>
                </select>
            </div>
        </div>
    @endif

    <!--<div class="form-group" id="divHora" style="display: none;">
        <hr>
        <label for="exampleInputEmail1">Indica una hora aproximada para recoger</label>
        <table style="margin: auto">
            <tr>
                <td style="border: 0px">

                </td>
                <td style="border: 0px">
                    <input type="time" class="form-control form-control-lg" id="time" value="{{ date('H:i') }}">
                </td>
                <td style="border: 0px">

                </td>
            </tr>
        </table>
    </div>-->

    <div class="form-group" id="divMotivos" style="display: none;">
        <hr>
        <label for="exampleInputEmail1">Indica un motivo</label>
        <select class="form-control" id="motivos">
            <option value="">- Motivos -</option>
            <option value="kitchen">&#9940 &nbsp; COCINA SATURADA </option>
            @foreach ($lines as $line)
                <option value="{{ $line['plato']->id }}">{{ $line['plato']->name }} AGOTADO &#10060 </option>
            @endforeach
        </select>
    </div>

</div>
<div class="modal-footer">

    <button type="button" class="btn btn-danger" id="btnRechazar" style="display: none;"
        data-order-id="{{ $order->id }}">Rechazar</button>

    @if ($room and $order->status == 1)
        <button type="button" class="btn btn-success" id="btnAceptarRoom" data-order-id="{{ $order->id }}">Aceptar
            pedido</button>
    @endif

    @if ($room)
        <button type="button" class="btn btn-danger" id="btnCancelarRoom" data-order-id="{{ $order->id }}">Cancelar
            pedido</button>
    @endif

    <div class="row" style="font-weight: bold;font-size: 19px;padding-right: 50px">
        <div class="col-1 text">
            Total
        </div>
        <div class="col-9 text">

        </div>
        <div class="col-1">
            <!--{{ $total }}€-->
            {!! $order->getTotal($euro = 1) !!}
        </div>
        <div class="col-1">
        </div>
    </div>
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

    $('.mas').click(function() {
        var unid = $("#bolsas").val();
        unid++;
        $("#bolsas").val(unid);
    });

    $('.menos').click(function() {
        var unid = $("#bolsas").val();
        unid--;
        if (unid < 0) {
            unid = 0;
        }
        $("#bolsas").val(unid);
    });

    $('#btnAceptarRoom').click(function() {
        var order = $(this).attr("data-order-id");
        aceptarPedidoTable(order);
    });

    $('#btnCancelarRoom').click(function() {
        var order = $(this).attr("data-order-id");
        if (confirm('¿Cancelar el pedido?')) {
            cancelarPedidoTable(order);
        }
    });

    function cancelarPedidoTable(order) {
        $.post('{{ route('admin.table.cancelOrder') }}', {
            order: order,
            "_token": "{{ csrf_token() }}"
        }, function(resp) {
            window.location.reload();
        });
    }

    function aceptarPedidoTable(order) {
        $.post('{{ route('admin.table.aceptOrder') }}', {
            order: order,
            "_token": "{{ csrf_token() }}"
        }, function(resp) {
            window.location.reload();
        });
    }

    function cancelarPedido(order, status, reason) {
        $.post('{{ route('admin.order.cancel') }}', {
            order_id: order,
            status: status,
            reason: reason,
        }, function(resp) {
            if (resp) {
                $('#row_order_' + order).remove();
            }
            $('#exampleModalLong').modal('hide');
        });
    }
</script>
