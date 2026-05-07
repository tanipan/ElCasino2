<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Config;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function alergenos(Request $request)
    {
        return view("front.privacidad");
    }

    public function privacidad(Request $request)
    {
        return view("front.privacidad");
    }

    public function legal(Request $request)
    {
        return view("front.legal");
    }

    public function cookies(Request $request)
    {
        return view("front.cookies");
    }
}
