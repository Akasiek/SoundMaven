<?php

namespace App\Http\Resources;

use App\Models\Artist;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Artist
 */
class ArtistResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'background_image' => $this->background_image,
            'albums' => AlbumResource::collection($this->whenLoaded('albums')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
