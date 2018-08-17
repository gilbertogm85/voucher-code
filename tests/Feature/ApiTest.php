<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testApi()
    {
    	$this->get('/api/json/vouchers/mail@example.com')->assertStatus(200);
        $this->get('/api/json/vouchers/mail@example.com')->assertJsonStructure(['status']);
        $this->get('/api/json/confirm-voucher/xyzabsde/mail@example.com')->assertStatus(200);
        $this->get('/api/json/confirm-voucher/xyzabsde/mail@example.com')->assertJsonStructure(['status']);
    }
}
