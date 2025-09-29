<?php

namespace App\Helpers;

class RatingColor
{
    public static function get(float|int|string|null $rating): string
    {
        return match (true) {
            $rating === 'Ø' => 'text-gray-400',
            $rating < 30 => 'text-red-400',
            $rating < 70 => 'text-yellow-400',
            default => 'text-green-400',
        };
    }
}
