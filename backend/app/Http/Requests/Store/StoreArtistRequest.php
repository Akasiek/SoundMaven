<?php

namespace App\Http\Requests\Store;

use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreArtistRequest extends FormRequest
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
        return [
            'name' => 'string|required|max:255',
            'description' => 'string|nullable',
            'type' => 'string|in:band,solo,duo,other|required',
            'background_image' => 'image|nullable|sometimes|max:5120',
        ];
    }
}
