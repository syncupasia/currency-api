<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Currency;

class CurrenciesListTest extends TestCase
{

    public function test_currencies_status_count_structure()
    {
        $totalCount = Currency::count();
        $response = $this->get('/api/currencies');
        $this->assertStatusCountStructure($response, $totalCount);
    }

    public function test_currencies_with_iso_codes()
    {
        $response = $this->get('/api/currencies?iso_codes[]=usd&iso_codes[]=cad');
        $this->assertStatusCountStructure($response, 2);
        $responseData = $response->json()['data'];
        $isoCodes = ['USD', 'CAD'];
    
        foreach ($responseData as $currency) {
            $this->assertContains($currency['iso_code'], $isoCodes);
        }
    }

    private function assertStatusCountStructure($response, $count) {
        $response->assertStatus(200);
        $response->assertJsonCount($count, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'iso_code',
                    'name',
                    'current_rate',
                    'previous_rate',
                    'last_modified'
                ]
            ]
        ]);
    }

}
