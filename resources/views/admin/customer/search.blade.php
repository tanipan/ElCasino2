@extends('adminlte::page')

@section('title', 'Listado de usuarios')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Búsqueda de clientes</h1>
        </div>
        <div class="col-sm-6">
            <a type="button" class="btn btn-success float-right" href="{{ route('admin.customer.create') }}">Crear nuevo
                cliente</a>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Clientes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Teléfono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->lastname }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <form action="{{ route('front.validarLoginToken') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="token" value="{{ $customer->token }}">
                                                <button class="btn btn-info" href="#">Acceder
                                                    a la web</button>
                                            </form>
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.customer.edit', $customer->id) }}">Modificar</a>

                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('admin.customer.delete', $customer->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item" href="#"
                                                        onclick="return confirm('Seguro que quieres eliminar al cliente?')">Eliminar
                                                        X</button>
                                                </form>

                                            </div>

                                        </div>


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

@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">-->
@stop

@section('js')
    <script></script>
@stop
