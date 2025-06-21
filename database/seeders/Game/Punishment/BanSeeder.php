<?php

namespace Database\Seeders\Game\Punishment;

use App\Models\Game\GameUser;
use App\Models\Game\Punishment\Ban;
use App\Models\Game\Punishment\Utils\BanIpAddress;
use Illuminate\Database\Seeder;

class BanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstUser = GameUser::firstOrFail();

        $bans = Ban::factory(30)->create([
            "punished_uuid" => $firstUser->uuid,
            "issuer_uuid" => "5c63e51b-82b1-4222-af0f-66a4c31e36ad"
        ]);

        $bans->each(function (Ban $ban) use ($firstUser) {
            BanIpAddress::factory(2)->create([
                "punishment_id" => $ban->id,
            ]);

            $amountOfSubBans = rand(0, 3);
            for ($i = 0; $i < $amountOfSubBans; $i++) {
                Ban::factory()->create([
                    "punished_uuid" => $firstUser->uuid,
                    "issuer_uuid" => "5c63e51b-82b1-4222-af0f-66a4c31e36ad",
                    "parent_id" => $ban->id
                ]);
            }
        });
    }
}
