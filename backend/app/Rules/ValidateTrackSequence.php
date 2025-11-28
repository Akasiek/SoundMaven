<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateTrackSequence implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value)) {
            return;
        }

        $this->validateOrderSequence($value, $fail);
        $this->validateDiscNumberSequence($value, $fail);
    }

    private function validateOrderSequence(array $tracks, Closure $fail): void
    {
        $orders = collect($tracks)->pluck('order')->unique()->sort()->values();
        $expectedOrder = 1;

        foreach ($orders as $order) {
            if ($order !== $expectedOrder) {
                $fail("The order must start from 1 and increment by 1. Found: $order, expected: $expectedOrder.");

                return;
            }
            $expectedOrder++;
        }
    }

    private function validateDiscNumberSequence(array $tracks, Closure $fail): void
    {
        $discNumbers = collect($tracks)->pluck('disc')->unique()->sort()->values();
        $expectedDiscNumber = 1;

        foreach ($discNumbers as $discNumber) {
            if ($discNumber !== $expectedDiscNumber) {
                $fail("Disc numbers must start from 1 and increment by 1. Found: $discNumber, expected: $expectedDiscNumber.");

                return;
            }
            $expectedDiscNumber++;
        }
    }
}
