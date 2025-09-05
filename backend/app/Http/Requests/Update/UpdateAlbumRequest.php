<?php

namespace App\Http\Requests\Update;

use App\Enums\AlbumTypeEnum;
use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

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
            'type' => ['string', 'nullable', Rule::in(AlbumTypeEnum::cases())],
            'artist_id' => 'uuid|exists:artists,id|required',
            'cover_image' => 'image|nullable|sometimes|max:5120',
        ];

        return $this->convertRulesBasedOnMethod($rules);
    }

    public function attributes(): array
    {
        return array_merge(parent::attributes(), [
            'artist_id' => 'artist',
        ]);
    }
}
