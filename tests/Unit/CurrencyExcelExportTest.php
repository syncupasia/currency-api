<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Currency;
use App\Exports\CurrencyExcelExport;
use Illuminate\Support\Facades\Storage;

class CurrencyExcelExportTest extends TestCase
{
    private $file;

    public function testCurrencyExportGeneratesCorrectFile()
    {
        $currencyExport = new CurrencyExcelExport(Currency::all());

        $this->file = $currencyExport->export();

        // Assert that file exists
        $this->assertFileExists($this->file);
        
        // Assert that file size greater than 0
        $this->assertGreaterThan(0, filesize($this->file));

        // Assert that the content type is valid
        $this->assertEquals('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', mime_content_type($this->file));

    }

    public function tearDown(): void
    {
        // Delete the file if it exists
        if (file_exists($this->file)) {
            unlink($this->file);
        }

        parent::tearDown();
    }
}

