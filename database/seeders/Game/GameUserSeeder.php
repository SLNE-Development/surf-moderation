<?php

namespace Database\Seeders\Game;

use App\Models\Game\GameUser;
use App\Models\Game\GameUserNameHistory;
use Illuminate\Database\Seeder;

class GameUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GameUser::create([
            "uuid" => "5c63e51b-82b1-4222-af0f-66a4c31e36ad",
            "last_name" => "NotAmmo",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        $users = GameUser::factory(50)->create();

        $histories = [];

        foreach ($users as $user) {
            $userHistories = GameUserNameHistory::factory(rand(0, 5))->make([
                'game_user_id' => $user->id,
            ])->toArray();

            $histories = array_merge($histories, $userHistories);
        }

        // Bulk insert
        if (!empty($histories)) {
            GameUserNameHistory::insert($histories);
        }
    }
}
