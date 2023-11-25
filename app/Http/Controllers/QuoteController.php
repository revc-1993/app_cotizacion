<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Requests\BillRequest;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Quote;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\ServiceDetail;
use App\Http\Requests\QuoteRequest;
use App\Mail\MailStoreQuote;
use App\Models\Configuration;
use Illuminate\Support\Facades\Auth;

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
            ->orderBy($request->input('sort.key', 'registration_date'), $request->input('sort.order', 'asc'))
            ->whereNotIn('id', [1])
            ->where(function ($query) use ($request) {
                $search = '%' . $request->input('search') . '%';

                $query->where('total', 'like', $search);
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
        if (!$this->hasConfiguration()) {
            $company = null;
        } else {
            $company = Configuration::all('id', 'company_name', 'ruc', 'address', 'contact_number', 'email', 'regime_category', 'logo')->firstOrFail();
            if ($company->logo) {
                $company->logoUrl = asset('storage/' . $company->logo);
            }
        }

        return Inertia::render('Quote/Index', [
            'quotes' => Quote::with([
                'customer' => function ($query) {
                    $query->select('id', 'ruc', 'name', 'last_name', 'address');
                },
                'user'
            ])->get(),
            'company' => $company
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->hasConfiguration()) {
            $company = null;
        } else {
            $company = Configuration::all('id', 'company_name', 'ruc', 'address', 'contact_number', 'email', 'regime_category', 'logo')->firstOrFail();
            if ($company->logo) {
                $company->logoUrl = asset('storage/' . $company->logo);
            }
        }

        return Inertia::render('Quote/Create', compact('company'));
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
        $post['user_id'] = $this->getIdUser();
        $post['state'] = $this->getState($request);

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

        // Preparar para pdf
        $configuration = Configuration::all()->first();
        if ($configuration['logo']) {
            $configuration['logoUrl'] = asset('storage/' . $configuration['logo']);
        }
        // dd($configuration['logoUrl']);

        $quoteValidity = Carbon::parse($quote->quote_validity);
        $transitTime = Carbon::parse($quote->transit_time);
        $now = Carbon::now();
        $quote['quoteValidity'] = $now->diffInDays($quoteValidity);
        $quote['transitTime'] = $now->diffInDays($transitTime);

        $pdfData = [
            'quote' => $quote,
            'configuration' => $configuration
        ];

        // Notifica
        foreach ([$quote->customer->email] as $emailAddress) {
            Mail::to($emailAddress)->send(new MailStoreQuote($pdfData));
        }

        if ($quote) {
            $type = 'success';
            $message = "Registro creado exitosamente";

            // Mail::to("ronny.verac.1993@gmail.com")->send(new MailStoreQuote());
        } else {
            $type = 'error';
            $message = "Ha ocurrido un error. Registro no creado";
        }

        return to_route('quotes.index')->with($type, $message);
    }

    public function show($id)
    {
        if (!$this->hasConfiguration()) {
            $company = null;
        } else {
            $company = Configuration::all('id', 'company_name', 'ruc', 'address', 'contact_number', 'email', 'regime_category', 'logo')->firstOrFail();
            if ($company->logo) {
                $company->logoUrl = asset('storage/' . $company->logo);
            }
        }

        $quote = Quote::with([
            'customer' => function ($query) {
                $query->select('id', 'ruc', 'name', 'last_name', 'address');
            },
            'user',
            'productDetails',
            'serviceDetails',
        ])
            ->where('quotes.id', '=', $id)
            ->first();

        return response()->json(compact('quote', 'company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$this->hasConfiguration()) {
            $company = null;
        } else {
            $company = Configuration::all('id', 'company_name', 'ruc', 'address', 'contact_number', 'email', 'logo')->firstOrFail();
            if ($company->logo) {
                $company->logoUrl = asset('storage/' . $company->logo);
            }
        }

        $quote = Quote::with([
            'customer' => function ($query) {
                $query->select('id', 'ruc', 'name', 'last_name', 'address');
            },
            'user' => function ($query) {
                $query->select('id', 'name');
            },
            'productDetails',
            'serviceDetails',
        ])
            ->where('quotes.id', '=', $id)
            ->first();

        return Inertia::render('Quote/Edit', compact('quote', 'company'));
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
        $post = $request->validated();
        $post['user_id'] = $this->getIdUser();
        $post['state'] = $this->getState($request);

        $quote->update($post);

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

    public function markAsBilled(BillRequest $request, Quote $quote)
    {
        // dd($quote);
        $quote->update([
            'is_billed' => true,
            'state' => 'aceptada',
            'invoice_date' => now(),
            'invoice_number' => $request->invoice_number,
        ]);

        if ($quote) {
            $type = 'success';
            $message = "Registro marcado como facturado";
        } else {
            $type = 'error';
            $message = "Ha ocurrido un error. Registro no marcado como facturado";
        }

        return to_route('bills.index')->with($type, $message);
    }

    public function getIdUser()
    {
        if (Auth::check())
            return Auth::id(); // Opción 1
        return null;
    }

    public function hasConfiguration()
    {
        return Configuration::count() > 0;
    }

    public function getState(QuoteRequest $request)
    {
        if ($request->is_billed == true) {
            return "aceptada";
        } else if (now() <= $request->quote_validity) {
            return "pendiente";
        } else {
            return "denegada";
        }
    }
}
