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

        $faker = \Faker\Factory::create();

        $name = $faker->name;
        $email = $faker->unique()->email;

        /**
         * Required fields check
         */
        $response = $this->post(route('recipient.store'), [
        ]);

        $response->assertSessionHasErrors(['name', 'email']);

        /**
         * E-mail must be valid
         */
        $response = $this->post(route('recipient.store'), [
            'name'          => $name,
            'email'         => 'asdasd@shuush',
        ]);

        // Check errors returned
        $response->assertSessionHasErrors(['email']);


        /**
         * E-mail must be unique
         */
        $response = $this->post(route('recipient.store'), [
            'name'          => $name,
            'email'         => 'sample@gmail.com', //must create sample@gmail.com on database
        ]);

        // Check errors returned
        $response->assertSessionHasErrors(['email']);

        /**
         * Name must be filled
         */
        $response = $this->post(route('recipient.store'), [
            'name'          => '',
            'email'         => $email,
        ]);

        // Check errors returned
        $response->assertSessionHasErrors(['name']);


        // Successful call
        $response = $this->post(route('recipient.store'), [
            'name'          => $name,
            'email'         => $email,
        ]);

        // Redirects after creating the Recipient
        $response->assertStatus(302);
        $response->assertRedirect(route('recipient.index'));
    }
}
