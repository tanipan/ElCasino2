@extends('adminlte::page')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Carta</h1>
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
                    <h3 class="card-title">Carta</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.menu.upload') }}" enctype="multipart/form-data">

                    @csrf
                    <div class="card-body">

                        <input type="file" name="carta" accept="application/pdf" />


                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Subir nueva carta</button>
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

    @if (session('status'))
        <script>
            alert({{ session('status') }});
        </script>
    @endif

@stop
