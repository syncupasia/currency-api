<?php

namespace Tests\Unit;

use App\Http\Requests\SearchCurrencyRequest;
use Tests\TestCase;

class SearchCurrencyRequestTest extends TestCase
{
    public function test_valid_iso_codes_array_multiple_items()
    {
        $this->assertTrue($this->testSearchCurrencyRequest([
            'iso_codes' => ['usd','cad']
        ]));
    }

    public function test_valid_iso_codes_array_single_item()
    {
        $this->assertTrue($this->testSearchCurrencyRequest([
            'iso_codes' => ['cad']
        ]));
    }

    public function test_invalid_iso_code_not_size_three()
    {
        $this->assertFalse($this->testSearchCurrencyRequest([
            'iso_codes' => ['us','cad']
        ]));
    }

    public function test_invalid_iso_code_not_alpha()
    {
        $this->assertFalse($this->testSearchCurrencyRequest([
            'iso_codes' => ['123']
        ]));
    }

    public function test_invalid_iso_code()
    {
        $this->assertFalse($this->testSearchCurrencyRequest([
            'iso_codes' => ['zzz']
        ]));
    }

    public function test_invalid_iso_code_uppercase()
    {
        $this->assertFalse($this->testSearchCurrencyRequest([
            'iso_codes' => ['ZZZ']
        ]));
    }

    public function test_invalid_iso_codes_string()
    {
        $this->assertFalse($this->testSearchCurrencyRequest([
            'iso_codes' => 'cad'
        ]));
    }

    public function test_no_iso_codes()
    {
        $this->assertTrue($this->testSearchCurrencyRequest([]));
    }

    public function test_invalid_iso_code_null()
    {
        $this->assertFalse($this->testSearchCurrencyRequest([
            'iso_codes' => null
        ]));
    }


    private function testSearchCurrencyRequest($data)
    {
        $request = new SearchCurrencyRequest();
        $validator = $this->app['validator']->make($data, $request->rules());
        return $validator->passes();
    }
}
