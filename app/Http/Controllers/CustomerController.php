<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CustomerRequest;
use App\Rules\UniqueNoGuestEmail;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search) {

            $sql = "select *
            from customers
            where 
            (concat(name,' ',lastname) like '%" . $request->search . "%'
            or id = '" . $request->search . "'
            or phone = '" . $request->search . "')
            and deleted_at is null";

            $customers = DB::select($sql);

            return view("admin.customer.search", compact('customers'));
        } else {
            $customers = Customer::orderBy('id')
                ->paginate(20);

            return view("admin.customer.index", compact('customers'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.customer.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {

        Customer::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'token' => Str::random(32),
            'birthday' => $request->birthday,
            'observacions' => $request->observacions,
        ]);

        return redirect()->route('admin.customer.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        if (request('password')) {
            $request->validate([
                'name' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:customers,email,' . $customer->id,
                'password' => 'required|min:6',
                'password_confirmation' => 'required_with:password|same:password',
            ]);
        } else {

            $request->validate([
                'name' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:customers,email,' . $customer->id,
            ]);
        }

        $customer->name = request("name");
        $customer->lastname = request("lastname");
        $customer->email = request("email");
        $customer->phone = request("phone");
        $customer->birthday = request("birthday");
        $customer->observacions = request("observacions");

        if (request('password')) {
            $customer->password = Hash::make(request('password'));
        }

        $customer->save();

        return redirect()->route('admin.customer.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //Recuperamos los pedidos del cliente
        $orders = Order::where('customer_id', $customer->id)->get();

        foreach ($orders as $order) {
            $order->delete();
        }

        $customer->delete();

        return redirect()->route('admin.customer.list');
    }

    public function registrarCliente(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $customer = Customer::where('email', $request->email)->first();
        if ($customer) {
            $customer->name = $request->name;
            $customer->lastname = $request->lastname;
            $customer->phone = $request->name;
            $customer->password = Hash::make($request->password);
            $customer->newsletter = ($request->newsletter ? 1 : 0);
            $customer->guest = false;
            $customer->save();
        } else {
            $customer = Customer::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'token' => Str::random(32),
                'birthday' => null,
                'observacions' => null,
                'newsletter' => ($request->newsletter ? 1 : 0),
            ]);
        }

        if ($customer) {
            //Si se crea correctamente, creamos la sesión de login
            $session = $request->session()->get('login');
            $session['cliente'] = $customer;
            $request->session()->put('login', $session);

            //Si viene del gestor
            if (Auth::user() != null) {
                return redirect()->route('front.recoger');
            }

            //if ($request->session()->get('cesta')) {
            //Si tiene sesión de cesta, lo llevamos al resumen de esta
            return redirect()->route('front.recoger');
            //} else {
            //Si no, a su perfil de usuario
            //return redirect()->route('front.perfil');
            //}
        }
    }

    public function validarLogin(Request $request)
    {
        //Recuperamos el cliente por el email
        $customer = Customer::where('email', $request->email)->first();
        if ($customer) {
            //Chequeamos la contraseña
            if (Hash::check($request->password, $customer->password)) {

                $session = $request->session()->get('login');
                $session['cliente'] = $customer;
                $request->session()->put('login', $session);

                $request->session()->forget('guest');

                //if ($request->session()->get('cesta')) {
                //Si tiene sesión de cesta, lo llevamos al resumen de esta
                //    return redirect()->route('front.resumen');
                //} else {
                //Si no, a su perfil de usuario
                //    return redirect()->route('front.perfil');
                //}
                return "ok";
            }
        }

        //return redirect()->route('front.login')->with('error', true);
        return "ko";
    }

    public function validarLoginToken(Request $request)
    {

        //Recuperamos el cliente por el email
        $customer = Customer::where('token', $request->token)->first();

        //Chequeamos la contraseña        
        $session = $request->session()->get('login');
        $session['cliente'] = $customer;
        $session['admin'] = true;
        $request->session()->put('login', $session);

        //Limpiamos la cesta por si contiene cosas, siempre y cuando no sea para modificar un pediddo
        if ($request->session()->get('conservar_cesta') !== true) {
            $request->session()->forget('cesta');
        }

        return redirect()->route('front.recoger');
    }

    public function modificarDatos(Request $request)
    {
        $customer = Customer::where('token', $request->token)->first();

        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
        ]);

        if ($customer) {
            $customer->name = request("name");
            $customer->lastname = request("lastname");
            $customer->phone = request("phone");
            $customer->newsletter = ((request("newsletter") == 'on') ? 1 : 0);
            $customer->save();
            $session['cliente'] = $customer;
            $request->session()->put('login', $session);
        }

        return redirect()->route('front.perfil')->with('success', true);
    }

    public function modificarPassword(Request $request)
    {

        $request->validate([
            'currpass' => 'required',
            'password' => 'required',
            'password2' => 'required|same:password'
        ]);

        $customer = Customer::where('token', $request->token)->first();
        if ($customer) {
            //Chequeamos la contraseña
            if (Hash::check($request->currpass, $customer->password)) {
                $customer->password = Hash::make($request->password);
                $customer->save();
            }
        }

        return redirect()->route('front.perfil')->with('successPass', true);
    }
}
