@extends('layouts.webInside')

@section('content')
    <div class="my-5 paddingBody">

        <div class="menu">

            <div class="facturacion col-lg-6 col-md-12 col-sm-12">
                <div class="progress">
                    <div class="progress-bar {{ $status > 0 ? 'bg-success' : 'bg-secondary' }}" role="progressbar"
                        style="width: 25%; border-right: 3px solid white;" aria-valuenow="15" aria-valuemin="0"
                        aria-valuemax="100"></div>
                    <div class="progress-bar {{ $status > 1 ? 'bg-success' : 'bg-secondary' }}" role="progressbar"
                        style="width: 25%; border-right: 3px solid white;" aria-valuenow="30" aria-valuemin="0"
                        aria-valuemax="100"></div>
                    <div class="progress-bar {{ $status > 2 ? 'bg-success' : 'bg-secondary' }}" role="progressbar"
                        style="width: 25%; border-right: 3px solid white;" aria-valuenow="20" aria-valuemin="0"
                        aria-valuemax="100"></div>
                    <div class="progress-bar {{ $status > 3 ? 'bg-success' : 'bg-secondary' }}" role="progressbar"
                        style="width: 25%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="my-2">
                    <div class="d-flex">
                        <div style="width: 1rem; height: 1rem;" class="spinner-grow text-success m-1" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <h5>
                            @php
                                switch ($status) {
                                    case 1:
                                        $estado = 'Pendiente';
                                        break;
                                    case 2:
                                        $estado = 'En proceso';
                                        break;
                                    case 3:
                                        $estado = 'Listo';
                                        break;
                                    case 4:
                                        $estado = 'Recogido';
                                        break;
                                    default:
                                        $estado = 'Desconocido';
                                }
                            @endphp

                            Pedido {{ $pedido }} {{ $estado }}
                        </h5>
                    </div>
                    <p class="text-secondary my-2">
                        Cliente:
                    </p>
                    <p>
                        <i class="bi bi-person"></i>
                        {{ $cliente->name }} {{ $cliente->lastname ? $cliente->lastname : '' }}
                    </p>
                    <p class="text-secondary my-2">
                        Dirección de correo:
                    </p>
                    <p>
                        <i class="bi bi-mailbox"></i>
                        {{ $cliente->email }}
                    </p>
                    <p class="text-secondary my-2">
                        Movil de contacto:
                    </p>
                    <p>
                        <i class="bi bi-telephone"></i>
                        {{ $cliente->phone }}
                    </p>

                    @if ($order->observacions)
                        <p class="text-secondary my-2">
                            Observaciones:
                        </p>
                        <p>
                            <i class="bi bi-stickies"></i>
                            {{ $order->observacions }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="orden m-2 col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-title text-center">
                        <img class="w-50" src="assets/img/Copia de logo-los-bartolos.svg" alt="">

                    </div>

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
                                                <button type="button" class="btn menos" id="menos"></button>
                                                <button type="button"
                                                    class="btn btn-success">{{ $elemento['unidades'] }}</button>
                                                <button type="button" class="btn mas" id="mas"></button>
                                            </div>

                                        </div>
                                        <div class="precio-plato">
                                            <p class="text-danger" style="font-size: 15px;">{{ $elemento['precio'] }}
                                                €</p>
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
                                        {{ $total }} €
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $customer = Session::get('login');
        @endphp

        @if (isset($customer['admin']) and $customer['admin'] or Auth::user())
            <a href="{{ route('admin.order.list', ['status' => 1]) }}" type="button"
                class="btn btn-block btn-primary">Volver al
                gestor</a>
        @endif

    </div>
    </div>
    </div>
@endsection

@php
    $customer = Session::get('login');
@endphp

@if (isset($customer['admin']) and $customer['admin'] or Auth::user())
    <script>
        setTimeout("window.location.href=\"{{ route('admin.order.list', ['status' => 1]) }}\";", 3000);
    </script>
@endif
