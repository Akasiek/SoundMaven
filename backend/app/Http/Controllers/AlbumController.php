<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreAlbumRequest;
use App\Http\Requests\Update\UpdateAlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\Collection\AlbumCollection;
use App\Models\Album;
use App\Services\AlbumService;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

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
                ->allowedFilters([
                    'title',
                    'artist.name',
                ])
                ->get()
        );
    }

    public function store(StoreAlbumRequest $request): AlbumResource
    {
        return new AlbumResource(
            $this->service->create($request->validated())->loadMissing('artist')
        );
    }

    public function show(string $param): AlbumResource
    {
        $album = Album::where(uuid_is_valid($param) ? 'id' : 'slug', $param)->firstOrFail();

        return new AlbumResource($album->loadMissing('artist'));
    }

    public function update(UpdateAlbumRequest $request, string $param): AlbumResource
    {
        $album = Album::where(uuid_is_valid($param) ? 'id' : 'slug', $param)->firstOrFail();

        return new AlbumResource(
            $this->service->update($request->validated(), $album)->loadMissing('artist')
        );
    }

    public function destroy(Album $album): Response
    {
        $album->delete();

        return response()->noContent();
    }
}
