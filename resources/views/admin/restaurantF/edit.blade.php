@extends('adminlte::page')

@section('title', 'Modificar restaurante')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Modificar restaurante</h1>
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
                    <h3 class="card-title">Datos del restaurante</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.restaurantF.update', $restaurant) }}"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name', $restaurant->name) }}" name="name" placeholder="Inserta el nombre">
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo"
                                value="{{ old('logo') }}" name="logo" placeholder="Selecciona el logo">
                            @error('logo')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                            <br>
                            <img width="100" src="{{ asset($restaurant->logo) }}" alt="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Producto 1</label>
                            <input type="text" class="form-control @error('dish1') is-invalid @enderror" id="dish1"
                                value="{{ old('dish1', $restaurant->dish1) }}" name="dish1"
                                placeholder="Inserta el producto">
                            @error('dish1')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Producto 2</label>
                            <input type="text" class="form-control @error('dish2') is-invalid @enderror" id="dish2"
                                value="{{ old('dish2', $restaurant->dish2) }}" name="dish2"
                                placeholder="Inserta el producto">
                            @error('dish2')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Producto 3</label>
                            <input type="text" class="form-control @error('dish3') is-invalid @enderror" id="dish3"
                                value="{{ old('dish3', $restaurant->dish3) }}" name="dish3"
                                placeholder="Inserta el producto">
                            @error('dish3')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Modificar restaurante</button>
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
    <script>
        console.log('Hi!');
    </script>
@stop
