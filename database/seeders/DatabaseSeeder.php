<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Game\GameSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            "name" => "Simon Homberg",
            "email" => "homberg@slne.dev",
            "email_verified_at" => now(),
            "password" => Hash::make("test1234"),
        ]);

        $this->call(GameSeeder::class);
    }
}
