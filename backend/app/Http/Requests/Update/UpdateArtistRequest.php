<?php

namespace App\Http\Requests\Update;

use Auth;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateArtistRequest extends UpdateRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'type' => 'string|in:band,solo,duo,other|required',
            'background_image' => 'image|nullable|sometimes|max:5120',
        ];

        return $this->convertRulesBasedOnMethod($rules);
    }
}
