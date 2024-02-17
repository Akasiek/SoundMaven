<?php

namespace App\Http\Requests\Update;

use App\Models\Track;
use Auth;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * @mixin Track
 */
class UpdateTrackRequest extends UpdateRequest
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
            'title' => 'string|max:255|required',
            'length' => 'integer|min:0|required',
            'order' => 'integer|min:0|required|unique:tracks,order,NULL,id,album_id,' . $this->album_id,
            'album_id' => 'uuid|exists:albums,id|required',
        ];

        return $this->convertRulesBasedOnMethod($rules);
    }
}
