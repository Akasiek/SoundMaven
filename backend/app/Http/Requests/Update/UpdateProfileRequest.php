<?php

namespace App\Http\Requests\Update;

use App\Models\Artist;
use App\Models\User;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends UpdateRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'password' => ['sometimes', 'nullable', 'confirmed', Password::defaults()],
            'avatar' => 'image|nullable|sometimes|max:5120',
            'favorite_artist_id' => ['nullable', 'sometimes', 'uuid', Rule::exists(Artist::class, 'id')],
        ];

        return $this->convertRulesBasedOnMethod($rules);
    }
}
