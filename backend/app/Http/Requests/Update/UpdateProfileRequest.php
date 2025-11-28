<?php

namespace App\Http\Requests\Update;

use Auth;

class UpdateProfileRequest extends UpdateRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $rules = [
            'password' => 'string|nullable|min:8|confirmed',
            'avatar' => 'image|nullable|sometimes|max:5120',
        ];

        return $this->convertRulesBasedOnMethod($rules);
    }
}
