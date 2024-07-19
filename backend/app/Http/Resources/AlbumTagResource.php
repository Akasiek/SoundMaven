<?php

namespace App\Http\Resources;

use App\Models\AlbumTag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AlbumTag */
class AlbumTagResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,

            'albums_count' => $this->whenCounted('albums'),
            'albums' => AlbumResource::collection($this->whenLoaded('albums')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
