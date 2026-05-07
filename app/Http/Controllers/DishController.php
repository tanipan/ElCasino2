<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Config;
use App\Models\Element;
use App\Models\DishType;
use App\Models\OrderLine;
use App\Models\Restaurant;
use App\Models\Modification;
use Illuminate\Http\Request;
use App\Models\ModificationType;
use App\Models\OrderLineElement;
use App\Http\Requests\DishRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Facade\FlareClient\Http\Response;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Support\Facades\Session;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->dishType) {
            $dishes = Dish::where("dish_type_id", $request->dishType)
                ->orderBy('hidden', 'desc')
                ->orderBy('short')
                ->paginate(20);
        } elseif ($request->search) {
            $dishes = Dish::where("name", 'like', "%" . $request->search . "%")
                ->orderBy('hidden', 'desc')
                ->orderBy('short')
                ->paginate(20);
        } else {
            $dishes = Dish::orderBy('hidden', 'desc')->orderBy('short')->paginate(20);
        }
        $dishTypes = DishType::orderBy('short')->get();

        return view("admin.dish.index", compact('dishes', 'dishTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dishTypes = DishType::orderBy('short')->get();

        return view("admin.dish.create", compact('dishTypes'));
    }

    public function createModif(Dish $dish)
    {
        $modifications = ModificationType::where('type', 'alternative')->get();

        $text1 = "Modificaciones";
        $text2 = "modificación";
        $type = "alternative";

        return view("admin.dish.create2", compact('modifications', 'dish', 'text1', 'text2', 'type'));
    }

    public function createExtra(Dish $dish)
    {
        $modifications = ModificationType::where('type', 'extra')->get();

        $text1 = "Extras";
        $text2 = "extra";
        $type = "extra";

        return view("admin.dish.create2", compact('modifications', 'dish', 'text1', 'text2', 'type'));
    }

    public function createExtraOld(Dish $dish)
    {
        $modifications = ModificationType::all();
        $extra = ModificationType::where('name', "extra")
            ->orWhere('name', "extras")->first();

        $text1 = "Extras";
        $text2 = "extra";
        $type = "extra";

        return view("admin.dish.create2", compact('modifications', 'dish', 'text1', 'text2', 'type', 'extra'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DishRequest $request)
    {

        //dd($request->all());

        $imageName = "";
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');

            // Generar un nombre único para la imagen
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

            // Definir el directorio de almacenamiento
            $uploadPath = public_path('images'); // Carpeta dentro de public/uploads/images            

            // Crear el directorio si no existe
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Mover la imagen al directorio de destino
            $image->move($uploadPath, $imageName);
        }


        $dish = Dish::create([
            'name' => $request->name,
            'dish_type_id' => $request->dishType,
            'price' => $request->price,
            'img1' => $imageName,
            'price_ca' => $request->price_ca,
            'stock' => ($request->stock ? $request->stock : 0),
            'description' => $request->description,
            'hidden' => ($request->hidden ? 1 : 0),
            'room_only' => ($request->room_only ? 1 : 0),
            'delivery_only' => ($request->delivery_only ? 1 : 0),
            'waiter_only' => ($request->waiter_only ? 1 : 0),
            'minimum_units' => ($request->minimum_units ? $request->minimum_units : 1),
            'restaurant_id' => Restaurant::first()->id,
        ]);

        $dish->short = $dish->id;
        $dish->save();

        return redirect()->route('admin.dish.create2', compact('dish'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit(dish $dish)
    {
        $dishTypes = DishType::orderBy('short')->get();

        return view("admin.dish.edit", compact('dishTypes', 'dish'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dish $dish)
    {

        $imageName = $dish->img1;
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');

            // Generar un nombre único para la imagen
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

            // Definir el directorio de almacenamiento
            $uploadPath = public_path('images'); // Carpeta dentro de public/uploads/images            

            // Crear el directorio si no existe
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Mover la imagen al directorio de destino
            $image->move($uploadPath, $imageName);
        }


        $dish->name = $request->name;
        $dish->dish_type_id = $request->dishType;
        $dish->price = $request->price;
        $dish->price_ca = $request->price_ca;
        $dish->stock = $request->stock;
        $dish->description = $request->description;
        $dish->minimum_units = 1;
        $dish->img1 = $imageName;
        $dish->hidden = ($request->hidden ? 1 : 0);
        $dish->room_only = ($request->room_only ? 1 : 0);
        $dish->delivery_only = ($request->delivery_only ? 1 : 0);
        $dish->waiter_only = ($request->waiter_only ? 1 : 0);
        $dish->minimum_units = ($request->minimum_units ? $request->minimum_units : 1);
        $dish->save();

        return redirect()->route('admin.dish.create2', compact('dish'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function destroy(dish $dish)
    {
        $dish->delete();

        return redirect()->route('admin.dish.list');
    }

    public function recuperarModalPlato(Request $request)
    {
        $foodglish = "";

        //Recuperamos los datos del plato
        $dish = Dish::find($request->dish_id);

        $foodglish = [
            "plato" => $dish
        ];

        //Recuperamos las modificaciones del plato
        $modifs = Modification::where('dish_id', $dish->id)
            ->where('hidden', '0')
            ->orderBy('orden')
            ->orderBy('created_at', 'desc')
            ->get();


        foreach ($modifs as $m) {

            if ($m->type == "alternative") {

                //Recuperamos el nombre de la modificación
                $modif = ModificationType::find($m->modification_type_id);

                //Recuperaos los elementos de la modificación
                $elems = Element::where('modification_id', $m->id)
                    ->where('hidden', '0')
                    ->get();

                $foodglish['alternativas'][] = [
                    "modificacion" => $m,
                    "nombre" => $modif->name,
                    "elementos" => $elems
                ];
            }

            if ($m->type != "alternative") {

                //Recuperamos el nombre de la modificación
                $modif = ModificationType::find($m->modification_type_id);

                //Recuperaos los elementos de la modificación
                $elems = Element::where('modification_id', $m->id)
                    ->where('hidden', '0')
                    ->get();

                $foodglish['extras'][] = [
                    "modificacion" => $m,
                    "nombre" => $modif->name,
                    "elementos" => $elems
                ];
            }
        }

        //dd($foodglish);

        //Generamos la vista y la deovlvemos
        return view("front.dish.modal2", compact('dish', 'foodglish'));
    }

    public function recuperarPrecioPlato(Request $request)
    {
        $precio = self::recuperarPrecioPlatoInner($request->plato, $request->elementos, $request->unidades, $request);

        return $precio;
    }

    public static function recuperarPrecioPlatoInner($plato, $elementos, $unidades, $request)
    {
        $precio = 0;

        $plato = $plato;
        $elementos = array_filter(explode(",", $elementos));

        $dish = Dish::find($plato);

        //Si es un pedido de CA, ponemos el precio de CA, si lo tiene        
        if (Auth::user() and Auth::user()->name == "Comoaqui" and $dish->price_ca > 0) {
            $precio += $dish->price_ca;
        } else {
            $precio += $dish->price;
        }



        $elementos = Element::whereIn('id', $elementos)->get();

        foreach ($elementos as $ele) {
            $precio += $ele->price;
        }

        if (isset($unidades)) {
            $precio = $precio * $unidades;
        }

        return $precio;
    }

    public function cargarCesta(Request $request)
    {
        $boton = $request->boton;
        //Recuperamos la cesta
        $cesta = $request->session()->get('cesta');

        //Procesamos la cesta a "humano" para la vista        
        $cestaHumana = self::procesarCestaHumano($cesta);

        $maximo_burgers = Config::find(12)->value;
        $web_abierta =  $this->webAbierta(); //Config::find(17)->value;

        return view("front.dish.cesta2", compact('cestaHumana', 'boton', 'maximo_burgers', 'web_abierta'));
    }

    function webAbierta()
    {
        $horarios = Config::find(21)->value;
        $horarios = explode("#", $horarios);

        $horaInicio = $horarios[0];
        $horaFin = $horarios[1];

        $dias = Config::find(22)->value;

        $horaActual = date('H:i:s');

        // Convertir las horas a formato de timestamp
        $timestampInicio = strtotime($horaInicio);
        $timestampFin = strtotime($horaFin);
        $timestampActual = strtotime($horaActual);

        // Comprobar si la hora actual está entre las horas de inicio y fin
        if ($timestampActual >= $timestampInicio && $timestampActual <= $timestampFin) {
            $return = true;
        } else {
            $return = false;
        }

        $pos = strpos($dias, $this->obtenerInicialDiaSemana());

        if (($pos !== false) and $return) {
            return true;
        }

        return false;
    }

    public function obtenerInicialDiaSemana()
    {
        $diasSemana = array('D', 'L', 'M', 'X', 'J', 'V', 'S');
        $numeroDiaSemana = date('N') % 7;
        $inicialDiaSemana = $diasSemana[$numeroDiaSemana];

        return $inicialDiaSemana;
    }

    public function cargarResumenCesta(Request $request)
    {
        $botones = $request->botones;
        $cleanCart = $request->cleanCart;
        //Recuperamos la cesta
        $cesta = $request->session()->get('cesta');

        //Procesamos la cesta a "humano" para la vista        
        $cestaHumana = self::procesarCestaHumano($cesta);

        return view("front.dish.resumencesta2", compact('cestaHumana', 'botones', 'cleanCart'));
    }

    public function cargarResumenCestaMesa(Request $request)
    {

        $botones = false;

        //Recuperamos la cesta
        $cesta = $this->deBDaCestaMesa($request, $request->orders);

        $cleanCart = false;
        //Procesamos la cesta a "humano" para la vista        
        $cestaHumana = self::procesarCestaHumano($cesta);

        return view("front.dish.resumencesta2", compact('cestaHumana', 'botones', 'cleanCart'));
    }

    public function cargarResumenCestaUltimoTicketMesa(Request $request)
    {


        //Recuperamos la cesta
        $cesta = $this->deBDaCestaMesaUltimoTicket($request, $request->orders, $request->type);

        $cleanCart = false;
        //Procesamos la cesta a "humano" para la vista        
        $cestaHumana = self::procesarCestaHumano($cesta);

        if ($request->type == "pendiente") {
            return view("front.dish.resumenUltimoTicketcesta2Pendiente", compact('cestaHumana', 'cleanCart'));
        } elseif ($request->type == "pagar") {
            return view("front.dish.resumenUltimoTicketcesta2Pagar", compact('cestaHumana', 'cleanCart'));
        } elseif ($request->type == "pagado") {
            return view("front.dish.resumenUltimoTicketcesta2Pagado", compact('cestaHumana', 'cleanCart'));
        }
    }

    public function cargarPedidoRealizado(Request $request)
    {
        $botones = false;
        $cleanCart = false;

        $order = Order::where('order', $request->order)->first();
        //Recuperamos la cesta
        $cesta = new OrderController();
        $cesta = $cesta->recuperarPedidoDeBD($order);

        //Procesamos la cesta a "humano" para la vista        
        $cestaHumana = self::procesarCestaHumano($cesta);

        return view("front.dish.resumencesta2", compact('cestaHumana', 'botones', 'cleanCart'));
    }

    public static function procesarCestaHumano($cesta, $mail = 0)
    {
        if ($cesta == null) {
            return [];
        }

        foreach ($cesta as $k => $elemento) {
            if (is_object($elemento['plato'])) {
                $elemento['plato'] = $elemento['plato']->id;
            }

            $e = [];
            $dish = Dish::find($elemento['plato']);

            $elems = [];
            if (($elemento['elementos'] != null) and is_array($elemento['elementos']) and !is_object($elemento['elementos'][array_key_first($elemento['elementos'])])) {
                $elems = Element::whereIn('id', $elemento['elementos'])->get();
            } else {
                if ($elemento['elementos'] != null) {
                    $arrayelementos = [];
                    foreach ($elemento['elementos'] as $e) {
                        $arrayelementos[] = $e->id;
                    }

                    $elems = Element::whereIn('id', $arrayelementos)->get();
                }
            }

            $n = "";
            foreach ($elems as $ele) {
                $n .= $ele->name . ",";
            }
            $e = explode(",", rtrim($n, ","));

            $ELE = null;

            if ($mail and (isset($elemento['elementos']) and $elemento['elementos'])) {
                $elemento['elementos'] = self::procesaEleParaMail($elemento['elementos']);
            }

            //dd($elemento['elementos']);
            if ($elemento['elementos'] != null) {
                $ELE = implode(",", $elemento['elementos']);
            }

            $cestaHumana[$k] = [
                "plato" => $dish->name,
                "plato_id" => $dish->id,
                "img1" => $dish->img1,
                "unidades" => $elemento['unidades'],
                "unidadesPagar" => (isset($elemento['unidadesPagar']) ? $elemento['unidadesPagar'] : null),
                "unidadesPagadas" => (isset($elemento['unidadesPagadas']) ? $elemento['unidadesPagadas'] : null),
                "idLinea" => (isset($elemento['idLinea']) ? $elemento['idLinea'] : null),
                "precio" => self::recuperarPrecioPlatoInner($elemento['plato'], $ELE, $elemento['unidades'], null),
                "elementos" => $e,
                "observaciones" => $elemento['observaciones'],
            ];
        }

        return $cestaHumana;
    }

    private static function procesaEleParaMail($elementos)
    {
        $ele = [];

        foreach ($elementos as $key => $value) {
            $ele[] = $value->id;
        }

        return $ele;
    }

    public function insertarEnCesta(Request $request)
    {
        $cesta = $request->session()->get('cesta');

        $precio = $this->recuperarPrecioPlato($request);
        $elementos = array_filter(explode(",", $request->elementos));

        //Si el artículo ya existe en el carrito simplemente aumentamos sus unidades
        if (($cesta != null) and array_key_exists($request->plato, $cesta)) {
            $request->unidades = $request->unidades + $cesta[$request->plato]['units'];
        }

        $dish = Dish::find($request->plato);

        $cesta[uniqid()] = array(
            "plato" => $request->plato,
            "unidades" => $request->unidades,
            "unidades_min" => $dish->minimum_units,
            "precio" => $precio,
            "elementos" => $elementos,
            "observaciones" => $request->observaciones,
        );

        $request->session()->put('cesta', $cesta);
    }

    public function actualizarCesta(Request $request)
    {
        $plato = $request->input('plato');
        $signo = $request->input('signo');
        $cesta = $request->session()->get('cesta');

        if ($signo == "+") {
            $cesta[$plato]['unidades']++;
        } elseif ($signo == "-") {
            $cesta[$plato]['unidades']--;
        }

        if (($cesta[$plato]['unidades'] <= 0) or ($cesta[$plato]['unidades'] < $cesta[$plato]['unidades_min'])) {
            unset($cesta[$plato]);
        }

        if ($signo == "x") {
            unset($cesta[$plato]);
        }

        $request->session()->put('cesta', $cesta);
    }

    public function addPagar(Request $request)
    {
        $plato = $request->input('plato');
        $linea = $request->input('linea');

        $line = OrderLine::where('id', $linea)->where('dish_id', $plato)->first();
        $line->units_pending++;
        $line->save();
    }

    public function subPagar(Request $request)
    {
        $plato = $request->input('plato');
        $linea = $request->input('linea');

        $line = OrderLine::where('id', $linea)->where('dish_id', $plato)->first();
        $line->units_pending--;
        $line->save();
    }

    public function upPosition(Request $request, Dish $dish)
    {
        //Recuperamos el elemento que tiene por encima
        $tipoA = Dish::where('short', "<", $dish->short)
            ->where('dish_type_id', $request->dishType)
            ->orderBy('short', 'desc')
            ->first();

        if ($tipoA) {
            $posocionAux = $tipoA->short;
            $tipoA->short = $dish->short;
            $dish->short = $posocionAux;
            $dish->save();
            $tipoA->save();
        }

        return redirect()->route('admin.dish.list', ['dishType' => $request->dishType]);
    }

    public function downPosition(Request $request, Dish $dish)
    {
        //Recuperamos el elemento que tiene por encima
        $tipoA = Dish::where('short', ">", $dish->short)
            ->where('dish_type_id', $request->dishType)
            ->orderBy('short', 'asc')
            ->first();

        if ($tipoA) {
            $posocionAux = $tipoA->short;
            $tipoA->short = $dish->short;
            $dish->short = $posocionAux;
            $dish->save();
            $tipoA->save();
        }

        return redirect()->route('admin.dish.list', ['dishType' => $request->dishType]);
    }

    public function deBDaCesta(Request $request)
    {
        $order = Order::where('token', $request->token)->first();
        $order_lines = OrderLine::where('order_id', $order->id)->get();
        $cesta = $request->session()->get('cesta');

        $cesta = null;

        foreach ($order_lines as $line) {

            $elements = OrderLineElement::where('order_line_id', $line->id)->get();
            $ele = "";
            foreach ($elements as $element) {
                $ele .= $element->element_id . ",";
            }
            $request2 = new Request([
                'plato'   => $line->dish_id,
                'elementos'   => $ele,
                'unidades' => $line->units,
                'observaciones' => $line->observacions,
            ]);

            $cesta = $this->insertarEnCestaV2($request2, $cesta);
        }
        //Log::info($cesta);
        $request->session()->put('cesta', $cesta);
        $request->session()->put('conservar_cesta', true);
        $request->session()->put('modificar_pedido', $order);

        return redirect()->route('front.validarLoginToken', ['token' => $order->customer->token]);
    }

    public function deBDaCestaMesa(Request $request, $orders)
    {
        $order_lines = OrderLine::whereIn('order_id', explode(",", $orders))->get();

        $cesta = null;

        foreach ($order_lines as $line) {

            $elements = OrderLineElement::where('order_line_id', $line->id)->get();
            $ele = "";
            foreach ($elements as $element) {
                $ele .= $element->element_id . ",";
            }
            $request2 = new Request([
                'plato'   => $line->dish_id,
                'elementos'   => $ele,
                'unidades' => $line->units,
                'observaciones' => $line->observacions,
            ]);

            $cesta = $this->insertarEnCestaV2($request2, $cesta);
        }
        //Log::info($cesta);
        //$request->session()->put('cestaMesa', $cesta);        
        return $cesta;
    }

    public function deBDaCestaMesaUltimoTicket(Request $request, $orders, $tipo = "pendiente")
    {
        if ($tipo == "pendiente") {
            $order_lines = OrderLine::whereIn('order_id', explode(",", $orders))
                ->whereRaw('units > (units_paid + units_pending)')
                ->get();
        } elseif ($tipo == "pagar") {
            $order_lines = OrderLine::whereIn('order_id', explode(",", $orders))
                ->whereRaw('units_pending > 0')
                ->get();
        } elseif ($tipo == "pagado") {
            $order_lines = OrderLine::whereIn('order_id', explode(",", $orders))
                ->whereRaw('units_paid > 0')
                ->get();;
        }

        $cesta = null;

        foreach ($order_lines as $line) {

            $elements = OrderLineElement::where('order_line_id', $line->id)->get();
            $ele = "";
            foreach ($elements as $element) {
                $ele .= $element->element_id . ",";
            }
            $request2 = new Request([
                'plato'   => $line->dish_id,
                'elementos'   => $ele,
                'unidades' => $line->units,
                'unidadesPagar' => $line->units_pending,
                'unidadesPagadas' => $line->units_paid,
                'observaciones' => $line->observacions,
                'idLinea' => $line->id,
            ]);

            $cesta = $this->insertarEnCestaV2UltimoTicket($request2, $cesta);
        }
        //Log::info($cesta);
        //$request->session()->put('cestaMesa', $cesta);        
        return $cesta;
    }

    public function insertarEnCestaV2UltimoTicket(Request $request, $cesta)
    {
        $precio = $this->recuperarPrecioPlato($request);

        $elementos = array_filter(explode(",", $request->elementos));

        $dish = Dish::find($request->plato);

        $cesta[uniqid()] = array(
            "plato" => $request->plato,
            "unidades" => $request->unidades,
            "unidadesPagar" => $request->unidadesPagar,
            "unidadesPagadas" => $request->unidadesPagadas,
            "idLinea" => $request->idLinea,
            "unidades_min" => $dish->minimum_units,
            "precio" => $precio,
            "elementos" => $elementos,
            "observaciones" => $request->observaciones,
        );

        return $cesta;
    }

    public function insertarEnCestaV2(Request $request, $cesta)
    {
        $precio = $this->recuperarPrecioPlato($request);

        $elementos = array_filter(explode(",", $request->elementos));

        $dish = Dish::find($request->plato);

        $cesta[uniqid()] = array(
            "plato" => $request->plato,
            "unidades" => $request->unidades,
            "unidades_min" => $dish->minimum_units,
            "precio" => $precio,
            "elementos" => $elementos,
            "observaciones" => $request->observaciones,
        );

        return $cesta;
    }

    function setearDescuento(Request $request)
    {
        if ($request->descuento) {
            $request->session()->put('descuento', $request->descuento);
        }

        return response()->json("", 200);
    }

    function ocultarElemento(Request $request)
    {

        $elemento = Element::find($request->elemento);

        if ($elemento) {
            $elemento->hidden = !$elemento->hidden;
            $elemento->save();
        }

        return response()->json("", 200);
    }
}
