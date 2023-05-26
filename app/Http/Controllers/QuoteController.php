<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\QuoteRequest;

class QuoteController extends Controller
{

    public function __construct()
    {
        Inertia::share([
            'quotes' => Quote::get(),
        ]);
    }

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
        return Inertia::render('Quote/Index');
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
        $post = array_merge($request->validated(), [
            'registration_date' => Carbon::now(),
        ]);

        $quote = Quote::create($post);

        $message = [
            "response" => "Registro creado correctamente.",
            "operation" => 1,
        ];

        return to_route('quotes.index')->with(compact('message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function edit(Quote $quote)
    {
        return Inertia::render('Quote/Edit', [
            'quote' => $quote,
        ]);
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

        $message = [
            "response" => "Registro modificado correctamente.",
            "operation" => 1,
        ];

        return to_route('quotes.index')->with(compact('message'));
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

        $message = [
            "response" => "Registro eliminado correctamente.",
            "operation" => 4,
        ];

        return to_route('quotes.index')->with(compact('message'));
    }
}
