<?php

namespace App\Http\DTO;

use App\Http\Requests\Update\UpdateProfileRequest;
use Illuminate\Http\UploadedFile;

readonly class UpdateProfileDTO
{
    public function __construct(
        public ?string $name,
        public ?string $email,
        public ?string $password,
        public ?UploadedFile $avatar,
        public ?string $favorite_artist_id,
    ) {}

    public static function fromRequest(UpdateProfileRequest $request): self
    {
        return new self(
            name: $request->input('name'), email: $request->input('email'),
            password: $request->input('password'), avatar: $request->file('avatar'),
            favorite_artist_id: $request->input('favorite_artist_id'),
        );
    }
}
