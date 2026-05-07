@php
    $anchura = 370;
    $titulo_tarjeta = 20;
    $titulo_plato = 24;
    $separacion_comandas = 1;
@endphp

<!-- Columna Sala -->
<div class="card card-row card-secondary" style="width: {{ $anchura }}px !important">
    <div class="card-header" style="background-color: orange">
        <h3 class="card-title">
            SALA
        </h3>
    </div>
    <div class="card-body">
        @foreach ($orders as $order)
            @if (
                ($order->hide_in_started == '0000-00-00 00:00:00' or $order->hide_in_started == null) and
                    $order->getType() == 'table' and
                    count($order->getLinesStarter()) and
                    $order->orderCanBePrepared())
                @php
                    $pedido_listo = $order->getLinesStarterIsPrepared();
                @endphp

                <div class="card card-info card-outline"
                    style="border-top: 3px solid orange;margin-bottom: {{ $separacion_comandas }}rem">
                    <div class="card-header" style="background-color: cornsilk;">
                        <h5 class="card-title" style="font-size: {{ $titulo_tarjeta }}px">
                            <strong>

                                @if ($order->time_ready)
                                    <span style="font-size: 17px" data-toggle="modal" data-target="#exampleModalLong"
                                        data-order="{{ $order->id }}"
                                        class="badge bg-danger modal-comanda2">{{ substr($order->time_ready, 0, -3) }}</span>
                                @else
                                    <span style="font-size: 17px" data-toggle="modal" data-target="#exampleModalLong"
                                        data-order="{{ $order->id }}"
                                        class="badge bg-info modal-comanda2">{{ substr(explode(' ', $order->date)[1], 0, -3) }}</span>
                                @endif

                                &nbsp;&nbsp;

                                {{ $order->observacions }}


                                @php
                                    $minutos = $order->getMinutesLate();
                                @endphp

                                @if ($minutos <= 5)
                                    <span style="font-size: 17px" class="badge bg-success">⏳{{ $minutos }}m</span>
                                @elseif($minutos > 5 and $minutos <= 10)
                                    <span style="font-size: 17px" class="badge bg-warning">⏳{{ $minutos }}m</span>
                                @elseif($minutos > 10)
                                    <span style="font-size: 17px" class="badge bg-danger">⏳{{ $minutos }}m</span>
                                @endif
                            </strong>
                        </h5>
                        @if ($pedido_listo)
                            <div class="card-tools">
                                <button data-order-id="{{ $order->id }}" type="button"
                                    class="btn btn-block btn-warning hidden_order">Liquidado</button>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">

                        @foreach ($order->getLinesStarter() as $line)
                            <div class="custom-control custom-checkbox" style="font-size: {{ $titulo_plato }}px">
                                <input class="custom-control-input" type="checkbox" {!! $line->is_ready ? 'checked' : '' !!}
                                    id="customCheckbox{{ $line->id }}">
                                <label data-line-id="{{ $line->id }}" for="customCheckbox{{ $line->id }}"
                                    class="entrante custom-control-label" style="margin-bottom: 8px">

                                    @if ($line->units > 1)
                                        <span
                                            style="color: red">{{ $line->units }}x</span>{{ ' ' . $line->dish->name }}
                                    @else
                                        {{ $line->units }}x{{ ' ' . $line->dish->name }}
                                    @endif

                                    @foreach ($line->getElements(0, 1) as $ele)
                                        <!-- Elementos -->
                                        <div class="row text-primary" style="font-size: 18px">
                                            <div class="col-1"></div>
                                            <div class="col-11">
                                                - {{ $ele->element->name }}
                                            </div>
                                        </div>
                                        <!-- /Elementos -->
                                    @endforeach

                                </label>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif
        @endforeach

    </div>
</div>
<!-- /Columna Sala -->

<!-- Columna CA -->
<div class="card card-row card-danger" style="width: {{ $anchura }}px !important">
    <div class="card-header">
        <h3 class="card-title">
            COMOAQUI
        </h3>
    </div>
    <div class="card-body">
        @foreach ($orders as $order)
            @if (
                ($order->hide_in_started == '0000-00-00 00:00:00' or $order->hide_in_started == null) and
                    $order->getType() == 'ca' and
                    count($order->getLinesStarter()) and
                    $order->orderCanBePrepared())
                @php
                    $pedido_listo = $order->getLinesStarterIsPrepared();
                @endphp

                <div class="card card-danger card-outline" style="margin-bottom: {{ $separacion_comandas }}rem">
                    <div class="card-header" style="background-color: #ffdcdc;">
                        <h5 class="card-title" style="font-size: {{ $titulo_tarjeta }}px">
                            <strong>

                                @if ($order->time_ready)
                                    <span style="font-size: 17px" data-toggle="modal" data-target="#exampleModalLong"
                                        data-order="{{ $order->id }}"
                                        class="badge bg-danger modal-comanda2">{{ substr($order->time_ready, 0, -3) }}</span>
                                @else
                                    <span style="font-size: 17px" data-toggle="modal" data-target="#exampleModalLong"
                                        data-order="{{ $order->id }}"
                                        class="badge bg-info modal-comanda2">{{ substr(explode(' ', $order->date)[1], 0, -3) }}</span>
                                @endif

                                &nbsp;&nbsp;

                                {{ explode('-', $order->order)[1] }} -
                                {{ $order->order_comoaqui }}

                                @php
                                    $minutos = $order->getMinutesLate();
                                @endphp

                                @if ($minutos <= 5)
                                    <span style="font-size: 17px" class="badge bg-success">⏳{{ $minutos }}m</span>
                                @elseif($minutos > 5 and $minutos <= 10)
                                    <span style="font-size: 17px" class="badge bg-warning">⏳{{ $minutos }}m</span>
                                @elseif($minutos > 10)
                                    <span style="font-size: 17px" class="badge bg-danger">⏳{{ $minutos }}m</span>
                                @endif
                            </strong>
                        </h5>
                        @if ($pedido_listo)
                            <div class="card-tools">
                                <button data-order-id="{{ $order->id }}" type="button"
                                    class="btn btn-block btn-warning hidden_order">Liquidado</button>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">

                        @foreach ($order->getLinesStarter() as $line)
                            <div class="custom-control custom-checkbox" style="font-size: {{ $titulo_plato }}px">
                                <input class="custom-control-input" type="checkbox" {!! $line->is_ready ? 'checked' : '' !!}
                                    id="customCheckbox{{ $line->id }}">
                                <label data-line-id="{{ $line->id }}" for="customCheckbox{{ $line->id }}"
                                    class="entrante custom-control-label" style="margin-bottom: 8px">

                                    @if ($line->units > 1)
                                        <span
                                            style="color: red">{{ $line->units }}x</span>{{ ' ' . $line->dish->name }}
                                    @else
                                        {{ $line->units }}x{{ ' ' . $line->dish->name }}
                                    @endif

                                    @foreach ($line->getElements() as $ele)
                                        <!-- Elementos -->
                                        <div class="row text-primary" style="font-size: 18px">
                                            <div class="col-1"></div>
                                            <div class="col-11">
                                                - {{ $ele->element->name }}
                                            </div>
                                        </div>
                                        <!-- /Elementos -->
                                    @endforeach

                                </label>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif
        @endforeach

    </div>
</div>
<!-- /Columna CA -->

<!-- Columna TakeAway -->
<div class="card card-row card-primary" style="width: {{ $anchura }}px !important">
    <div class="card-header">
        <h3 class="card-title">
            TAKEAWAY
        </h3>
    </div>
    <div class="card-body">
        @foreach ($orders as $order)
            @if (
                ($order->hide_in_started == '0000-00-00 00:00:00' or $order->hide_in_started == null) and
                    $order->getType() == 'takeAway' and
                    count($order->getLinesStarter()) and
                    $order->orderCanBePrepared())
                @php
                    $pedido_listo = $order->getLinesStarterIsPrepared();
                @endphp

                <div class="card card-primary card-outline" style="margin-bottom: {{ $separacion_comandas }}rem">
                    <div class="card-header" style="background-color: #dcf0ff;">
                        <h5 class="card-title" style="font-size: {{ $titulo_tarjeta }}px">
                            <strong>

                                @if ($order->time_ready)
                                    <span style="font-size: 17px" data-toggle="modal" data-target="#exampleModalLong"
                                        data-order="{{ $order->id }}"
                                        class="badge bg-danger modal-comanda2">{{ substr($order->time_ready, 0, -3) }}</span>
                                @else
                                    <span style="font-size: 17px" data-toggle="modal" data-target="#exampleModalLong"
                                        data-order="{{ $order->id }}"
                                        class="badge bg-info modal-comanda2">{{ substr(explode(' ', $order->date)[1], 0, -3) }}</span>
                                @endif

                                &nbsp;&nbsp;

                                {{ explode('-', $order->order)[1] }} -
                                {{ $order->customer->name }}
                                {{ $order->customer->lastname }}

                                @php
                                    $minutos = $order->getMinutesLate();
                                @endphp

                                @if ($minutos <= 5)
                                    <span style="font-size: 17px"
                                        class="badge bg-success">⏳{{ $minutos }}m</span>
                                @elseif($minutos > 5 and $minutos <= 10)
                                    <span style="font-size: 17px"
                                        class="badge bg-warning">⏳{{ $minutos }}m</span>
                                @elseif($minutos > 10)
                                    <span style="font-size: 17px"
                                        class="badge bg-danger">⏳{{ $minutos }}m</span>
                                @endif
                            </strong>
                        </h5>
                        @if ($pedido_listo)
                            <div class="card-tools">
                                <button data-order-id="{{ $order->id }}" type="button"
                                    class="btn btn-block btn-warning hidden_order">Liquidado</button>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">

                        @foreach ($order->getLinesStarter() as $line)
                            <div class="custom-control custom-checkbox" style="font-size: {{ $titulo_plato }}px">
                                <input class="custom-control-input" type="checkbox" {!! $line->is_ready ? 'checked' : '' !!}
                                    id="customCheckbox{{ $line->id }}">
                                <label data-line-id="{{ $line->id }}" for="customCheckbox{{ $line->id }}"
                                    class="entrante custom-control-label" style="margin-bottom: 8px">

                                    @if ($line->units > 1)
                                        <span
                                            style="color: red">{{ $line->units }}x</span>{{ ' ' . $line->dish->name }}
                                    @else
                                        {{ $line->units }}x{{ ' ' . $line->dish->name }}
                                    @endif

                                    @foreach ($line->getElements() as $ele)
                                        <!-- Elementos -->
                                        <div class="row text-primary" style="font-size: 18px">
                                            <div class="col-1"></div>
                                            <div class="col-11">
                                                - {{ $ele->element->name }}
                                            </div>
                                        </div>
                                        <!-- /Elementos -->
                                    @endforeach

                                </label>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif
        @endforeach

    </div>
</div>
<!-- /Columna TakeAway -->
