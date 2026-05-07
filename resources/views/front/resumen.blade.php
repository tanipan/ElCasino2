@extends('layouts.webInside')


@section('content')
    @php
        $customer = Session::get('login')['cliente'];
        $order_modif = Session::get('modificar_pedido');
    @endphp

    <div class="my-5 paddingBody">
        <div class="menu">
            <div class="orden m-2" id="cesta">

            </div>

            <div class="facturacion card m-2">
                <div class="p-2">
                    <h4>
                        Datos del cliente
                    </h4>

                    @if (Auth::user() != null)
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label">ID</label>
                            <div class="col-sm-9">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                    value="{{ $customer->id }}">
                            </div>
                        </div>
                    @endif

                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Cliente</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $customer->name }} {{ $customer->lastname ? $customer->lastname : '' }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Teléfono</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $customer->phone }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="{{ $customer->email }}">
                        </div>
                    </div>
                    <form action="{{ route('front.registrarPedido') }}" method="POST" id="formu">
                        @csrf
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-3 col-form-label text-success">Indica la hora de
                                recogida</label>
                            <div class="col-sm-9">
                                <input style="border-color: rgb(25,135,84);width: 150px" type="time"
                                    class="form-control form-control-lg" id="time" name="time"
                                    value="{{ date('H:i', strtotime('+' . $minutos_margen->value . ' minutes', strtotime(date('H:i:s')))) }}">
                            </div>
                        </div>

                </div>
                <div>
                    <form action="{{ route('front.registrarPedido') }}" method="POST" id="formu">
                        @csrf
                        <div class="my-2">
                            <label class="text-secondary" for="">Observaciones del pedido</label>

                            @if ($order_modif != null)
                                <input class="form-control" type="text" name="observaciones"
                                    value="{{ $order_modif->observacions }}">
                            @else
                                <input class="form-control" type="text" name="observaciones">
                            @endif
                        </div>
                    </form>
                    <div class="my-2">
                        <div class="my-2 p-2 text-center">
                            <a class="btn btn-danger" href="{{ route('front.recoger') }}">Volver</a>
                            <button class="btn btn-success" id="confirmar">
                                @if (session()->get('conservar_cesta'))
                                    Modificar pedido
                                @else
                                    Confirmar pedido
                                @endif
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    //Desde aqui lanzamos los eventos tras la carga de la página
    $(document).ready(function() {

        cargarCesta();

        $("#confirmar").click(function() {

            var time = $('#time').val();

            var dt = new Date();
            var minutes = (dt.getMinutes() < 10 ? '0' : '') + dt.getMinutes()
            var time2 = dt.getHours() + ":" + minutes

            if (Date.parse('01/01/2011 ' + time + ':00') > Date.parse('01/01/2011 ' + dt.getHours() +
                    ':' + minutes + ':10')) {
                $("#formu").submit();
            } else {
                alert("La hora de recogida debe de ser mayor a la hora actual");
            }
        });
    });

    function cargarCesta() {
        console.log("Cesta cargada");
        $.get("{{ route('front.cargarCesta') }}", {
                "boton": false
            },
            function(data, status) {
                $('#cesta').html(data);
            });
    }
</script>
