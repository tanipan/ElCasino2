@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Gestión horaria</h1>
        </div>

    </div>
@stop

@php
    $empleados = [
        '48634998a' => 'Juanjo',
        '77840732s' => 'Borja',
        '21066922a' => 'Angela',
        '71732662d' => 'Isa',
        '48695560y' => 'Kevin',
        '48432960c' => 'Nico',
        '46380884g' => 'David',
        '77842603t' => 'Marta',
    ];
@endphp

@section('content')

    <div class="row">
        <!-- left column -->
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Gestión horaria</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form onsubmit="return validarFormulario()" method="POST"
                    action="{{ route('admin.user.timeControlStorate') }}">

                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>DNI trabajador</label>
                                    <input type="password" name="user222" id="user222" class="form-control"
                                        placeholder="Empleado">
                                </div>

                                <span class="error" style="color: red;font-weight: bold" id="error"></span>
                                @if (session()->get('ok'))
                                    <span class="error" style="color: green;font-weight: bold" id="ok">Registro
                                        correcto</span>
                                @endif
                            </div>

                        </div>


                    </div>

                    <div class="card-footer">
                        <button type="" class="btn btn-primary float-right">Grabar registro</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </div>

        <!--/.col (right) -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filtro entre:</h3>
                    <form action="{{ route('admin.user.timeControl') }}" method="GET" id="formu_filter">

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
                                <button type="button" class="btn btn-primary btn-sm filtrar">Filtrar</button>
                            </div>
                        </div>
                    </form>

                </div>

                @if ($time_controls)
                    @if (isset($time_controls['fechas']) && count($time_controls['fechas']) > 0)
                        @foreach ($time_controls['fechas'] as $k => $item)
                            <!-- /.card-header -->
                            <div class="card-header">
                                <h3 class="card-title">{{ $k }}</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Empleado</th>
                                            <th>Hora de entrada</th>
                                            <th>Hora de salida</th>
                                            <th>Minutos</th>
                                            <th>Horas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item as $nif => $user)
                                            @php
                                                if ($user['entrada'] and $user['salida']) {
                                                    $color = '#c6ebc6';
                                                } else {
                                                    $color = '#ebc6c6';
                                                }
                                            @endphp

                                            <tr style="background-color: {{ $color }}">
                                                <td>{{ $empleados[$nif] }} ({{ $nif }})</td>
                                                <td>{{ $user['entrada'] }}</td>
                                                <td>{{ $user['salida'] }}</td>
                                                <td>{{ $user['minutosDiff'] }}</td>
                                                <td>{{ $user['horasDiff'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        @endforeach
                    @endif
                @endif
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col -->
    </div>

    @if ($time_controls)
        <div class="row">
            <div class="col-md-6">

            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Horas totales</h3>
                    </div>

                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Trabajador</th>
                                    <th>Horas</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($time_controls['minutosTotalesPorTrabajador'] as $nif => $minutos)
                                    <tr>
                                        <td>{{ $empleados[$nif] }}</td>
                                        <td>{{ round($minutos / 60, 2) }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    @endif


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
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        const dniArray = ['NDg0MzI5NjBD', 'NDg2OTU1NjBZ', 'NzE3MzI2NjJE', 'Nzc4NTUxNjhG', 'Nzc4NDA3MzJT', 'MjEwNjY5MjJB',
            'NDYzODA4ODRH', 'Nzc4NDI2MDNU'

        ];

        function dniToBase64(dni) {
            var decodedStringBtoA = dni;
            var encodedStringBtoA = btoa(decodedStringBtoA);

            return encodedStringBtoA;
        }

        function validarFormulario() {
            $('#ok').html("");
            $('#error').html("");
            var dni = document.getElementById('user222').value;
            const dniBase64 = dniToBase64(dni.toUpperCase());

            if (dniArray.includes(dniBase64)) {
                return true;
            } else {
                $('#error').html("DNI incorrecto");
                return false;
            }
        }

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
    </script>
@stop
