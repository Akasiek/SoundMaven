<?php

namespace App\Services;

use App\Enums\SearchTypeEnum;
use App\Http\DTO\SearchDTO;
use App\Http\Resources\Collections\AlbumCollection;
use App\Http\Resources\Collections\ArtistCollection;
use App\Http\Resources\Collections\SearchResultCollection;
use App\Http\Resources\Collections\TrackCollection;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Track;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchService
{
    public function search(SearchDTO $dto): SearchResultCollection
    {
        if ($dto->type) {
            $searchType = SearchTypeEnum::from($dto->type);
            return new SearchResultCollection(
                [$searchType->value => $this->getSearchTypeCollection($searchType, $dto->query)]
            );
        }

        return new SearchResultCollection(array_map(
            fn(SearchTypeEnum $type) => $this->getSearchTypeCollection($type, $dto->query),
            SearchTypeEnum::cases()
        ));
    }

    public function getSearchTypeCollection(SearchTypeEnum $type, string $query): ResourceCollection
    {
        return match ($type) {
            SearchTypeEnum::ALBUM => $this->searchAlbum($query),
            SearchTypeEnum::ARTIST => $this->searchArtist($query),
            SearchTypeEnum::TRACK => $this->searchTrack($query),
        };
    }

    public function searchAlbum(string $query): AlbumCollection
    {
        return AlbumCollection::make(
            Album::search($query)->get()->load(['artist', 'tracks'])
        );
    }

    public function searchArtist(string $query): ArtistCollection
    {
        return ArtistCollection::make(
            Artist::search($query)->get()->load(['albums'])
        );
    }

    public function searchTrack(string $query): TrackCollection
    {
        return TrackCollection::make(
            Track::search($query)->get()->load(['album', 'album.artist'])
        );
    }
}
