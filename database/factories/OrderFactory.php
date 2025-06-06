<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Client;
use App\Models\ShippingAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client = Client::inRandomOrder()->first() ?? Client::factory()->create();
        $shippingAddress = $client->shippingAddresses()->inRandomOrder()->first()
            ?? $client->shippingAddresses()->create(ShippingAddress::factory()->make()->toArray());

        return [
            'client_id' => $client->id,
            'shipping_address_id' => $shippingAddress->id,
            'status' => $this->faker->randomElement(OrderStatus::cases())->value,
            'total_amount' => 0, 
        ];
    }
}
