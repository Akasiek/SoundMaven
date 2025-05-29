<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreArtistRequest;
use App\Http\Requests\Update\UpdateArtistRequest;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\Collections\ArtistCollection;
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
                ->allowedFilters(['name', 'type', 'albums.title', 'albums.id'])
                ->allowedSorts(['name', 'type', 'created_at', 'updated_at'])
                ->paginate(request('perPage'))
        );
    }

    public function show(string $param): \Inertia\Response
    {
        $artist = Artist::whereSlugOrId($param)
            ->with(['albums'])
            ->firstOrFail();

        return inertia('artist/Show', [
            'artist' => new ArtistResource($artist),
        ]);
    }

    public function store(StoreArtistRequest $request): ArtistResource
    {
        return new ArtistResource(
            $this->service->create($request->validated())->loadMissing('albums')
        );
    }

    public function update(UpdateArtistRequest $request, string $param): ArtistResource
    {
        $artist = Artist::whereSlugOrId($param)->firstOrFail();

        return new ArtistResource(
            $this->service->update($request->validated(), $artist)->loadMissing('albums')
        );
    }

    public function destroy(Artist $artist): Response
    {
        $this->service->delete($artist);

        return response()->noContent();
    }
}
