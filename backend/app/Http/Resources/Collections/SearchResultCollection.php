<?php

namespace App\Http\Resources\Collections;

use App\Enums\SearchTypeEnum;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\TrackResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchResultCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return $this->collection->mapWithKeys(function (ResourceCollection $collection) use ($request) {
            $searchType = $this->getSearchTypeFromResourceName($collection->collects);
            return [$searchType->value => $collection->toArray($request)];
        })->toArray();
    }

    private function getSearchTypeFromResourceName(string $resourceName): SearchTypeEnum
    {
        return match ($resourceName) {
            AlbumResource::class => SearchTypeEnum::ALBUM,
            ArtistResource::class => SearchTypeEnum::ARTIST,
            TrackResource::class => SearchTypeEnum::TRACK,
        };
    }
}
