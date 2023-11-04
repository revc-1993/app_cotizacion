<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Quote;
use Illuminate\Http\Request;
use App\Models\Configuration;

class BillController extends Controller
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

        return Inertia::render('Bill/Index', [
            'quotes' => Quote::with([
                'customer' => function ($query) {
                    $query->select('id', 'ruc', 'name', 'last_name');
                }
            ])->get(),
            'company' => $company
        ]);
    }

    public function hasConfiguration()
    {
        return Configuration::count() > 0;
    }
}
