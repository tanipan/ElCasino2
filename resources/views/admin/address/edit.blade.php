@extends('adminlte::page')

@section('title', 'Modificar dirección')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Modificar dirección para <strong>{{ $customer->name }} {{ $customer->lastname }}</strong></h1>
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
                    <h3 class="card-title">Datos de la direccion
                    </h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.address.update', [$address, $customer]) }}">

                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Dirección</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                value="{{ old('address', $address->address) }}" name="address"
                                placeholder="Inserta la dirección">
                            @error('address')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Alias</label>
                            <input type="text" class="form-control @error('alias') is-invalid @enderror" id="alias"
                                value="{{ old('alias', $address->alias) }}" name="alias"
                                placeholder="Inserta los apellidos">
                            @error('alias')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Principal</label>

                            <select class="form-control @error('principal') is-invalid @enderror" id="principal"
                                name="principal">
                                <option {{ old('principal', $address->principal) == '1' ? 'selected' : '' }} value="1">Si
                                </option>
                                <option {{ old('principal', $address->principal) == '0' ? 'selected' : '' }} value="0">No
                                </option>
                            </select>

                            @error('principal')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Observaciones</label>
                            <textarea class="form-control" rows="3" placeholder="Observaciones" id="observacions"
                                value="{{ old('observacions', $address->observacions) }}" name="observacions"></textarea>
                            @error('observacions')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Modificar dirección</button>
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
