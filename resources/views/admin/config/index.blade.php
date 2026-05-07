@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Configuración</h1>
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
                    <h3 class="card-title">Configuración</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.config.update') }}">

                    @csrf
                    <div class="card-body">

                        @foreach ($configs as $config)
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ ucfirst($config->title) }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ $config->value }}" name="{{ $config->id }}"
                                    placeholder="Inserta el valor">
                            </div>
                        @endforeach

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Modificar configuración</button>
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
