<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ClientSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
        ]);
    }
}
