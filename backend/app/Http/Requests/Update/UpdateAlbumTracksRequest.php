<?php

namespace App\Http\Requests\Update;

use App\Rules\ValidateTrackSequence;
use Auth;

class UpdateAlbumTracksRequest extends UpdateRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'tracks' => ['array', 'required', new ValidateTrackSequence],
            'tracks.*.title' => 'string|required|max:255',
            'tracks.*.duration' => 'string|required|max:255',
            'tracks.*.order' => 'integer|required|min:1|distinct',
            'tracks.*.disc' => 'integer|required|min:1',
        ];
    }
}
