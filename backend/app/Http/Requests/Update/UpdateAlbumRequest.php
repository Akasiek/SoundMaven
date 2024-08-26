<?php

namespace App\Http\Requests\Update;

use Auth;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateAlbumRequest extends UpdateRequest
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
            'type' => 'string|nullable|in:LP,EP,Single,Compilation,Live,Soundtrack,Remix,Other',
            'artist_id' => 'uuid|exists:artists,id|required',
            'cover_image' => 'image|nullable|sometimes|max:5120',
        ];

        return $this->convertRulesBasedOnMethod($rules);
    }
}
