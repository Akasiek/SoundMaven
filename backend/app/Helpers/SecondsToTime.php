<?php

namespace App\Helpers;

class SecondsToTime
{
    private int $seconds;

    public function __invoke(int $seconds): string
    {
        $this->seconds = $seconds;

        return $seconds >= 3600
            ? $this->convertToTimeWithHours()
            : $this->convertToTimeWithMinutes();
    }

    private function convertToTimeWithHours(): string
    {
        $hours = $this->getHours();
        $minutes = $this->getMinutes();
        $seconds = $this->getSeconds();

        return "$hours:$minutes:$seconds";
    }

    private function convertToTimeWithMinutes(): string
    {
        $minutes = $this->getMinutes();
        $seconds = $this->getSeconds();

        return "$minutes:$seconds";
    }

    private function getMinutes(): string
    {
        return $this->addLeadingZero(
            floor(($this->seconds % 3600) / 60)
        );
    }

    private function getSeconds(): string
    {
        return $this->addLeadingZero($this->seconds % 60);
    }

    private function getHours(): string
    {
        return $this->addLeadingZero(
            floor($this->seconds / 3600)
        );
    }

    private function addLeadingZero(string $value): string
    {
        return str_pad($value, 2, '0', STR_PAD_LEFT);
    }
}
