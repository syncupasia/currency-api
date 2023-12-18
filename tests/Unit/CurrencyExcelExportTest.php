<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Currency;
use App\Exports\CurrencyExcelExport;

class CurrencyExcelExportTest extends TestCase
{
    protected $currencies;

    public function setUp(): void
    {
        parent::setUp();
        $this->currencies = Currency::all();
    }

    public function testCurrencyExportGeneratesCorrectFile()
    {
        $currencyExport = new CurrencyExcelExport($this->currencies);

        $export = $currencyExport->export();

        $this->assertStringContainsString('currencies', $export['file']);
        $this->assertStringEndsWith('.xlsx', $export['file']);
        $this->assertFileExists($export['file']);
        
        // Assert that file size greater than 0
        $this->assertGreaterThan(0, filesize($export['file']));

        // Assert that the content type is valid
        $this->assertEquals('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', mime_content_type($export['file']));

        $this->assertArrayHasKey('error', $export);
        $this->assertFalse($export['error']);

        // Delete the file if it exists
        if (file_exists($export['file'])) {
            unlink($export['file']);
        }
        unset($export);
    }

    public function testCurrencyExportException()
    {
        $currencyExport = new CurrencyExcelExport($this->currencies);

        $export = $currencyExport->export('fake_path/');

        $this->assertArrayHasKey('error', $export);
        $this->assertTrue($export['error']);
        $this->assertArrayHasKey('message', $export);
    }

}

