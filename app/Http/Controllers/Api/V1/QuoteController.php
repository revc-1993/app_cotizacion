<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        return Quote::withTrashed()->get();
    }
}
