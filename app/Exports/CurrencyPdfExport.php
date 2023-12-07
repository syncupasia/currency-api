<?php

namespace App\Exports;

use Illuminate\Support\Str;
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
        $randomSuffix = Str::random(8);
        $pdfObject = new \stdClass();
        $html = view('exports.currencies-pdf', ['currencies' => $this->currencies])->render();
        $pdfObject->pdf = PDF::loadHTML($html);
        $pdfObject->file = 'currencies'. now()->format('Ymd') . '-' . $randomSuffix. '.pdf';
        return $pdfObject;
    }
}
