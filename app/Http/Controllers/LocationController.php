<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Config;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $locations = Location::all();

        return view("admin.location.index", compact('locations'));
    }

    public function create()
    {
        return view("admin.location.create");
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required'
        ]);

        $type = Location::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.location.list');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('admin.location.list');
    }

    public function edit(Location $location)
    {
        return view('admin.location.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $location->name = $request->name;
        $location->save();

        return redirect()->route('admin.location.list');
    }
}
