<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpecialOfferTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSpecialOffer()
    {
        $this->get('/special-offer')->assertStatus(200);
        $this->get('/special-offer/create')->assertStatus(200);
    }
}
