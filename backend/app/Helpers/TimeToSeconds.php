<?php

namespace App\Helpers;

use Exception;

class TimeToSeconds
{
    private string $time;

    /**
     * @throws Exception
     */
    public static function convert(string $time): int
    {
        $instance = new self;

        return $instance($time);
    }

    /**
     * @throws Exception
     */
    public function __invoke(string $time): int
    {
        $this->setTime($time);

        return $this->convertToSeconds();
    }

    /**
     * @throws Exception
     */
    private function setTime(string $time): void
    {
        $this->time = match (substr_count($time, ':')) {
            0 => "00:00:$time",
            1 => "00:$time",
            2 => $time,
            default => throw new Exception('Invalid time format'),
        };
    }

    private function convertToSeconds(): int
    {
        $time = array_map(
            fn($value) => (int) $value,
            explode(':', $this->time)
        );

        return $time[0] * 3600 + $time[1] * 60 + $time[2];
    }
}
