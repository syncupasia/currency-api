<?php

namespace Tests\Feature;

use Tests\TestCase;

class GetCurrenciesDataTaskTest extends TestCase
{
    public function test_get_currencies_data_command_runs_successfully()
    {
        $this->artisan('get:currencies-data')
             ->expectsOutput('JSON data fetched successfully.')
             ->assertExitCode(0);
    }
}
