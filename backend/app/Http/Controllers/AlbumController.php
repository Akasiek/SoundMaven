<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreAlbumRequest;
use App\Http\Requests\Update\UpdateAlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\Collection\AlbumCollection;
use App\Http\Resources\Collection\AlbumReviewCollection;
use App\Http\Resources\Collection\GenreCollection;
use App\Http\Resources\Collection\TrackCollection;
use App\Models\Album;
use App\Models\Genre;
use App\Services\AlbumService;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AlbumController extends Controller
{
    private AlbumService $service;

    public function __construct(AlbumService $service)
    {
        $this->service = $service;
    }

    public function index(): AlbumCollection
    {
        return new AlbumCollection(
            QueryBuilder::for(Album::class)
                ->with(['artist'])
                ->allowedIncludes(['tracks'])
                ->allowedFilters([
                    'title',
                    'type',
                    'artist.name',
                ])
                ->get()
        );
    }


    public function show(string $albumParam): AlbumResource
    {
        $album = Album::where(uuid_is_valid($albumParam) ? 'id' : 'slug', $albumParam)->firstOrFail();

        return new AlbumResource($album->loadMissing(['artist', 'tracks']));
    }

    public function store(StoreAlbumRequest $request): AlbumResource
    {
        return new AlbumResource(
            $this->service->create($request->validated())->loadMissing(['artist', 'tracks'])
        );
    }

    public function update(UpdateAlbumRequest $request, string $albumParam): AlbumResource
    {
        $album = Album::where(uuid_is_valid($albumParam) ? 'id' : 'slug', $albumParam)->firstOrFail();

        return new AlbumResource(
            $this->service->update($request->validated(), $album)->loadMissing(['artist', 'tracks'])
        );
    }

    public function destroy(Album $album): Response
    {
        $this->service->delete($album);

        return response()->noContent();
    }

    public function showTracks(string $albumParam): TrackCollection
    {
        $album = Album::where(uuid_is_valid($albumParam) ? 'id' : 'slug', $albumParam)->firstOrFail();

        return new TrackCollection($album->tracks);
    }

    public function showReviews(string $albumParam): AlbumReviewCollection
    {
        $album = Album::where(uuid_is_valid($albumParam) ? 'id' : 'slug', $albumParam)->firstOrFail();

        return new AlbumReviewCollection($album->reviews);
    }

    public function showGenres(string $albumParam): GenreCollection
    {
        $album = Album::where(uuid_is_valid($albumParam) ? 'id' : 'slug', $albumParam)->firstOrFail();

        return new GenreCollection($album->genres);
    }

    public function attachGenre(string $albumParam, string $genreParam): Response
    {
        $album = Album::where(uuid_is_valid($albumParam) ? 'id' : 'slug', $albumParam)->firstOrFail();
        $genre = Genre::where(uuid_is_valid($genreParam) ? 'id' : 'slug', $genreParam)->firstOrFail();

        $album->genres()->attach($genre);

        return response()->noContent(HttpResponse::HTTP_CREATED);
    }

    public function detachGenre(string $albumParam, string $genreParam): Response
    {
        $album = Album::where(uuid_is_valid($albumParam) ? 'id' : 'slug', $albumParam)->firstOrFail();
        $genre = Genre::where(uuid_is_valid($genreParam) ? 'id' : 'slug', $genreParam)->firstOrFail();

        $album->genres()->detach($genre);

        return response()->noContent();
    }
}
