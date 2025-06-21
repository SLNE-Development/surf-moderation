<?php

namespace Database\Factories\Game\Punishment;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game\Punishment\Mute>
 */
class MuteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-1 year');
        $unpunished = $this->faker->boolean(20);
        $permanent = $this->faker->boolean();

        return [
            "punishment_id" => substr($this->faker->unique()->uuid(), 0, 8),
            "reason" => $this->faker->sentence(),
            "unpunished" => $unpunished,
            "unpunished_date" => $unpunished ? $this->faker->dateTimeBetween($date, '+1 year') : null,
            "unpunisher_uuid" => $unpunished ? "5c63e51b-82b1-4222-af0f-66a4c31e36ad" : null,
            "permanent" => $permanent,
            "expiration_date" => $permanent ? null : $this->faker->dateTimeBetween($date, '+1 year'),
            "created_at" => $date,
            "updated_at" => $date,
        ];
    }
}
