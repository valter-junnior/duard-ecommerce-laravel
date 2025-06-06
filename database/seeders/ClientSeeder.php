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
        $user = User::factory()->create([
            "name"=> "client",
            "email"=> "cliente@gmail.com",
            "password"=> "12345678",
        ]);

        $user ->assignRole("client");

        $client = Client::create([
            "user_id"=> $user->id,
        ]);

        ShippingAddress::create([
            "client_id"=> $client->id,
            "postal_code"=> "65036-284",
            "address"=> "Rua teste",
            "number"=> "123",
            "complement"=> "Casa",
            "district"=> "Centro",
            "city"=> "São Luís",
            "state"=> "MA",
        ]);
    }
}
