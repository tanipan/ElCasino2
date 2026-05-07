<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Config;
use App\Models\OrderLine;
use Illuminate\Http\Request;

class BurgerController extends Controller
{
    public function prepared(Request $request)
    {
        $line = OrderLine::find($request->order_line);
        if ($line) {
            $line->is_ready = 1;
            $line->save();
        }
    }

    public function unprepared(Request $request)
    {
        $line = OrderLine::find($request->order_line);
        if ($line) {
            $line->is_ready = 0;
            $line->save();
        }
    }

    public function toFire(Request $request)
    {
        $line = OrderLine::find($request->order_line);
        if ($line) {
            if ($line->units_in_progress >= $line->units) {
                $line->units_in_progress = 0;
                $line->is_ready = 0;
            } else {
                $line->units_in_progress++;
            }
            $line->save();
        }
    }

    public function orderHide(Request $request)
    {
        $order = Order::find($request->order_id);
        if ($order) {
            $order->hide_in_burger = date("Y-m-d H:i:s");;
            $order->save();
        }
    }

    public function index(Request $request)
    {

        //Obtenemos el total de burgers
        $maximo_burgers = Config::find(12)->value;
        $minutos_maregen = Config::find(14)->value;
        $sonido = false;

        //dd($queries);
        return view("admin.burger.index", compact('sonido', 'maximo_burgers', 'minutos_maregen'));
    }

    public function reload(Request $request)
    {
        //Pedidos en curso
        $requestStatus = 2;

        $status_aux = "";

        if ($requestStatus != null) {
            $status = $requestStatus;
        } else {
            $status = 1;
        }

        if ($status == 7) {
            $status_aux = 7;
            $status = 1;
        }

        $orders = Order::where('status', $status);

        if (in_array($status, [4, 5, 6])) {
            $orders->whereRaw('date(created_at) = curdate()');
        }

        if ($status_aux == 7) {
            $orders->where('paid', 0);
        } else {
            $orders->where('paid', 1);
        }

        $orders->orWhereRaw('(`table` and !`paid` and status = ' . $status . ' )');
        $orders = $orders->orderByRaw('TIME(IFNULL(time_ready, `date`))')->get();


        return view("admin.burger.reload", compact('orders'));
    }
}
