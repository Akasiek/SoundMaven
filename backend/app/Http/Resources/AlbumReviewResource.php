<?php

namespace App\Http\Resources;

use App\Models\AlbumReview;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AlbumReview
 */
class AlbumReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'body' => $this->body,
            'album' => AlbumResource::make($this->whenLoaded('album')),
            'creator' => UserResource::make($this->whenLoaded('creator')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
