@extends('adminlte::page')

@section('title', 'Listado de platos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Listado de platos</h1>
        </div>
        <div class="col-sm-6">
            <a type="button" class="btn btn-success float-right" href="{{ route('admin.dish.create') }}">Crear nuevo
                plato</a>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="card-title">Tipos de platos</h3>
                            <form action="{{ route('admin.dish.list') }}" method="GET" id="formu_filter">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="dishType" id="dishType" class="custom-select">
                                            <option value="">- Tipo de plato -</option>
                                            @foreach ($dishTypes as $item)
                                                <option {{ request()->dishType == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-sm">Filtrar</button>
                                        <a href="{{ route('admin.dish.list') }}" class="btn btn-danger btn-sm">Limpiar</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h3 class="card-title">Buscador de platos</h3>
                            <form action="{{ route('admin.dish.list') }}" method="GET" id="formu_filter">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="search" value=""
                                            name="search" placeholder="Plato">
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nombre</th>
                                <th>Importe</th>
                                <th>Oculto</th>
                                <th>Stock</th>
                                <th>Se ofrece en</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dishes as $dish)
                                <tr>
                                    <td>{{ $dish->id }}</td>
                                    <td>{{ $dish->name }}</td>
                                    <td>{{ $dish->price }}€</td>
                                    <td>
                                        @if ($dish->hidden)
                                            <span class="badge bg-warning">Oculto</span>
                                        @else
                                            <span class="badge bg-success">Disponible</span>
                                        @endif
                                    </td>
                                    <td {!! $dish->stock != 0 ? 'style="color: blue;font-size: 19px;font-weight: bold"' : '' !!}>{{ $dish->stock }} ud.</td>

                                    <td>
                                        @if ($dish->delivery_only)
                                            <span style="font-size: 30px">🛵</span>
                                        @elseif ($dish->room_only)
                                            <span style="font-size: 30px">🪑</span>
                                        @else
                                            <span class="badge bg-success">Todo</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-info"
                                                href="{{ route('admin.dish.edit', $dish) }}">Modificar</a>
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('admin.dish.delete', $dish) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item" href="#"
                                                        onclick="return confirm('Seguro que quieres eliminar el usuario?')">Eliminar
                                                        X</button>
                                                </form>

                                            </div>
                                        </div>

                                        @if (request()->dishType)
                                            <div class="btn-group">
                                                <a href="{{ route('admin.dish.upPosition', ['dish' => $dish, 'dishType' => request()->dishType]) }}"
                                                    type="button" class="btn btn-warning">Subir ⬆️</a>
                                                <a href="{{ route('admin.dish.downPosition', ['dish' => $dish, 'dishType' => request()->dishType]) }}"
                                                    type="button" class="btn btn-warning">Bajar ⬇️</a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix float-right">
                    @php
                        $params = [
                            'dishType' => Request::get('dishType'),
                        ];
                    @endphp
                    {{ $dishes->appends($params)->links() }}
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
