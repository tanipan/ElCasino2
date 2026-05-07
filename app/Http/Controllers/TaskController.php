<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Order;
use App\Models\Table;
use App\Models\Config;
use App\Models\OrderLine;
use App\Models\TaskDone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    public function index(Request $request)
    {
        $groups = $this->prepareTask();

        return view("admin.task.index", compact('groups'));
    }

    public function prepareTask()
    {
        //Recuperamos todas las tareas
        $dia_de_semana = date('N');
        $hora = date('H:i:s');

        $tasks = Task::whereRaw('(day_of_the_week like "%' . $dia_de_semana . '%" or all_days = 1) and turn = ' . (int)($hora > '22:15:00'))->get();

        $tareas = [];
        foreach ($tasks as $task) {
            $tareas[$task->type()->type][] = $task;
        }

        return $tareas;
    }

    public function marcar(Request $request)
    {
        TaskDone::create([
            'date' => date("Y-m-d H:i:s"),
            'task_id' => $request->task
        ]);
    }

    public function desmarcar(Request $request)
    {
        $task = TaskDone::whereRaw('date(created_at) = curdate()')
            ->where('task_id', $request->task)->first();

        $task->delete();
        $task->save();
    }
}
