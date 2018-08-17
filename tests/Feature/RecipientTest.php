<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecipientTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRecipient()
    {
        $this->get('/recipient')->assertStatus(200);
        $this->get('/recipient/create')->assertStatus(200);
    }
}
