<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Quote;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $query = Quote::query()->with('customer');

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if (!is_null($startDate) && !is_null($endDate)) {
            try {
                $startDate = Carbon::parse($startDate);
                $endDate = Carbon::parse($endDate);

                // Asegúrate de que las fechas se hayan analizado correctamente antes de usarlas en la consulta.
                if ($startDate instanceof Carbon && $endDate instanceof Carbon) {
                    $query->whereBetween('registration_date', [$startDate, $endDate]);
                } else {
                    // Manejar el caso en el que las fechas no se analizaron correctamente.
                }
            } catch (\Exception $e) {
                // Manejar cualquier excepción que pueda ocurrir al analizar las fechas.
                Log::error('Error al analizar fechas: ' . $e->getMessage());
                return response()->json(['error' => 'Hubo un error al procesar las fechas.'], 500);
            }
        }

        if (!is_null($request->input('state'))) {
            $query->orWhere('state', $request->state);
        }

        if (!is_null($request->input('user'))) {
            $query->orWhere('user_id', $request->user);
        }

        if (!is_null($request->input('customer'))) {
            $query->orWhere('customer_id', $request->customer);
        }

        $quotes = $query->get();

        return Inertia::render('Report/Index', [
            'quotes' => $quotes,
            'users' => User::all('id', 'name'),
            'customers' => Customer::all('id', 'names')
        ]);
    }
}
