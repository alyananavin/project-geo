<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderControllerTest extends TestCase
{
    use WithFaker;
    use DatabaseTransactions;

    protected $order;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->order = Order::factory()->create();
        $this->user = User::factory()->create();
    }

    /**
     * Test endpoint for creating new order.
     *
     * @return void
     */
    public function testCreateNewOrder(): void
    {
        $data = [
            'data' => [
                'total_value' => $this->faker->numberBetween(100, 999),
                'date' => $this->faker->date('Y-m-d', 'now'),
                'user_id' => $this->user->id
            ]
        ];
        $response = $this->post('/api/order', $data);
        $decodedResponse = json_decode($response->getContent());
        $response->assertStatus(201)
            ->assertJsonFragment([
                'id' => $decodedResponse->id,
                'total_value' => $decodedResponse->total_value,
                'date' => $decodedResponse->date,
                'user_id' => $decodedResponse->user_id
            ])
            ->assertJsonStructure([
                'id',
                'total_value',
                'date',
                'user_id'
            ]);
    }

    /**
     * Test 403 endpoint for creating new order.
     *
     * @return void
     */
    public function testCreateNewOrder403(): void
    {
        $data = [
            'data' => [
                'total_value' => $this->faker->name,
                'date' => $this->faker->date('Y-m-d', 'now'),
                'user_id' => $this->user->id
            ]
        ];
        $response = $this->post('/api/order', $data);
        $response->assertStatus(403);
    }

    /**
     * Test endpoint for getting all user's orders.
     *
     * @return void
     */
    public function testGetUserOrders(): void
    {
        $order1 = Order::factory()->create([
            'total_value' => 500,
            'date' => $this->faker->date('Y-m-d', 'now'),
            'user_id' => $this->user->id
        ]);
        $order2 = Order::factory()->create([
            'total_value' => 600,
            'date' => $this->faker->date('Y-m-d', 'now'),
            'user_id' => $this->user->id
        ]);

        $response = $this->get('/api/order/user/'.$this->user->id);
        $response->assertStatus(200)
            ->assertJsonFragment([
                'orders' => [
                    [
                        'id' => $order1->id,
                        'total_value' => number_format($order1->total_value, 2, '.', ''),
                        'date' => $order1->date,
                        'user_id' => $order1->user_id
                    ],
                    [
                        'id' => $order2->id,
                        'total_value' => number_format($order2->total_value, 2, '.', ''),
                        'date' => $order2->date,
                        'user_id' => $order2->user_id
                    ]
                ],
                'order_sum' => $order1->total_value + $order2->total_value
            ])
            ->assertJsonStructure([
                'orders' => [
                    '*' => [
                        'id',
                        'total_value',
                        'date',
                        'user_id'
                    ]
                ],
                'order_sum'
            ]);
    }
}
