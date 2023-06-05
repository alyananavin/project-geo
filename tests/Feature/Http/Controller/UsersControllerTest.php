<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersControllerTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Test endpoint for creating new user.
     *
     * @return void
     */
    public function testCreateNewUser(): void
    {
        $data = [
            'data' => [
                'name' => $this->faker->name
            ]
        ];
        $response = $this->post('/api/user', $data);
        $decodedResponse = json_decode($response->getContent());
        $response->assertStatus(201)
            ->assertJsonFragment([
                'id' => $decodedResponse->id,
                'name' => $decodedResponse->name
            ])
            ->assertJsonStructure([
                'id',
                'name'
            ]);
    }

    /**
     * Test 403 endpoint for creating new user.
     *
     * @return void
     */
    public function testCreateNewUser403(): void
    {
        $data = [
            'data' => [
                'name' => $this->faker->numerify(2)
            ]
        ];
        $response = $this->post('/api/user', $data);
        $response->assertStatus(403);
    }

    /**
     * Test endpoint for getting user by id.
     *
     * @return void
     */
    public function testGetUserById(): void
    {
        $response = $this->get('/api/user/'.$this->user->id);
        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $this->user->id,
                'name' => $this->user->name
            ])
            ->assertJsonStructure([
                'id',
                'name'
            ]);
    }

    /**
     * Test endpoint for updating user by ID.
     *
     * @return void
     */
    public function testUpdateUserById(): void
    {
        $data = [
            'data' => [
                'name' => $this->faker->name
            ]
        ];
        $response = $this->patch('/api/user/'.$this->user->id, $data);
        $decodedResponse = json_decode($response->getContent());
        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $decodedResponse->id,
                'name' => $decodedResponse->name
            ])
            ->assertJsonStructure([
                'id',
                'name'
            ]);
    }

    /**
     * Test 403 endpoint for updating user by ID.
     *
     * @return void
     */
    public function testUpdateUserById403(): void
    {
        $data = [
            'data' => [
                'name' => $this->faker->numerify(2)
            ]
        ];
        $response = $this->patch('/api/user/'.$this->user->id, $data);
        $response->assertStatus(403);
    }
}
