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

        $faker = \Faker\Factory::create();

        $name = $faker->sentence(2);
        $discount = $faker->numberBetween(1, 100);
        $expiry_date = $faker->dateTimeBetween('+1 days', '+5 months');

        /**
         * Required fields check
         */
        $response = $this->post(route('special-offer.store'), [
        ]);

        $response->assertSessionHasErrors(['name', 'discount', 'expiry_date']);

        /**
         * Discount must be numeric check
         */
        $response = $this->post(route('special-offer.store'), [
            'name'          => $name,
            'discount'      => 'asdasd',
            'expiry_date'    => $expiry_date
        ]);

        // Check errors returned
        $response->assertSessionHasErrors(['discount']);

        /**
         * Discount must be less than 100
         */
        $response = $this->post(route('special-offer.store'), [
            'name'          => $name,
            'discount'      => 105,
            'expiry_date'    => $expiry_date
        ]);

        // Check errors returned
        $response->assertSessionHasErrors(['discount']);

        /**
         * Date must be a valid date
         */
        $response = $this->post(route('special-offer.store'), [
            'name'          => $name,
            'discount'      => $discount,
            'expiry_date'    => '2018-02-30'
        ]);

        // Check errors returned
        $response->assertSessionHasErrors(['expiry_date']);


        /**
          * Date must be today or in the future
         */
        $response = $this->post(route('special-offer.store'), [
            'name'          => $name,
            'discount'      => $discount,
            'expiry_date'    => date("Y-m-d", time() - 60 * 60 * 24)
        ]);

        // Check errors returned
        $response->assertSessionHasErrors(['expiry_date']);

        // Successful call
        $response = $this->post(route('special-offer.store'), [
            'name'          => $name,
            'discount'      => $discount,
            'expiry_date'    => $expiry_date
        ]);

        // Redirects after creating the Special Offer
        $response->assertStatus(302);
        $response->assertRedirect(route('special-offer.index'));
    }

}
