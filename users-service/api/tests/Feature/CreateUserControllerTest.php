<?php

namespace Api\Tests\Feature;

use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Api\Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;

class CreateUserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_user_successful()
    {
        $faker = Factory::create();

        $payload = [
            'firstName' => $faker->firstName,
            'lastName' => $faker->lastName,
            'email' => $faker->email,
        ];

        $response = $this->post('/api/users', $payload);

        $response->assertJsonStructure(
            [
                'user' => [
                    'id'
                ]
            ]
        )->assertStatus(201);

        $this->assertDatabaseHas(
            'users', [
                'first_name' => $payload['firstName'],
                'last_name' => $payload['lastName'],
                'email' => $payload['email'],
            ]
        );
    }

    public function test_user_get_bad_request_for_already_existing()
    {
        $faker = Factory::create();

        $payload = [
            'firstName' => $faker->firstName,
            'lastName' => $faker->lastName,
            'email' => $faker->email,
        ];

        // send a request with same payload the first time
        $this->post('/api/users', $payload);

        // send a request with same payload the second time
        $response = $this->post('/api/users', $payload);

        $response->assertStatus(400);
    }
}
