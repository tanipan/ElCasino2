<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Dish;
use App\Models\DishType;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stock(Request $request)
    {
        //Recuperamos las categorias que gestionan stock
        $dish_types = DishType::where('manageStock', 1)->get();

        $stocks = [];
        foreach ($dish_types as $type) {
            //Recuperamos los platos de cada categoria
            $dishes = Dish::where('dish_type_id', $type->id)
                ->orderBy('short')
                ->get();

            $stocks[] = [
                "category" => $type,
                "dishes" => $dishes
            ];
        }

        return view("admin.dish.stock", compact('stocks'));
    }

    public function add(Request $request)
    {
        $dish = Dish::find($request->dish_id);
        $dish->stock = $dish->stock + $request->units;

        if ($dish->stock < 0) {
            $dish->stock = 0;
        }

        $dish->save();

        return $dish->stock;
    }

    public function check(Request $request)
    {
        //Recuperamos las categorias que gestionan   stock
        $dish_types = DishType::where('manageStock', 1)->get();

        $stocks = [];
        foreach ($dish_types as $type) {
            //Recuperamos los platos de cada categoria
            $dishes = Dish::where('dish_type_id', $type->id)->get();

            foreach ($dishes as $dish) {
                $stocks[] = [
                    "dish" => $dish->id,
                    "stock" => $dish->stock,
                ];
            }
        }

        return json_encode($stocks);
    }
}
