<?php

namespace App\Utils;

use App\Models\Game\Punishment\Kick;
use Random\RandomException;
use RuntimeException;

class PunishmentIdGenerator
{
    static function generate(int $maxIterations = 50): string
    {
        try {
            $punishmentId = self::generateRandomString();

            while (!self::isPunishmentIdUnique($punishmentId)) {
                if ($maxIterations <= 0) {
                    return self::generateRandomString(16) . "-failed";
                }

                $punishmentId = self::generateRandomString();

                $maxIterations--;
            }
        } catch (RandomException $exception) {
            throw new RuntimeException("Failed to generate a unique punishment ID: " . $exception->getMessage());
        }

        return $punishmentId;
    }

    private static function isPunishmentIdUnique(string $punishmentId): bool
    {
//        if (Ban::where('punishment_id', $punishmentId)->exists()) {
//            return false;
//        }

        if (Kick::where('punishment_id', $punishmentId)->exists()) {
            return false;
        }

//        if (Mute::where('punishment_id', $punishmentId)->exists()) {
//            return false;
//        }
//
//        if (Warn::where('punishment_id', $punishmentId)->exists()) {
//            return false;
//        }

        // FIXME: 03.06.2025 14:23 Implement

        return true;
    }

    /**
     * @throws RandomException
     */
    private static function generateRandomString(int $length = 8): string
    {
        return bin2hex(random_bytes($length / 2));
    }
}
