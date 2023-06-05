<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Http\Controllers\UsersController;
use App\Http\Requests\UserRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;

class UsersControllerTest extends TestCase
{
    use WithFaker;

    protected UserService $userService;
    protected UsersController $controller;

    public function setUp() : void
    {
        parent::setUp();
        $this->userService = Mockery::mock(UserService::class);
        $this->controller = new UsersController($this->userService);
    }

    /**
     * Test controller for creating new user.
     *
     * @return void
     */
    public function testCreateNewUser(): void
    {
        $user = new User();
        $user->id = 1;
        $user->name = $this->faker->name;

        $payload = [
            'data' => [
                'name' => $user->name
            ]
        ];

        $request = Mockery::mock(UserRequest::class);
        $request->shouldReceive('input')->with('data')->andReturn($payload);

        $this->userService->expects('create')->withArgs([$payload])->andReturn($user);

        $response = $this->controller->createUser($request);
        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * Test controller for getting user by id.
     *
     * @return void
     */
    public function testGetUserById(): void
    {
        $user = new User();
        $user->id = 1;
        $user->name = $this->faker->name;

        $this->userService->expects('getById')->withArgs([$user->id])->andReturn($user);

        $response = $this->controller->getUserById($user->id);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test controller for updating user by ID.
     *
     * @return void
     */
    public function testUpdateUserById(): void
    {
        $user = new User();
        $user->id = 1;
        $user->name = $this->faker->name;

        $payload = [
            'data' => [
                'name' => $user->name
            ]
        ];

        $request = Mockery::mock(UserRequest::class);
        $request->shouldReceive('input')->with('data')->andReturn($payload);

        $this->userService->expects('update')->withArgs([$payload, $user->id])->andReturn($user);

        $response = $this->controller->updateUserById($request, $user->id);
        $this->assertEquals(200, $response->getStatusCode());       
    }
}