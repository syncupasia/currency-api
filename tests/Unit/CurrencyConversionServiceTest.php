<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\CurrencyConversionService;

class CurrencyConversionServiceTest extends TestCase
{
    private $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CurrencyConversionService();
    }

    public function test_valid_calculation_usd_cad()
    {
        $result = $this->service->calculate([
            'base_currency' => 'USD',
            'target_currency' => 'CAD',
            'amount' => 100
        ]);
        $this->assertEquals(99, $result);
    }

    public function test_invalid_input_no_amount()
    {
        $result = $this->service->calculate([
            'base_currency' => 'USD',
            'target_currency' => 'CAD',
        ]);
        $this->assertFalse($result);
    }

    public function test_invalid_iso_code()
    {
        $result = $this->service->calculate([
            'base_currency' => 'US',
            'target_currency' => 'CAD',
            'amount' => 100
        ]);
        $this->assertFalse($result);
    }

    public function test_same_base_and_target_iso_codes()
    {
        $params = [
            'base_currency' => 'CAD',
            'target_currency' => 'CAD',
            'amount' => 100
        ];
        $result = $this->service->calculate($params);
        $this->assertEquals($params['amount'], $result);
    }
}
