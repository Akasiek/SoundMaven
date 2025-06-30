<?php

namespace App\Http\Requests\Store;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'body' => 'string|sometimes|nullable',
            'album_id' => [
                'uuid',
                'exists:albums,id',
                'required',
            ],
            // User cannot review the same album more than once
            // It is handled by the AlbumReviewService
        ];
    }

    public function messages()
    {
        return [
            'album_id.unique' => 'You have already reviewed this album.',
        ];
    }
}
