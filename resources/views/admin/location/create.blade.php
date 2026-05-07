@extends('adminlte::page')

@section('title', 'Crear nueva ubicación')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Crear nueva ubicación</h1>
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
                    <h3 class="card-title">Ubicación</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.location.store') }}">

                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre de la ubicación</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name') }}" name="name" placeholder="Inserta la ubicación">
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Crear ubicación</button>
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
