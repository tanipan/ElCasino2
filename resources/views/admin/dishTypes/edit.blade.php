@extends('adminlte::page')

@section('title', 'Modificar nuevo tipo de plato')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Modificar nuevo tipo de plato</h1>
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
                    <h3 class="card-title">Datos del tipo de plato</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('admin.dishType.update', $dishType) }}">

                    @method('PUT')

                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tipo de plato</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name', $dishType->name) }}" name="name" placeholder="Inserta el nombre">
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                value="{{ old('slug', $dishType->slug) }}" name="slug" placeholder="Inserta el slug">
                            @error('slug')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class=" form-group">
                            <label for="exampleInputFile">Oculto</label>
                            <div class="form-group">

                                <select class="form-control @error('hidden') is-invalid @enderror" id="hidden"
                                    name="hidden">
                                    <option {{ old('hidden', $dishType->hidden) == '0' ? 'selected' : '' }} value="0">
                                        No
                                    </option>
                                    <option {{ old('hidden', $dishType->hidden) == '1' ? 'selected' : '' }} value="1">
                                        Si
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="exampleInputFile">Gestiona stock</label>
                            <div class="form-group">

                                <select class="form-control @error('manageStock') is-invalid @enderror" id="manageStock"
                                    name="manageStock">
                                    <option {{ old('manageStock', $dishType->manageStock) == '0' ? 'selected' : '' }}
                                        value="0">No
                                    </option>
                                    <option {{ old('manageStock', $dishType->manageStock) == '1' ? 'selected' : '' }}
                                        value="1">Si
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="exampleInputFile">Solo camarero</label>
                            <div class="form-group">

                                <select class="form-control" id="waiter_only" name="waiter_only">
                                    <option {{ old('waiter_only', $dishType->waiter_only) == '0' ? 'selected' : '' }}
                                        value="0">No
                                    </option>
                                    <option {{ old('waiter_only', $dishType->waiter_only) == '1' ? 'selected' : '' }}
                                        value="1">Si
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class=" form-group">
                            <label for="exampleInputFile">Solo en local</label>
                            <div class="form-group">

                                <select class="form-control" id="room_only" name="room_only">
                                    <option {{ old('room_only', $dishType->room_only) == '0' ? 'selected' : '' }}
                                        value="0">No
                                    </option>
                                    <option {{ old('room_only', $dishType->room_only) == '1' ? 'selected' : '' }}
                                        value="1">Si
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Gestión semanal</h3>
                            </div>
                            <div class="card-body">

                                <!--Mondaty-->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Lunes</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheckMonday"
                                                    name="monday" value="1"
                                                    {{ old('monday', $dishType->monday) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="exampleCheckMonday">Activo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Turno del lunes</label>
                                            <select class="form-control" name="mondayTurn">
                                                <option
                                                    {{ old('mondayTurn', $dishType->mondayTurn) == 'allDay' ? 'selected' : '' }}
                                                    value="allDay">Todo el dia</option>
                                                <option
                                                    {{ old('mondayTurn', $dishType->mondayTurn) == 'atMeals' ? 'selected' : '' }}
                                                    value="atMeals">Solo comidas</option>
                                                <option
                                                    {{ old('mondayTurn', $dishType->mondayTurn) == 'atDinners' ? 'selected' : '' }}
                                                    value="atDinners">Solo cenas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--Tuesday-->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Martes</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheckTuesday"
                                                    name="tuesday" value="1"
                                                    {{ old('tuesday', $dishType->tuesday) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="exampleCheckTuesday">Activo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Turno del martes</label>
                                            <select class="form-control" name="tuesdayTurn">
                                                <option
                                                    {{ old('tuesdayTurn', $dishType->tuesdayTurn) == 'allDay' ? 'selected' : '' }}
                                                    value="allDay">Todo el dia</option>
                                                <option
                                                    {{ old('tuesdayTurn', $dishType->tuesdayTurn) == 'atMeals' ? 'selected' : '' }}
                                                    value="atMeals">Solo comidas</option>
                                                <option
                                                    {{ old('tuesdayTurn', $dishType->tuesdayTurn) == 'atDinners' ? 'selected' : '' }}
                                                    value="atDinners">Solo cenas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--Wednesday-->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Miércoles</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="exampleCheckWednesday" name="wednesday" value="1"
                                                    {{ old('wednesday', $dishType->wednesday) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="exampleCheckWednesday">Activo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Turno del miércoles</label>
                                            <select class="form-control" name="wednesdayTurn">
                                                <option
                                                    {{ old('wednesdayTurn', $dishType->wednesdayTurn) == 'allDay' ? 'selected' : '' }}
                                                    value="allDay">Todo el dia</option>
                                                <option
                                                    {{ old('wednesdayTurn', $dishType->wednesdayTurn) == 'atMeals' ? 'selected' : '' }}
                                                    value="atMeals">Solo comidas</option>
                                                <option
                                                    {{ old('wednesdayTurn', $dishType->wednesdayTurn) == 'atDinners' ? 'selected' : '' }}
                                                    value="atDinners">Solo cenas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--thursday-->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Jueves</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheckThursday"
                                                    name="thursday" value="1"
                                                    {{ old('thursday', $dishType->thursday) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="exampleCheckThursday">Activo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Turno del jueves</label>
                                            <select class="form-control" name="thursdayTurn">
                                                <option
                                                    {{ old('thursdayTurn', $dishType->thursdayTurn) == 'allDay' ? 'selected' : '' }}
                                                    value="allDay">Todo el dia</option>
                                                <option
                                                    {{ old('thursdayTurn', $dishType->thursdayTurn) == 'atMeals' ? 'selected' : '' }}
                                                    value="atMeals">Solo comidas</option>
                                                <option
                                                    {{ old('thursdayTurn', $dishType->thursdayTurn) == 'atDinners' ? 'selected' : '' }}
                                                    value="atDinners">Solo cenas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--friday-->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Viernes</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheckFriday"
                                                    name="friday" value="1"
                                                    {{ old('friday', $dishType->friday) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="exampleCheckFriday">Activo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Turno del viernes</label>
                                            <select class="form-control" name="fridayTurn">
                                                <option
                                                    {{ old('fridayTurn', $dishType->fridayTurn) == 'allDay' ? 'selected' : '' }}
                                                    value="allDay">Todo el dia</option>
                                                <option
                                                    {{ old('fridayTurn', $dishType->fridayTurn) == 'atMeals' ? 'selected' : '' }}
                                                    value="atMeals">Solo comidas</option>
                                                <option
                                                    {{ old('fridayTurn', $dishType->fridayTurn) == 'atDinners' ? 'selected' : '' }}
                                                    value="atDinners">Solo cenas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--saturday-->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Sábado</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheckSaturday"
                                                    name="saturday" value="1"
                                                    {{ old('saturday', $dishType->saturday) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="exampleCheckSaturday">Activo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Turno del sábado</label>
                                            <select class="form-control" name="saturdayTurn">
                                                <option
                                                    {{ old('saturdayTurn', $dishType->saturdayTurn) == 'allDay' ? 'selected' : '' }}
                                                    value="allDay">Todo el dia</option>
                                                <option
                                                    {{ old('saturdayTurn', $dishType->saturdayTurn) == 'atMeals' ? 'selected' : '' }}
                                                    value="atMeals">Solo comidas</option>
                                                <option
                                                    {{ old('saturdayTurn', $dishType->saturdayTurn) == 'atDinners' ? 'selected' : '' }}
                                                    value="atDinners">Solo cenas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!--sunday-->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Domingo</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheckSunday"
                                                    name="sunday" value="1"
                                                    {{ old('sunday', $dishType->sunday) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="exampleCheckSunday">Activo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Turno del domingo</label>
                                            <select class="form-control" name="sundayTurn">
                                                <option
                                                    {{ old('sundayTurn', $dishType->sundayTurn) == 'allDay' ? 'selected' : '' }}
                                                    value="allDay">Todo el dia</option>
                                                <option
                                                    {{ old('sundayTurn', $dishType->sundayTurn) == 'atMeals' ? 'selected' : '' }}
                                                    value="atMeals">Solo comidas</option>
                                                <option
                                                    {{ old('sundayTurn', $dishType->sundayTurn) == 'atDinners' ? 'selected' : '' }}
                                                    value="atDinners">Solo cenas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Modificar tipo de plato</button>
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
        function string_to_slug(str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

            return str;
        }

        $("#name").keyup(function() {
            $("#slug").val(string_to_slug($("#name").val()));
        });

        $("#slug").keyup(function() {
            $("#slug").val(string_to_slug($("#slug").val()));
        });
    </script>
@stop
