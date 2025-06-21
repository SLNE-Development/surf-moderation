<?php

namespace Database\Seeders\Game\Punishment;

use Illuminate\Database\Seeder;

class PunishmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(BanSeeder::class);
        $this->call(KickSeeder::class);
        $this->call(WarnSeeder::class);
        $this->call(MuteSeeder::class);
    }
}
