<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreArtistRequest;
use App\Http\Requests\Update\UpdateArtistRequest;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\Collection\ArtistCollection;
use App\Models\Artist;
use App\Services\ArtistService;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class ArtistController extends Controller
{
    private ArtistService $service;

    public function __construct(ArtistService $service)
    {
        $this->service = $service;
    }

    public function index(): ArtistCollection
    {
        return new ArtistCollection(
            QueryBuilder::for(Artist::class)
                ->with(['albums'])
                ->allowedFilters([
                    'name',
                ])->whereNull('deleted_at')
                ->get()
        );
    }

    public function show(string $param): ArtistResource
    {
        $artist = Artist::where(uuid_is_valid($param) ? 'id' : 'slug', $param)->firstOrFail();

        return new ArtistResource($artist->loadMissing('albums'));
    }

    public function store(StoreArtistRequest $request): ArtistResource
    {
        return new ArtistResource(
            $this->service->create($request->validated())->loadMissing('albums')
        );
    }

    public function update(UpdateArtistRequest $request, string $param): ArtistResource
    {
        $artist = Artist::where(uuid_is_valid($param) ? 'id' : 'slug', $param)->firstOrFail();

        return new ArtistResource(
            $this->service->update($request->validated(), $artist)->loadMissing('albums')
        );
    }

    public function destroy(Artist $artist): Response
    {
        $artist->delete();

        return response()->noContent();
    }
}
