<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Http\Controllers\CustomerController;

class OrderPhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $request->session()->put('orderPhone', true);        

        //Buscar al cliente por telefono
        $customer = Customer::where('phone', $request->telefono)
            ->first();

        if ($customer) {
            $custoCls = new CustomerController();
            $request->merge(['token' => $customer->token]);

            return $custoCls->validarLoginToken($request);
        } else {
            //Si no existe el cliente, crear uno nuevo
            return redirect()->route('front.registro', ['telefono' => $request->telefono]);
        }
    }
}
