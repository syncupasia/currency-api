<?php

namespace Tests\Feature;

use Tests\TestCase;

class CurrencyExcelDownloadTest extends TestCase
{
    private $filePath;

    public function testCurrencyExcelDownload()
    {
        // Assert that the response is successful and valid content type
        $response = $this->get('/api/currencies?format=excel');
        $response->assertStatus(200)
                ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        // Assert that filename has the valid format
        $contentDispositionHeader = $response->headers->get('Content-Disposition');
        $expectedPattern = '/^attachment; filename=currencies\d{8}-[a-zA-Z0-9]+\.xlsx$/';
        $this->assertMatchesRegularExpression($expectedPattern, $contentDispositionHeader);
        
        $this->filePath = $response->getFile()->getPathname();

        // Assert that the file exists
        $this->assertFileExists($this->filePath);
        
        // Assert that the file size is greater than 0
        $this->assertGreaterThan(0, filesize($this->filePath));
    }

    public function tearDown(): void
    {
        // It doesn't delete server file from test like a web browser download
        // Delete the file
        if (file_exists($this->filePath)) {
            unlink($this->filePath);
        }

        parent::tearDown();
    }
}
