<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()
            ->count(10)
            ->create()
            ->each(function ($order) {
                $items = OrderItem::factory()
                    ->count(rand(1, 4))
                    ->make()
                    ->each(fn ($item) => $item->order_id = $order->id);
                    
                $order->items()->saveMany($items);

                $total = $items->sum(fn ($item) => $item->quantity * $item->unit_price);
                $order->update(['total_amount' => $total]);
            });
    }
}
