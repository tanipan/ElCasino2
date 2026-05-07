<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'taskes';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function type()
    {
        return TaskType::where('id', $this->task_type_id)->first();
    }

    public function done()
    {
        $today = date('Y-m-d');

        return TaskDone::where('task_id', $this->id)
            ->whereRaw("date between '$today 00:00:00' and '$today 23:59:59'")
            ->count();
    }
}
