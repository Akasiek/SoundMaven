<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

abstract class UpdateRequest extends FormRequest
{
    public function convertRulesBasedOnMethod($rules): array
    {
        if ($this->isMethod('patch')) {
            return array_map(fn($rule) => str_replace('required', 'nullable', $rule), $rules);
        }

        return $rules;
    }
}
