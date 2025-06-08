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
        $this->call(KickSeeder::class);
    }
}
