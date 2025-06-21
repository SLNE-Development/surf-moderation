<?php

namespace Database\Seeders\Game\Punishment;

use App\Models\Game\GameUser;
use App\Models\Game\Punishment\Warn;
use Illuminate\Database\Seeder;

class WarnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstUser = GameUser::firstOrFail();

        Warn::factory(30)->create([
            "punished_uuid" => $firstUser->uuid,
            "issuer_uuid" => "5c63e51b-82b1-4222-af0f-66a4c31e36ad"
        ]);
    }
}
