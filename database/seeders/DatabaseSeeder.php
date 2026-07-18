<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            "name" => "Admin Laundry",
            "email" => "admin@laundry.test",
            "password" => bcrypt("password"),
        ]);

        $this->call([
            ServiceSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
