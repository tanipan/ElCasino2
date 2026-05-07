@extends('adminlte::page')

@if (request('num_burgers'))
    @section('title', 'Listado de pedidos (' . $maximo_burgers . ')')
@else
    @section('title', 'Listado de pedidos')
@endif

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-10" id="parpadear">
            <h1 id="elemento_a_parpadear">Situación de sala

                @if (request('num_burgers'))
                    <span style="color: red">({{ $maximo_burgers }} burgers)
                @endif

                </span>
            </h1>
        </div>

    </div>
@stop

@section('content')

    <style>
        .blink_bk {
            animation: blink-animation 2s steps(2, start) infinite;
            -webkit-animation: blink-animation 2s steps(2, start) infinite;
        }

        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }

        @-webkit-keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mesas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row" id="tables">

                    </div>
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

    <!-- Modal Comanda Mesa total -->
    <div class="modal fade" id="exampleModalLongTable" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTableTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="exampleModalTable">

            </div>
        </div>
    </div>

    <!-- Modal Hora Recogida -->
    <div class="modal fade" id="exampleModalHoraLong" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalHoraLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modificar hora recogida</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="time" name="time" id="time-modal" class="form-control">
                    <input type="hidden" name="order" id="order-modal" class="form-control">
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="button" class="btn btn-danger btn-modificar-hora">Modificar hora</button>
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
                    <h5 class="modal-title" id="exampleModalLongStatusDeliveredTitle">¿Cambiar estado del pedido #<span
                            id="order_title" class="order_title"></span>?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="cambiarEstado2">Cambiar estado</button>
                    <input type="hidden" id="order_hidden" value="">
                    <input type="hidden" id="order_new_status" value="">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Estado a Entregado -->
    <div class="modal fade" id="exampleModalLongStatusDelivered2" tabindex="-1" role="dialog"
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
                    <button type="button" class="btn btn-danger" id="cambiarFpago">Cambiar forma de pago</button>
                    <input type="hidden" id="order_hidden" value="">
                    <input type="hidden" id="order_new_status" value="">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pago Manual -->
    <div class="modal fade modal-pago-manual" id="exampleModalLongStatusDelivered22" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongStatusDeliveredTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongStatusDeliveredTitle">¿Mandar a cocina e indicar forma de
                        pago del pedido
                        #<span id="order_title" class="order_title"></span>?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group" id="divFormaPago">
                        <label for="exampleInputEmail1">Indica la forma de pago</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="payment_method2">
                                <option value="cash">EFECTIVO</option>
                                <option value="card">TARJETA</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="mandarACocina">Mandar a cocina</button>
                    <input type="hidden" id="order_hidden2" value="">
                    <input type="hidden" id="order_new_status2" value="">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar todos -->
    <div class="modal fade" id="exampleModalLongStatusAll" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongStatusTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongStatusTitle">¿Cambiar el estado de todos los pedidos?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="cambiarEstadoAll">Cambiar estados</button>
                    <input type="hidden" id="order_hidden_all" value="">
                    <input type="hidden" id="order_new_status_all" value="">
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    @if ($sonido)
        <audio class="audio">
            <source src="{{ asset('audio/alert.mp3') }}" type="audio/mp3">
        </audio>
        <script>
            $(".audio")[0].play();
        </script>
    @endif


    <script>
        function getTables() {
            $.get("{{ route('admin.roomSituationAjax') }}", {},
                function(data) {
                    $('#tables').html(data);

                    $('.table-alert-waiter').click(function() {
                        uncheckWaiter($(this).attr("data-table"))
                    });

                    $('.table-alert-account').click(function() {
                        uncheckAccount($(this).attr("data-table"))
                    });

                    $(".modal-comanda2").click(function() {
                        recuperarModalPedido($(this).attr("data-order"), 1);
                    });
                    $(".modal-comandaTable").click(function() {
                        recuperarModalPedidoTable($(this).attr("data-table"), 1);
                    });
                });
        }

        function uncheckWaiter(table) {
            $.get("{{ route('unnotifyWaiter') }}", {
                    "table": table
                },
                function(data) {
                    getTables();
                });
        }

        function uncheckAccount(table) {
            $.get("{{ route('unnotifyAccount') }}", {
                    "table": table
                },
                function(data) {
                    getTables();
                });
        }

        getTables();

        function recuperarModalPedido(order, estatico = 0, room = 1) {
            $('#exampleModal').html("");
            $.get('{{ route('admin.order.modal') }}', {
                order_id: order,
                static: estatico,
                room: room,
            }, function(resp) {
                $('#exampleModal').html(resp);
            });
        }

        function recuperarModalPedidoTable(table, estatico = 0, room = 1) {
            $('#exampleModalTable').html("");
            $.get('{{ route('admin.order.modalTableTotal') }}', {
                table: table,
                static: estatico,
                room: room,
            }, function(resp) {
                $('#exampleModalTable').html(resp);
            });
        }

        $(document).ready(function() {

            var queryString = window.location.search;

            //if (queryString == "?status=1") {
            var isPaused = false;
            var time = 0;
            var t = window.setInterval(function() {
                if (!isPaused) {
                    time++;

                    if (time % 15 == 0) {
                        if (!$("#staticModal").hasClass("show")) {
                            getTables();
                        }
                    }
                }
            }, 400);
            //}

            //with jquery
            $('#exampleModalLong').on('shown.bs.modal', function(e) {
                e.preventDefault();
                isPaused = true;
            });
            $('#exampleModalLongTable').on('shown.bs.modal', function(e) {
                e.preventDefault();
                isPaused = true;
            });

            $('#exampleModalLong').on('hidden.bs.modal', function(e) {
                e.preventDefault();
                isPaused = false;
            });

            $('#exampleModalLongTable').on('hidden.bs.modal', function(e) {
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

        });
    </script>
@stop
