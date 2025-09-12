<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\StoreArtistRequest;
use App\Http\Requests\Update\UpdateArtistRequest;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\Collections\AlbumCollection;
use App\Models\Album;
use App\Models\Artist;
use App\Services\ArtistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

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
            Artist::with(['albums'])->paginate(request('perPage', 24))
        )]);
    }

    public function show(Artist $artist): \Inertia\Response
    {
        $typeQuery = request()->query('type');
        $albums = Album::with(['artist', 'genres'])
            ->where('artist_id', $artist->id)
            ->when($typeQuery, function ($query, $typeQuery) {
                $query->where('type', $typeQuery);
            })
            ->get();

        return Inertia::render('artist/Show', [
            'artist' => ArtistResource::make($artist),
            'albums' => AlbumCollection::make($albums),
            'typeCount' => $artist->getAlbumTypeCounts(),
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

    public function fetchRaw(Request $request): JsonResponse
    {
        $artists = Artist::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->input('search')) . '%']);
            })
            ->paginate($request->input('perPage', 24));

        return response()->json($artists->map(fn(Artist $artist) => [
            'id' => $artist->id,
            'name' => $artist->name,
        ]));
    }
}
