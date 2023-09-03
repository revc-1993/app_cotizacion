<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index()
    {
        return Inertia::render('Report/Index', [
            'users' => User::all('id', 'name'),
            'customers' => Customer::all('id', 'names')
        ]);
    }

    public function search(Request $request)
    {
        // dd($request->all());

        $state = $request->state;
        $user = $request->user;
        $customer = $request->customer;

        $quotes = Quote::query()
            ->with('customer')
            ->where('state', $state)
            ->orWhere('user_id', $user)
            ->orWhere('customer_id', $customer)
            ->get();

        // dd($quotes);

        return Inertia::render('Report/Index', [
            'quotes' => $quotes,
            'users' => User::all('id', 'name'),
            'customers' => Customer::all('id', 'names')
        ]);

        // return response()->json($response);
    }
}
