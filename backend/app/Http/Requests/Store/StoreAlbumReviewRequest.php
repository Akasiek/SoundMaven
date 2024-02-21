<?php

namespace App\Http\Requests\Store;

use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAlbumReviewRequest extends FormRequest
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
        return [
            'rating' => 'integer|min:1|max:100|required',
            'body' => 'string|sometimes',
            'album_id' => [
                'uuid',
                'exists:albums,id',
                'required',
                Rule::unique('album_reviews', 'album_id')
                    ->where('created_by', Auth::id())
                    ->whereNull('deleted_at'),
            ],
        ];
    }
}
