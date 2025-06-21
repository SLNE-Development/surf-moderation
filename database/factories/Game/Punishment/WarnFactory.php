<?php

namespace Database\Factories\Game\Punishment;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game\Punishment\Warn>
 */
class WarnFactory extends Factory
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
            "punishment_id" => substr($this->faker->unique()->uuid(), 0, 8),
            "reason" => $this->faker->sentence(),
            "created_at" => $date,
            "updated_at" => $date,
        ];
    }
}
