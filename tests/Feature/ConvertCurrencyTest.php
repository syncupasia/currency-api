<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Services\CurrencyConversionService;

class ConvertCurrencyTest extends TestCase
{
    public function test_valid_convert_usd_to_cad_with_amount()
    {
        // Example of mocking test to isolate the testing on controller instead of the service
        $mockedService = Mockery::mock(CurrencyConversionService::class);
    
        // Define the expected return value for the mock
        $mockedService->shouldReceive('calculate')
            ->with([
                'base_currency' => 'USD',
                'target_currency' => 'CAD',
                'amount' => 100
            ])
            ->andReturn(1.30);
   
        // Bind the mock to the service container
        $this->app->instance(CurrencyConversionService::class, $mockedService);
    
        $response = $this->get('/api/currencies/convert/usd/cad?amount=100');

        $response->assertStatus(200)->assertJson(['amount' => 1.30]);
    
    }

    public function test_valid_convert_usd_to_cad_with_no_amount()
    {
        $mockedService = Mockery::mock(CurrencyConversionService::class);
    
        // Define the expected return value for the mock
        $mockedService->shouldReceive('calculate')
            ->with([
                'base_currency' => 'USD',
                'target_currency' => 'CAD',
                'amount' => 1 // default 1
            ])
            ->andReturn(1.30);
   
        // Bind the mock to the service container
        $this->app->instance(CurrencyConversionService::class, $mockedService);
    
        $response = $this->get('/api/currencies/convert/usd/cad'); // no amount

        $response->assertStatus(200)->assertJson(['amount' => 1.30]);
    
    }

    public function test_invalid_base_currency()
    {   
        $response = $this->get('/api/currencies/convert/usd/caz?amount=1');
        $response->assertStatus(422);
    }

    public function test_invalid_target_currency()
    {   
        $response = $this->get('/api/currencies/convert/123/cad?amount=1');
        $response->assertStatus(422);
    }

    public function test_invalid_amount()
    {   
        $response = $this->get('/api/currencies/convert/usd/cad?amount=');
        $response->assertStatus(422);
    }

    public function test_invalid_convert_path()
    {   
        $response = $this->get('/api/currencies/convert/');
        $response->assertStatus(404);
    }
}
