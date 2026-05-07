<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Element;
use App\Models\Modification;
use Illuminate\Http\Request;
use App\Models\ModificationType;

class ModificationController extends Controller
{
    public function updateApi(Request $request)
    {

        $element = Element::where('id', $request->input('modification_type_id'))->first();

        $element->price = $request->input('price');
        $element->name = $request->input('name');
        $element->save();

        return response()->json("", 200);
    }

    public function indexApi(Request $request)
    {
        $modif = Element::where('id', $request->input('modification_type_id'))->first();

        return response()->json($modif, 200);
    }

    public function deleteApi(Request $request)
    {
        $modif = Element::where('id', $request->input('modification_type_id'))->first();
        $modificacion_padre = $modif->modification_id;

        if ($modif) {
            $modif->delete();
        }

        //Si la modificacion ya no tiene elementos, la eliminamos
        $modifs = Element::where('modification_id', $modificacion_padre)->get();

        if (count($modifs) == 0) {
            $padre = Modification::find($modificacion_padre);
            $padre->delete();
        }

        return response()->json(null, 200);
    }

    public function storeApi(Request $request)
    {
        $modif = Modification::where('modification_type_id', $request->input('modification_type_id'))
            ->where('dish_id', $request->input('dish_id'))
            ->first();

        //Comprobamos si la modificacion existe
        if ($modif == null) {
            $modif = Modification::create([
                'dish_id' => $request->dish_id,
                'orden' => 1,
                'hidden' => false,
                'min_num' => $request->min_num,
                'type' => $request->type,
                'modification_type_id' => $request->modification_type_id
            ]);
        }

        //Creamos el elemento nuevo
        $element = Element::create([
            'name' => $request->name,
            'orden' => 1,
            'hidden' => false,
            'price' => ($request->price ? $request->price : 0),
            'modification_id' => $modif->id,
        ]);


        if ($element) {
            return response()->json([
                "element" => $element
            ], 200);
        } else {
            return response()->json([
                "element" => $element
            ], 500);
        }
    }

    public function generateModificationTable(Request $request, Dish $dish)
    {
        //Recuperamos las modificaciones del plato        
        $modif = Modification::where('dish_id', $dish->id)
            ->where('type', "=", $request->type)
            ->get();

        $modifications = [];

        foreach ($modif as $m) {
            //Recuperamos los elementos de las modificaciones
            $elements = Element::where('modification_id', $m->id)->get();
            $modifications[] = [
                "modification" => $m,
                "elements" => $elements
            ];
        }

        //dd($request->all());

        return view("admin.dish.tableModif", compact('modifications'));
    }
}
