<?php

namespace Tests\Feature;

use Tests\TestCase;

class CurrencyPdfDownloadTest extends TestCase
{
    public function testCurrencyExcelDownload()
    {
        $response = $this->get('/api/currencies?format=pdf');

        $response->assertStatus(200)
                 ->assertHeader('Content-Type', 'application/pdf')
                 ->assertHeader('Content-Length');
        $this->assertNotEmpty($response->getContent());
    }
}
