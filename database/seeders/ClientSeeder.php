<?php

namespace Database\Seeders;

use App\Models\Client;
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

        Client::create([
            "user_id"=> $user->id,
        ]);
    }
}
