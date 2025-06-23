<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreTrackRequest;
use App\Http\Requests\Update\UpdateTrackRequest;
use App\Http\Resources\Collections\TrackCollection;
use App\Http\Resources\TrackResource;
use App\Models\Track;
use App\Services\TrackService;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class TrackController extends Controller
{
    private TrackService $service;

    public function __construct(TrackService $service)
    {
        $this->service = $service;
    }

    public function index(): TrackCollection
    {
        return new TrackCollection(
            QueryBuilder::for(Track::class)
                ->with(['album'])
                ->allowedFilters(['title', 'slug', 'album.title', 'album.slug', 'album.artist.name', 'album.artist.slug'])
                ->allowedSorts(['title', 'length', 'order', 'disc'])
                ->paginate(request('perPage'))
        );
    }

    public function show(string $trackParam): TrackResource
    {
        $track = Track::whereSlugOrId($trackParam)->firstOrFail();

        return new TrackResource($track->loadMissing(['album']));
    }

    public function store(StoreTrackRequest $request): TrackResource
    {
        return new TrackResource(
            $this->service->create($request->validated())->loadMissing(['album'])
        );
    }


    public function update(UpdateTrackRequest $request, string $trackParam): TrackResource
    {
        $track = Track::whereSlugOrId($trackParam)->firstOrFail();

        return new TrackResource(
            $this->service->update($request->validated(), $track)->loadMissing(['album'])
        );
    }

    public function destroy(Track $track): Response
    {
        $this->service->delete($track);

        return response()->noContent();
    }
}
