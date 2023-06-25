<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{

    public function __construct()
    {
        Inertia::share([
            'customers' => Customer::get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Customer/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Customer/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        if ($customer) {
            $type = 'success';
            $message = "Registro creado exitosamente";
        } else {
            $type = 'error';
            $message = "Ha ocurrido un error. Registro no creado";
        }

        return to_route('customers.index')->with($type, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return Inertia::render('Customer/Edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        if ($customer) {
            $type = 'success';
            $message = "Registro modificado exitosamente";
        } else {
            $type = 'error';
            $message = "Ha ocurrido un error. Registro no modificado";
        }

        return to_route('customers.index')->with($type, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        if ($customer) {
            $type = 'error';
            $message = "Registro eliminado exitosamente";
        } else {
            $type = 'error';
            $message = "Ha ocurrido un error. Registro no eliminado";
        }

        return to_route('customers.index')->with($type, $message);
    }

    public function getCustomerByRuc(Request $request)
    {
        $customer = Customer::where('ruc', $request->get('ruc'))
            ->first(['id', 'ruc', 'name', 'last_name']);

        // if ($customer) {
        //     $type = 'error';
        //     $message = "Registro eliminado exitosamente";
        // } else {
        //     $type = 'error';
        //     $message = "Ha ocurrido un error. Registro no eliminado";
        // }

        return response()->json(compact('customer'));
    }
}
