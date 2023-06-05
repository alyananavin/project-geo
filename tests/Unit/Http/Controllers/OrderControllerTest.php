<?php

namespace Tests\Unit\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use App\Http\Controllers\OrderController;
use App\Http\Requests\OrderRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;

class OrderControllerTest extends TestCase
{
    use WithFaker;

    protected OrderService $orderService;
    protected OrderController $controller;

    public function setUp() : void
    {
        parent::setUp();
        $this->orderService = Mockery::mock(OrderService::class);
        $this->controller = new OrderController($this->orderService);
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

        $order = new Order();
        $order->id = 1;
        $order->total_value = $this->faker->numberBetween(100, 999);
        $order->date = $this->faker->date('Y-m-d', 'now');
        $order->user_id = $user->id;

        $payload = [
            'data' => [
                'total_value' => $this->faker->numberBetween(100, 999),
                'date' => $this->faker->date('Y-m-d', 'now'),
                'user_id' => $user->id
            ]
        ];

        $request = Mockery::mock(OrderRequest::class);
        $request->shouldReceive('input')->with('data')->andReturn($payload);

        $this->orderService->expects('create')->withArgs([$payload])->andReturn($order);

        $response = $this->controller->createOrder($request);
        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * Test controller for getting all user's orders.
     *
     * @return void
     */
    public function testGetUserOrders(): void
    {
        $user = new User();
        $user->id = 1;
        $user->name = $this->faker->name;

        $order1 = new Order();
        $order1->id = 1;
        $order1->total_value = $this->faker->numberBetween(100, 999);
        $order1->date = $this->faker->date('Y-m-d', 'now');
        $order1->user_id = $user->id;

        $order2 = new Order();
        $order2->id = 1;
        $order2->total_value = $this->faker->numberBetween(100, 999);
        $order2->date = $this->faker->date('Y-m-d', 'now');
        $order2->user_id = $user->id;

        $payload = [
            'orders' => [
                $order1,
                $order2,
            ],
            'order_sum' => $order1->total_value + $order2->total_value
        ];

        $this->orderService->expects('getOrdersByUserId')->withArgs([$user->id])->andReturn($payload);

        $response = $this->controller->getUserOrders($user->id);
        $this->assertEquals(200, $response->getStatusCode());
    }
}