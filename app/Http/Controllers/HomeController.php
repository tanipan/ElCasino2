<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Order;
use App\Mail\Contacto;
use App\Models\Config;
use App\Jobs\TicketJob;
use App\Models\Customer;
use App\Models\DishType;
use App\Mail\RecordarPass;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Rules\UniqueGuestEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Ssheduardo\Redsys\Facades\Redsys;

class HomeController extends Controller
{
    public function autoLogin(Request $request)
    {
        if ((Auth::user() != null) and ($request->token == "NZQ0EHOcedq2MuPkNVBLwUuUa5mXEuka")) {
            $customer = Customer::where('token', $request->token)->first();

            //Obtenemos el méximo de burgers para hacer
            $maximo_burgers = Config::find(12)->value;
            $request->session()->put('maximo_burgers', $maximo_burgers);

            $request->session()->forget('login');

            $session = $request->session()->get('login');
            $session['cliente'] = $customer;
            $request->session()->put('login', $session);

            $request->session()->forget('guest');
            $request->session()->forget('cesta');
            $request->session()->forget('descuento');
            $request->session()->forget('orderPhone');
        }

        return redirect()->route('front.recoger');
    }

    public function recoger(Request $request)
    {
        //Recuperamos las categorias
        $dishTypes = DishType::where('hidden', '0')
            ->orderBy('short')
            ->get();

        $carta = [];

        //Por cada tipo recuperamos sus platos
        foreach ($dishTypes as $type) {
            $dishs = Dish::where('dish_type_id', $type->id)
                ->orderBy('short')
                ->get();

            if ($dishs) {
                $carta[] = [
                    "tipo" => $type,
                    "platos" => $dishs
                ];
            }
        }

        $maximo_burgers = Config::find(12)->value;
        $request->session()->forget('descuento');

        return view("front.recoger2", compact('carta', 'maximo_burgers'));
    }

    // public function index(Request $request)
    // {
    //     //Recuperamos las categorias


    //     //Recuperamos los productos de cada categoria

    //     return view("front.index");
    // }

    // public function carta(Request $request)
    // {
    //     $titulo = "CARTA";
    //     $menu = "carta";

    //     return view("front.carta", compact('titulo', 'menu'));
    // }

    // public function cestaMovil(Request $request)
    // {
    //     $titulo = "TU CESTA";
    //     $menu = "cesta";

    //     return view("front.cestaMovil", compact('titulo', 'menu'));
    // }

    // public function contacto(Request $request)
    // {
    //     $titulo = "CONTACTANOS";
    //     $menu = "contacto";

    //     return view("front.contacto", compact('titulo', 'menu'));
    // }

    // public function contactoEnviar(Request $request)
    // {
    //     if (($request->name != "HenryNix") and ($request->name != "CrytoNix")) {
    //         //dd($request->all());
    //         Mail::to(env('LB_EMAIL'))->send(new Contacto($request->name, $request->email, $request->subject, $request->message));
    //     }

    //     return redirect()->route('front.contacto')->with('status', true);
    // }

    // public function login(Request $request)
    // {
    //     if ($request->session()->get('login')) {
    //         return redirect()->route('front.perfil');
    //     }

    //     $titulo = "ACCEDE";
    //     $menu = "login";

    //     return view("front.login", compact('titulo', 'menu'));
    // }

    // public function recordar(Request $request)
    // {
    //     $titulo = "RECUPERA TU CONTRASEÑA";
    //     $menu = "login";

    //     return view("front.recordar", compact('titulo', 'menu'));
    // }

    public function recordar1(Request $request)
    {
        $status = false;

        //Recuperamos el cliente por el correo
        $customer = Customer::where('email', $request->email)->first();
        if ($customer) {
            Mail::to($request->email)->send(new RecordarPass($customer->token));
            $status = true;
        }

        if ($status) {
            return "ok";
        }
        return "ko";
    }

    public function recordar2(Request $request)
    {
        $token = $request->token;

        return view("front.recordar2", compact('token'));
    }

    public function recordar3(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password2' => 'required|same:password'
        ]);

        $customer = Customer::where('token', $request->token)->first();
        $customer->password = Hash::make($request->password);
        $customer->save();

        if ($customer) {
            $session['cliente'] = $customer;
            $request->session()->put('login', $session);

            return view("front.perfil", compact('customer'));
        }

        return redirect()->route('front.recordar2')->with('status', true);
    }

    // public function privacidad(Request $request)
    // {
    //     $titulo = "PRIVACIDAD";
    //     $menu = "privacidad";

    //     return view("front.privacidad", compact('titulo', 'menu'));
    // }

    public function registro(Request $request)
    {
        //Solo borramos las sesiones si venimos del gestor
        if (Auth::user() != null) {
            //Borramos las sessiones de la cesta y el login
            $request->session()->forget('login');
            $request->session()->forget('cesta');
            $request->session()->forget('descuento');
        }
        if ($request->session()->get('login')) {
            return redirect()->route('front.perfil');
        }

        return view("front.registro2");
    }

    // public function pedido(Request $request)
    // {
    //     $titulo = "HACER PEDIDO";
    //     $menu = "pedido";

    //     return view("front.pedido", compact('titulo', 'menu'));
    // }

    public function resumen(Request $request)
    {
        $minutos_margen = Config::find(1);   //Configuración de los minutos de margen
        $maximo_burgers = Config::find(12)->value;

        $franja_inicio = Config::find(25)->value;
        $franja_fin = Config::find(26)->value;
        $saltos_franjas = Config::find(27)->value;
        $margen_seleccion_franja = Config::find(28)->value;

        //$request->session()->forget('descuento');

        if (Auth::user() or isset(session()->get('login')['mesa']) and session()->get('login')['mesa']) {
            return view("front.resumen2", compact('franja_inicio', 'franja_fin', 'saltos_franjas', 'margen_seleccion_franja'));
        } else {
            return redirect()->route('front.recoger');
        }
    }

    public function resumenFin(Request $request)
    {
        $cesta = $request->session()->get('cesta');
        $cliente = $request->session()->get('login');
        $guest = $request->session()->get('guest');

        if ($cesta == null) {
            return redirect()->route('front.recoger')->with('error', 'Se ha producido un error, la cesta estaba vacía, intentalo de nuevo');
        }

        $guest = null;

        if ($request->name and $request->lastname and $request->phone and $request->email) {

            $request->validate([
                'email' => ['required', 'email']
            ]);

            $guest = Customer::where('email', $request->email)->first();

            if (!$guest) {

                $guest = new Customer();
                $guest->name = $request->name;
                $guest->lastname = $request->lastname;
                $guest->phone = $request->phone;
                $guest->email = $request->email;
                $guest->newsletter = $request->newsletter;
                $guest->guest = true;
            } else {
                $cliente = $guest;
                $request->session()->put('login', $cliente);
            }
        }

        if (!$cliente and !$guest) {
            return redirect()->route('front.recoger')->with('error', 'Se ha producido un error al crear el pedido, intentalo de nuevo');
        }

        $session['cliente'] = $guest;
        $request->session()->put('guest', $session);

        $OrderController = new OrderController();
        $order = $OrderController->registrarPedido($request);

        $minutos_margen_web = Config::find(20);   //Configuración de los minutos de margen web

        $hora_recogida = $this->sumarMinutos($minutos_margen_web->value);

        if (Auth::user() != null and !isset(session()->get('login')['mesa'])) {
            $order->paid = true;
            $order->payment_method = $request->formaPago;
            $order->save();
            $form = "";

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
                dispatch(new TicketJob($order->id, "(Copia para el restaurante)", $request->user));
            } else {
                $orderController = new OrderController();
                $orderController->generateJsonOrder($order->id, "(Copia para el restaurante)", $request->user);
            }
            /////////////////////////

            return view("front.resumenFin", compact('guest', 'order', 'form', 'hora_recogida'));
        } elseif (Auth::user() != null and isset(session()->get('login')['mesa'])) {

            $form = "";
            $tableC = new TableController();
            $tableC->aceptOrder($request, $order);

            return view("front.resumenFin", compact('guest', 'order', 'form', 'hora_recogida'));
        } else {
            if ($order) {
                $form = $this->generarPagoTpv($order);
                $form = $this->remplazarFormularioTpv($form);
            }

            return view("front.resumenFin", compact('guest', 'order', 'form', 'hora_recogida'));
        }
    }

    function sumarMinutos($minutos = 30)
    {
        $fechaActual = time();

        // Sumar 30 minutos (30 * 60 segundos) a la fecha actual
        $fechaResultante = $fechaActual + ($minutos * 60);

        // Mostrar la fecha y hora resultante en formato legible
        return date('H:i:s d-m-Y', $fechaResultante);
    }

    public function remplazarFormularioTpv($formuTpv)
    {
        $formuTpv = str_replace(
            '<input type="submit" name="btn_submit" id="btn_submit" value="Send"  >',
            '<input class="btn btn-primary" type="submit" name="btn_submit" id="btn_submit" value="REALIZA EL PAGO >">',
            $formuTpv
        );

        return $formuTpv;
    }

    public function generarPagoTpv(Order $order)
    {
        try {
            $key = config('redsys.key');
            $code = config('redsys.merchantcode');

            Redsys::setAmount($order->total);
            Redsys::setOrder($order->order);
            Redsys::setMerchantcode('357998525'); //Reemplazar por el código que proporciona el banco
            Redsys::setCurrency('978');
            Redsys::setTransactiontype('0');
            Redsys::setTerminal('1');
            Redsys::setMethod('T'); //Solo pago con tarjeta, no mostramos iupay
            Redsys::setNotification(route('front.notificacionPago')); //Url de notificacion
            Redsys::setUrlOk(route('front.pagoOk', ['token' => $order->token])); //Url OK
            Redsys::setUrlKo(route('front.pagoOk', ['token' => $order->token])); //Url KO
            Redsys::setVersion('HMAC_SHA256_V1');
            Redsys::setTradeName('Smash Urban Burger');
            Redsys::setTitular('Smash Urban');
            Redsys::setProductDescription('Pedido ' . $order->order);
            //Redsys::setEnviroment('test'); //Entorno test
            Redsys::setEnviroment('live'); //Entorno test

            $signature = Redsys::generateMerchantSignature('zMAp0bCW5ocmJrC2uqTZpYZt4CpuCBct');

            Redsys::setMerchantSignature($signature);

            $form = Redsys::createForm();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return $form;
    }

    public function perfil(Request $request)
    {
        if (!$request->session()->get('login')) {
            return redirect()->route('front.login');
        }

        $customer = $request->session()->get('login')['cliente'];

        $customer = Customer::find($customer->id);

        return view("front.perfil", compact('customer'));
    }

    // public function proceso(Request $request)
    // {
    //     $titulo = "PEDIDO EN PROCESO";
    //     $menu = "proceso";

    //     return view("front.proceso", compact('titulo', 'menu'));
    // }

    // public function movil(Request $request)
    // {
    //     $titulo = "RECOGER EN LA ARROCERIA";
    //     $menu = "recoger";
    //     $movil = true;

    //     return view("front.movil", compact('titulo', 'movil'));
    // }

    public function logout(Request $request)
    {
        $login = $request->session()->get('login');

        //Borramos las sessiones de la cesta y el login
        $request->session()->forget('login');
        $request->session()->forget('guest');
        //$request->session()->forget('cesta');

        if (isset($login['admin']) and $login['admin']) {
            return redirect()->route('admin.customer.list');
        } else {
            return redirect()->route('front.recoger');
        }
    }
}
