<?php

namespace Database\Seeders\Game;

use Database\Seeders\Game\Punishment\PunishmentSeeder;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(GameUserSeeder::class);
        $this->call(PunishmentSeeder::class);
    }
}
