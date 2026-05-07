<?php

namespace App\Http\Controllers;

use App\Models\DishType;
use Illuminate\Http\Request;

class DishTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dishTypes = DishType::orderBy('short')->paginate(20);
        return view("admin.dishTypes.index", compact('dishTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.dishTypes.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $type = DishType::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'hidden' => $request->hidden,
            'manageStock' => $request->manageStock,
            'waiter_only' => $request->waiter_only,
            'room_only' => $request->room_only,

            'monday' => ($request->monday ? $request->monday : 0),
            'mondayTurn' => $request->mondayTurn,

            'tuesday' => ($request->tuesday ? $request->tuesday : 0),
            'tuesdayTurn' => $request->tuesdayTurn,

            'wednesday' => ($request->wednesday ? $request->wednesday : 0),
            'wednesdayTurn' => $request->wednesdayTurn,

            'thursday' => ($request->thursday ? $request->thursday : 0),
            'thursdayTurn' => $request->thursdayTurn,

            'friday' => ($request->friday ? $request->friday : 0),
            'fridayTurn' => $request->fridayTurn,

            'saturday' => ($request->saturday ? $request->saturday : 0),
            'saturdayTurn' => $request->saturdayTurn,

            'sunday' => ($request->sunday ? $request->sunday : 0),
            'sundayTurn' => $request->sundayTurn,
        ]);

        //Asignamos su orden
        $type->short = $type->id;
        $type->save();

        return redirect()->route('admin.dishType.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DishType  $dishTypes
     * @return \Illuminate\Http\Response
     */
    public function show(DishType $dishTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DishType $dishTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(DishType $dishType)
    {
        return view('admin.dishTypes.edit', compact('dishType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DishType  $dishTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DishType $dishType)
    {
        //dd($request->all());
        $dishType->name = request("name");
        $dishType->slug = request("slug");
        $dishType->hidden = request("hidden");
        $dishType->manageStock = request("manageStock");
        $dishType->waiter_only = request("waiter_only");
        $dishType->room_only = request("room_only");

        $dishType->monday = ($request->monday ? $request->monday : 0);
        $dishType->mondayTurn = $request->mondayTurn;

        $dishType->tuesday = ($request->tuesday ? $request->tuesday : 0);
        $dishType->tuesdayTurn = $request->tuesdayTurn;

        $dishType->wednesday = ($request->wednesday ? $request->wednesday : 0);
        $dishType->wednesdayTurn = $request->wednesdayTurn;

        $dishType->thursday = ($request->thursday ? $request->thursday : 0);
        $dishType->thursdayTurn = $request->thursdayTurn;

        $dishType->friday = ($request->friday ? $request->friday : 0);
        $dishType->fridayTurn = $request->fridayTurn;

        $dishType->saturday = ($request->saturday ? $request->saturday : 0);
        $dishType->saturdayTurn = $request->saturdayTurn;

        $dishType->sunday = ($request->sunday ? $request->sunday : 0);
        $dishType->sundayTurn = $request->sundayTurn;

        $dishType->save();

        return redirect()->route('admin.dishType.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DishType  $dishTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(DishType $dishType)
    {
        $dishType->delete();

        return redirect()->route('admin.dishType.list');
    }

    public function upPosition(Request $request, DishType $dishType)
    {
        //Recuperamos el elemento que tiene por encima
        $tipoA = DishType::where('short', "<", $dishType->short)
            ->orderBy('short', 'desc')
            ->first();

        if ($tipoA) {
            $posocionAux = $tipoA->short;
            $tipoA->short = $dishType->short;
            $dishType->short = $posocionAux;
            $dishType->save();
            $tipoA->save();
        }

        return redirect()->route('admin.dishType.list');
    }

    public function downPosition(Request $request, DishType $dishType)
    {
        //Recuperamos el elemento que tiene por encima
        $tipoA = DishType::where('short', ">", $dishType->short)
            ->orderBy('short', 'asc')
            ->first();

        if ($tipoA) {
            $posocionAux = $tipoA->short;
            $tipoA->short = $dishType->short;
            $dishType->short = $posocionAux;
            $dishType->save();
            $tipoA->save();
        }

        return redirect()->route('admin.dishType.list');
    }
}
