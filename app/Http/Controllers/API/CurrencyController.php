<?php

namespace App\Http\Controllers\API;

use App\Models\Currency;
use App\Exports\CurrencyPdfExport;
use App\Exports\CurrencyExcelExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Services\CurrencyConversionService;
use App\Http\Requests\SearchCurrencyRequest;
use App\Http\Requests\ConvertCurrencyRequest;

class CurrencyController extends Controller
{
    public function index(SearchCurrencyRequest $request)
    {
        $isoCodes = $request->input('iso_codes');
        if (!is_null($isoCodes)) {
            $currencies = Currency::whereIn('iso_code', $isoCodes)->get();
        } else {
            $currencies = Currency::all();
        }
        $format = $request->input('format', 'json'); // default json

        if ($format === 'excel') {
            $currencyExport = new CurrencyExcelExport($currencies);
            // Return the file as a download response and delete it after sending
            $filePath = $currencyExport->export();
            return response()->download($filePath)->deleteFileAfterSend(true);

        } elseif ($format === 'pdf') {
            $currencyExport = new CurrencyPdfExport($currencies);
            $pdfExport = $currencyExport->export();
            return $pdfExport->pdf->download($pdfExport->file);

        } else {

            return CurrencyResource::collection($currencies);
        }
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
