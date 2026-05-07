@extends('adminlte::page')

@section('title', 'Gestión de stock')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Gestión de stock</h1>
        </div>
        <div class="col-sm-6"></div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Platos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="accordion">
                        @foreach ($stocks as $stock)
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100 collapsed" data-toggle="collapse"
                                            href="#collapse{{ $stock['category']->id }}" aria-expanded="false">
                                            <h4>{{ $stock['category']->name }}</h4>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse{{ $stock['category']->id }}" class="collapse"
                                    data-parent="#accordion" style="">
                                    <div class="card-body">

                                        <table class="table table-bordered">
                                            <tbody>
                                                @foreach ($stock['dishes'] as $dish)
                                                    <tr>
                                                        <td>
                                                            <table style="margin: auto">
                                                                <tr>
                                                                    <td style="border: 0px">
                                                                        <h4>{{ $dish->name }}</h4>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table style="margin: auto">
                                                                <tr>
                                                                    <td style="border: 0px">
                                                                        <button type="button"
                                                                            class="btn btn-lg btn-block btn-danger menos"
                                                                            data-dish="{{ $dish->id }}">&nbsp;&nbsp;-&nbsp;&nbsp;</button>
                                                                    </td>
                                                                    <td style="border: 0px">
                                                                        <input style="text-align: center"
                                                                            class="form-control form-control-lg" type="text"
                                                                            disabled value="0"
                                                                            id="dish-{{ $dish->id }}">
                                                                    </td>
                                                                    <td style="border: 0px">
                                                                        <button type="button"
                                                                            class="btn btn-lg btn-block btn-success mas"
                                                                            data-dish="{{ $dish->id }}">&nbsp;&nbsp;+&nbsp;&nbsp;</button>
                                                                    </td>
                                                                    <td style="border: 0px">
                                                                        <button type="button"
                                                                            class="btn btn-block btn-warning btn-lg add"
                                                                            data-dish="{{ $dish->id }}">Añadir
                                                                            ></button>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table style=" margin: auto">
                                                                <tr>
                                                                    <td style="border: 0px">
                                                                        <button type="button"
                                                                            class="btn btn-block btn-default btn-lg">
                                                                            <table
                                                                                style="border: 0px;margin: 0px;padding: 0px">
                                                                                <tr
                                                                                    style="border: 0px;margin: 0px;padding: 0px">
                                                                                    <td
                                                                                        style="border: 0px;margin: 0px;padding: 0px">
                                                                                        <h2 id="stock-{{ $dish->id }}">
                                                                                            {{ $dish->stock }}</h2>
                                                                                    </td>
                                                                                    <td
                                                                                        style="border: 0px;margin: 0px;padding: 0px;">
                                                                                        <h5
                                                                                            style="margin-top: 7px;margin-left: 7px;">
                                                                                            platos
                                                                                        </h5>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->

        </div>
        <!-- /.col -->
    </div>

@stop

@section('js')
    <script>
        $('.mas').click(function() {
            var dish = $(this).attr("data-dish");
            var unid = $("#dish-" + dish).val();
            unid++;
            $("#dish-" + dish).val(unid);
        });

        $('.menos').click(function() {
            var dish = $(this).attr("data-dish");
            var unid = $("#dish-" + dish).val();
            unid--;
            $("#dish-" + dish).val(unid);
        });

        $('.add').click(function() {
            var dish = ($(this).attr("data-dish"));
            $.get("{{ route('admin.stock.add') }}", {
                    dish_id: dish,
                    units: $("#dish-" + dish).val()
                },
                function(data, status) {
                    $("#stock-" + dish).html(data)
                    $("#dish-" + dish).val(0)
                });
        });

        function checkStock() {
            $.get("{{ route('admin.stock.check') }}", {},
                function(data, status) {
                    data = JSON.parse(data);
                    for (let [key, value] of Object.entries(data)) {
                        $("#stock-" + value.dish).html(value.stock)
                    }
                });
        }

        setInterval(function() {
            checkStock();
        }, 10000);
    </script>
@stop
