@extends('adminlte::page')

@section('title', 'Listado de tipos de platos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listado de tipos de platos</h1>
        </div>
        <div class="col-sm-6">
            <a type="button" class="btn btn-success float-right" href="{{ route('admin.dishType.create') }}">Crear nuevo
                tipo de plato</a>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tipos de platos</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Tipo de plato</th>
                                <th>Slug</th>
                                <th>Oculto</th>
                                <th>Gestiona stock</th>
                                <th>Solo camarero</th>
                                <th>Solo en local</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dishTypes as $dishType)
                                <tr>
                                    <td>{{ $dishType->id }}</td>
                                    <td>{{ $dishType->name }}</td>
                                    <td>{{ $dishType->slug }}</td>
                                    <td>{{ $dishType->hidden ? 'Si' : 'No' }}</td>
                                    <td>{{ $dishType->manageStock ? 'Si' : 'No' }}</td>
                                    <td>{{ $dishType->waiter_only ? 'Si' : 'No' }}</td>
                                    <td>{{ $dishType->room_only ? 'Si' : 'No' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-info"
                                                href="{{ route('admin.dishType.edit', $dishType) }}">Modificar</a>
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.dish.list', ['dishType' => $dishType->id]) }}">Ver
                                                    platos</a>
                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('admin.dishType.delete', $dishType) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item" href="#"
                                                        onclick="return confirm('Seguro que quieres eliminar el tipo de plato?')">Eliminar
                                                        X</button>
                                                </form>

                                            </div>
                                        </div>

                                        <div class="btn-group">
                                            <a href="{{ route('admin.dishType.upPosition', $dishType) }}" type="button"
                                                class="btn btn-warning">Subir ⬆️</a>
                                            <a href="{{ route('admin.dishType.downPosition', $dishType) }}" type="button"
                                                class="btn btn-warning">Bajar ⬇️</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix float-right">
                    {{ $dishTypes->links() }}
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
