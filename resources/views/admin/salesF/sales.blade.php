@extends('adminlte::page')

@section('title', 'Listado de restaurantes')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Participantes</h1>
        </div>

    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">


                    <div class="row">

                        <div class="row mt-4">
                            @foreach ($restaurants as $restaurant)
                                <div class="col-sm-3 restaurante" style="margin-bottom: 15px"
                                    data-burger="{{ $restaurant->id }}" data-burger-name="{{ $restaurant->name }}"
                                    data-toggle="modal" data-target="#exampleModal">
                                    <div class="position-relative" style="min-height: 180px;">
                                        <img style="border-radius: 30px;" src="{{ asset($restaurant->logo) }}"
                                            alt="Photo 3" class="img-fluid">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->

        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ultimas ventas</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hamburguesería</th>
                                <th>Venta</th>
                                <th>Unidades</th>
                                <th>Hora</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="lineas_ventas">

                        </tbody>
                    </table>
                </div>

            </div>

        </div>



    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" id="contenido_modal">

        </div>
    </div>

@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">-->
@stop

@section('js')
    <script>
        $('.restaurante').click(function() {
            let texto;
            let id;

            texto = $(this).attr("data-burger-name");
            id = $(this).attr("data-burger");

            $('#burger-name').html(texto);

            //Hacer la llamada Ajax
            $.ajax({
                url: "{{ route('getBurger') }}",
                method: 'POST',
                data: {
                    id: id,
                    user: {{ Auth::user()->id }}
                }
            }).done(function(data) {
                $('#contenido_modal').html(data);
            })
        });

        function refrescarVentas() {
            $.ajax({
                url: "{{ route('getSales') }}",
                method: 'POST',
                data: {
                    user: {{ Auth::user()->id }}
                }
            }).done(function(data) {
                $('#lineas_ventas').html(data);
            })
        }

        function eliminar(id) {
            if (!confirm("Eliminar la venta")) {
                return;
            }


            $.ajax({
                url: "{{ route('deleteSale') }}",
                method: 'POST',
                data: {
                    id: id
                }
            }).done(function(data) {
                refrescarVentas();
            })
        }

        setInterval(refrescarVentas, 1000);
        refrescarVentas()
    </script>
@stop
