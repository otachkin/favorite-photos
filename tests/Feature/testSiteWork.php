<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class testSiteWork extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSiteWork()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
