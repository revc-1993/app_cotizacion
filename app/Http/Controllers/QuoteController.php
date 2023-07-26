<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\QuoteRequest;
use App\Models\ProductDetail;
use App\Models\ServiceDetail;

class QuoteController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function paginate(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
            'perPage' => 'nullable|integer|min:1|max:500',
            'sort.key' => 'nullable|string',
            'sort.order' => 'nullable|in:asc,desc',
        ]);

        return Quote::withTrashed((bool) $request->input('withTrashed', 0))
            ->orderBy($request->input('sort.key', 'name'), $request->input('sort.order', 'asc'))
            ->whereNotIn('id', [1])
            ->where(function ($query) use ($request) {
                $search = '%' . $request->input('search') . '%';

                $query->where('name', 'like', $search);
                // ->orWhere('username', 'like', $search)
                // ->orWhere('email', 'like', $search)
                // ->orWhere('email_verified_at', 'like', $search)
                // ->orWhere('created_at', 'like', $search)
                // ->orWhere('deleted_at', 'like', $search);
            })
            ->paginate($request->input('perPage', 10));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Quote/Index', [
            'quotes' => Quote::get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Quote/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuoteRequest $request)
    {
        $post = $request->validated();

        // dd($post);
        $quote = Quote::create($post);

        $detailsProductRequest = $request->details_charge;

        // Detalles de producto
        $product_details = [];
        foreach ($detailsProductRequest as $detail) {
            $product_details[] = new ProductDetail([
                'cargo_name' => $detail['cargo_name'],
                'amount_of_charge' => $detail['amount_of_charge'],
                'unit_of_weight_measurement' =>
                $detail['unit_of_weight_measurement'],
                'weight' => $detail['weight'],
                'unit_of_length_measurement' =>
                $detail['unit_of_length_measurement'],
                'length' => $detail['length'],
                'width' => $detail['width'],
                'high' => $detail['high'],
                'volumen' => $detail['volumen'],
                'weight_calculated' => $detail['weight_calculated'],
            ]);
        }
        $quote->productDetails()->saveMany($product_details);

        $detailsServiceRequest = $request->details_service;

        // Detalles de servicio
        $service_details = [];
        foreach ($detailsServiceRequest as $detail) {
            $service_details[] = new ServiceDetail([
                'type_of_service' => $detail['type_of_service'],
                'amount_of_service' => $detail['amount_of_service'],
                'service' => $detail['service'],
                'pvp_provider' => $detail['pvp_provider'],
                'utility' => $detail['utility'],
                'utility_usd' => $detail['utility_usd'],
                'subtotal' => $detail['subtotal']
            ]);
        }
        $quote->serviceDetails()->saveMany($service_details);

        if ($quote) {
            $type = 'success';
            $message = "Registro creado exitosamente";
        } else {
            $type = 'error';
            $message = "Ha ocurrido un error. Registro no creado";
        }

        return to_route('quotes.index')->with($type, $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quote = Quote::with([
            'customer' => function ($query) {
                $query->select('id', 'ruc', 'name', 'last_name');
            },
            'productDetails',
            'serviceDetails',
        ])
            ->where('quotes.id', '=', $id)
            ->first();

        return Inertia::render('Quote/Edit', compact('quote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(QuoteRequest $request, Quote $quote)
    {
        $quote->update($request->validated());

        $detailsProductRequest = $request->details_charge;

        // dd($details);

        // Detalles de producto
        $product_details = [];
        foreach ($detailsProductRequest as $detail) {
            $product_details[] = new ProductDetail([
                'cargo_name' => $detail['cargo_name'],
                'amount_of_charge' => $detail['amount_of_charge'],
                'unit_of_weight_measurement' =>
                $detail['unit_of_weight_measurement'],
                'weight' => $detail['weight'],
                'unit_of_length_measurement' =>
                $detail['unit_of_length_measurement'],
                'length' => $detail['length'],
                'width' => $detail['width'],
                'high' => $detail['high'],
                'volumen' => $detail['volumen'],
                'weight_calculated' => $detail['weight_calculated'],
            ]);
        }
        $quote->productDetails()->delete();
        $quote->productDetails()->saveMany($product_details);

        $detailsServiceRequest = $request->details_service;

        // Detalles de servicio
        $service_details = [];
        foreach ($detailsServiceRequest as $detail) {
            $service_details[] = new ServiceDetail([
                'type_of_service' => $detail['type_of_service'],
                'amount_of_service' => $detail['amount_of_service'],
                'service' => $detail['service'],
                'pvp_provider' => $detail['pvp_provider'],
                'utility' => $detail['utility'],
                'utility_usd' => $detail['utility_usd'],
                'subtotal' => $detail['subtotal']
            ]);
        }
        $quote->serviceDetails()->delete();
        $quote->serviceDetails()->saveMany($service_details);

        if ($quote) {
            $type = 'success';
            $message = "Registro modificado exitosamente";
        } else {
            $type = 'error';
            $message = "Ha ocurrido un error. Registro no modificado";
        }

        return to_route('quotes.index')->with($type, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();

        if ($quote) {
            $type = 'error';
            $message = "Registro eliminado exitosamente";
        } else {
            $type = 'error';
            $message = "Ha ocurrido un error. Registro no eliminado";
        }

        return to_route('quotes.index')->with($type, $message);
    }
}
