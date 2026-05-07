<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use App\Models\Config;
use App\Models\Location;
use App\Models\OrderLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    public function readToQr(Request $request)
    {
        return view("front.readqr");
    }

    public function index(Request $request)
    {
        $tables = Table::all();

        return view("admin.table.index", compact('tables'));
    }

    public function create()
    {
        $locations = Location::all();

        return view("admin.table.create", compact('locations'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'eaters' => 'required',
        ]);

        Table::create([
            'name' => $request->name,
            'location' => $request->location,
            'orderWithoutWaiter' => $request->orderWithoutWaiter,
            'eaters' => $request->eaters,
            'token' => md5($request->name . floor(microtime(true) * 1000)),
        ]);

        return redirect()->route('admin.table.list');
    }

    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('admin.table.list');
    }

    public function edit(Table $table)
    {
        $locations = Location::all();

        return view('admin.table.edit', compact('table', 'locations'));
    }

    public function update(Request $request, Table $table)
    {
        $table->name = $request->name;
        $table->location = $request->location;
        $table->orderWithoutWaiter = ($request->orderWithoutWaiter ? $request->orderWithoutWaiter : 0);
        $table->eaters = $request->eaters;
        $table->save();

        return redirect()->route('admin.table.list');
    }

    public function tableLogin(Request $request, $token)
    {
        //Recuperamos la mesa por el token
        $table = Table::where('token', $token)->first();

        if ($table) {
            $session = $request->session()->get('login');
            $session['cliente'] = $table;
            $session['mesa'] = true;
            $request->session()->put('login', $session);

            $request->session()->forget('guest');

            //Borramos el posible contenido de la cesta
            $request->session()->forget('cesta');
        }


        //if (Auth::user()) {
        //return redirect()->route('front.recoger');
        //}


        return redirect()->route('tableMenu');
    }

    public function tableMenu(Request $request)
    {

        if (!isset($request->session()->get('login')['mesa']) or !$request->session()->get('login')['mesa']) {
            return redirect()->route('readToQr');
        }

        $table = Table::find($request->session()->get('login')['cliente']->id);

        //Borramos el posible contenido de la cesta
        $request->session()->forget('cesta');

        return view("front.menu", compact('table'));
    }

    public function notifyWaiter(Request $request)
    {
        $table = Table::find($request->input('table'));

        if (!$table) {
            return;
        }

        $table->notify_waiter = true;
        $table->save();
    }

    public function notifyAccount(Request $request)
    {
        $table = Table::find($request->input('table'));

        $table->request_account = true;
        $table->division_account = $request->divisionPago;
        $table->payment_method = $request->formaPago;
        $this->setPaymentMethodTableOrders($request->formaPago);

        //Si la cuenta la selecciona el camarero
        if (Auth::user()) {
            $this->unnotifyAccount($request);
            $table->request_account = false;
        }

        $this->markAllLinesTableAsPaid($request->input('table'));

        $table->save();
    }

    function markAllLinesTableAsPaid($table)
    {
        $today = date('Y-m-d');

        //Recuperamos los pedidos pendinetes de la mesa
        $orders_aux = Order::select('id')
            ->where('table', $table)
            ->whereRaw("date  between '$today 00:00:00' and '$today 23:59:59'")
            ->get();
        $orders = [];

        foreach ($orders_aux as $order) {
            $orders[] = $order->id;
        }

        $lineas = OrderLine::whereIn('order_id', $orders)
            //->where('units_pending', '>', 0)
            ->get();

        foreach ($lineas as $linea) {
            $linea->units_paid = 0;
            $linea->units_pending = 0;
            $linea->save();
        }
    }

    function setPaymentMethodTableOrders($payment_method)
    {
        $orders = $this->getTableOrders();

        foreach ($orders as $order) {
            $order->payment_method = $payment_method;
            $order->save();
        }
    }

    public function aceptNotifyAccount(Request $request)
    {
        //Generamos el ticket de la cuenta

        $table = Table::find($request->input('table'));
        $table->cleanTable();

        //Cambiar la forma de pago de todos los pedidos activos de la mesa
        $today = date('Y-m-d');
        $orders_aux = Order::select('id')
            ->where('table', $request->input('table'))
            ->whereRaw("date  between '$today 00:00:00' and '$today 23:59:59'")
            ->where('paid', 0)
            ->where('status', "!=", 6)
            ->get();

        $orders = [];
        foreach ($orders_aux as $order) {
            //$order->paid = true;
            $order->payment_method = $request->formaPago;
            $order->save();
            $orders[] = $order->id;
        }

        //$orderController = new OrderController();
        //$orderController->generateJsonOrderTableAccount($orders, "restaurante");
    }

    public function unnotifyWaiter(Request $request)
    {
        $table = Table::find($request->input('table'));

        if (!$table) {
            return;
        }

        $table->notify_waiter = false;
        $table->save();
    }

    public function unnotifyAccount(Request $request)
    {
        //Generamos el ticket de la cuenta

        $table = Table::find($request->input('table'));

        //Cambiar la forma de pago de todos los pedidos activos de la mesa
        $today = date('Y-m-d');
        $orders_aux = Order::select('id')
            ->where('table', $request->input('table'))
            ->whereRaw("date  between '$today 00:00:00' and '$today 23:59:59'")
            ->where('paid', 0)
            ->where('status', "!=", 6)
            ->get();

        $orders = [];
        //Sacamos todos los pedidos de la mesa en un array
        foreach ($orders_aux as $order) {
            $orders[] = $order->id;
        }

        $orderController = new OrderController();
        $orderController->generateJsonOrderTableAccount($orders, $table);

        $hora_de_pago = date("Y-m-d H:i:s");
        //Marcamos como pagados todos los pedidos de la pesa y cambiamos el estado
        foreach ($orders_aux as $order) {
            $order->paid = true;
            $order->status = 4;
            $order->pay_time = $hora_de_pago;
            $order->save();
        }

        $table->cleanTable();
    }

    public function aceptOrder(Request $request, Order $order)
    {
        $order = Order::find(($request->order ? $request->order : $order->id));

        if ($order) {
            $order->status = 2;
            $order->save();

            //Generamos el ticket
            $orderController = new OrderController();
            $orderController->generateJsonOrderTable($order->id, "restaurante");
            $orderController->generateJsonOrderTable($order->id, "sala");
        }
    }

    public function cancelOrder(Request $request, Order $order)
    {
        $order = Order::find($request->order);

        if ($order) {
            $order->status = 6;
            $order->save();
        }
    }

    public function unservedLine(Request $request)
    {
        $line = OrderLine::find($request->line);

        if ($line) {
            if ($line->units_served_table > 0) {
                $line->units_served_table--;
                $line->save();
            }
        }
    }

    public function servedLine(Request $request)
    {
        $line = OrderLine::find($request->line);

        if ($line) {
            if ($line->units_served_table < $line->units) {
                $line->units_served_table++;
                $line->save();
            }
        }
    }

    public function resumenMesa(Request $request)
    {
        $today = date('Y-m-d');

        //Recuperamos los pedidos pendinetes de la mesa
        $orders_aux = Order::select('id')
            ->where('table', session()->get('login')['cliente']->id)
            ->whereRaw("date  between '$today 00:00:00' and '$today 23:59:59'")
            ->where('paid', 0)
            ->where('status', "!=", 6)
            ->get();
        $orders = [];

        foreach ($orders_aux as $order) {
            $orders[] = $order->id;
        }

        //$lineas = [];
        //$lineas = OrderLine::whereIn('order_id', $orders)->get();

        return view("front.resumenMesa", compact('orders'));
    }

    public function ultimoTicketMesa(Request $request)
    {
        $today = date('Y-m-d');

        //Recuperamos el útlmo bloque de pedidos
        $ultima_fecha_de_ticket_mesa = Order::orderBy('pay_time', 'desc')->first();

        if (!$ultima_fecha_de_ticket_mesa) {
            return [];
        }

        //Recuperamos los pedidos pendinetes de la mesa
        $orders_aux = Order::select('id')
            ->where('table', session()->get('login')['cliente']->id)
            ->whereRaw("date  between '$today 00:00:00' and '$today 23:59:59'")
            //->where('paid', 0)
            ->where('pay_time', $ultima_fecha_de_ticket_mesa->pay_time)
            ->get();
        $orders = [];

        foreach ($orders_aux as $order) {
            $orders[] = $order->id;
        }

        //$lineas = [];
        //$lineas = OrderLine::whereIn('order_id', $orders)->get();

        return view("front.ultimoTicketMesa", compact('orders'));
    }

    public function marcamosPagadasLineasUltimoTicket(Request $request)
    {
        $today = date('Y-m-d');

        //Recuperamos el útlmo bloque de pedidos
        $ultima_fecha_de_ticket_mesa = Order::orderBy('pay_time', 'desc')->first();

        if (!$ultima_fecha_de_ticket_mesa) {
            return [];
        }

        //Recuperamos los pedidos pendinetes de la mesa
        $orders_aux = Order::select('id')
            ->where('table', session()->get('login')['cliente']->id)
            ->whereRaw("date  between '$today 00:00:00' and '$today 23:59:59'")
            ->where('pay_time', $ultima_fecha_de_ticket_mesa->pay_time)
            ->get();
        $orders = [];

        foreach ($orders_aux as $order) {
            $orders[] = $order->id;
        }

        $lineas = OrderLine::whereIn('order_id', $orders)
            ->where('units_pending', '>', 0)
            ->get();

        foreach ($lineas as $linea) {
            $linea->units_paid += $linea->units_pending;
            $linea->units_pending = 0;
            $linea->save();
        }
    }

    public function cuentaMesa(Request $request)
    {
        //Recuperamos los pedidos pendinetes de la mesa
        $orders_aux = $this->getTableOrders();
        $orders = [];

        foreach ($orders_aux as $order) {
            $orders[] = $order->id;
        }

        return view("front.cuentaMesa", compact('orders'));
    }

    public function getTableOrders()
    {
        $today = date('Y-m-d');

        return Order::select('id')
            ->where('table', session()->get('login')['cliente']->id)
            ->whereRaw("date  between '$today 00:00:00' and '$today 23:59:59'")
            ->where('paid', 0)
            ->where('status', "!=", 6)
            ->get();
    }
}
