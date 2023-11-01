<?php

namespace Tests\Feature;

use Tests\TestCase;

class UnknownApiPathTest extends TestCase
{
    public function test_no_specific_path()
    {
        $response = $this->get('/api/');

        $response->assertStatus(404);
    }

    public function test_invalid_path()
    {
        $response = $this->get('/api/c');

        $response->assertStatus(404);

        $response->assertJsonStructure(['error']);
    }
}
