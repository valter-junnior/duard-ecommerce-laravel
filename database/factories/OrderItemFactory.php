<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $variation = $product->variations()->inRandomOrder()->first();

        $price = $variation && $variation->price !== null
            ? $variation->price
            : $product->price;

        $quantity = $this->faker->numberBetween(1, 5);

        return [
            'product_id' => $product->id,
            'variation_id' => $variation?->id,
            'quantity' => $quantity,
            'unit_price' => $price,
        ];
    }
}
