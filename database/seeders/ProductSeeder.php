<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            "name"=> "Camiseta",
            "description"=> "Camiseta branca",
            "price"=> 10.00,
            "category_id"=> 1,
        ]);

        ProductVariation::create([
            "product_id"=> 1,
            "name"=> "P",
            "stock"=> 10,
        ]);
    }
}
