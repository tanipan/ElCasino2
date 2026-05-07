<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Config;
use App\Models\Customer;
use App\Models\DishType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Recuperamos las categorias que gestionan stock
        $configs = Config::all();

        if (Auth::user()->role != "admin") {
            die("No puedes acceder aqui");
        }

        return view("admin.config.index", compact('configs'));
    }

    public function update(Request $request)
    {
        foreach ($request->all() as $id => $value) {
            $config = Config::find($id);

            if ($config) {
                $config->value = $value;
                $config->save();
            }
        }

        return redirect()->route('admin.config.list');
    }
}
