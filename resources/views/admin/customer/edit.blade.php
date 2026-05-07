@extends('adminlte::page')

@section('title', 'Modificar cliente')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Modificar cliente</h1>
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
                    <h3 class="card-title">Datos del cliente</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.customer.update', $customer) }}">

                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name', $customer->name) }}" name="name" placeholder="Inserta el nombre">
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Apellidos</label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname"
                                value="{{ old('lastname', $customer->lastname) }}" name="lastname"
                                placeholder="Inserta los apellidos">
                            @error('lastname')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                value="{{ old('email', $customer->email) }}" name="email" placeholder="Inserta el email">
                            @error('email')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Teléfono</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                value="{{ old('phone', $customer->phone) }}" name="phone"
                                placeholder="Inserta el teléfono">
                            @error('phone')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Contrasela">
                            @error('password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Repite Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" placeholder="Contrasela">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Año de nacimiento</label>
                            <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday"
                                value="{{ old('birthday', $customer->birthday) }}" name="birthday">
                            @error('birthday')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Observaciones</label>
                            <textarea class="form-control" rows="3" placeholder="Observaciones" id="observacions"
                                name="observacions">{{ old('observacions', $customer->observacions) }}</textarea>
                            @error('observacions')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Modificar cliente</button>
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
