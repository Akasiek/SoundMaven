<?php

namespace App\Http\Resources;

use App\Models\Track;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Track
 */
class TrackResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'length' => $this->length,
            'order' => $this->order,
            'album' => new AlbumResource($this->whenLoaded('album')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
