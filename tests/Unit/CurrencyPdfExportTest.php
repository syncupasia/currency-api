<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Currency;
use App\Exports\CurrencyPdfExport;

class CurrencyPdfExportTest extends TestCase
{
    protected $currencies;

    public function setUp(): void
    {
        parent::setUp();
        $this->currencies = Currency::all();
    }

    public function testCurrencyExportSuccess()
    {
        $currencyExport = new CurrencyPdfExport($this->currencies);
        $export = $currencyExport->export();
        $this->assertFalse($export['error']);
        $this->assertNotNull($export['pdf']);
        $this->assertInstanceOf(\Barryvdh\DomPDF\PDF::class, $export['pdf']);
        $this->assertStringContainsString('currencies', $export['file']);
        $this->assertStringEndsWith('.pdf', $export['file']);

    }

    public function testCurrencyExportException()
    {
        \Barryvdh\DomPDF\Facade\Pdf::shouldReceive('loadHTML')->andThrow(new \Exception('Mocked PDF Load Error'));
        $currencyExport = new CurrencyPdfExport($this->currencies);
        $export = $currencyExport->export();
        $this->assertArrayHasKey('error', $export);
        $this->assertTrue($export['error']);
        $this->assertArrayHasKey('message', $export);
    }
}
