<?php

namespace Tests\Feature;

use Tests\TestCase;

class CurrenciesListTest extends TestCase
{
    public function test_currencies_status_count_structure()
    {
        $response = $this->get('/api/currencies');
        $response->assertStatus(200);
        $response->assertJsonCount(192, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'iso_code',
                    'name',
                    'current_rate',
                    'previous_rate'
                ]
            ]
        ]);
    }
}
