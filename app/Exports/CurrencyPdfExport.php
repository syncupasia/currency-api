<?php

namespace App\Exports;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class CurrencyPdfExport
{
    protected $currencies;

    public function __construct($currencies)
    {
        $this->currencies = $currencies;
    }

    public function export()
    {
        try {
            $randomSuffix = Str::random(8);
            $html = view('exports.currencies-pdf', ['currencies' => $this->currencies])->render();
            $pdf = PDF::loadHTML($html);
            $file = 'currencies'. now()->format('Ymd') . '-' . $randomSuffix. '.pdf';
            return ['error' => false, 'pdf' => $pdf, 'file' => $file];
        } catch (\Exception $e) {
            Log::error('ExcelExport Error: '.$e->getMessage());
            return ['error' => true, 'message' => 'Failed pdf export. Please try again later.'];
        }
    }
}
