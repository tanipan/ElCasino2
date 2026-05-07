@extends('adminlte::page')

@if (request('num_burgers'))
    @section('title', 'Listado de pedidos (' . $maximo_burgers . ')')
@else
    @section('title', 'Listado de pedidos')
@endif

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-10">
            <h1>Barra pendientes ☕️🧃🍵

                @if (request('num_burgers'))
                    <span style="color: red">({{ $maximo_burgers }} burgers)</span>
                @endif
            </h1>
        </div>
    </div>

    <style>
        .content-wrapper.kanban {
            height: 1px;

            .content {
                height: 100%;
                overflow-x: auto;
                overflow-y: hidden;

                .container,
                .container-fluid {
                    width: max-content;
                    display: flex;
                    align-items: stretch;
                }
            }

            .content-header+.content {
                height: calc(100% - ((2 * 15px) + (1.8rem * #{$headings-line-height})));
            }

            .card {
                .card-body {
                    padding: .5rem;
                }

                &.card-row {
                    width: 340px;
                    display: inline-block;
                    margin: 0 .5rem;

                    &:first-child {
                        margin-left: 0;
                    }

                    .card-body {
                        height: calc(100% - (12px + (1.8rem * #{$headings-line-height}) + .5rem));
                        overflow-y: auto;
                    }

                    .card {
                        &:last-child {
                            margin-bottom: 0;
                            border-bottom-width: 1px;
                        }

                        .card-header {
                            padding: .5rem .75rem;
                        }

                        .card-body {
                            padding: .75rem;
                        }
                    }
                }
            }

            .btn-tool {
                &.btn-link {
                    text-decoration: underline;
                    padding-left: 0;
                    padding-right: 0;
                }
            }
        }
    </style>

@stop

@section('content')

    <!-- /.card-header -->

    <div class="content-wrapper kanban" style="min-height: 784px;margin-left: 50px !important;height: 2000px;">
        <section class="content pb-3">
            <div class="container-fluid h-100" style="margin-left: -11px" id="kanban-colums">

            </div>
        </section>
    </div>

    <!-- /.card-body -->

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
    @if ($sonido)
        <audio class="audio">
            <source src="{{ asset('audio/alert.mp3') }}" type="audio/mp3">
        </audio>
        <script>
            $(".audio")[0].play();
        </script>
    @endif


    <script>
        function kanban_reload() {
            $.get('{{ route('burgers.reload') }}', {}, function(data) {
                $('#kanban-colums').html(data);


                $(".entrante").click(function() {

                    if ($('#customCheckbox' + $(this).attr("data-line-id")).is(":checked")) {
                        desmarcarLinea($(this).attr("data-line-id"));
                    } else {
                        marcarLinea($(this).attr("data-line-id"));
                    }

                });

                $(".entrante_fuego").click(function() {
                    mandarAplancha($(this).attr("data-line-id"));
                });

                function marcarLinea(order_line) {
                    $.get('{{ route('orderlineburgers.prepared') }}', {
                        order_line: order_line
                    }, function(resp) {
                        kanban_reload();
                    });
                }

                function mandarAplancha(order_line) {
                    $.get('{{ route('orderlineburgers.toFire') }}', {
                        order_line: order_line
                    }, function(resp) {
                        kanban_reload();
                    });
                }

                function desmarcarLinea(order_line) {
                    $.get('{{ route('orderlineburgers.unprepared') }}', {
                        order_line: order_line
                    }, function(resp) {
                        kanban_reload();
                    });
                }

                function ocultarPedido(order) {
                    $.get('{{ route('orderlineburgers.orderHide') }}', {
                        order_id: order
                    }, function(resp) {
                        kanban_reload();
                    });
                }

                $(".hidden_order").click(function() {
                    ocultarPedido($(this).attr("data-order-id"));
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

                //with jquery
                $('#exampleModalLong').on('shown.bs.modal', function(e) {
                    e.preventDefault();
                    isPaused = true;
                });

                $('#exampleModalLong').on('hidden.bs.modal', function(e) {
                    e.preventDefault();
                    isPaused = false;
                });

            });
        }

        kanban_reload();

        function refrescarPagina() {
            //location.reload();
            kanban_reload();
        }
        // Establecer el intervalo en milisegundos (5 segundos en este caso)
        var intervalo = 5000;
        // Configurar el intervalo con la función y el tiempo especificado
        setInterval(refrescarPagina, intervalo);
    </script>
@stop
