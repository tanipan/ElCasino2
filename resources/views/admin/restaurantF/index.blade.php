@extends('adminlte::page')

@section('title', 'Listado de restaurantes')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listado de restaurates</h1>
        </div>
        <div class="col-sm-6">
            <a type="button" class="btn btn-success float-right" href="{{ route('admin.restaurantF.create') }}">Crear nuevo
                restaurante</a>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Restaurantes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Restaurante</th>
                                <th>Logo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($restaurants as $restaurant)
                                <tr>
                                    <td>{{ $restaurant->id }}</td>
                                    <td>{{ $restaurant->name }}</td>
                                    <td>
                                        <img width="100" src="{{ asset($restaurant->logo) }}" alt="">
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info">Operaciones</button>
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.restaurantF.edit', $restaurant) }}">Modificar</a>
                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('admin.restaurantF.delete', $restaurant) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item" href="#"
                                                        onclick="return confirm('Seguro que quieres eliminar el restaurante?')">Eliminar
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
                <div class="card-footer clearfix float-right">
                    {{ $restaurants->links() }}
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
