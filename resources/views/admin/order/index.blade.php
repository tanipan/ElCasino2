@extends('adminlte::page')

@if (request('num_burgers'))
    @section('title', 'Listado de pedidos (' . $maximo_burgers . ')')
@else
    @section('title', 'Listado de pedidos')
@endif

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-10">
            <h1>Listado de pedidos
                @if (request('num_burgers'))
                    <span style="color: red">({{ $maximo_burgers }} burgers)</span>
                @endif
            </h1>
        </div>
        <div class="col-sm-2">
            @if (request()->status == 2)
                <button type="button" class="btn col-sm-8 btn-block btn-success modal-status-all" data-toggle="modal"
                    data-target="#exampleModalLongStatusAll" data-status="3">Marcar todos como
                    listos</button>
            @elseif (request()->status == 3)
                <button type="button" class="btn col-sm-8 btn-block btn-warning modal-status-all" data-toggle="modal"
                    data-target="#exampleModalLongStatusAll" data-status="4">Marcar todos como
                    entregados</button>
            @endif
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pedidos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered" id="tabla">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Cliente</th>
                                <th>Importe</th>
                                @if (request()->status == 1 or request()->status == 2)
                                    <!--<th>Hora preparación</th>-->
                                @endif
                                <th>Forma de pago</th>
                                <th>Hora de creación</th>
                                <th>Hora de recogida</th>
                                <th>CA</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $orders_all = null;
                            @endphp
                            @foreach ($orders as $order)
                                @php
                                    $orders_all .= $order->id . ',';
                                @endphp
                                <tr id="row_order_{{ $order->id }}">
                                    <td>
                                        <h3><span class="badge bg-warning">
                                                #{{ explode('-', $order->order)[1] }}
                                            </span></h3>
                                    </td>
                                    <td>
                                        <table>
                                            <tr style="border: 0px !important">
                                                <td style="border: 0px !important">
                                                    <h4><span class="badge bg-info">
                                                            @if ($order->order_comoaqui)
                                                                Comoaqui
                                                            @elseif($order->table)
                                                                MESA {{ $order->table }}
                                                            @else
                                                                {{ $order->customer->name }}
                                                                {{ $order->customer->lastname }}
                                                            @endif
                                                        </span></h4>
                                                </td>
                                                <td style="border: 0px !important">
                                                    @if ($order->order_comoaqui)
                                                        <img width="30" src="{{ asset('images/comoaqui.png') }}"
                                                            alt="">
                                                    @elseif($order->customer_id > 715)
                                                        <img width="30" src="{{ asset('images/web.png') }}"
                                                            alt="">
                                                    @elseif($order->table)
                                                        🪑
                                                    @else
                                                        <img width="30" src="{{ asset('images/smashurban.jpg') }}"
                                                            alt="">
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <h3><span class="badge">
                                                {!! $order->getTotal($euro = 1) !!}
                                            </span></h3>
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

                                    <td>
                                        <h4><span class="badge bg-primary">
                                                {{ $order->DateCreated }}
                                            </span></h4>
                                    </td>
                                    <td>
                                        @if ($order->time_ready)
                                            <h4><span class="badge bg-danger modal-hora" data-toggle="modal"
                                                    data-target="#exampleModalHoraLong" data-order="{{ $order->id }}"
                                                    data-time="{{ $order->time_ready }}">

                                                    {{ $order->time_ready }}

                                                </span></h4>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->order_comoaqui)
                                            <h4><span class="badge bg-primary">
                                                    {{ $order->order_comoaqui }}
                                                </span></h4>
                                        @endif
                                    </td>

                                    <td>

                                        @switch(request()->status)
                                            @case(1)
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-success modal-comanda"
                                                            data-toggle="modal" data-target="#exampleModalLong"
                                                            data-order="{{ $order->id }}">Ver comanda</button>
                                                    </div>
                                                    <!--<div class="col-sm-2">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a class="btn btn-block btn-primary modal-cancelar"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                href="{{ route('front.deBDaCesta', ['token' => $order->token]) }}">Modificar</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>-->
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirU"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; U</button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirC"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; C</button>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-block btn-danger modal-cancelar"
                                                            data-toggle="modal" data-target="#exampleModalLongDelete"
                                                            data-order="{{ $order->id }}">X</button>
                                                    </div>
                                                </div>
                                            @break

                                            @case(2)
                                                <div class="row">
                                                    <!--<div class="col-sm-2">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="form-group">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button type="button" class="btn btn-block btn-warning modal-status"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    data-toggle="modal" data-target="#exampleModalLongStatus"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    data-status="1" data-order="{{ $order->id }}">Volver a
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    reciente</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>-->
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-warning modal-status"
                                                            data-toggle="modal" data-target="#exampleModalLongStatusDelivered2"
                                                            data-status="4" data-order="{{ $order->id }}"
                                                            data-payment-method="{{ $order->payment_method }}">Cambiar f.
                                                            pago</button>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-dark modal-comanda2"
                                                                data-toggle="modal" data-target="#exampleModalLong"
                                                                data-order="{{ $order->id }}">Ver comanda</button>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-success modal-status"
                                                                data-toggle="modal" data-target="#exampleModalLongStatus"
                                                                data-status="3" data-order="{{ $order->id }}">Marcar como
                                                                listo</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirU"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; U</button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirC"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; C</button>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-block btn-danger modal-cancelar"
                                                            data-toggle="modal" data-target="#exampleModalLongDelete"
                                                            data-order="{{ $order->id }}">X</button>
                                                    </div>
                                                </div>
                                            @break

                                            @case(3)
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-warning modal-status"
                                                                data-toggle="modal" data-target="#exampleModalLongStatus"
                                                                data-status="2" data-order="{{ $order->id }}">Volver a
                                                                cocina</button>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-dark modal-comanda2"
                                                                data-toggle="modal" data-target="#exampleModalLong"
                                                                data-order="{{ $order->id }}">Ver comanda</button>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-success modal-status"
                                                                data-toggle="modal" data-target="#exampleModalLongStatusDelivered"
                                                                data-status="4" data-order="{{ $order->id }}">Marcar como
                                                                entregado</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirU"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; U</button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirC"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; C</button>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-block btn-danger modal-cancelar"
                                                            data-toggle="modal" data-target="#exampleModalLongDelete"
                                                            data-order="{{ $order->id }}">X</button>
                                                    </div>
                                                </div>
                                            @break

                                            @case(4)
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-warning modal-status"
                                                                data-toggle="modal" data-target="#exampleModalLongStatus"
                                                                data-status="3" data-order="{{ $order->id }}">Volver a
                                                                listo</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-dark modal-comanda2"
                                                                data-toggle="modal" data-target="#exampleModalLong"
                                                                data-order="{{ $order->id }}">Ver comanda</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirU"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; U</button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirC"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; C</button>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-block btn-danger modal-cancelar"
                                                            data-toggle="modal" data-target="#exampleModalLongDelete"
                                                            data-order="{{ $order->id }}">X</button>
                                                    </div>
                                                </div>
                                            @break

                                            @case(5)
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-warning modal-status"
                                                                data-toggle="modal" data-target="#exampleModalLongStatus"
                                                                data-status="1" data-order="{{ $order->id }}">Volver a
                                                                reciente</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-dark modal-comanda2"
                                                                data-toggle="modal" data-target="#exampleModalLong"
                                                                data-order="{{ $order->id }}">Ver comanda</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirU"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; U</button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirC"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; C</button>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-block btn-danger modal-cancelar"
                                                            data-toggle="modal" data-target="#exampleModalLongDelete"
                                                            data-order="{{ $order->id }}">X</button>
                                                    </div>
                                                </div>
                                            @break

                                            @case(6)
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-dark modal-comanda2"
                                                                data-toggle="modal" data-target="#exampleModalLong"
                                                                data-order="{{ $order->id }}">Ver comanda</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-warning modal-status"
                                                                data-toggle="modal" data-target="#exampleModalLongStatus"
                                                                data-status="1" data-order="{{ $order->id }}">Volver a
                                                                reciente</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirU"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; U</button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirC"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; C</button>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-block btn-danger modal-cancelar"
                                                            data-toggle="modal" data-target="#exampleModalLongDelete"
                                                            data-order="{{ $order->id }}">X</button>
                                                    </div>
                                                </div>
                                            @break

                                            @case(7)
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button"
                                                                class="btn btn-block btn-info modal-pago-manual"
                                                                data-toggle="modal"
                                                                data-target="#exampleModalLongStatusDelivered22" data-status="2"
                                                                data-order="{{ $order->id }}">Pago
                                                                manual</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-dark modal-comanda2"
                                                                data-toggle="modal" data-target="#exampleModalLong"
                                                                data-order="{{ $order->id }}">Ver comanda</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-block btn-warning modal-status"
                                                                data-toggle="modal" data-target="#exampleModalLongStatus"
                                                                data-status="1" data-order="{{ $order->id }}">Volver a
                                                                reciente</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirU"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; U</button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button type="button" class="btn btn-block btn-primary imprimirC"
                                                            data-order="{{ $order->order }}">🖨 &nbsp; C</button>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" class="btn btn-block btn-danger modal-cancelar"
                                                            data-toggle="modal" data-target="#exampleModalLongDelete"
                                                            data-order="{{ $order->id }}">X</button>
                                                    </div>
                                                </div>
                                            @break
                                        @endswitch

                                    </td>
                                </tr>
                            @endforeach

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
        $(document).ready(function() {
            $(".modal-comanda").click(function() {
                recuperarModalPedido($(this).attr("data-order"));
            });

            $(".modal-comanda2").click(function() {
                recuperarModalPedido($(this).attr("data-order"), 1);
            });

            $(".modal-pago-manual").click(function() {
                var order = $(this).attr("data-order");
                var status = $(this).attr("data-status");
                $('#order_hidden2').val(order);
                $('#order_new_status2').val(status);
                $('.order_title').html(order);
            });

            $(".btn-modificar-hora").click(function() {
                var order = $('#order-modal').val();
                var hora = $('#time-modal').val();

                modificarHoraRecogida(order, hora);
            });

            $(".modal-hora").click(function() {
                $("#time-modal").val($(this).attr("data-time"));
                $("#order-modal").val($(this).attr("data-order"));
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

            function modificarHoraRecogida(order, hora) {
                $.get('{{ route('admin.order.time') }}', {
                    order_id: order,
                    time: hora,
                }, function(resp) {

                    $('#exampleModalHoraLong').modal('hide');

                    if (!resp) {
                        alert(
                            "Los tickets ya están impresos, no se pueden modificar, contacta con El Casino"
                        );
                    }

                    window.location.reload();
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

            $('.modal-status-all').click(function() {
                var order = '' + '{{ $orders_all }}';
                var status = $(this).attr("data-status");
                $('#order_hidden_all').val(order);
                $('#order_new_status_all').val(status);
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

            $('#cambiarEstadoAll').click(function() {
                var order = $('#order_hidden_all').val();
                var status = $('#order_new_status_all').val();
                cambiarEstados(order, status);
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

            $('#cambiarFpago').click(function() {
                var order = $('#order_hidden').val();
                var status = $('#order_new_status').val();
                var payment_method = $('#payment_method').find(":selected").val();
                cambiarFpago(order, status, payment_method);
            });

            $('#mandarACocina').click(function() {
                var order = $('#order_hidden2').val();
                var status = $('#order_new_status2').val();
                var payment_method = $('#payment_method2').find(":selected").val();
                mandarACocina(order, status, payment_method);
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

            function cambiarEstados(orders, status, payment_method = "") {
                $.post('{{ route('admin.order.changesStatus') }}', {
                    order_ids: orders,
                    status: status
                }, function(resp) {
                    window.location.reload();
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

            //if (queryString == "?status=1") {
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
            //}

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


            $('#cambiarFormaPago').click(function() {
                var order = $('#order_hidden').val();
                var payment_method = $('#payment_method').find(":selected").val();

                if (payment_method == "") {
                    alert("Selecciona una forma de pago");
                } else {
                    cambiarEstado(order, status, payment_method);
                }
            });

            function cambiarFpago(order, status, payment_method = "") {
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

            function mandarACocina(order, status, payment_method = "") {
                $.post('{{ route('admin.order.changeStatusPay') }}', {
                        order_id: order,
                        status: status,
                        payment_method: payment_method,
                    },
                    function(resp) {
                        if (resp) {
                            location.reload();
                        }
                        $('#exampleModalLongStatus').modal('hide');
                        $('#exampleModalLongStatusDelivered').modal('hide');
                        $("#payment_method").val("");
                    });
            }

        });
    </script>
@stop
