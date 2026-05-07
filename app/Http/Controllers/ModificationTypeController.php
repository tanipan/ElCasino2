<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModificationType;
use App\Http\Requests\ModificationTypeRequest;

class ModificationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexApi()
    {
        $modifications = ModificationType::all();

        return response()->json([
            "modifications_type" => $modifications
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeApi(ModificationTypeRequest $request)
    {
        $modif = ModificationType::create([
            'name' => $request->name,
            'type' => $request->type
        ]);

        if ($modif) {
            return response()->json([
                "modification_type" => ModificationType::where('type', $request->type)->get()
            ], 200);
        } else {
            return response()->json([
                "modification_type" => ModificationType::where('type', $request->type)->get()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\modification  $modification
     * @return \Illuminate\Http\Response
     */
    public function show(ModificationType $modification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\modification  $modification
     * @return \Illuminate\Http\Response
     */
    public function edit(ModificationType $modification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\modification  $modification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModificationType $modification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\modification  $modification
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModificationType $modification)
    {
        //
    }
}
