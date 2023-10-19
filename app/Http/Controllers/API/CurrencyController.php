<?php

namespace App\Http\Controllers\API;

use App\Models\Currency;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyRource;

class CurrencyController extends Controller
{
    public function index()
    {
        return CurrencyRource::collection(Currency::all());
    }
}
