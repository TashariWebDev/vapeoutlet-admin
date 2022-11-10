<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'processed_by' => $this->faker->word(),
            'is_editing' => $this->faker->boolean(),
            'delivery_charge' => $this->faker->randomNumber(),
            'waybill' => $this->faker->word(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'placed_at' => Carbon::now(),

            'customer_id' => Customer::factory(),
            'salesperson_id' => User::factory(),
        ];
    }
}
