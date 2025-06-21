<?php

namespace Database\Factories\Game\Punishment\Utils;

use Illuminate\Database\Eloquent\Factories\Factory;

class BanIpAddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            "ip_address" => $this->faker->ipv4,
        ];
    }
}
