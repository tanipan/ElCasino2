<?php

namespace App\Models;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderBalance extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'orders_balance';

    public static function createBalance($order, $total, $payment_method, $type = 'single')
    {
        OrderBalance::create([
            'order' => $order,
            'total' => $total,
            'type' => $type,
            'payment_method' => $payment_method,
        ]);
    }
}
