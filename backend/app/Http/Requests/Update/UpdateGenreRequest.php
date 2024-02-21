<?php

namespace App\Http\Requests\Update;

use Auth;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateGenreRequest extends UpdateRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'string|required|max:255',
            'description' => 'string|nullable',
        ];

        return $this->convertRulesBasedOnMethod($rules);
    }
}
