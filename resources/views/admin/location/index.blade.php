@extends('adminlte::page')

@section('title', 'Listado de ubicaciones')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listado de ubicaciones</h1>
        </div>
        <div class="col-sm-6">
            <a type="button" class="btn btn-success float-right" href="{{ route('admin.location.create') }}">Crear nueva
                ubicación</a>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ubicaciones</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 80%">Ubicación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locations as $location)
                                <tr>
                                    <td>{{ $location->name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-info"
                                                href="{{ route('admin.location.edit', $location) }}">Modificar</a>
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <form action="{{ route('admin.location.delete', $location) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item" href="#"
                                                        onclick="return confirm('Seguro que quieres eliminar esta ubicación?')">Eliminar
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
