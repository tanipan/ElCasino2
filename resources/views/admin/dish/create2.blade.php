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
                        <a href="{{ route('admin.dish.edit', $dish) }}" style="color: white" type="button"
                            class="btn btn-block btn-info btn-lg">Información principal</a>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Paso 2</label>
                        @if ($type == 'extra')
                            <a href="{{ route('admin.dish.create2', $dish) }}" style="color: white" type="button"
                                class="btn btn-block btn-secondary btn-lg">Modificaciones</a>
                        @else
                            <a href="{{ route('admin.dish.create2', $dish) }}" style="color: white" type="button"
                                class="btn btn-block btn-primary btn-lg">Modificaciones</a>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Paso 3</label>
                        @if ($type == 'extra')
                            <a href="{{ route('admin.dish.create3', $dish) }}" style="color: white" type="button"
                                class="btn btn-block btn-primary btn-lg">Extras</a>
                        @else
                            <a href="{{ route('admin.dish.create3', $dish) }}" style="color: white" type="button"
                                class="btn btn-block btn-secondary btn-lg">Extras</a>
                        @endif
                    </div>
                </div>

            </div>
            <!-- /.card -->

        </div>

        <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-warning">

                <div class="card-header">
                    <h3 class="card-title">{{ $text1 }}</h3>
                </div>

                <!-- /.card-header -->
                <!-- form start -->
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <!-- checkbox -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Crear una {{ $text2 }}</label>
                                <div class="input-group input-group">
                                    <input type="text" class="form-control" name="modification" id="modification">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary btn-flat"
                                            id="crear_modif">Crear</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">


                        <div class="col-sm-8">
                            <!-- checkbox -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Selecciona {{ $text2 == 'extra' ? 'un' : '' }}
                                    {{ $text2 }}</label>
                                <select class="form-control" name="modification_type_id" id="dishModif">
                                    @if ($text2 == 'extra')
                                        <option value="">- Extra -</option>
                                    @else
                                        <option value="">- Modificación -</option>
                                    @endif


                                    @foreach ($modifications as $modif)
                                        <option value="{{ $modif->id }}">{{ $modif->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nº mín. de selecciones</label>
                                <select class="form-control" name="min_num" id="min_num">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <!-- checkbox -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Elemento {{ $text2 == 'extra' ? 'del' : 'de la' }}
                                    {{ $text2 }}</label>
                                <input type="text" class="form-control" id="element" name="element"
                                    placeholder="Elemento">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <!-- checkbox -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Suplemento</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01"
                                    placeholder="Suplemento">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <!-- checkbox -->
                            <div class="form-group">
                                <input type="hidden" id="type" name="type" value="{{ $type }}">
                                <input type="hidden" id="current_element_modif">
                                <label
                                    for="exampleInputEmail1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary"
                                            id="crear_modificacion">Añadir</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-warning" style="display: none;"
                                            id="editar_modificacion">Actualizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-12">
                            <p class="mb-1">
                                <label for="exampleInputEmail1">{{ $text1 }} actuales</label>
                            </p>
                            <p id="table_section">
                                <!-- MODIFICACIONES -->
                            </p>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <!--<button type="submit" class="btn btn-danger">Volver</button>-->

                    @if ($type == 'extra')
                        <a href="{{ route('admin.dish.list') }}" style="color: white" type="submit"
                            class="btn btn-success">Finalizar</a>
                    @else
                        <a href="{{ route('admin.dish.create3', $dish) }}" style="color: white" type="submit"
                            class="btn btn-success">Siguiente ></a>
                    @endif
                </div>
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
        $('#crear_modif').click(function() {
            if ($('#modification').val()) {
                $.ajax({
                    url: "{{ route('modificationType.store') }}",
                    method: 'POST',
                    data: {
                        "name": $('#modification').val(),
                        "type": '{{ $type }}'
                    },
                    dataType: "json",
                }).done(function(data) {
                    //console.log(data);
                    $('#modification').val("")
                    fillComboModif(data.modification_type);
                });
            } else {
                alert("Inserta el nombre de la modifiación");
            }
        });

        function fillComboModif(data) {

            $("#dishModif").empty();
            $('#dishModif').append('<option value="">- Modificación -</option>');

            for (var index = 0; index < data.length; index++) {
                $('#dishModif').append('<option value="' + data[index].id + '">' + data[index].name +
                    '</option>');
            }

        }

        //--------------------       

        $('#crear_modificacion').click(function() {
            if (($('#dishModif').find(":selected").val() != "") && ($('#element').val())) {
                $.ajax({
                    url: "{{ route('modification.store') }}",
                    method: 'POST',
                    data: {
                        "dish_id": '{{ $dish->id }}',
                        "min_num": $('#min_num').find(":selected").val(),
                        "modification_type_id": $('#dishModif').find(":selected").val(),
                        "price": $('#price').val(),
                        "name": $('#element').val(),
                        "type": $('#type').val(),
                    },
                    dataType: "json",
                }).done(function(data) {
                    fillTableModif();
                    $('#element').val("");
                    $('#price').val("");
                });
            } else {
                alert("Inserta todos los datos");
            }
        });

        $('#editar_modificacion').click(function() {
            if (($('#element').val())) {

                $.post("{{ route('modification.update') }}", {
                        price: ($('#price').val() ? $('#price').val() : 0),
                        name: $('#element').val(),
                        modification_type_id: $('#current_element_modif').val(),
                    },
                    function(data, status) {
                        $('#editar_modificacion').hide();
                        $('#crear_modificacion').show();

                        fillTableModif();
                        $('#element').val("");
                        $('#price').val("");
                        $('#current_element_modif').val("");

                        $("#min_num").prop("disabled", false);
                        $("#dishModif").prop("disabled", false);
                        $("#modification").prop("disabled", false);
                    });

            } else {
                alert("Inserta todos los datos");
            }
        });

        function fillTableModif() {
            $.ajax({
                url: "{{ route('admin.modification.table', $dish) }}",
                method: 'GET',
                data: {
                    type: $('#type').val()
                }
            }).done(function(data) {
                $('#table_section').html(data);

                $('.btn-delete').click(function() {
                    deleteElement($(this).attr("data-element-id"))
                });

                $('.btn-modif').click(function() {
                    $('#editar_modificacion').show();
                    $('#crear_modificacion').hide();

                    getElement($(this).attr("data-element-id"))

                    $("#min_num").prop("disabled", true);
                    $("#dishModif").prop("disabled", true);
                    $("#modification").prop("disabled", true);
                });
            });

        }

        fillTableModif();

        function deleteElement(element) {
            $.post("{{ route('modification.delete') }}", {
                    modification_type_id: element
                },
                function(data, status) {
                    fillTableModif();
                });
        }

        function getElement(element) {
            $.get("{{ route('modification.index') }}", {
                    modification_type_id: element
                },
                function(data) {
                    $('#element').val(data.name);
                    $('#price').val(data.price);
                    $('#current_element_modif').val(data.id);
                });
        }
    </script>
@stop
