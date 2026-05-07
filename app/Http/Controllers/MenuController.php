<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Config;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.menu.index");
    }

    public function upload(Request $request)
    {
        foreach ($request->file() as $name => $file) {
            $fileName = "carta" . "." . $file->extension();
            $file->storeAs('pdf', $fileName, 'public');
        }

        return redirect()->back()->with('success', 'Carta subida correctamente.');
    }
}
