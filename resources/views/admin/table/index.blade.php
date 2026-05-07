@extends('adminlte::page')

@section('title', 'Listado de mesas')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listado de mesas</h1>
        </div>
        <div class="col-sm-6">
            <a type="button" class="btn btn-success float-right" href="{{ route('admin.table.create') }}">Crear nueva mesa</a>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mesas</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mesa</th>
                                <th>Ubicación</th>
                                <th>Permite pedir</th>
                                <th>Comensales</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tables as $table)
                                <tr>
                                    <td>{{ $table->name }}</td>
                                    <td>{{ $table->location()->name }}</td>
                                    <td>{{ $table->orderWithoutWaiter ? 'Si' : 'No' }}</td>
                                    <td>{{ $table->eaters }}</td>
                                    <td>{{ $table->status }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-info"
                                                href="{{ route('admin.table.edit', $table) }}">Modificar</a>
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <form action="{{ route('admin.table.delete', $table) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item" href="#"
                                                        onclick="return confirm('Seguro que quieres eliminar esta mesa?')">Eliminar
                                                        X</button>
                                                </form>

                                                <a class="dropdown-item" href="{{ route('admin.qrcode.index', $table) }}"
                                                    target="_black">Ver QR</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <!-- /.card -->

        </div>
        <!-- /.col -->
    </div>

@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">-->
@stop

@section('js')
    <script></script>
@stop
