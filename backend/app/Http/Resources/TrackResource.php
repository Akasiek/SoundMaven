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
            'length_in_minutes' => $this->length_in_minutes,
            'order' => $this->order,
            'disc' => $this->disc,

            'album' => AlbumResource::make($this->whenLoaded('album')),

            'creator' => UserResource::make($this->whenLoaded('creator')),
            'updater' => UserResource::make($this->whenLoaded('updater')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
