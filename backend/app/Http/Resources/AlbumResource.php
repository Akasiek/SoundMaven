<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'artist' => ArtistResource::make($this->whenLoaded('artist')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
