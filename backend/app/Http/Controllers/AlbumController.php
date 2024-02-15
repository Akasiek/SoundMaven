<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreAlbumRequest;
use App\Http\Requests\Update\UpdateAlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\Collection\AlbumCollection;
use App\Models\Album;
use App\Services\AlbumService;
use Spatie\QueryBuilder\QueryBuilder;

class AlbumController extends Controller
{
    private AlbumService $service;

    public function __construct(AlbumService $service)
    {
        $this->service = $service;
    }

    public function index()
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlbumRequest $request)
    {
        return new AlbumResource(
            $this->service->create($request->validated())->loadMissing('artist')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $param)
    {
        $album = Album::where(uuid_is_valid($param) ? 'id' : 'slug', $param)->firstOrFail();

        return new AlbumResource($album->loadMissing('artist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlbumRequest $request, string $param)
    {
        $album = Album::where(uuid_is_valid($param) ? 'id' : 'slug', $param)->firstOrFail();

        return new AlbumResource(
            $this->service->update($request->validated(), $album)->loadMissing('artist')
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        $album->delete();

        return response()->noContent();
    }
}
