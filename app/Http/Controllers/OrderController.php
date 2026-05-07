<?php

namespace App\Http\Controllers;

use App\Mail\Test;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Config;
use App\Models\Ticket;
use App\Jobs\TicketJob;
use App\Models\Element;
use App\Models\Customer;
use App\Models\DishType;
use App\Models\OrderLine;
use App\Mail\PedidoCreado;
use App\Models\Restaurant;
use Illuminate\Support\Str;
use App\Mail\PedidoAceptado;
use Illuminate\Http\Request;
use App\Mail\PedidoCancelado;
use App\Models\OrderLineElement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Ssheduardo\Redsys\Facades\Redsys;
use App\Http\Controllers\DishController;
use App\Models\RedsysLog;
use App\Models\Table;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget('conservar_cesta');
        $request->session()->forget('modificar_pedido');
        $status_aux = "";

        if ($request->status != null) {
            $status = $request->status;
        } else {
            $status = 1;
        }

        if ($status == 7) {
            $status_aux = 7;
            $status = 1;
        }

        $orders = Order::where(function ($query) use ($status, $status_aux) {
            $query->where('status', $status);

            if (in_array($status, [4, 5, 6])) {
                $query->whereRaw('date(created_at) = curdate()');
            }

            if ($status_aux == 7) {
                $query->where('paid', 0);
            } else {
                $query->where('paid', 1);
            }
        });

        if (in_array($status, [4, 6])) {
            $orders->orWhere(function ($query) use ($status) {
                $query->whereRaw('(`table` and !`paid` and status = ' . $status . ' )')
                    ->whereRaw('date(created_at) = curdate()');
            });
        } else {
            $orders->orWhereRaw('(`table` and !`paid` and status = ' . $status . ' )');
        }

        $orders = $orders->orderBy('id')->get();

        $sonido = false;
        if ($orders->count()) {
            //Obtenemos el último pedido de la colección 
            $ultimo_coleccion = $orders->last()->id;
            $ultimo_actualizado = Config::find(6);

            if ($ultimo_coleccion > $ultimo_actualizado->value) {
                $sonido = true;

                $ultimo_actualizado->value = $ultimo_coleccion;
                $ultimo_actualizado->save();
            }
        }

        //Obtenemos el total de burgers
        $maximo_burgers = Config::find(12)->value;
        $minutos_maregen = Config::find(14)->value;

        return view("admin.order.index", compact('orders', 'sonido', 'maximo_burgers', 'minutos_maregen'));
    }

    public function deleteUnpaidOrders()
    {

        //Borrar pedidos no pagados
        if (Config::find(24)->value == 0) {
            return;
        }

        //Minutos de retraso de pedidos
        $min = Config::find(23)->value;

        //Recuperamos los pedidos no pagados de hoy
        $sql = "select *
        from orders o 
        where o.date between concat(curdate(),' 00:00:00') and concat(curdate(),' 23:59:59')
        and o.`payment_method` is null and o.`paid` = 0
        and o.status != 6
        and  TIMESTAMPDIFF(MINUTE,o.`date`,now())> $min";

        $orders = DB::select($sql);

        foreach ($orders as $order) {
            $request = new Request();
            $request->merge(['order_id' => $order->id]);

            $this->orderDelete($request);
        }

        //dd($orders);
    }

    public function pendingOrders(Request $request)
    {
        $order = new Order();

        $orders_pending = $order->getOrdersPending();
        $dishs = $order->getDishses();

        $maximo_burgers = Config::find(12)->value;

        return view("admin.order.pending", compact('maximo_burgers', 'orders_pending', 'dishs'));
    }

    public function orderModal(Request $request)
    {
        $order = Order::find($request->order_id);
        $static = $request->get('static');
        $room = $request->get('room');

        $lines = $this->recuperarPedidoDeBD($order);
        //dd($lines);
        $menuDelDia = $this->DishIsMenuDelDia($order->id);

        return view("admin.order.modalComanda", compact('order', 'lines', 'static', 'menuDelDia', 'room'));
    }

    public function modalTableTotal(Request $request)
    {
        $table = Table::find($request->table);
        $orders_aux = $table->getOrders($request->table);

        $static = $request->get('static');
        $room = $request->get('room');

        $orders = [];
        //Sacamos todos los pedidos de la mesa en un array
        foreach ($orders_aux as $order) {
            $orders[] = $order->id;
        }

        $lineas = $this->recuperarPedidoDeBDTable($orders);

        return view("admin.order.modalComandaTable", compact('table', 'lineas', 'static'));
    }

    public function orderTime(Request $request)
    {
        //Cambiamos la hora
        $order = Order::find($request->order_id);
        $order->time_ready = $request->time;
        $order->save();

        //Cambiamos la hora de los tickets
        return $this->recuperarTicketsYCambiarHora($order, $request->time);
    }

    public function registrarInvitado(Customer $guest)
    {
        $customer = Customer::where('email', $guest->email)->first();
        if ($customer) {
            //El cliente ya existe
            return null;
        }

        return $customer = Customer::create([
            'name' => $guest->name,
            'lastname' => $guest->lastname,
            'email' => $guest->email,
            'phone' => $guest->phone,
            'password' => Hash::make(Str::random(32)),
            'token' => Str::random(32),
            'birthday' => null,
            'observacions' => null,
            'newsletter' => ($guest->newsletter ? 1 : 0),
            'guest' => ($guest->guest ? 1 : 0),
        ]);
    }

    public function registrarPedido(Request $request)
    {
        $cliente = $request->session()->get('login');
        $guest = $request->session()->get('guest');
        $cesta = $request->session()->get('cesta');
        $descuento = $request->session()->get('descuento');
        $order_modif = $request->session()->get('modificar_pedido');

        $cesta = $this->ordenarLineasCesta($cesta);

        if (!$cliente and $guest) {
            $cliente['cliente'] = $this->registrarInvitado($guest['cliente']);
        }

        //Guardamos los datos de la cabecera
        $restaurante = Restaurant::first();
        $pedido_id = Order::orderBy("id", "desc")->first();
        $pedido_id = ($pedido_id ? $pedido_id->id : 0);

        if ($order_modif) {
            /*$order = Order::find($order_modif->id);
            $order->total = $this->calcularTotalCesta($cesta);
            $order->observacions = $request->observaciones;
            $order->time_ready = $request->time;
            $order->status = 1;
            $order->save();

            //Borramos todas la lineas del pedido            
            $this->deleteOrderLinesAndResetStock($order);*/
        } else {
            $order = Order::create([
                "order" => date("Y") . "-" . str_pad(++$pedido_id, 4, "0", STR_PAD_LEFT),
                "date" => date("Y-m-d H:i:s"),
                "total" => $this->calcularTotalCesta($cesta, $request),
                "observacions" => ((isset(session()->get('login')['mesa']) and session()->get('login')['mesa']) ? session()->get('login')['cliente']->name : $request->observaciones),
                "observations_kitchen" => $request->comentario_cocina,
                "order_comoaqui" => $request->num_comoaqui,
                "time_ready" => ($request->time ? ($request->time) : null),
                "margin_ready" => ($request->time ? (Config::find(14)->value) : null),
                "status" => 1,
                "table" => ((isset(session()->get('login')['mesa']) and session()->get('login')['mesa']) ? session()->get('login')['cliente']->id : null),
                "customer_id" => ((isset(session()->get('login')['mesa']) and session()->get('login')['mesa']) ? 708 : (isset($cliente['cliente']->id) ? $cliente['cliente']->id : $cliente->id)),
                "address_id" => 1,
                "restaurant_id" => $restaurante->id,
                "token" => Str::random(30),
                "discount" => ($descuento ? $descuento : 0),
            ]);

            //Incrementamos el ID de pedido en la tabla de configs
            $ultimo = Config::find(2);
            $ultimo->value = $order->id;
            $ultimo->save();
        }

        //Guardamos los datos de las lineas
        if ($order) {
            foreach ($cesta as $plato) {
                $line = OrderLine::create([
                    "order_id" => $order->id,
                    "units" => $plato['unidades'],
                    "observacions" => $plato['observaciones'],
                    "dish_id" => $plato['plato'],
                    //No pasamos aqui los elementos para precio del plato sea el precio base
                    "price" => DishController::recuperarPrecioPlatoInner($plato['plato'], null, $plato['unidades'], $request),
                ]);

                $this->restamosUnidadesPlato($plato['plato'], $plato['unidades']);
                $this->siEsBurgerDescuento($line);

                if ($line) {
                    //Guardamos los datos de los elementos de las lineas                    
                    foreach ($plato['elementos'] as $elemento) {
                        OrderLineElement::create([
                            "order_line_id" => $line->id,
                            "price" => Element::find($elemento)->price,
                            "element_id" => $elemento,
                        ]);
                    }
                }

                $this->controlDeStock($plato);
            }
        }

        //Limpiamos la cesta
        //$request->session()->forget('cesta');

        //Mostramos la vista del pedido realizado
        $cliente = $cliente['cliente'];

        return $order;

        //return view("front.proceso", compact('titulo', 'pedido', 'menu', 'cliente', 'cestaHumana', 'orderOk', 'status', 'order'));
    }

    public function controlDeStock($plato)
    {
        //Si su categoria tiene la gestión de stock activa
        $dish = Dish::find($plato['plato']);

        if ($dish->getType()->manageStock) {
            //Restamos el stock
            $dish->stock -= $plato['unidades'];
            $dish->save();
        }
    }

    public function AjutarHoraComoaqui($hora_recogida)
    {
        date_default_timezone_set('Europe/Madrid');
        $minutos_margen = Config::find(14)->value;
        $nueva_hora = date('H:i:s', strtotime("-$minutos_margen minutes", strtotime($hora_recogida)));
        return $nueva_hora;
    }

    public function siEsBurgerDescuento($linea)
    {
        $maximo_buergers = Config::find(12);
        $categoria_buergers = Config::find(13)->value;

        //if ($linea->dish->dish_type_id == $categoria_buergers) {
        if (in_array($linea->dish->dish_type_id, explode(",", $categoria_buergers))) {
            $maximo_buergers->value -= $linea->units;
            $maximo_buergers->save();
        }
    }

    public function siEsBurgerAumento($linea)
    {
        $maximo_buergers = Config::find(12);
        $categoria_buergers = Config::find(13)->value;

        if ($linea->dish->dish_type_id == $categoria_buergers) {
            $maximo_buergers->value += $linea->units;
            $maximo_buergers->save();
        }
    }

    public function siGestionaStockAumento($linea)
    {

        if ($linea->dish->getType()->manageStock) {
            $linea->dish->stock += $linea->units;
            $linea->dish->save();
        }
    }

    public function seguimientoPedido(Request $request, $token)
    {
        $order = Order::where('token', $token)->first();
        $cliente = Customer::find($order->customer_id);
        $cesta = $this->recuperarPedidoDeBD($order);

        //Mostramos la vista del pedido realizado
        $titulo = "SEGUIMIENTO DE PROCESO";
        $menu = "Seguimiento";
        $pedido = $order->order;
        $cestaHumana = DishController::procesarCestaHumano($cesta);

        $status = $order->status;

        return view("front.proceso", compact('titulo', 'pedido', 'menu', 'cliente', 'cestaHumana', 'status', 'order'));
    }

    public function calcularTotalCesta($cesta, $request)
    {
        $total = 0;
        foreach ($cesta as $plato) {
            $total += DishController::recuperarPrecioPlatoInner($plato['plato'], implode(",", $plato['elementos']), $plato['unidades'], $request);
        }

        return $total;
    }

    public function recuperarPedidoDeBD($order)
    {
        $orderArray = [];
        $elementos = [];
        $orderLines = OrderLine::where('order_id', $order->id)->get();

        foreach ($orderLines as $line) {
            $precio = 0;
            $elementos = null;
            $orderLineElements = OrderLineElement::where('order_line_id', $line->id)->get();
            foreach ($orderLineElements as $element) {
                $elementos[] = $element->element;
                $precio += ($element->element->price) * $line->units;
            }

            $dish = Dish::find($line->dish->id);

            $color = $this->getColorType($dish->getType()->id);

            $orderArray[] = [
                "plato" => $line->dish,
                "unidades" => $line->units,
                "precio" => $line->price + $precio,
                "precio_ca" => ($dish->price_ca ? $dish->price_ca + $precio : $dish->price_ca),
                "elementos" => $elementos,
                "observaciones" => $line->observacions,
                "color" => $color,
                "preparado" => ($line->is_ready),
            ];
        }

        return $orderArray;
    }

    public function getColorType($id)
    {
        switch ($id) {
            case 57:
                return "red";
                break;
            case 58:
                return "orange";
                break;
            case 60:
                return "green";
                break;
            case 61:
                return "blue";
                break;
        }
    }

    public function recuperarPedidoDeBDTable($orders)
    {
        $orderArray = [];
        $elementos = [];
        $orderLines = OrderLine::whereIn('order_id', $orders)->get();

        foreach ($orderLines as $line) {
            $precio = 0;
            $elementos = null;
            $orderLineElements = OrderLineElement::where('order_line_id', $line->id)->get();
            foreach ($orderLineElements as $element) {
                $elementos[] = $element->element;
                $precio += ($element->element->price) * $line->units;
            }

            $orderArray[] = [
                "linea" => $line->id,
                "plato" => $line->dish,
                "unidades" => $line->units,
                "precio" => $line->price + $precio,
                "unidadesServidas" => $line->units_served_table,
                "elementos" => $elementos,
                "observaciones" => $line->observacions,
            ];
        }

        return $orderArray;
    }

    public function recuperarTicketsYCambiarHora($order, $time)
    {
        $return = false;
        $tickets = Ticket::where('json', 'LIKE', '%' . $order->order . '%')
            ->where("impreso", null)
            ->get();

        foreach ($tickets as $ticket) {
            $ticket->impreso = null;
            $ticket->hora_impresion = date('Y-m-d ') . " " . $this->AjutarHoraComoaqui($time);
            $ticket->save();

            $return = true;
        }

        return $return;
    }

    public static function recuperarPedidoDeBDJob($order)
    {
        $orderArray = [];
        $elementos = [];
        $orderLines = OrderLine::where('order_id', $order->id)->get();

        foreach ($orderLines as $line) {
            $precio = 0;
            $elementos = null;
            $orderLineElements = OrderLineElement::where('order_line_id', $line->id)->get();
            foreach ($orderLineElements as $element) {
                $elementos[] = $element->element;
                $precio += ($element->element->price) * $line->units;
            }

            $orderArray[] = [
                "plato" => $line->dish,
                "unidades" => $line->units,
                "precio" => $line->price + $precio,
                "elementos" => $elementos,
                "observaciones" => $line->observacions,
            ];
        }

        return $orderArray;
    }

    public function restamosUnidadesPlato($dish, $unids)
    {
        $dish = Dish::find($dish);
        $dish->stock = $dish->stock - $unids;

        //Lo comentamos para que puedan meter stock negativo
        if ($dish->stock < 0) {
            $dish->stock = 0;
        }

        $dish->save();
    }

    public function orderAccept(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->status;
        $order->bags = $request->bags;
        $order->payment_method = $request->paymentMethod;
        //$order->time_ready = $request->time;

        //Aqui comprobamos si el pedido es del menu del dia y lo pasamos directo a "entregado"
        if ($this->DishIsMenuDelDia($order->id)) {
            $order->status = 4;
        }

        //Si se pasa a cocina, estado 2
        if ($order->status == 2) {
            $order->save();

            if (env('TICKET_JOBS')) {
                dispatch(new TicketJob($order->id, "(Copia para el restaurante)", $request->user));
            } else {
                $this->generateJsonOrder($order->id, "(Copia para el restaurante)", $request->user);
            }
        }

        //Si se entrega, estado 4
        if ($order->status == 4) {
            $order->save();

            if (env('TICKET_JOBS')) {
                dispatch(new TicketJob($order->id, "(Copia para el cliente)", $request->user));
            } else {
                $this->generateJsonOrder($order->id, "(Copia para el cliente)", $request->user);
            }
        }

        //TODO: mandar el mail
        if (isset($order->customer->email)) {
            if (stripos($order->customer->email, '@smashurban.com') === false) {
                if (strpos($order->customer->email, '@') !== false) {
                    if (env('MAIL_ORDER')) {
                        Mail::to($order->customer->email)->send(new PedidoAceptado($order->order, $order->time_ready));
                    }
                }
            }
        }

        return $order->save();
    }

    public function orderCancel(Request $request)
    {

        $order = Order::find($request->order_id);
        $order->status = $request->status;

        if ($request->reason == "kitchen") {
            $order->observations_canceled = "Cocina saturada";
        } else {
            $dish = Dish::find($request->reason);
            $order->observations_canceled = "El plato '" . $dish->name . "' está agotado";
        }

        //TODO: mandar el mail
        if (isset($order->customer->email)) {
            if (stripos($order->customer->email, '@smashurban.com') === false) {
                if (strpos($order->customer->email, '@') !== false) {
                    Mail::to($order->customer->email)->send(new PedidoCancelado($order->order, $order->observations_canceled));
                }
            }
        }

        return $order->save();
    }

    private function gestionDeStockDePlatosEstados(Order $order, $orientacion = "-")
    {
        $lines = OrderLine::where('order_id', $order->id)->get();

        foreach ($lines as $line) {
            $dish = Dish::find($line->dish_id);
            $dishType = DishType::find($dish->dish_type_id);

            if ($dishType->manageStock) {
                if ($orientacion == "-") {
                    $this->restamosUnidadesPlato($dish->id, ($line->units * (-1)));
                } else {
                    $this->restamosUnidadesPlato($dish->id, ($line->units));
                }
            }
        }
    }

    public function orderDelete(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = 6; //Cancelar

        $lineas = OrderLine::where('order_id', $order->id)->get();
        foreach ($lineas as $line) {
            $this->siEsBurgerAumento($line);
            $this->siGestionaStockAumento($line);
        }

        //Borramos sus tickets
        $this->deleteTicketsOrder($order);

        return $order->save();
    }

    public function deleteTicketsOrder(Order $order)
    {
        $tickets = Ticket::where('json', 'LIKE', '%' . $order->order . '%')->get();

        foreach ($tickets as $ticket) {
            $ticket->delete();
        }
    }

    public function orderChangeStatus(Request $request)
    {
        $order = Order::find($request->order_id);

        //Si estado actual es cancelado y el nuevo es reciente, restamos stocks si corresponde
        if (($order->status == "6") and ($request->status == "1")) {
            $this->gestionDeStockDePlatosEstados($order, "+");
        }

        if ($request->status != "") {
            $order->status = $request->status;
        }

        if ($request->payment_method) {
            $order->payment_method = $request->payment_method;
        }

        //Si se entrega, estado 4
        if ($order->status == 4) {
            $ticket_al_entregar = Config::find(8);   //$ticket_al_entregar
            if ($ticket_al_entregar->value) {
                $this->generateJsonOrder($order->id, "(Copia para el cliente)", $request->user);
            }
        }

        return $order->save();
    }

    public function orderChangesStatus(Request $request)
    {
        //$orders = Order::find($request->order_id);
        $orders = Order::find(explode(',', $request->order_ids));

        foreach ($orders as $order) {

            //Si estado actual es cancelado y el nuevo es reciente, restamos stocks si corresponde
            /*if (($order->status == "6") and ($request->status == "1")) {
                $this->gestionDeStockDePlatosEstados($order, "+");
            }*/

            if ($request->status != "") {
                $order->status = $request->status;
            }

            /*if ($request->payment_method) {
                $order->payment_method = $request->payment_method;
            }*/

            //Si se entrega, estado 4
            /*if ($order->status == 4) {
                $ticket_al_entregar = Config::find(8);   //$ticket_al_entregar
                if ($ticket_al_entregar->value) {
                    $this->generateJsonOrder($order->id, "(Copia para el cliente)", $request->user);
                }
            }*/
            $order->save();
        }

        //return $order->save();
    }

    public function orderChangeStatusPay(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($order == null) {
            return 0;
        }

        if ($request->status != "") {
            $order->status = $request->status;
        }

        if ($request->payment_method) {
            $order->payment_method = $request->payment_method;
            $order->paid = 1;
        }

        if ($order->status == 2) {
            //Dos copias para el cliente
            $this->generateJsonOrder($order->id, "(Copia para el cliente)", $request->user);
            $this->generateJsonOrder($order->id, "(Copia para el cliente)", $request->user);
            //Copia para la cocina
            $this->generateJsonOrder($order->id, "(Copia para el restaurante)", $request->user);
        }

        return $order->save();
    }

    public function DishIsMenuDelDia($order)
    {
        $menu = 0;

        $menu_del_dia = Config::find(3);   //Configuración del menu del dia
        $menu_del_dia = explode(",", $menu_del_dia->value);

        $lines = OrderLine::where('order_id', $order)->get();
        foreach ($lines as $line) {
            $dish = Dish::find($line->dish_id);

            if (in_array($dish->dish_type_id, $menu_del_dia)) {
                $menu = 1;
            } else {
                $menu = 0;
                return $menu;
            }
        }

        return $menu;
    }

    public function testMail(Request $request)
    {
        $pedido = $request->order;

        $order = Order::find($pedido);
        $cesta = $this->recuperarPedidoDeBD($order);
        $customer = Customer::find($order->customer_id);

        //Mostramos la vista del pedido realizado
        $pedido = $order->order;
        $cesta = DishController::procesarCestaHumano($cesta, $mail = 1);
        $hora_recogida = "";
        //Mail::to("tanipan@gmail.com")->send(new PedidoCreado($cestaHumana, $customer, $order));
        return view('mail.pedidoRealizado', compact('cesta', 'order', 'customer', 'hora_recogida'));
        //Mail::to("salvandreo@gmail.com")->send(new Test());
        //Mail::to("adrianandreosoria@gmail.com")->send(new Test());
    }

    public function testTpv(Request $request)
    {
        try {
            $key = config('redsys.key');
            $code = config('redsys.merchantcode');

            Redsys::setAmount(rand(10, 600));
            Redsys::setOrder(time());
            Redsys::setMerchantcode($code); //Reemplazar por el código que proporciona el banco
            Redsys::setCurrency('978');
            Redsys::setTransactiontype('0');
            Redsys::setTerminal('1');
            Redsys::setMethod('T'); //Solo pago con tarjeta, no mostramos iupay
            Redsys::setNotification(config('redsys.url_notification')); //Url de notificacion
            Redsys::setUrlOk(config('redsys.url_ok')); //Url OK
            Redsys::setUrlKo(config('redsys.url_ko')); //Url KO
            Redsys::setVersion('HMAC_SHA256_V1');
            Redsys::setTradeName('Smash Urban Burger');
            Redsys::setTitular('Smash Urban');
            Redsys::setProductDescription('Pedido Smash Urban');
            Redsys::setEnviroment('test'); //Entorno test

            $signature = Redsys::generateMerchantSignature($key);

            Redsys::setMerchantSignature($signature);

            $form = Redsys::createForm();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return view('front.tpv', compact('form'));
    }

    function sumarMinutos($minutos = 30)
    {
        $fechaActual = time();

        // Sumar 30 minutos (30 * 60 segundos) a la fecha actual
        $fechaResultante = $fechaActual + ($minutos * 60);

        // Mostrar la fecha y hora resultante en formato legible
        return date('H:i:s d-m-Y', $fechaResultante);
    }

    public function enviarMailPedidoRealizado($order_id)
    {
        $order = Order::find($order_id);
        $cesta = $this->recuperarPedidoDeBD($order);
        $customer = Customer::find($order->customer_id);

        //Mostramos la vista del pedido realizado
        $cesta = DishController::procesarCestaHumano($cesta, 1);


        //Mandamos el mail
        if (isset($customer->email)) {
            if (stripos($customer->email, '@smashurban.com') === false) {
                if (strpos($customer->email, '@') !== false) {

                    $minutos_margen_web = Config::find(20);   //Configuración de los minutos de margen web

                    $hora_recogida = $this->sumarMinutos($minutos_margen_web->value);

                    Mail::to($customer->email)->send(new PedidoCreado($cesta, $customer, $order, $hora_recogida));
                }
            }
        }
    }

    public function ordenarLineasTicket($lineas)
    {
        $lineas_aux = [];
        foreach ($lineas as $linea) {
            $dishType = Dish::find($linea['plato_id'])->getType();

            $linea['sort'] = $dishType->shortTicket;
            $lineas_aux[] = $linea;
        }

        // Ordenar el array usando usort y la función de comparación
        $lineas_aux = $this->ordenarPorValor('sort', $lineas_aux);

        return $lineas_aux;
    }

    public function ordenarLineasCesta($lineas)
    {
        $lineas_aux = [];
        foreach ($lineas as $linea) {
            $dishType = Dish::find($linea['plato'])->getType();

            $linea['sort'] = $dishType->shortTicket;
            $lineas_aux[] = $linea;
        }

        // Ordenar el array usando usort y la función de comparación
        $lineas_aux = $this->ordenarPorValor('sort', $lineas_aux);

        return $lineas_aux;
    }

    public function ordenarPorValor($campo, $array)
    {
        usort($array, function ($a, $b) use ($campo) {
            return $a[$campo] <=> $b[$campo];
        });

        return $array;
    }

    public function generateJsonOrder($order_id = "", $copia = "Copia para el restaurante", $usuario = 0)
    {
        $order = Order::find($order_id);
        $restaurante = Restaurant::find($order->restaurant_id);
        $cesta = $this->recuperarPedidoDeBD($order);
        $total = 0;

        $lineas = [];
        foreach ($cesta as $linea) {
            $n = "";
            $e = null;
            //Sacamos el nombre de los elementos
            if ($linea['elementos']) {
                foreach ($linea['elementos'] as $ele) {
                    $n .= $ele->name . ",";
                }
                $e = explode(",", rtrim($n, ","));
            }

            //Si es un pedido de CA, ponemos el precio de CA, si lo tiene
            if (Auth::user() and Auth::user()->name == "Comoaqui" and $linea['precio_ca'] > 0) {
                $linea['precio'] = $linea['precio_ca'] * $linea['unidades'];
            }


            $lineas[] = [
                "plato" => $linea['plato']->name,
                "plato_id" => $linea['plato']->id,
                "img1" => $linea['plato']->img1,
                "unidades" => $linea['unidades'],
                "precio" =>  number_format($linea['precio'] / $linea['unidades'], 2, ',', ''),
                "total" => number_format($linea['unidades'] * ($linea['precio'] / $linea['unidades']), 2, ',', ''),
                "opciones" => $e,
                "observaciones" => $linea['observaciones'],
            ];

            $total += ($linea['unidades'] * ($linea['precio'] / $linea['unidades']));
        }

        $lineas = $this->ordenarLineasTicket($lineas);

        //dd($lineas);

        //Si tiene bolsas
        if ($order->bags) {
            $precioBolsa = Config::find(4);

            $precioBolsa->value = str_replace(",", ".", $precioBolsa->value);

            $lineas[] = [
                "plato" => "Bolsas",
                "unidades" => $order->bags,
                "precio" =>  number_format($precioBolsa->value, 2, ',', ''),
                "total" => number_format($precioBolsa->value * $order->bags, 2, ',', ''),
                "opciones" => null,
                "observaciones" => "",
            ];

            $total += ($precioBolsa->value * $order->bags);
        }

        $restaurante_extra = Config::find(7);

        $pedido_en_titulo = Config::find(9);
        if ($pedido_en_titulo->value) {
            $ped_aux = explode("-", $order->order);
            $titulo = $restaurante->name . " - " . (int)end($ped_aux);

            if ($order->order_comoaqui) {
                $titulo = "SU - " . (int)end($ped_aux) . " = CA - " . $order->order_comoaqui;
            }
        } else {
            $titulo = $restaurante->name;
        }

        //Si el pedido es de un cliente web, ponemos su nombre en el ticket
        if ($order->customer_id > 715) {
            $custo = Customer::find($order->customer_id);
            $titulo = $custo->name . " " . $custo->lastname  . " - " . (int)end($ped_aux);

            //Si custo contiene en el email el dominio pedidotelefonico.com añadimos al principio del titulo "TELEFONO: "
            if (session()->has('orderPhone') && session('orderPhone') === true) {
                $titulo = "TELEFONO: " . $titulo;
            }
        }

        $pedido = [
            "total" => str_replace(",", ".", ($order->discount ? $order->getTotal(0, 1) : $total)),
            "pedido" => $order->order,
            "restaurante" => $titulo,
            "restaurante_extra" => $restaurante_extra->value,
            "lineas" => $lineas,
            "copia" => $copia,
            "observaciones" => $order->observacions . ($order->discount ? "Descuento del " . $order->discount . "%" : ""),
            "coletilla" => "Hora de recogida: " . $order->time_ready,
            //"coletilla" => "Buen provecho :)",
        ];

        if (strpos($copia, "restaurante") !== false) {
            $pedido["grande"] = 1;
        }

        //Si es el cliente Comoaqui, imprimimos tres copias
        if (strpos($copia, "restaurante") !== false) {
            $copias_cocina = Config::find(10);
            $copias = $copias_cocina->value;
        } else {

            //Si es CA
            if (($order->order_comoaqui) and ($order->time_ready)) {
                $copias_cliente = Config::find(15);
                $copias = $copias_cliente->value;
                //Si es en local
            } else {
                $copias_ca = Config::find(11);
                $copias = $copias_ca->value;
            }
        }

        for ($i = 0; $i < $copias; $i++) {
            //Si es de cocina
            if ((strpos($copia, "restaurante") !== false)) {

                $separar_tickets = Config::find(19)->value;

                if ($separar_tickets != 1) {

                    $ticket = Ticket::create([
                        'json' => json_encode($pedido),
                        'copias' => $copias,
                        'tipo' => ((strpos($copia, "restaurante") !== false) ? "cocina" : "cliente"),
                        'usuario' => $usuario,
                        'hora_impresion' => (($order->time_ready) ? date('Y-m-d ') . $this->AjutarHoraComoaqui($order->time_ready) : NULL),
                        'token_restaurante' => $restaurante['token'],
                    ]);
                } else {

                    //Ticket para hamburguesas
                    $burgers = $this->tienePedidoBurgers($pedido);
                    if ($burgers) {

                        $pedido_con_solo_burger = $burgers;

                        $ticket = Ticket::create([
                            'json' => json_encode($pedido_con_solo_burger),
                            'copias' => $copias,
                            'tipo' => "cocina",
                            'usuario' => $usuario,
                            'hora_impresion' => (($order->time_ready) ? date('Y-m-d ') . $this->AjutarHoraComoaqui($order->time_ready) : NULL),
                            'token_restaurante' => $restaurante['token'],
                        ]);
                    }

                    //Ticket para patatas
                    $patatas = $this->tienePedidoPatatas($pedido);
                    if ($patatas) {

                        $pedido_con_solo_patatas = $patatas;

                        $ticket = Ticket::create([
                            'json' => json_encode($pedido_con_solo_patatas),
                            'copias' => $copias,
                            'tipo' => "patatas",
                            'usuario' => $usuario,
                            'hora_impresion' => (($order->time_ready) ? date('Y-m-d ') . $this->AjutarHoraComoaqui($order->time_ready) : NULL),
                            'token_restaurante' => $restaurante['token'],
                        ]);
                    }
                }

                //Si es para el cliente
            } else {
                //Si es de comoaqui, se programa para la sala
                if ($order->order_comoaqui) {
                    $ticket = Ticket::create([
                        'json' => json_encode($pedido),
                        'copias' => $copias,
                        'tipo' => ((strpos($copia, "restaurante") !== false) ? "cocina" : "cliente"),
                        'usuario' => $usuario,
                        'hora_impresion' => (($order->time_ready) ? date('Y-m-d ') . $this->AjutarHoraComoaqui($order->time_ready) : NULL),
                        'token_restaurante' => $restaurante['token'],
                    ]);
                    //Si es programado de cliente, se imprime ya el de sala para el cliente
                } else {

                    //Si es un código de cliente registrado en la web, no sacamos el primer ticket
                    if ((($order->customer_id > 715) and ($i == 0))) {
                    } else {

                        $ticket = Ticket::create([
                            'json' => json_encode($pedido),
                            'copias' => $copias,
                            'tipo' => ((strpos($copia, "restaurante") !== false) ? "cocina" : "cliente"),
                            'usuario' => $usuario,
                            'hora_impresion' => ((($order->time_ready) and ($i > 0)) ? date('Y-m-d ') . $this->AjutarHoraComoaqui($order->time_ready) : NULL),
                            'token_restaurante' => $restaurante['token'],
                        ]);
                    }
                }
            }
        }

        //return $ticket;
    }

    public function generateJsonOrderTable($order_id = "", $copia = "Copia para el restaurante", $usuario = 0)
    {
        $order = Order::find($order_id);
        $restaurante = Restaurant::find($order->restaurant_id);
        $cesta = $this->recuperarPedidoDeBD($order);
        $total = 0;

        $lineas = [];
        foreach ($cesta as $linea) {
            $n = "";
            $e = null;
            //Sacamos el nombre de los elementos
            if ($linea['elementos']) {
                foreach ($linea['elementos'] as $ele) {
                    $n .= $ele->name . ",";
                }
                $e = explode(",", rtrim($n, ","));
            }

            $lineas[] = [
                "plato" => $linea['plato']->name,
                "plato_id" => $linea['plato']->id,
                "img1" => $linea['plato']->img1,
                "unidades" => $linea['unidades'],
                "precio" =>  number_format($linea['precio'] / $linea['unidades'], 2, ',', ''),
                "total" => number_format($linea['unidades'] * ($linea['precio'] / $linea['unidades']), 2, ',', ''),
                "opciones" => $e,
                "observaciones" => $linea['observaciones'],
            ];

            $total += ($linea['unidades'] * ($linea['precio'] / $linea['unidades']));
        }

        $lineas = $this->ordenarLineasTicket($lineas);

        $restaurante_extra = Config::find(7);

        $pedido_en_titulo = Config::find(9);
        if ($pedido_en_titulo->value) {
            $ped_aux = explode("-", $order->order);
            $titulo = $restaurante->name . " - " . (int)end($ped_aux);
        } else {
            $titulo = $restaurante->name;
        }

        $pedido = [
            "total" => str_replace(",", ".", ($order->discount ? $order->getTotal(0, 1) : $total)),
            "pedido" => $order->observacions . ' - ' . explode("-", $order->order)[1],
            "restaurante" => $order->observacions,
            "restaurante_extra" => $restaurante_extra->value,
            "lineas" => $lineas,
            "copia" => $copia,
            "observaciones" => $order->observacions . ($order->discount ? "Descuento del " . $order->discount . "%" : ""),
            "coletilla" => "Hora de recogida: " . $order->time_ready,
        ];

        if (strpos($copia, "restaurante") !== false) {
            $pedido["grande"] = 1;
        }

        $copias = 1;

        for ($i = 0; $i < $copias; $i++) {
            //Si es de cocina
            if ((strpos($copia, "restaurante") !== false)) {

                $separar_tickets = Config::find(19)->value;

                if ($separar_tickets != 1) {

                    $ticket = Ticket::create([
                        'json' => json_encode($pedido),
                        'copias' => $copias,
                        'tipo' => ((strpos($copia, "restaurante") !== false) ? "cocina" : "cliente"),
                        'usuario' => $usuario,
                        'hora_impresion' => (($order->time_ready) ? date('Y-m-d ') . $this->AjutarHoraComoaqui($order->time_ready) : NULL),
                        'token_restaurante' => $restaurante['token'],
                    ]);
                } else {

                    //Ticket para hamburguesas
                    $burgers = $this->tienePedidoBurgers($pedido);
                    if ($burgers) {

                        $pedido_con_solo_burger = $burgers;

                        $ticket = Ticket::create([
                            'json' => json_encode($pedido_con_solo_burger),
                            'copias' => $copias,
                            'tipo' => "cocina",
                            'usuario' => $usuario,
                            'hora_impresion' => (($order->time_ready) ? date('Y-m-d ') . $this->AjutarHoraComoaqui($order->time_ready) : NULL),
                            'token_restaurante' => $restaurante['token'],
                        ]);
                    }

                    //Ticket para patatas
                    $entrantes = $this->tienePedidoPatatas($pedido);
                    if ($entrantes) {

                        $pedido_con_solo_patatas = $entrantes;

                        $ticket = Ticket::create([
                            'json' => json_encode($pedido_con_solo_patatas),
                            'copias' => $copias,
                            'tipo' => "patatas",
                            'usuario' => $usuario,
                            'hora_impresion' => (($order->time_ready) ? date('Y-m-d ') . $this->AjutarHoraComoaqui($order->time_ready) : NULL),
                            'token_restaurante' => $restaurante['token'],
                        ]);
                    }
                }

                //Si es para el cliente
            } else {
                //Si es de comoaqui, se programa para la sala

                $ticket = Ticket::create([
                    'json' => json_encode($pedido),
                    'copias' => $copias,
                    'tipo' => ((strpos($copia, "restaurante") !== false) ? "cocina" : "cliente"),
                    'usuario' => $usuario,
                    'hora_impresion' => ((($order->time_ready) and ($i > 0)) ? date('Y-m-d ') . $this->AjutarHoraComoaqui($order->time_ready) : NULL),
                    'token_restaurante' => $restaurante['token'],
                ]);
            }
        }

        //return $ticket;
    }

    public function generateJsonOrderTableAccount($orders, $table)
    {
        $restaurante = Restaurant::find(1);
        $cesta = $this->recuperarPedidoDeBDTable($orders);
        $total = 0;

        $lineas = [];
        foreach ($cesta as $linea) {
            $n = "";
            $e = null;
            //Sacamos el nombre de los elementos
            if ($linea['elementos']) {
                foreach ($linea['elementos'] as $ele) {
                    $n .= $ele->name . ",";
                }
                $e = explode(",", rtrim($n, ","));
            }

            $lineas[] = [
                "plato" => $linea['plato']->name,
                "plato_id" => $linea['plato']->id,
                "img1" => $linea['plato']->img1,
                "unidades" => $linea['unidades'],
                "precio" =>  number_format($linea['precio'] / $linea['unidades'], 2, ',', ''),
                "total" => number_format($linea['unidades'] * ($linea['precio'] / $linea['unidades']), 2, ',', ''),
                "opciones" => $e,
                "observaciones" => $linea['observaciones'],
            ];

            $total += ($linea['unidades'] * ($linea['precio'] / $linea['unidades']));
        }

        $restaurante_extra = Config::find(7);

        $pedido = [
            "total" => str_replace(",", ".", $total),
            "pedido" => $table->name,
            "restaurante" => explode('#', $restaurante_extra->value)[2],
            "restaurante_extra" => $restaurante_extra->value,
            "lineas" => $lineas,
            "copia" => 1,
            "observaciones" => '',
            "coletilla" => ($table->payment_method == 'card' ? "TARJETA. " : "EFECTIVO. ") .
                ($table->division_account > 1 ? 'Dividir entre ' . $table->division_account . ' ( ' . round(($total / $table->division_account), 2) . ' por persona)' : ''),
        ];

        Ticket::create([
            'json' => json_encode($pedido),
            'copias' => 1,
            'tipo' => "cliente",
            'usuario' => 1,
            'hora_impresion' => date('Y-m-d '),
            'token_restaurante' => $restaurante['token'],
        ]);
    }

    public function tienePedidoPatatas($pedido)
    {
        $tiene = 0;
        $lineas_aux = [];

        //Recuperamos la categoria de hamburguesas
        $categoria_entrantes = Config::find(18)->value;
        $categoria_postres = Config::find(29)->value;

        //Recorremos todas las lineas del pedido
        foreach ($pedido['lineas'] as $linea) {
            $plato = Dish::find($linea['plato_id']);
            if (($plato->dish_type_id == $categoria_entrantes) or
                ($plato->dish_type_id == $categoria_postres)
            ) {
                $tiene = 1;
                $lineas_aux[] = $linea;
            }
        }

        if ($tiene) {
            $pedido['lineas'] = $lineas_aux;
            return $pedido;
        }

        return null;
    }

    public function tienePedidoBurgers($pedido)
    {
        $tiene = 0;
        $lineas_aux = [];

        //Recuperamos la categoria de hamburguesas
        $categoria_burgers = Config::find(13)->value;

        //Recorremos todas las lineas del pedido
        foreach ($pedido['lineas'] as $linea) {
            $plato = Dish::find($linea['plato_id']);
            if ($plato->dish_type_id == $categoria_burgers) {
                $tiene = 1;
                $lineas_aux[] = $linea;
            }
        }

        if ($tiene) {
            $pedido['lineas'] = $lineas_aux;
            return $pedido;
        }

        return null;
    }

    public function tickets(Request $request)
    {
        //Recuperamos todas las etiquetas que están pendientes de imprimir
        $tickets = Ticket::where("impreso", null)
            ->where('token_restaurante', $request->token)
            ->orderBy("id")
            ->get();

        $newTickets = [];
        foreach ($tickets as $ticket) {
            $arrayJson = json_decode($ticket['json'], 1);
            $arrayJson['id'] = $ticket['id'];

            //Recuperamos el último ticket
            $ultimoTicket = Config::find(2);
            $ultimoTicket->value++;
            $ultimoTicket->save();
            $arrayJson['factura'] = $ultimoTicket->value;

            $newTickets['tickets'][] = $arrayJson;
        }

        $newTickets['status'] = true;

        return response()->json($newTickets, 200);
    }

    public function ticketsV2old(Request $request)
    {
        //Recuperamos todas las etiquetas que están pendientes de imprimir
        $tickets = Ticket::where("impreso", null)
            ->where('token_restaurante', $request->token)
            ->where('tipo', $request->type);

        //Si es de cliente, indicamos el usuario de la impresora
        if ($request->type == "cliente") {
            $tickets->where('usuario', $request->user);
        }

        $tickets = $tickets->orderBy("id")->get();

        $newTickets = [];
        foreach ($tickets as $ticket) {
            $arrayJson = json_decode($ticket['json'], 1);
            $arrayJson['id'] = $ticket['id'];

            //Recuperamos el último ticket
            $ultimoTicket = Config::find(2);
            $ultimoTicket->value++;
            $ultimoTicket->save();
            $arrayJson['factura'] = $ultimoTicket->value;

            $newTickets['tickets'][] = $arrayJson;
        }

        $newTickets['status'] = true;

        return response()->json($newTickets, 200);
    }

    public function ticketsV2(Request $request)
    {
        date_default_timezone_set('Europe/Madrid');

        $sql = "select * from `tickets` 
            where 
            impreso is null and 
            token_restaurante = '" . $request->token . "' and 
            tipo = '" . $request->type . "' and 
            (hora_impresion is null or hora_impresion <= '" . date('Y-m-d H:i:s') . "') and 
            tickets.deleted_at is null";

        $tickets = DB::select($sql);

        $newTickets = [];
        foreach ($tickets as $ticket) {
            $arrayJson = json_decode($ticket->json, 1);
            $arrayJson['id'] = $ticket->id;

            //Recuperamos el último ticket
            $ultimoTicket = Config::find(2);
            $ultimoTicket->value++;
            $ultimoTicket->save();
            $arrayJson['factura'] = $ultimoTicket->value;

            $newTickets['tickets'][] = $arrayJson;
        }

        $newTickets['status'] = true;

        return response()->json($newTickets, 200);
    }

    public function ticketsPrinted(Request $request)
    {
        //Recuperamos todas las etiquetas que están pendientes de imprimir
        $ticket = Ticket::find(request("idTicket"));

        if ($ticket) {
            $ticket->impreso = date("Y-m-d H:i:s");
            $ticket->save();
        }

        return response()->json("", 200);
    }

    public function informe(Request $request)
    {
        $date = $request->date;
        $date2 = $request->date2;
        $paymentMethod = $request->paymentMethod;
        $type = $request->type;

        //DB::enableQueryLog();

        $orders = Order::whereRaw("(`paid` = 1 or (`table`>0))")->whereRaw("date(date) between '$date' and '$date2'")
            ->where('status', "<=", 4); //Entregados


        if ($paymentMethod != null) {
            $orders = $orders->where('payment_method', $paymentMethod);
        }

        if ($type == 'table') {
            $orders = $orders->where('table', "!=", '');
        }

        if ($type == 'takeAway') {
            $orders = $orders
                ->whereRaw("(payment_method = 'cash' or payment_method='card') and (`table` = '' OR `table` is null)");
        }

        if ($type == 'ca') {
            $orders = $orders
                ->whereRaw("payment_method = 'ca'");
        }

        $orders = $orders->get();

        //dd(DB::getQueryLog()[0]['query']);

        $totalBurgers = $this->burgersCount($orders);

        $precioBolsa = Config::find(4);
        $precioBolsa = $precioBolsa->value;
        $precioBolsa = (float) str_replace(',', '.', $precioBolsa);

        $totalArticulos = new Order();
        $totalArticulos = $totalArticulos->getTotalDishByOrders($date, $date2);

        if (Auth::user()->role != "admin") {
            die("No puedes acceder aqui");
        }



        return view("admin.order.informe", compact('orders', 'precioBolsa', 'totalBurgers', 'totalArticulos'));
    }

    public function burgersCount($orders)
    {
        $total = 0;

        try {

            foreach ($orders as $order) {
                $lines = OrderLine::where("order_id", $order->id)->get();

                foreach ($lines as $line) {
                    $dish = Dish::find($line->dish_id);

                    $categoria_buergers = Config::find(13)->value;

                    if ($dish and in_array($dish->dish_type_id, explode(',', $categoria_buergers))) {
                        $total += $line->units;
                        //echo "<br>" . $order->id . " - " . $line->id . " - Plato: " . $dish->name . " - Pagado: " . $order->paid . " - Table: " . $order->table;
                    }
                }
            }
        } catch (\Throwable $th) {
            dd($dish);
            dd($line);
        }

        return $total;
    }

    public function reprintTickets(Request $request)
    {
        if ($request->type == 'c') {
            $ticket = Ticket::where('json', 'like', '%' . $request->order . '%')
                ->where('tipo', 'cocina')
                ->first();
        } else {
            $ticket = Ticket::where('json', 'like', '%' . $request->order . '%')
                ->where('tipo', 'cliente')
                ->first();
        }

        if ($ticket) {
            $ticket->impreso = null;
            if (Auth::user()->id) {
                $ticket->usuario = Auth::user()->id;
            }
            $ticket->save();;
        }
    }

    private function deleteOrderLinesAndResetStock($order)
    {
        //Recuperamos todas las lineas del pedido
        $orderLine = OrderLine::where('order_id', $order->id)->get();

        //Recorremos todas las lineas
        foreach ($orderLine as $line) {

            //Recuperamos su categoria
            $dish = Dish::find($line->dish_id);
            $dish_type = DishType::find($dish->dish_type_id);
            //Log::info($dish_type);
            if ($dish_type->manageStock) {
                //Actualizamos el stock
                $dish->stock = $dish->stock + $line->units;
                $dish->save();
            }

            //Recuperamos todos elementos de la linea
            $orderLineElements = OrderLineElement::where('order_line_id', $line->id)->get();

            //Recorremos todos los elementos
            foreach ($orderLineElements as $lineElement) {
                //Eliminamos todos elementos
                $lineElement->delete();
            }
            //Eliminamos la linea
            $line->delete();
        }
    }

    public function pagoOk(Request $request)
    {
        $order = Order::where('token', $request->token)->first();
        $custo = Customer::find($order->customer_id);

        if (!$order) {
            return redirect()->route('front.recoger')->with('error', 'No se ha podido recuperar el pedido');
        }

        if ($order->paid) {
            $pago = true;
        } else {
            $pago = false;
        }

        return view("front.finPedido", compact('pago', 'order', 'custo'));
    }

    public function pagoKo(Request $request)
    {
        $order = Order::where('token', $request->token)->first();

        if (!$order) {
            return redirect()->route('front.recoger')->with('error', 'No se ha podido recuperar el pedido');
        }

        $pago = false;
        $customer = Customer::find($order->customer->id);

        return view("front.finPedido", compact('pago', 'order', 'customer'));
    }

    public function notificacionPago(Request $request)
    {
        //Recuperamos los datos de la respuesta
        $key = "zMAp0bCW5ocmJrC2uqTZpYZt4CpuCBct";
        $parameters = Redsys::getMerchantParameters($request->input('Ds_MerchantParameters'));
        $DsResponse = $parameters["Ds_Response"];
        $DsResponse += 0;

        //Registramos la respuesta
        RedsysLog::create([
            'order' => $parameters['Ds_Order'],
            'response' => json_encode($parameters),
        ]);

        //Chequeamos si la respuesta es OK
        if (Redsys::check($key, $request->input()) && $DsResponse <= 99) {
            // lo que quieras que haya si es positiva la confirmación de redsys
            if (isset($parameters['Ds_Order'])) {
                $order = Order::where('order', $parameters['Ds_Order'])->first();

                //Pagamos el pedido
                $order->paid = 1;
                $order->status = 2; //Lo pasamos directamente a cocina
                $order->payment_method = 'card';
                $order->save();

                //Generamos los tickets
                $this->generateTickets($order);

                //Enviamos el mail al cliente
                $this->enviarMailPedidoRealizado($order->id);
            }
        } else {
            //lo que quieras que haga si no es positivo
            $order = Order::where('order', $parameters['Ds_Order'])->first();

            //Pagamos el pedido
            $order->paid = 0;
            $order->payment_method = 'fail card';
            $order->save();
        }

        // Log::info('Nueva petición recibida', ['request' => $parameters]);
    }

    public function notificacionPagoTest(Request $request)
    {
        //Chequeamos si la respuesta es OK

        $order = Order::where('order', $request->order)->first();

        //Pagamos el pedido
        $order->paid = 1;
        $order->status = 2; //Lo pasamos directamente a cocina
        $order->payment_method = 'card';
        $order->save();

        //Generamos los tickets
        $this->generateTickets($order);

        //Enviamos el mail al cliente
        $this->enviarMailPedidoRealizado($order->id);


        // Log::info('Nueva petición recibida', ['request' => $parameters]);
    }

    public function generateTickets($order)
    {
        //Sacamos el ticket para el cliente en el local
        if (env('TICKET_JOBS')) {
            dispatch(new TicketJob($order->id, "(Copia para el cliente)"));
        } else {
            $orderController = new OrderController();
            $orderController->generateJsonOrder($order->id, "(Copia para el cliente)");
        }
        ////////////////////////

        //Pasamos directamente el pedido a "en cocina" para saltarnos el paso de aceptarlo
        $order->status = 2;
        $order->save();

        if (env('TICKET_JOBS')) {
            dispatch(new TicketJob($order->id, "(Copia para el restaurante)", 0));
        } else {
            $orderController = new OrderController();
            $orderController->generateJsonOrder($order->id, "(Copia para el restaurante)", 0);
        }
        /////////////////////////
    }

    public function roomSituation(Request $request)
    {
        $request->session()->forget('conservar_cesta');
        $request->session()->forget('modificar_pedido');

        $sonido = false;

        //Obtenemos el total de burgers
        $maximo_burgers = Config::find(12)->value;
        $minutos_maregen = Config::find(14)->value;

        return view("admin.order.room", compact('sonido', 'maximo_burgers', 'minutos_maregen'));
    }

    public function roomSituationAjax(Request $request)
    {
        $tables = Table::all();

        $tables = $this->tableOrganizer($tables);

        return view("admin.order.roomtablesajax", compact('tables'));
    }

    public function tableOrganizer($tables)
    {
        $tables_actives = [];
        $tables_noactives = [];

        foreach ($tables as $table) {
            if ($table->getOrdersPending()->count() or $table->notify_waiter or $table->request_account) {
                $tables_actives[] = $table;
            } else {
                $tables_noactives[] = $table;
            }
        }

        return array_merge($tables_actives, $tables_noactives);
    }
}
