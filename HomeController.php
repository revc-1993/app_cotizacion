<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Configuration;

class HomeController extends Controller
{
    public function index()
    {
        if (!$this->hasConfiguration()) {
            $company = null;
        } else {
            $company = Configuration::all()->firstOrFail();
            if ($company->logo) {
                $company->logoUrl = asset('storage/' . $company->logo);
            }
        }

        // dd($company);

        return Inertia::render('Dashboard', compact('company'));
    }

    public function hasConfiguration()
    {
        return Configuration::count() > 0;
    }
}
