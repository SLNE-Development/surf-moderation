<?php

namespace Database\Factories\Game;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game\GameUser>
 */
class GameUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-1 year');
        
        return [
            "uuid" => $this->faker->uuid(),
            "last_name" => $this->faker->minecraftUsername(),
            "created_at" => $date,
            "updated_at" => $date,
        ];
    }
}
