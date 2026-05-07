<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantF extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'restaurants_f';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
