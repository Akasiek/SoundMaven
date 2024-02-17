<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreAlbumRequest;
use App\Http\Requests\Update\UpdateAlbumRequest;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\Collection\AlbumCollection;
use App\Http\Resources\Collection\TrackCollection;
use App\Http\Resources\TrackResource;
use App\Models\Album;
use App\Services\AlbumService;
use Illuminate\Http\Request;
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


    public function show(string $albumParam): AlbumResource
    {
        $album = Album::where(uuid_is_valid($albumParam) ? 'id' : 'slug', $albumParam)->firstOrFail();

        return new AlbumResource($album->loadMissing(['artist', 'tracks']));
    }

    public function store(StoreAlbumRequest $request): AlbumResource
    {
        return new AlbumResource(
            $this->service->create($request->validated())->loadMissing('artist')
        );
    }

    public function update(UpdateAlbumRequest $request, string $albumParam): AlbumResource
    {
        $album = Album::where(uuid_is_valid($albumParam) ? 'id' : 'slug', $albumParam)->firstOrFail();

        return new AlbumResource(
            $this->service->update($request->validated(), $album)->loadMissing('artist')
        );
    }

    public function destroy(Album $album): Response
    {
        $album->delete();

        return response()->noContent();
    }

    public function showTracks(string $albumParam): TrackCollection
    {
        $album = Album::where(uuid_is_valid($albumParam) ? 'id' : 'slug', $albumParam)->firstOrFail();

        return new TrackCollection($album->tracks);
    }

    public function storeTrack(Request $request, string $albumParam): TrackResource
    {
        $album = Album::where(uuid_is_valid($albumParam) ? 'id' : 'slug', $albumParam)->firstOrFail();

        $data = $request->validate([
            'title' => 'string|max:255|required',
            'length' => 'integer|min:0|required',
            'order' => 'integer|min:0|required|unique:tracks,order,NULL,id,album_id,' . $album->id,
        ]);

        return new TrackResource(
            $this->service->addTrack($data, $album)->loadMissing(['album'])
        );
    }
}
