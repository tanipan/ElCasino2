<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getHasStockAttribute()
    {
        //Comprobamos si su categoria gestiona stock
        $dish_type = DishType::find($this->dish_type_id);

        //Ponemos aqui el stock para que acente stocn en negativo
        return 1;

        if ($dish_type->manageStock == 1) {
            return ($this->stock > 0);
        } else {
            return 1;
        }
    }

    public function getType()
    {
        return DishType::find($this->dish_type_id);
    }
}
