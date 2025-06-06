<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ShippingAddress;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::factory()
            ->count(10)
            ->create()
            ->each(function ($client) {
                $client->user->assignRole('client');

                ShippingAddress::factory()->create([
                    'client_id' => $client->id,
                ]);
            });
    }
}
