@extends('adminlte::page')

@section('title', 'Listado de pedidos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Informe de pedidos</h1>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filtro entre:</h3>
                    <form action="{{ route('admin.order.informe') }}" method="GET" id="formu_filter">

                        <div class="row">
                            <div class="col-md-2">
                                <input type="date" name="date" id="date" class="form-control"
                                    value="{{ request('date') ? request('date') : date('Y-m-d') }}">
                            </div>
                            y
                            <div class="col-md-2">
                                <input type="date" name="date2" id="date2" class="form-control"
                                    value="{{ request('date2') ? request('date2') : date('Y-m-d') }}">
                            </div>
                            <div class="col-md-2">
                                <select id="paymentMethod" name="paymentMethod" class="custom-select">
                                    <option value="">- Forma de pago -</option>
                                    <option value="cash" {{ request('paymentMethod') == 'cash' ? 'selected' : '' }}>
                                        EFECTIVO
                                    </option>
                                    <option value="card" {{ request('paymentMethod') == 'card' ? 'selected' : '' }}>
                                        TARJETA
                                    </option>
                                    <option value="ca" {{ request('paymentMethod') == 'ca' ? 'selected' : '' }}>
                                        COMOAQUI
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="type" name="type" class="custom-select">
                                    <option value="">- Tipo de pedido -</option>
                                    <option value="table" {{ request('type') == 'table' ? 'selected' : '' }}>
                                        LOCAL
                                    </option>
                                    <option value="takeAway" {{ request('type') == 'takeAway' ? 'selected' : '' }}>
                                        TakeAway
                                    </option>
                                    <option value="ca" {{ request('type') == 'ca' ? 'selected' : '' }}>
                                        COMOAQUI
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary btn-sm filtrar">Filtrar</button>
                                <a href="{{ route('admin.order.informe') }}" class="btn btn-danger btn-sm">Limpiar</a>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered" id="tabla">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Cliente</th>
                                <th>Forma de pago</th>
                                <th>Origen</th>
                                <th>Hora de creación</th>
                                <th>Importe</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                                $i = 0;
                            @endphp
                            @foreach ($orders as $order)
                                <tr id="row_order_{{ $order->id }}">
                                    <td>
                                        <h3><span class="badge bg-warning">
                                                #{{ explode('-', $order->order)[1] }}
                                            </span></h3>
                                    </td>
                                    <td>
                                        <h4><span class="badge bg-info">
                                                @if ($order->table)
                                                    Mesa {{ $order->table }}
                                                @else
                                                    {{ $order->customer->name }}
                                                    {{ $order->customer->lastname }}
                                                @endif
                                            </span></h4>
                                    </td>
                                    <td>
                                        <h3><span class="badge">
                                                @if ($order->payment_method == 'cash')
                                                    Efectivo
                                                @elseif ($order->payment_method == 'card')
                                                    Tarjeta
                                                @elseif ($order->payment_method == 'ca')
                                                    Comoaqui
                                                @endif
                                            </span></h3>
                                    </td>
                                    <td style="font-size: 40px">
                                        @if ($order->payment_method == 'ca')
                                            🛵
                                        @elseif ($order->table)
                                            🪑
                                        @else
                                            👱🏻‍♂️
                                        @endif
                                    </td>
                                    <td>
                                        <h5><span class="badge bg-primary">
                                                {{ $order->DateCreated }}
                                            </span></h5>
                                    </td>
                                    <td>
                                        <h3><span class="badge">
                                                @php
                                                    $bolsas = $order->bags * $precioBolsa;
                                                @endphp

                                                <!--{{ $order->total + $bolsas }}€-->
                                                {!! $order->getTotal(1) !!}
                                            </span></h3>
                                    </td>
                                    @php
                                        $total += $order->getTotal(0, 1) + $bolsas;
                                    @endphp
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-block btn-success modal-comanda2"
                                                    data-toggle="modal" data-target="#exampleModalLong"
                                                    data-order="{{ $order->id }}">Ver comanda</button>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-block btn-primary imprimir"
                                                    data-order="{{ $order->order }}">🖨 &nbsp; Ticket</button>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-block btn-warning modal-status"
                                                        data-toggle="modal" data-target="#exampleModalLongStatusDelivered"
                                                        data-status="4" data-order="{{ $order->id }}"
                                                        data-payment-method="{{ $order->payment_method }}">Cambiar f.
                                                        pago</button>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-block btn-danger modal-cancelar"
                                                    data-toggle="modal" data-target="#exampleModalLongDelete"
                                                    data-order="{{ $order->id }}">X</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach

                            @if ($total)
                                <tr>
                                    <td colspan="6">
                                    </td>
                                </tr>
                                <tr class="text-success">
                                    <td colspan="6" style="text-align: right">
                                        <h3><span class="badge ">
                                                Importe total
                                            </span>
                                        </h3>
                                    </td>
                                    <td>
                                        <h3><span class="badge">
                                                {{ $total }}€
                                            </span>
                                        </h3>
                                    </td>
                                </tr>
                            @endif

                            @if ($i)
                                <tr>
                                    <td colspan="6">
                                    </td>
                                </tr>
                                <tr class="text-success">
                                    <td colspan="6" style="text-align: right">
                                        <h3><span class="badge ">
                                                Total pedidos
                                            </span>
                                        </h3>
                                    </td>
                                    <td>
                                        <h3><span class="badge">
                                                {{ $i }} 🛒
                                            </span>
                                        </h3>
                                    </td>
                                </tr>
                            @endif

                            @if ($totalBurgers)
                                <tr>
                                    <td colspan="6">
                                    </td>
                                </tr>
                                <tr class="text-success">
                                    <td colspan="6" style="text-align: right">
                                        <h3><span class="badge ">
                                                Total burgers
                                            </span>
                                        </h3>
                                    </td>
                                    <td>
                                        <h3><span class="badge">
                                                {{ $totalBurgers }} 🍔
                                            </span>
                                        </h3>
                                    </td>
                                </tr>
                            @endif

                            @if ($totalArticulos)
                                <tr class="">
                                    <td colspan="6" style="text-align: right">

                                        <table class="table table-bordered" id="tabla">
                                            <thead>
                                                <tr>
                                                    <th>Artículos</th>
                                                    <th>Unidades</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($totalArticulos as $articulo)
                                                    <tr>
                                                        <td>{{ $articulo->nombre }}</td>
                                                        <td>{{ $articulo->unidades }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </td>
                                    <td>
                                        <h3><span class="badge">

                                            </span>
                                        </h3>
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col -->
    </div>

    <!-- Modal Comanda -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="exampleModal">

            </div>
        </div>
    </div>

    <!-- Modal Estado -->
    <div class="modal fade" id="exampleModalLongStatus" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongStatusTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongStatusTitle">¿Cambiar estado del pedido #<span
                            id="order_title" class="order_title"></span>?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="cambiarEstado">Cambiar estado</button>
                    <input type="hidden" id="order_hidden" value="">
                    <input type="hidden" id="order_new_status" value="">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Estado a Entregado -->
    <div class="modal fade" id="exampleModalLongStatusDelivered" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongStatusDeliveredTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongStatusDeliveredTitle">¿Cambiar forma de pago del pedido
                        #<span id="order_title" class="order_title"></span>?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group" id="divFormaPago">
                        <label for="exampleInputEmail1">Indica la forma de pago</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="payment_method">
                                <option value="">- Opciones -</option>
                                <option value="cash">EFECTIVO</option>
                                <option value="card">TARJETA</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="cambiarEstado2">Cambiar forma de pago</button>
                    <input type="hidden" id="order_hidden" value="">
                    <input type="hidden" id="order_new_status" value="">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div class="modal fade" id="exampleModalLongDelete" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongDeleteTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #ffbfbf;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongStatusTitle">¿Cancelar el pedido #<span
                            id="order_title_delete" class="order_title"></span>?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="cancelarPedido">Cancelar pedido</button>
                    <input type="hidden" id="order_hidden" value="">
                    <input type="hidden" id="order_new_status" value="">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal password -->
    <div class="modal fade" id="choose_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="padding: 17px 16px 0 16px">
                <div class="modal-header">
                    <h5 class="modal-title">Mostrar informe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Contraseña</label>
                            <input type="password" id="discount_pass" class="form-control" id="recipient-name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn_filtrar">Mostrar informe</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal password -->

@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">-->
@stop

@section('js')
    <script>
        $(document).ready(function() {

            //Poder filtrar el informe
            $(".filtrar").click(function() {
                $("#choose_modal").modal("show");
            });

            $("#btn_filtrar").click(function() {

                var descuento = $("#descuento").val();
                var sb64 = btoa($('#discount_pass').val());

                //if (sb64 == "bG9hcGxpY29wb3JxdWVxdWllcm8=") {
                if (sb64 == "OTk5") {

                    $('#formu_filter').submit();

                } else {
                    alert("Contraseña incorrecta");
                }
            });

            $(".modal-comanda").click(function() {
                recuperarModalPedido($(this).attr("data-order"));
            });

            $(".imprimir").click(function() {
                imprimirTicket($(this).attr("data-order"), 1);
            });

            function imprimirTicket(order) {
                $.get('{{ route('reprintTickets') }}', {
                        order: order
                    },
                    function(data) {
                        alert('Imprimiendo...');
                    });
            }

            $(".modal-comanda2").click(function() {
                recuperarModalPedido($(this).attr("data-order"), 1);
            });

            function recuperarModalPedido(order, estatico = 0) {
                $('#exampleModal').html("");
                $.get('{{ route('admin.order.modal') }}', {
                        order_id: order,
                        static: estatico,
                    },
                    function(resp) {
                        //$('#modalComanda').show();
                        $('#exampleModal').html(resp);
                        //$('#exampleModal').modal('show');
                    });
            }

            $('.modal-status').click(function() {
                var order = $(this).attr("data-order");
                var status = $(this).attr("data-status");
                var payment_method = $(this).attr("data-payment-method");

                $("#payment_method").val(payment_method);
                $('#order_hidden').val(order);
                $('#order_new_status').val(status);
                $('.order_title').html(order.padStart(4, "0"));
            });

            $('#cambiarEstado').click(function() {
                var order = $('#order_hidden').val();
                var status = $('#order_new_status').val();
                cambiarEstado(order, status);
            });

            $('#cambiarEstado2').click(function() {
                var order = $('#order_hidden').val();
                var status = $('#order_new_status').val();
                var payment_method = $('#payment_method').find(":selected").val();

                if (payment_method == "") {
                    alert("Selecciona una forma de pago");
                } else {
                    cambiarEstado(order, status, payment_method);
                }
            });

            function cambiarEstado(order, status, payment_method = "") {
                $.post('{{ route('admin.order.changeStatus') }}', {
                        order_id: order,
                        status: '',
                        payment_method: payment_method,
                    },
                    function(resp) {
                        if (resp) {
                            //$('#row_order_' + order).remove();
                            location.reload();
                        }
                        $('#exampleModalLongStatus').modal('hide');
                        $('#exampleModalLongStatusDelivered').modal('hide');
                        $("#payment_method").val("");
                    });
            }

            var queryString = window.location.search;

            if (queryString == "?status=1") {
                var isPaused = false;
                var time = 0;
                var t = window.setInterval(function() {
                    if (!isPaused) {
                        time++;
                        //console.log(time);
                        if (time % 30 == 0) {
                            if (!$("#staticModal").hasClass("show")) {
                                window.location.reload();
                            }
                        }
                    }
                }, 1000);
            }

            //with jquery
            $('#exampleModalLong').on('shown.bs.modal', function(e) {
                e.preventDefault();
                isPaused = true;
            });

            $('#exampleModalLong').on('hidden.bs.modal', function(e) {
                e.preventDefault();
                isPaused = false;
            });

            //with jquery
            $('#exampleModalLongStatus').on('shown.bs.modal', function(e) {
                e.preventDefault();
                isPaused = true;
            });

            $('#exampleModalLongStatus').on('hidden.bs.modal', function(e) {
                e.preventDefault();
                isPaused = false;
            });

            //with jquery
            $('#exampleModalLongStatusDelivered').on('shown.bs.modal', function(e) {
                e.preventDefault();
                isPaused = true;
            });

            $('#exampleModalLongStatusDelivered').on('hidden.bs.modal', function(e) {
                e.preventDefault();
                isPaused = false;
            });

            $('.modal-cancelar').click(function() {
                var order = $(this).attr("data-order");
                var status = $(this).attr("data-status");
                $('#order_hidden').val(order);
                $('#order_new_status').val(status);
                $('.order_title').html(order.padStart(4, "0"));
            });

            $('#cancelarPedido').click(function() {
                var order = $('#order_hidden').val();
                var status = $('#order_new_status').val();
                cancelarPedido(order, status);
            });

            function cancelarPedido(order, status, payment_method = "") {
                $.post('{{ route('admin.order.delete') }}', {
                    order_id: order
                }, function(resp) {
                    if (resp) {
                        $('#row_order_' + order).remove();
                    }
                    $('#exampleModalLongDelete').modal('hide');
                    $('#exampleModalLongStatus').modal('hide');
                    $('#exampleModalLongStatusDelivered').modal('hide');
                    $("#payment_method").val("");
                });
            }
        });
    </script>
@stop
