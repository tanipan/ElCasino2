@extends('adminlte::page')

@section('title', 'Crear nuevo usuario')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Crear nuevo usuario</h1>
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
                    <h3 class="card-title">Datos del nuevo usuario</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.user.store') }}">

                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name') }}" name="name" placeholder="Inserta el nombre">
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                value="{{ old('email') }}" name="email" placeholder="Inserta el email">
                            @error('email')
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
                        <div class=" form-group">
                            <label for="exampleInputFile">Tipo de Rol</label>
                            <div class="form-group">

                                <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                    <option value="">- Tipo de rol -</option>
                                    <option {{ old('role') == 'admin' ? 'selected' : '' }} value="admin">Administrador
                                    </option>
                                    <option {{ old('role') == 'reviewer' ? 'selected' : '' }} value="reviewer">Revisor
                                    </option>
                                </select>
                            </div>
                            @error('role')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Crear usuario</button>
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
