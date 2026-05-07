@extends('adminlte::page')

@section('title', 'Listado de usuarios')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-9">
            <h1>Listado de direcciones de <strong>{{ $customer->name }} {{ $customer->lastname }}</strong></h1>
        </div>
        <div class="col-sm-3">
            <a type="button" class="btn btn-success float-right"
                href="{{ route('admin.address.create', $customer) }}">Crear nueva
                dirección</a>
            <a type="button" style="margin-right: 20px;" class="btn btn-primary float-right"
                href="{{ route('admin.customer.list') }}">Volver</a>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Direcciones</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Dirección</th>
                                <th>Alias</th>
                                <th>Principal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addresses as $address)
                                <tr>
                                    <td>{{ $address->id }}</td>
                                    <td>{{ $address->address }}</td>
                                    <td>{{ $address->alias }}</td>
                                    <td>{!! $address->principal ? '<strong>Si</strong>' : 'No' !!}</td>
                                    
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info">Operaciones</button>
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.address.edit', [$address, $customer]) }}">Modificar</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.address.setAsPrimary', [$address, $customer]) }}">Marcar
                                                    como
                                                    principal</a>
                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('admin.address.delete', [$address, $customer]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="dropdown-item" href="#"
                                                        onclick="return confirm('Seguro que quieres eliminar la dirección?')">Eliminar
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
                    {{ $addresses->links() }}
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
    <script>


    </script>
@stop
