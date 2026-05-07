@extends('adminlte::page')

@section('title', 'Crear nueva mesa')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Crear nueva mesa</h1>
        </div>

    </div>
@stop

@section('content')

    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Mesa</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.table.store') }}">

                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre de la mesa</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name') }}" name="name" placeholder="Inserta la mesa">
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Ubicación</label>

                            <select class="form-control @error('location') is-invalid @enderror" id="location"
                                name="location">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>

                            @error('principal')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Permite hacer pedidos directos</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="orderWithoutWaiter"
                                    name="orderWithoutWaiter" value="1" checked="">
                                <label class="form-check-label" for="orderWithoutWaiter">Pedidos directos</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Comensales</label>
                            <input type="number" class="form-control @error('eaters') is-invalid @enderror" id="eaters"
                                value="{{ old('eaters') }}" name="eaters" placeholder="Inserta el número de comensales">
                            @error('eaters')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Crear mesa</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </div>

        <!--/.col (right) -->
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')


@stop
