@extends('adminlte::page')

@section('title', 'Crear nuevo plato')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Modificar plato {{ $dish->name }}</h1>
        </div>

    </div>
@stop

@section('content')

    <div class="row">
        <!-- left column -->
        <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Datos del plato</h3>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Paso 1</label>
                        <a style="color: white" type="button" class="btn btn-block btn-primary btn-lg">Información
                            principal</a>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Paso 2</label>
                        <a href="{{ route('admin.dish.create2', $dish) }}" type="button"
                            class="btn btn-block btn-secondary btn-lg">Modificaciones</a>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Paso 3</label>
                        <a href="{{ route('admin.dish.create3', $dish) }}" type="button"
                            class="btn btn-block btn-secondary btn-lg">Extras</a>
                    </div>
                </div>

            </div>
            <!-- /.card -->

        </div>

        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-warning">

                <div class="card-header">
                    <h3 class="card-title">Información principal</h3>
                </div>

                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.dish.update', $dish) }}" enctype="multipart/form-data"
                    id="formu-dish">
                    @method('PUT')
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nombre del plato</label>
                                    <input type="text" class="form-control" id="name"
                                        value="{{ old('name', $dish->name) }}" name="name"
                                        placeholder="Nombre del plato">
                                    @error('name')
                                        <small style="color: red" class="error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Unidedes mínimas</label>
                                    <input type="number" class="form-control" id="minimum_units" name="minimum_units"
                                        step="1" value="{{ old('minimum_units', $dish->minimum_units) }}"
                                        placeholder="Unidades mínimas">
                                    @error('minimum_units')
                                        <small style="color: red" class="error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock" step="1"
                                        value="{{ old('stock', $dish->stock) }}" placeholder="Stock">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <!-- checkbox -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Categoría del plato</label>
                                    <select class="form-control" name="dishType" id="dishType">
                                        <option value="">- Categoría -</option>
                                        @foreach ($dishTypes as $dishType)
                                            <option
                                                {{ old('dishType', $dish->dish_type_id) == $dishType->id ? 'selected' : '' }}
                                                value="{{ $dishType->id }}">{{ $dishType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('dishType')
                                        <small style="color: red" class="error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <!-- radio -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Precio</label>
                                    <input type="number" class="form-control" id="price" name="price" step="0.01"
                                        value="{{ old('price', $dish->price) }}" placeholder="Precio">
                                    @error('price')
                                        <small style="color: red" class="error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <!-- radio -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Precio CA</label>
                                    <input type="number" class="form-control" id="price_ca" name="price_ca" step="0.01"
                                        value="{{ old('price_ca', $dish->price_ca) }}" placeholder="Precio CA">

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Subir imagen</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="imagen" name="imagen"
                                        accept=".jpg,.jpeg">
                                    <label class="custom-file-label" for="exampleInputFile"></label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Descripción del plato</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="3">{{ old('description', $dish->description) }}</textarea>
                            @error('description')
                                <small style="color: red" class="error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="hidden" name="hidden"
                                {{ old('hidden', $dish->hidden) ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleCheck1">Plato oculto</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="room_only" name="room_only"
                                {{ old('room_only', $dish->room_only) ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleCheck1">Plato solo en sala 🪑</label>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="delivery_only" name="delivery_only"
                                {{ old('delivery_only', $dish->delivery_only) ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleCheck1">Plato solo para delivery 🛵</label>
                        </div>

                        <div class="form-check">
                            <input {{ old('waiter_only', $dish->waiter_only) ? 'checked' : '' }} type="checkbox"
                                class="form-check-input" id="waiter_only" name="waiter_only">
                            <label class="form-check-label" for="exampleCheck1">Plato solo para el camerero 🥤</label>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger">Volver</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
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
        document.getElementById('imagen').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Obtener el archivo seleccionado
            const errorElement = document.getElementById('error');

            if (file) {
                const img = new Image();
                img.src = URL.createObjectURL(file);

                img.onload = function() {
                    const width = img.width;
                    const height = img.height;

                    // Comprobar si la imagen es cuadrada
                    if (width !== height) {
                        alert('La imagen debe de ser cuadrada.');
                    }
                };

                img.onerror = function() {
                    console.error('El archivo seleccionado no es una imagen válida.');
                };
            }
        });

        document.getElementById('imagen').addEventListener('submit', function(event) {
            const errorElement = document.getElementById('error');

            // Evitar envío si hay un error
            if (errorElement.style.display === 'block') {
                event.preventDefault();
                alert('Por favor, selecciona una imagen cuadrada.');
            }
        });
    </script>

    <script>
        document.getElementById('formu-dish').addEventListener('submit', function(event) {
            const fileInput = document.getElementById('imagen'); // Input del archivo
            const file = fileInput.files[0]; // Archivo seleccionado

            if (file) {
                const img = new Image();

                img.onload = function() {
                    const width = img.width;
                    const height = img.height;

                    // Comprobar si la imagen es cuadrada
                    if (width !== height) {
                        alert('La imagen seleccionada debe tener dimensiones cuadradas (ancho igual a alto).');
                        event.preventDefault(); // Bloquear el envío del formulario
                        return; // Salir de la función si no es válida
                    } else {
                        // Si es válida, no hacemos nada y permitimos el envío
                        document.getElementById('formu-dish').submit();
                    }
                };

                img.onerror = function() {
                    alert('El archivo seleccionado no es una imagen válida.');
                    event.preventDefault(); // Bloquear el envío si no es una imagen válida
                };

                img.src = URL.createObjectURL(file); // Cargar la imagen para verificar dimensiones

                // Bloquear temporalmente el envío para realizar la validación
                event.preventDefault();
            } else {
                document.getElementById('formu-dish').submit();
            }
        });
    </script>
@stop
