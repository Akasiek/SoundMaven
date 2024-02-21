<?php

namespace App\Http\Requests\Update;

use Auth;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateAlbumReviewRequest extends UpdateRequest
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
            'rating' => 'integer|min:1|max:100|required',
            'body' => 'string|sometimes',
            'album_id' => 'uuid|exists:albums,id|required',
        ];

        return $this->convertRulesBasedOnMethod($rules);
    }
}
