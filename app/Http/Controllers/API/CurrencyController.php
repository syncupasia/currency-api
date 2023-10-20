<?php

namespace App\Http\Controllers\API;

use App\Models\Currency;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyRource;
use App\Services\CurrencyConversionService;
use App\Http\Requests\ConvertCurrencyRequest;

class CurrencyController extends Controller
{
    public function index()
    {
        return CurrencyRource::collection(Currency::all());
    }

    /**
     * Convert one currency to another
     * @param string $baseCurrency
     * @param string $targetCurrency
     * @param ConvertCurrencyRequest
     * 
     * @return response json data
     */
    public function convert(string $baseCurrency, string $targetCurrency, ConvertCurrencyRequest $request)
    {
        $service = app(CurrencyConversionService::class); // there's already a service binding in AppServiceProvider.php
        return response()->json(['amount' => $service->calculate($request->validated())]);
    }
}
