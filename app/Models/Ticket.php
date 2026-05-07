<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     {
        "lineas":[
            {
                "plato":"Hamburguesa de pollo empanado",
                "unidades":1,
                "precio":4.5,
                "total":4.5,
                "opciones":"",
                "observaciones":""
            }      
        ],
        "total":35,
        "pedido":"0013-001-108293",
        "restaurante":"Gastrocervecer\u00eda La Abad\u00eda"
    }
     */
}
