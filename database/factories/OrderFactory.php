<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {    
        return [
            'total_value' => fake()->numberBetween(100, 999),
            'date' => fake()->date('Y-m-d', 'now'),
            'user_id' => User::factory()->create()->id
        ];
    }
}