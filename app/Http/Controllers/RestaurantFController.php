<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\RestaurantF;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RestaurantFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = RestaurantF::paginate(20);

        if (Auth::user()->role != "admin") {
            die("No puedes acceder aqui");
        }

        return view("admin.restaurantF.index", compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function create()
    {
        return view("admin.restaurantF.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->file('logo')) {
            $ruta = $request->file('logo')->store('public/logos');
            $ruta = str_replace('public', 'storage', $ruta);
        }

        RestaurantF::create([
            'name' => $request->name,
            'logo' => ($ruta ? $ruta : ''),
            'dish1' => $request->dish1,
            'dish2' => $request->dish2,
            'dish3' => $request->dish3,
        ]);

        return redirect()->route('admin.restaurantF.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(RestaurantF $restaurant)
    {
        return view('admin.restaurantF.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RestaurantF $restaurant)
    {
        if ($request->file('logo')) {
            $ruta = $request->file('logo')->store('public/logos');
            $ruta = str_replace('public', 'storage', $ruta);
            $restaurant->logo = $ruta;
        }

        $restaurant->name = $request->name;
        $restaurant->dish1 = $request->dish1;
        $restaurant->dish2 = $request->dish2;
        $restaurant->dish3 = $request->dish3;

        $restaurant->save();

        return redirect()->route('admin.restaurantF.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.restaurantF.list');
    }

    public function login(Request $request)
    {
        return redirect()->route('admin.restaurant.list');
    }

    public function getBurger(Request $request)
    {
        $restaurant = RestaurantF::find($request->id);
        $user = $request->user;

        return view('admin.restaurantF.modal', compact('restaurant', 'user'));
    }
}
