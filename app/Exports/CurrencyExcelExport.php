<?php

namespace App\Exports;

use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CurrencyExcelExport
{
    protected $currencies;

    public function __construct($currencies)
    {
        $this->currencies = $currencies;
    }

    public function export()
    {
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Create a new worksheet
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers
        $headers = ['ISO', 'Currency', 'Previous Rate', 'Current Rate'];
        $sheet->fromArray([$headers], null, 'A1');

        // Add data
        $data = $this->prepareData();
        $sheet->fromArray($data, null, 'A2');

        // Create a new Xlsx writer
        $writer = new Xlsx($spreadsheet);
        $randomSuffix = Str::random(8);
        $filePath = storage_path('app/public/currencies' . now()->format('Ymd') . '-' . $randomSuffix. '.xlsx');
        $writer->save($filePath);
        return $filePath;
    }

    protected function prepareData()
    {
        // Modify this method to return the data you want to export
        return $this->currencies->map(function ($currency) {
            return [
                $currency->iso_code,
                $currency->name,
                $currency->previous_rate,
                $currency->current_rate,
            ];
        })->toArray();
    }
}


