<?php

namespace Database\Factories\Providers;

use Faker\Provider\Base;

class MinecraftUsernameProvider extends Base
{
    public function minecraftUsername(): string
    {
        $first = $this->generator->firstName();
        $number = $this->generator->numberBetween(0, 99);
        $suffix = $this->generator->optional(0.3)->randomElement(['_', 'YT', 'PvP', 'Xx', 'HD']);

        $username = $first . $number . $suffix;
        $username = preg_replace('/[^a-zA-Z0-9_]/', '', $username);
        return substr($username, 0, 16);
    }
}
