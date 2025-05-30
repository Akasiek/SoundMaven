<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreArtistRequest;
use App\Http\Requests\Update\UpdateArtistRequest;
use App\Http\Resources\ArtistResource;
use App\Models\Artist;
use App\Services\ArtistService;
use Illuminate\Http\Response;

class ArtistController extends Controller
{
    private ArtistService $service;

    public function __construct(ArtistService $service)
    {
        $this->service = $service;
    }

    public function index(): \Inertia\Response
    {
        return inertia('artist/List', ['artists' => ArtistResource::collection(
            Artist::with(['albums'])->paginate(request('perPage', 10))
        )]);
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
