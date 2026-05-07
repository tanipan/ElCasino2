@extends('adminlte::page')

@section('title', 'Listado de usuarios')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tareas pendientes</h1>
        </div>
        <div class="col-sm-6">

        </div>
    </div>
@stop

@section('content')

    <style>
        .rojo {
            background-color: #ffc4c4
        }

        .verde {
            background-color: #c8ffc8
        }

        .oculto {
            display: none;
        }
    </style>

    <div class="row">
        <div class="col-md-10">

            @foreach ($groups as $group => $tasks)
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Tareas de {{ $group }}</h3>
                        <div class="card-tools">

                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <tbody>
                                @foreach ($tasks as $task)
                                    @if ($task->done())
                                        <tr class="verde" id="tr-{{ $task->id }}">
                                        @else
                                        <tr class="rojo" id="tr-{{ $task->id }}">
                                    @endif
                                    <td>{{ $task->task }}</td>
                                    <td class="text-right py-0 align-middle">
                                        <div class="btn-group btn-group-sm">

                                            <a class="desmarcar {!! $task->done() ? '' : 'oculto' !!}"
                                                id="a-desmarcar-{{ $task->id }}" data-task-id="{{ $task->id }}"
                                                style="cursor: pointer;font-size: 25px !important" class="btn ">⛔️</a>

                                            <a class="marcar {!! $task->done() ? 'oculto' : '' !!}" id="a-marcar-{{ $task->id }}"
                                                data-task-id="{{ $task->id }}"
                                                style="cursor: pointer;font-size: 25px !important" class="btn ">✅</a>



                                        </div>
                                    </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            @endforeach

        </div>
        <!-- /.col -->
    </div>

@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">-->
@stop

@section('js')
    <script>
        $('.marcar').click(function() {
            var id = $(this).attr("data-task-id");
            $.ajax({
                url: "{{ route('admin.task.marcar') }}",
                method: 'GET',
                data: {
                    task: id
                }
            }).done(function(data) {
                $('#tr-' + id).addClass('verde');
                $('#tr-' + id).removeClass('rojo');
                $('#a-desmarcar-' + id).removeClass('oculto');
                $('#a-marcar-' + id).addClass('oculto');
            })
        });

        $('.desmarcar').click(function() {
            var id = $(this).attr("data-task-id");
            $.ajax({
                url: "{{ route('admin.task.desmarcar') }}",
                method: 'GET',
                data: {
                    task: id
                }
            }).done(function(data) {
                $('#tr-' + id).addClass('rojo');
                $('#tr-' + id).removeClass('verde');
                $('#a-marcar-' + id).removeClass('oculto');
                $('#a-desmarcar-' + id).addClass('oculto');
            })
        });
    </script>
@stop
