<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Requests\ConvertCurrencyRequest;

class ConvertCurrencyRequestTest extends TestCase
{
    public function test_all_valid_input_request()
    {
        $this->assertTrue(
            $this->testConvertCurrencyRequest([
                'base_currency' => 'usd',
                'target_currency' => 'cad',
                'amount' => 100,
            ])
        );
    }

    public function test_all_invalid_input_request()
    {
        $this->assertFalse(
            $this->testConvertCurrencyRequest([
                'base_currency' => 'us',
                'target_currency' => 'caz',
                'amount' => 'a',
            ])
        );
    }

    public function test_invalid_currency_request()
    {
        $this->assertFalse(
            $this->testConvertCurrencyRequest([
                'base_currency' => 'c',
                'target_currency' => 1,
                'amount' => 100,
            ])
        );
    }

    public function test_invalid_base_currency_request()
    {
        $this->testInvalidCurrencyDataRequest('base_currency');
    }

    public function test_invalid_target_currency_request()
    {
        $this->testInvalidCurrencyDataRequest('target_currency');
    }

    public function test_valid_no_amount_request() {
        // missing amount
        $this->assertTrue(
            $this->testConvertCurrencyRequest([
                'base_currency' => 'usd',
                'target_currency' => 'cad',
            ])
        );
    }

    public function test_invalid_amount_request()
    {
        // invalid due to string
        $this->assertFalse(
            $this->testConvertCurrencyRequest([
                'base_currency' => 'usd',
                'target_currency' => 'cad',
                'amount' => 'a',
            ])
        );
    }

    public function test_negative_amount_request()
    {
        // invalid due to string
        $this->assertFalse(
            $this->testConvertCurrencyRequest([
                'base_currency' => 'usd',
                'target_currency' => 'cad',
                'amount' => -100,
            ])
        );
    }

    private function testConvertCurrencyRequest($data) {
        $request = new ConvertCurrencyRequest();
        $validator = $this->app['validator']->make($data, $request->rules());
        return $validator->passes();
    }

    // use to test base and target currency
    private function testInvalidCurrencyDataRequest($invalidField) 
    {
        $validCurrencyField = ($invalidField == 'base_currency') ? 'target_currency' : 'base_currency';
        $invalidCurrencyField = ($invalidField == 'base_currency') ? 'base_currency' : 'target_currency';
        // missing currency
        $this->assertFalse(
            $this->testConvertCurrencyRequest([
                $validCurrencyField => 'cad',
                'amount' => 100,
            ])
        );

        // invalid length
        $this->assertFalse(
            $this->testConvertCurrencyRequest([
                $invalidCurrencyField => 'us',
                $validCurrencyField => 'cad',
                'amount' => 100,
            ])
        );

        // invalid alpha
        $this->assertFalse(
            $this->testConvertCurrencyRequest([
                $invalidCurrencyField => '123',
                $validCurrencyField => 'cad',
                'amount' => 100,
            ])
        );

        // invalid number
        $this->assertFalse(
            $this->testConvertCurrencyRequest([
                $invalidCurrencyField => 123,
                $validCurrencyField => 'cad',
                'amount' => 100,
            ])
        );

        // invalid iso_code - not in currency db table
        $this->assertFalse(
            $this->testConvertCurrencyRequest([
                $invalidCurrencyField => 'usz',
                $validCurrencyField => 'cad',
                'amount' => 100,
            ])
        );

        // invalid uppercase
        $this->assertFalse(
            $this->testConvertCurrencyRequest([
                $invalidCurrencyField => 'USD',
                $validCurrencyField => 'cad',
                'amount' => 100,
            ])
        );
    }
}
