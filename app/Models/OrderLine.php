<?php

namespace App\Models;

use App\Models\Dish;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderLine extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    function getElements($only_burger = false, $only_starter = false)
    {
        $id_menus = Config::find(31)->value;

        if ($this->dish_id == $id_menus) {

            $orderLineElement =  OrderLineElement::where('order_line_id', $this->id)->get();
            $orderLineElement_aux = [];

            //Si es solo burger, hay que sacar del elemento, cual es su modification_id lugo si modification_type_id
            //y ver si su modification_type_id es del tipo "elige tu burger"
            foreach ($orderLineElement as $ele) {

                if ($only_burger) {
                    $element = Element::find($ele->element_id);
                    $modif = Modification::find($element->modification_id);
                    $modif = ModificationType::find($modif->modification_type_id);

                    if (in_array($modif->id, [48, 32, 34, 37])) {
                        $orderLineElement_aux[] = $ele;
                    }
                } elseif ($only_starter) {
                    $element = Element::find($ele->element_id);
                    $modif = Modification::find($element->modification_id);
                    $modif = ModificationType::find($modif->modification_type_id);

                    if (in_array($modif->id, [47])) {
                        $orderLineElement_aux[] = $ele;
                    }
                }
            }

            return $orderLineElement_aux;
        } else {
            return OrderLineElement::where('order_line_id', $this->id)->get();
        }
    }
}
