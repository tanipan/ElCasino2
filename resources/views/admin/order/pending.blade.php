@extends('adminlte::page')

@section('title', 'Listado de pedidos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listado de pedidos
                @if (request('num_burgers'))
                    <span style="color: red">({{ $maximo_burgers }} burgers)</span>
                @endif
            </h1>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="timeline">

                @foreach ($orders_pending as $time => $item)
                    <div class="time-label">
                        <span
                            class="{{ $time < date('H:i:s') ? 'bg-secondary' : 'bg-red' }}">{{ $time ? $time : 'Para Ya' }}</span>
                    </div>


                    <div>
                        <i class="fas fa-clock {{ $time < date('H:i:s') ? 'bg-gray' : 'bg-blue' }}"></i>
                        <div class="timeline-item">
                            <div class="row">
                                @foreach ($item['order'] as $order)
                                    <div class="col-sm-1" style="margin: 10px 0 10px 10px">
                                        <button type="button"
                                            class="btn btn-block {{ $order->order_comoaqui ? ($time < date('H:i:s') ? 'bg-gray' : 'bg-danger') : ($time < date('H:i:s') ? 'bg-gray' : 'bg-warning') }} modal-comanda2"
                                            data-toggle="modal" data-target="#exampleModalLong"
                                            data-order="{{ $order->id }}">Urban {{ $order->id }}
                                            {{ $order->order_comoaqui ? ' - CA ' . $order->order_comoaqui : '' }}</button>
                                    </div>
                                @endforeach
                            </div>
                            <div class="timeline-body">
                                <div class="row">
                                    @foreach ($item['dishs'] as $id => $total)
                                        <div class="col-sm-2" style="margin: 10px 0 10px 10px">
                                            <button type="button"
                                                class="btn-lg btn-block {{ $time < date('H:i:s') ? 'btn-secondary' : 'btn-primary' }}">{{ $total }}
                                                x {{ $dishs[$id]->name }}</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>

    <!-- Modal Comanda -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="exampleModal">

            </div>
        </div>
    </div>

@stop



@section('js')
    <script>
        $(document).ready(function() {
            $(".modal-comanda").click(function() {
                recuperarModalPedido($(this).attr("data-order"));
            });

            $(".modal-comanda2").click(function() {
                recuperarModalPedido($(this).attr("data-order"), 1);
            });

            function recuperarModalPedido(order, estatico = 0) {
                $('#exampleModal').html("");
                $.get('{{ route('admin.order.modal') }}', {
                    order_id: order,
                    static: estatico,
                }, function(resp) {
                    //$('#modalComanda').show();
                    $('#exampleModal').html(resp);
                    //$('#exampleModal').modal('show');
                });
            }

            $(".imprimirU").click(function() {
                imprimirTicketU($(this).attr("data-order"), 1);
            });

            function imprimirTicketU(order) {
                $.get('{{ route('reprintTickets') }}', {
                        order: order
                    },
                    function(data) {
                        alert('Imprimiendo...');
                    });
            }

            $(".imprimirC").click(function() {
                imprimirTicketC($(this).attr("data-order"), 1);
            });

            function imprimirTicketC(order) {
                $.get('{{ route('reprintTickets') }}', {
                        order: order,
                        type: 'c'
                    },
                    function(data) {
                        alert('Imprimiendo...');
                    });
            }

            $('.modal-status').click(function() {
                var order = $(this).attr("data-order");
                var status = $(this).attr("data-status");
                $('#order_hidden').val(order);
                $('#order_new_status').val(status);
                $('.order_title').html(order.padStart(4, "0"));
            });

            $('.modal-cancelar').click(function() {
                var order = $(this).attr("data-order");
                var status = $(this).attr("data-status");
                $('#order_hidden').val(order);
                $('#order_new_status').val(status);
                $('.order_title').html(order.padStart(4, "0"));
            });

            $('#cambiarEstado').click(function() {
                var order = $('#order_hidden').val();
                var status = $('#order_new_status').val();
                cambiarEstado(order, status);
            });

            $('#cancelarPedido').click(function() {
                var order = $('#order_hidden').val();
                var status = $('#order_new_status').val();
                cancelarPedido(order, status);
            });

            $('#cambiarEstado2').click(function() {
                var order = $('#order_hidden').val();
                var status = $('#order_new_status').val();
                var payment_method = $('#payment_method').find(":selected").val();

                //if (payment_method == "") {
                //    alert("Selecciona una forma de pago");
                //} else {
                cambiarEstado(order, status, payment_method);
                //}
            });

            function cambiarEstado(order, status, payment_method = "") {
                $.post('{{ route('admin.order.changeStatus') }}', {
                    order_id: order,
                    status: status,
                    payment_method: payment_method,
                    user: {{ Auth::user()->id }},
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

            var queryString = window.location.search;

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

        });
    </script>

    <script>
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
            }, 1000);
        });
    </script>
@stop
