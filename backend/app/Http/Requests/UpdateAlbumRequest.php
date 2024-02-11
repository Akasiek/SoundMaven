<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumRequest extends FormRequest
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
            'title' => 'string|required|max:255',
            'description' => 'string|nullable',
            'release_date' => 'date|nullable',
            'artist_id' => 'uuid|exists:artists,id|required',
        ];

        if ($this->isMethod('patch')) {
            return array_map(fn($rule) => str_replace('required', 'nullable', $rule), $rules);
        }

        return $rules;
    }
}
