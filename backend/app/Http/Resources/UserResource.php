<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'slug' => $this->slug,
            'stats' => [
                'album_rating_count' => $this->whenCounted('albumReviews', $this->album_rating_count),
                'album_review_count' => $this->whenCounted('albumReviews', $this->album_review_count),
                'average_album_rating' => $this->whenCounted('albumReviews', $this->average_album_rating),
            ]
        ];
    }
}
