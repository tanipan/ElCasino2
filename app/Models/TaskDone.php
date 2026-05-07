<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskDone extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tasks_done';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
