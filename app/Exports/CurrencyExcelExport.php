<?php

namespace App\Exports;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CurrencyExcelExport
{
    protected $currencies;

    public function __construct($currencies)
    {
        $this->currencies = $currencies;
    }

    public function export($storage_path = 'app/public/currencies')
    {
        try {
            // Create a new Spreadsheet object
            $spreadsheet = new Spreadsheet();

            // Create a new worksheet
            $sheet = $spreadsheet->getActiveSheet();

            // Add headers
            $headers = ['ISO', 'Currency', 'Previous Rate', 'Current Rate'];
            $sheet->fromArray([$headers], null, 'A1');

            // Add data
            $data = $this->currencies->map(function ($currency) {
                        return [
                            $currency->iso_code,
                            $currency->name,
                            $currency->previous_rate,
                            $currency->current_rate,
                        ];
                    })->toArray();
            $count = count($this->currencies);
            $rowStart = 1;
            $rowEnd = 1 + $count;
            $columnArray = ['A','B','C','D'];
            foreach ($columnArray as $column) {
                $sheet->getStyle($column.'1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF66CDAA');
                $sheet->getStyle($column.'1')->getFont()->setBold( true );
            }
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF708090'],
                    ],                         
                ],
            ];
            foreach ($columnArray as $column) {
                $cellRange = $column.$rowStart.':'.$column.$rowEnd;
                $sheet->getStyle($cellRange)->applyFromArray($styleArray);
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
            $sheet->fromArray($data, null, 'A2');

            // Create a new Xlsx writer
            $writer = new Xlsx($spreadsheet);
            $randomSuffix = Str::random(8);
            // option: can also use buffer instead of file
            $filePath = storage_path($storage_path . now()->format('Ymd') . '-' . $randomSuffix. '.xlsx');
            $writer->save($filePath);
            
            return ['file' => $filePath, 'error' => false];
        } catch (\Exception $e) {
            Log::error('ExcelExport Error: '.$e->getMessage());
            return ['error' => true, 'message' => 'Failed excel export. Please try again later.'];
        }
    }

}


