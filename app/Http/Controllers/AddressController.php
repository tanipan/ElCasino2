<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $addresses = Address::where("customer_id", $customer->id)
            ->paginate(20);

        return view("admin.address.index", compact('addresses', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        return view("admin.address.create", compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request, Customer $customer)
    {
        if ($request->principal == 1) {
            $addresses = Address::where('customer_id', $customer->id)->get();

            //Marcamos todas las direcciones del cliente a 0 si la actual es a 1
            foreach ($addresses as $address) {
                $address->principal = 0;
                $address->save();
            }
        }

        Address::create([
            'address' => $request->address,
            'alias' => $request->alias,
            'principal' => $request->principal,
            'observations' => $request->observations,
            'customer_id' => $customer->id
        ]);

        return redirect()->route('admin.address.list', $customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address, Customer $customer)
    {
        return view('admin.address.edit', compact('address', 'customer'));
    }

    public function update(Request $request, Address $address, Customer $customer)
    {
        if ($request->principal == 1) {
            $addresses = Address::where('customer_id', $customer->id)->get();

            //Marcamos todas las direcciones del cliente a 0 si la actual es a 1
            foreach ($addresses as $add) {
                $add->principal = 0;
                $add->save();
            }
        }

        $address->address = request("address");
        $address->alias = request("alias");
        $address->principal = request("principal");
        $address->observacions = request("observacions");
        $address->save();

        return redirect()->route('admin.address.list', $customer);
    }

    public function setAsPrimary(Address $address, Customer $customer)
    {
        $addresses = Address::where('customer_id', $customer->id)->get();

        //Marcamos todas las direcciones del cliente a 0 si la actual es a 1
        foreach ($addresses as $add) {
            $add->principal = 0;
            $add->save();
        }

        $address->principal = 1;
        $address->save();

        return redirect()->route('admin.address.list', $customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address, Customer $customer)
    {
        $address->delete();

        return redirect()->route('admin.address.list', $customer);
    }
}
