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
            'name' => $this->clean_name,
            'original_name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'type' => $this->type,
            'background_image' => $this->background_image,
            'background_image_preview' => $this->background_image_preview,
            'background_image_placeholder' => $this->background_image_placeholder,

            'albums' => AlbumResource::collection($this->whenLoaded('albums')),

            'creator' => UserResource::make($this->whenLoaded('creator')),
            'updater' => UserResource::make($this->whenLoaded('updater')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
