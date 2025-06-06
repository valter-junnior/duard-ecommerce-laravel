<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingAddress>
 */
class ShippingAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id'    => Client::factory(),
            'postal_code'  => $this->faker->postcode,
            'address'      => $this->faker->streetAddress,
            'number'       => $this->faker->buildingNumber,
            'complement'   => $this->faker->optional()->secondaryAddress,
            'district'     => $this->faker->citySuffix,
            'city'         => 'São Luís',
            'state'        => 'MA',
        ];
    }
}
