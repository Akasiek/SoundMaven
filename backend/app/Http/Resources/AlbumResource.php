<?php

namespace App\Http\Resources;

use App\Models\Album;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Album
 */
class AlbumResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'type' => $this->type,
            'cover_image' => $this->cover_image,
            'cover_image_preview' => $this->cover_image_preview,
            'average_rating' => $this->average_rating,
            'rating_color' => $this->rating_color,
            'total_length' => $this->whenLoaded('tracks') ? $this->total_length : null,
            'total_length_formatted' => $this->whenLoaded('tracks') ? $this->total_length_formatted : null,

            'artist' => ArtistResource::make($this->whenLoaded('artist')),
            'tracks' => TrackResource::collection($this->whenLoaded('tracks')),
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
            'reviews' => AlbumReviewResource::collection($this->whenLoaded('reviews')),
            'reviews_count' => $this->whenLoaded('reviews') ? $this->reviews_count : null,

            'creator' => UserResource::make($this->whenLoaded('creator')),
            'updater' => UserResource::make($this->whenLoaded('updater')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
