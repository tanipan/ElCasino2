@extends('adminlte::page')

@section('title', 'Crear nuevo plato')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Crear nuevo plato</h1>
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
                    <h3 class="card-title">Datos del nuevo plato</h3>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Paso 1</label>
                        <button type="button" class="btn btn-block btn-primary btn-lg">Información principal</button>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Paso 2</label>
                        <button type="button" class="btn btn-block btn-secondary btn-lg">Modificaciones</button>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Paso 3</label>
                        <button type="button" class="btn btn-block btn-secondary btn-lg">Extras</button>
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
                <form method="POST" action="{{ route('admin.dish.store') }}" enctype="multipart/form-data" id="formu-dish">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    @error('name')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <label for="exampleInputEmail1">Nombre del plato</label>
                                    <input type="text" class="form-control" id="name" value="{{ old('name') }}"
                                        name="name" placeholder="Nombre del plato">
                                    @error('name')
                                        <small style="color: red" class="error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Unidades mínimas</label>
                                    <input type="number" class="form-control" id="minimum_units" name="minimum_units"
                                        step="1" placeholder="Unidades mínimas" value="{{ old('minimum_units') }}">
                                    @error('minimum_units')
                                        <small style="color: red" class="error">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Stock</label>
                                    <input type="number" class="form-control" id="stock" name="stock" step="1"
                                        placeholder="Stock" value="{{ old('stock') }}">
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
                                            <option {{ old('dishType') == $dishType->id ? 'selected' : '' }}
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
                                        placeholder="Precio" value="{{ old('price') }}">
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
                                        placeholder="Precio CA" value="{{ old('price_ca') }}">
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
                            @error('imagen')
                                <small style="color: red" class="error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Descripción del plato</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <small style="color: red" class="error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input {{ old('hidden') ? 'checked' : '' }} type="checkbox" class="form-check-input"
                                id="hidden" name="hidden">
                            <label class="form-check-label" for="exampleCheck1">Plato oculto</label>
                        </div>

                        <div class="form-check">
                            <input {{ old('room_only') ? 'checked' : '' }} type="checkbox" class="form-check-input"
                                id="room_only" name="room_only">
                            <label class="form-check-label" for="exampleCheck1">Plato solo en sala 🪑</label>
                        </div>
                        <div class="form-check">
                            <input {{ old('delivery_only') ? 'checked' : '' }} type="checkbox" class="form-check-input"
                                id="delivery_only" name="delivery_only">
                            <label class="form-check-label" for="exampleCheck1">Plato solo para delivery 🛵</label>
                        </div>
                        <div class="form-check">
                            <input {{ old('waiter_only') ? 'checked' : '' }} type="checkbox" class="form-check-input"
                                id="waiter_only" name="waiter_only">
                            <label class="form-check-label" for="exampleCheck1">Plato solo para el camerero 🥤</label>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="" class="btn btn-danger">Volver</button>
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
        /*!
         * bsCustomFileInput v1.3.4 (https://github.com/Johann-S/bs-custom-file-input)
         * Copyright 2018 - 2020 Johann-S <johann.servoire@gmail.com>
         * Licensed under MIT (https://github.com/Johann-S/bs-custom-file-input/blob/master/LICENSE)
         */
        ! function(e, t) {
            "object" == typeof exports && "undefined" != typeof module ? module.exports = t() : "function" ==
                typeof define && define.amd ? define(t) : (e = e || self).bsCustomFileInput = t()
        }(this, function() {
            "use strict";
            var s = {
                    CUSTOMFILE: '.custom-file input[type="file"]',
                    CUSTOMFILELABEL: ".custom-file-label",
                    FORM: "form",
                    INPUT: "input"
                },
                l = function(e) {
                    if (0 < e.childNodes.length)
                        for (var t = [].slice.call(e.childNodes), n = 0; n < t.length; n++) {
                            var l = t[n];
                            if (3 !== l.nodeType) return l
                        }
                    return e
                },
                u = function(e) {
                    var t = e.bsCustomFileInput.defaultText,
                        n = e.parentNode.querySelector(s.CUSTOMFILELABEL);
                    n && (l(n).textContent = t)
                },
                n = !!window.File,
                r = function(e) {
                    if (e.hasAttribute("multiple") && n) return [].slice.call(e.files).map(function(e) {
                        return e.name
                    }).join(", ");
                    if (-1 === e.value.indexOf("fakepath")) return e.value;
                    var t = e.value.split("\\");
                    return t[t.length - 1]
                };

            function d() {
                var e = this.parentNode.querySelector(s.CUSTOMFILELABEL);
                if (e) {
                    var t = l(e),
                        n = r(this);
                    n.length ? t.textContent = n : u(this)
                }
            }

            function v() {
                for (var e = [].slice.call(this.querySelectorAll(s.INPUT)).filter(function(e) {
                        return !!e.bsCustomFileInput
                    }), t = 0, n = e.length; t < n; t++) u(e[t])
            }
            var p = "bsCustomFileInput",
                m = "reset",
                h = "change";
            return {
                init: function(e, t) {
                    void 0 === e && (e = s.CUSTOMFILE), void 0 === t && (t = s.FORM);
                    for (var n, l, r = [].slice.call(document.querySelectorAll(e)), i = [].slice.call(document
                            .querySelectorAll(t)), o = 0, u = r.length; o < u; o++) {
                        var c = r[o];
                        Object.defineProperty(c, p, {
                            value: {
                                defaultText: (n = void 0, n = "", (l = c.parentNode.querySelector(s
                                    .CUSTOMFILELABEL)) && (n = l.textContent), n)
                            },
                            writable: !0
                        }), d.call(c), c.addEventListener(h, d)
                    }
                    for (var f = 0, a = i.length; f < a; f++) i[f].addEventListener(m, v), Object.defineProperty(i[
                        f], p, {
                        value: !0,
                        writable: !0
                    })
                },
                destroy: function() {
                    for (var e = [].slice.call(document.querySelectorAll(s.FORM)).filter(function(e) {
                            return !!e.bsCustomFileInput
                        }), t = [].slice.call(document.querySelectorAll(s.INPUT)).filter(function(e) {
                            return !!e.bsCustomFileInput
                        }), n = 0, l = t.length; n < l; n++) {
                        var r = t[n];
                        u(r), r[p] = void 0, r.removeEventListener(h, d)
                    }
                    for (var i = 0, o = e.length; i < o; i++) e[i].removeEventListener(m, v), e[i][p] = void 0
                }
            }
        });
        //# sourceMappingURL=bs-custom-file-input.min.js.map
    </script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>

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
